<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends MY_Controller {

    private $authentication;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Authentication');

        $this->authentication = $this->lb_authentication->check();
    }

    function login() {
        if (isset($this->authentication) && is_array($this->authentication))
            redirect('backend_post/post/view');
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|valid_email');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[8]|max_length[40]');
            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $user = $this->M_Authentication->_get([
                    'select' => '*',
                    'table' => 'user',
                    'param_where' => array(
                        'email' => $email,
                        'password' => sha1(md5($password))
                    )
                ]);
                if (is_array($user) && count($user)) {
                    //dang nhap thanh cong
                    //Lay permission
                    $permission = $this->M_Authentication->_get([
                        'select' => 'permission',
                        'table' => 'user_group',
                        'param_where' => [
                            'id' => $user['group_id']
                        ]
                    ]);
                    $user['permission'] = json_decode($permission['permission'], TRUE);

                    $user_data = array(
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'password' => $user['password'],
                        'permission' => $user['permission']
                    );
                    $this->session->set_userdata('authentication', $user_data);
                    redirect('backend_post/post/view');
                } else {
                    //dang nhap that bai
                    $this->session->set_flashdata('message_error', array(
                        'message' => 'Email hoặc mật khẩu không đúng!',
                    ));
                }
            }
        }
        $this->load->view('login');
    }

    //Logout
    function logout() {
        if (isset($this->authentication) && is_array($this->authentication)) {
            $this->session->unset_userdata('authentication');
            redirect(base_url());
        }
    }

}
