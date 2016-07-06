<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    private $authentication;
    private $segment;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_User');
        $this->load->library('Lb_string');

        $this->authentication = $this->lb_authentication->check();
        if (empty($this->authentication))
            redirect('admin');
        if (empty($this->authentication['permission'])) {
            show_error('Bạn không được cấp quyền để thực hiện thao tác này', 403, 'Lỗi! 403');
        }

        $this->segment = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);
        if (!in_array($this->segment, $this->authentication['permission'])) {
            show_error('Bạn không được cấp quyền để thực hiện thao tác này', 403, 'Lỗi! 403');
        }
    }

    function index() {
        $this->view();
    }

    function view($page = 1) {
        //Co submit gui len
        if (isset($_POST['submit'])) {
            $redirect = $this->lb_string->url_origin();
            $action = $this->input->post('action');
            $checkbox = $this->input->post('checkbox');
            if ($action == "delete" && is_array($checkbox)) {
                //Hanh dong xoa
                $flag = $this->M_User->delete_users($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else if ($action == "active" && is_array($checkbox)) {
                //Hanh dong xuat ban
                $flag = $this->M_User->active_users($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else if ($action == "banned" && is_array($checkbox)) {
                //Hanh dong bo xuat ban
                $flag = $this->M_User->deactivate_users($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else {
                $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Bạn chưa chọn thao tác hoặc chưa chọn đối tượng!'));
            }
        }

        // pagination      
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = base_url() . '/backend_user/user/view/';
        $config['total_rows'] = $this->M_User->count_user();
        $config['per_page'] = 10;
        $config['num_links'] = 4;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = '&laquo; Đầu';
        $config['last_link'] = 'Cuối &raquo;';
        $config['prev_link'] = '&larr;';
        $config['next_link'] = '&rarr;';
        $config['cur_tag_open'] = '<a class="number current">';
        $config['cur_tag_close'] = '</a>';
        $total_pages = ceil($config['total_rows'] / $config['per_page']);
        $page = ($page < 1) ? 1 : $page;
        $page = ($page > $total_pages) ? $total_pages : $page;
        $page = $page - 1;
        $this->pagination->initialize($config);
        $data['paginator'] = $this->pagination->create_links();

        if ($page >= 0) {
            $data['user'] = $this->M_User->view($config['per_page'], $page * $config['per_page']);
        }

        $data['meta_title'] = "Quản lý tài khoản";
        $data['template'] = 'user/view';
        $data['active'] = 'view_user';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    function add() {
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            $this->form_validation->set_rules('name', 'Tên đầy đủ', 'trim|required|min_length[3]|max_length[60]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|valid_email|callback__email');
            $this->form_validation->set_rules('password', 'Mật khẩu 1', 'trim|required|min_length[8]|max_length[40]');
            $this->form_validation->set_rules('repassword', 'Mật khẩu 2', 'trim|required|min_length[8]|max_length[40]|matches[password]');
            $this->form_validation->set_rules('group', 'Nhóm', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Đóng"><span aria-hidden="true">×</span></button>', '</div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_User->_save(array(
                    'table' => 'user',
                    'data' => array(
                        'name' => addslashes($this->input->post('name')),
                        'email' => $this->input->post('email'),
                        'password' => sha1(md5($this->input->post('password'))),
                        'group_id' => (int) $this->input->post('group'),
                        'status' => '1'
                    )
                ));
                if ($flag >= 1) {
                    //them thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Thêm thành viên ' . $this->input->post('name') . ' thành công',
                    ));
                } else {
                    //them that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Thêm thành viên thất bại!'
                    ));
                }
                redirect('backend_user/user/view');
            }
        }
        $data['group'] = $this->M_User->group_dropdown();
        $data['meta_title'] = "Thêm thành viên";
        $data['template'] = 'user/add';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    function edit($id) {
        $id = (int) ($id);
        $data['user'] = $this->M_User->_get(array(
            'select' => 'id, name, email, group_id, status',
            'table' => 'user',
            'param_where' => ['id' => $id]
        ));
        $data['group'] = $this->M_User->group_dropdown();

        if (!isset($data['user']) || !is_array($data['user']) || count($data['user']) == 0) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Tài khoản không tồn tại!',
            ));
            redirect('backend_user/user/view');
        }
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            if ($data['user']['email'] != $this->input->post('email')) {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|valid_email|callback__email');
            }
            $this->form_validation->set_rules('name', 'Tên đầy đủ', 'trim|required|min_length[3]|max_length[60]');
            $this->form_validation->set_rules('group', 'Nhóm', 'trim|required|is_natural');
            $this->form_validation->set_rules('status', 'Trạng thái', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Đóng"><span aria-hidden="true">×</span></button>', '</div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_User->_save(array(
                    'param_where' => ['id' => $id],
                    'table' => 'user',
                    'data' => array(
                        'name' => addslashes($this->input->post('name')),
                        'email' => $this->input->post('email'),
                        'group_id' => (int) $this->input->post('group'),
                        'status' => (int) $this->input->post('status')
                    ),
                    'date' => TRUE
                ));
                if ($flag >= 1) {
                    //cap nhat thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Chỉnh sửa thông tin thành viên ' . $this->input->post('name') . ' thành công',
                    ));
                } else {
                    //cap nhat that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Chỉnh sửa thông tin thành viên thất bại!'
                    ));
                }
                $redirect = base64_decode($this->input->get('redirect'));
                redirect(isset($redirect) ? $redirect : 'backend_user/user/view');
            }
        }
        $data['meta_title'] = "Chỉnh sửa thông tin thành viên";
        $data['template'] = 'user/edit';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    function del($id) {
        $id = (int) ($id);
        $data['user'] = $this->M_User->_get(array(
            'select' => 'id, name',
            'table' => 'user',
            'param_where' => ['id' => $id]
        ));

        if (!isset($data['user']) || !is_array($data['user']) || count($data['user']) == 0) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Tài khoản không tồn tại!',
            ));
            redirect('backend_user/user/view');
        }

        //Dem so bai viet cua thanh vien
        $num_post = $this->M_User->_get([
            'select' => 'doc_id',
            'table' => 'document',
            'param_where' => ['doc_publisher' => $id],
            'count' => TRUE
        ]);
        (isset($num_post) && ($num_post > 0)) ? $data['num_post'] = $num_post : '';

        if (isset($_POST['submit'])) {
            $flag = $this->M_User->_del(array(
                'param_where' => ['id' => $id],
                'table' => 'user'
            ));
            if ($flag >= 1) {
                //Xoa thanh cong
                $this->session->set_flashdata('message_flashdata', array(
                    'status' => 'success',
                    'message' => 'Xóa thành viên ' . $data['user']['name'] . ' thành công',
                ));
            } else {
                //Xóa that bai
                $this->session->set_flashdata('message_flashdata', array(
                    'status' => 'error',
                    'message' => 'Xóa thành viên thất bại!'
                ));
            }
            $redirect = base64_decode($this->input->get('redirect'));
            redirect(isset($redirect) ? $redirect : 'backend_user/user/view');
        }
        $data['meta_title'] = "Xóa thành viên";
        $data['template'] = 'user/del';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //update profile
    function update_profile() {
        $data['user'] = $this->M_User->_get(array(
            'select' => 'id, name, email, password',
            'table' => 'user',
            'param_where' => ['id' => $this->authentication['id']]
        ));

        if (!isset($data['user']) || !is_array($data['user']) || count($data['user']) == 0) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Tài khoản không tồn tại!',
            ));
            redirect('backend_user/user/view');
        }
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            if (!empty($this->input->post('password')) && sha1(md5($this->input->post('password'))) != $data['user']['password']) {
                $this->session->set_flashdata('message_flashdata', array(
                    'status' => 'error',
                    'message' => 'Mật khẩu cũ không đúng!',
                ));
                redirect('backend_user/user/update_profile');
            }
            if (!empty($this->input->post('newPassword')) && !empty($this->input->post('confirmNewPassword'))) {
                $this->form_validation->set_rules('newPassword', '', 'trim|required|min_length[8]|max_length[40]');
                $this->form_validation->set_rules('confirmNewPassword', '', 'trim|required|min_length[8]|max_length[40]|matches[newPassword]');
                $updatePassword = TRUE;
            }
            if ($data['user']['email'] != $this->input->post('email')) {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|valid_email|callback__email');
            }
            $this->form_validation->set_rules('name', 'Tên đầy đủ', 'trim|required|min_length[3]|max_length[60]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Đóng"><span aria-hidden="true">×</span></button>', '</div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_User->_save(array(
                    'param_where' => ['id' => $this->authentication['id']],
                    'table' => 'user',
                    'data' => array(
                        'name' => addslashes($this->input->post('name')),
                        'email' => $this->input->post('email'),
                        'password' => (isset($updatePassword) && $updatePassword == TRUE) ? sha1(md5(trim($this->input->post('newPassword')))) : sha1(md5(trim($this->input->post('password'))))
                    ),
                    'date' => TRUE
                ));
                if ($flag >= 1) {
                    //cap nhat thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Cập nhật hồ sơ thành công',
                    ));
                } else {
                    //cap nhat that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Không có gì được cập nhật!'
                    ));
                }
                redirect('backend_user/user/update_profile');
            }
        }
        $data['meta_title'] = "Chỉnh sửa hồ sơ cá nhân";
        $data['template'] = 'user/update_profile';
        $data['authentication'] = $this->authentication;
        $data['active'] = 'update_profile';
        $this->load->view('backend/layout/home', $data);
    }

    //Callback email
    public function _email($email = '') {
        $count = $this->M_User->_get(array(
            'table' => 'user',
            'param_where' => array(
                'email' => $email
            ),
            'count' => TRUE
        ));
        if ($count >= 1) {
            $this->form_validation->set_message('_email', '{field} đã tồn tại');
            return FALSE;
        }
        return TRUE;
    }

}
