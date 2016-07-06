<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends MY_Controller {

    private $authentication;
    private $segment;

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Group');
        $this->load->library('Lb_string');

        $this->authentication = $this->lb_authentication->check();
        empty($this->authentication) ? redirect('admin') : '';
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

    function view() {
        $data['group'] = $this->M_Group->_get([
            'select' => '*',
            'table' => 'user_group',
            'orderby' => 'group_name ASC',
            'list' => TRUE
        ]);
        $data['authentication'] = $this->authentication;
        $data['meta_title'] = "Quản lý nhóm quyền";
        $data['template'] = 'group/view';
        $data['active'] = "view_group";
        $this->load->view('backend/layout/home', $data);
    }

    function add() {
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            $this->form_validation->set_rules('name', 'Tên nhóm quyền', 'trim|required|min_length[3]|max_length[60]|callback__groups');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Đóng"><span aria-hidden="true">×</span></button>', '</div>');

            if ($this->form_validation->run()) {
                $permissions = $this->input->post('permissions');
                if (!empty($permissions) && is_array($permissions)) {
                    $tempPermission = NULL;
                    foreach ($permissions as $key => $val) {
                        $tempPermission[] = $val;
                    }
                }
                $flag = $this->M_Group->_save(array(
                    'table' => 'user_group',
                    'data' => [
                        'group_name' => addslashes($this->input->post('name')),
                        'permission' => json_encode($tempPermission)
                    ]
                ));
                if ($flag >= 1) {
                    //them thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Thêm nhóm quyền ' . htmlentities($this->input->post('name')) . ' thành công',
                    ));
                } else {
                    //them that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Thêm nhóm quyền thất bại!'
                    ));
                }
                redirect('backend_user/group/view');
            }
        }
        $data['meta_title'] = "Thêm nhóm quyền";
        $data['template'] = 'group/add';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    function edit($id) {
        $id = (int) ($id);

        if ($id == 1) {
            //Khong cho phep sua nhom quyen admin
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Đây là nhóm quyền mặc định. Bạn không được phép sửa nhóm quyền này!',
            ));
            redirect('backend_user/group/view');
        }
        $data['group'] = $this->M_Group->_get(array(
            'select' => 'id, group_name',
            'table' => 'user_group',
            'param_where' => ['id' => $id]
        ));

        if (empty($data['group']) || !is_array($data['group'])) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Nhóm quyền không tồn tại!',
            ));
            redirect('backend_user/group/view');
        }
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            if ($data['group']['group_name'] != $this->input->post('name')) {
                $this->form_validation->set_rules('name', 'Tên nhóm quyền', 'trim|required|min_length[3]|max_length[60]|callback__groups');
            } else {
                $this->form_validation->set_rules('name', 'Tên nhóm quyền', 'trim|required|min_length[3]|max_length[60]');
            }

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Đóng"><span aria-hidden="true">×</span></button>', '</div>');

            if ($this->form_validation->run()) {
                $permissions = $this->input->post('permissions');
                if (!empty($permissions) && is_array($permissions)) {
                    $tempPermission = NULL;
                    foreach ($permissions as $key => $val) {
                        $tempPermission[] = $val;
                    }
                }
                $flag = $this->M_Group->_save(array(
                    'table' => 'user_group',
                    'data' => [
                        'group_name' => addslashes($this->input->post('name')),
                        'permission' => json_encode($tempPermission)
                    ],
                    'param_where' => ['id' => $id]
                ));
                if ($flag >= 1) {
                    //cap nhat thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Chỉnh sửa nhóm quyền ' . $this->input->post('name') . ' thành công',
                    ));
                } else {
                    //cap nhat that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Không nhóm quyền nào được chỉnh sửa!'
                    ));
                }
                $redirect = base64_decode($this->input->get('redirect'));
                redirect(isset($redirect) ? $redirect : 'backend_user/group/view');
            }
        } else {
            $permissions = $this->M_Group->_get([
                'select' => 'permission',
                'table' => 'user_group',
                'param_where' => ['id' => $id]
            ]);
            $data['permissions_post'] = json_decode($permissions['permission']);
        }
        $data['meta_title'] = "Chỉnh sửa nhóm quyền";
        $data['template'] = 'group/edit';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    function del($id = 0) {
        if ($id == 1) {
            //Khong cho phep sua nhom quyen admin
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Đây là nhóm quyền mặc định. Bạn không được phép sửa nhóm quyền này!',
            ));
            redirect('backend_user/group/view');
        }
        $data['group'] = $this->M_Group->_get(array(
            'select' => '*',
            'table' => 'user_group',
            'param_where' => ['id' => $id]
        ));

        if (empty($data['group']) || !is_array($data['group'])) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Nhóm quyền không tồn tại!',
            ));
            redirect('backend_user/group/view');
        }

        //Dem so thanh vien trong nhom
        $num_member = $this->M_Group->_get([
            'select' => 'id',
            'table' => 'user',
            'param_where' => ['group_id' => $id],
            'count' => TRUE
        ]);
        (isset($num_member) && ($num_member > 0)) ? $data['num_member'] = $num_member : '';
        if (isset($_POST['submit'])) {
            if ($num_member == 0) {
                //Khong co thanh vien nao trong nhom => duoc phep xoa
                $flag = $this->M_Group->_del(array(
                    'param_where' => ['id' => $id],
                    'table' => 'user_group'
                ));
                if ($flag >= 1) {
                    //Xoa thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Xóa nhóm quyền ' . $this->input->post('name') . ' thành công',
                    ));
                } else {
                    //Xóa that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Xóa nhóm quyền thất bại!'
                    ));
                }

                $redirect = base64_decode($this->input->get('redirect'));
                redirect(isset($redirect) ? $redirect : 'backend_user/group/view');
            }
        }
        $data['meta_title'] = "Xóa nhóm quyền";
        $data['template'] = 'group/del';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    public function _groups($group_name = '') {
        $count = $this->M_Group->_get(array(
            'table' => 'user_group',
            'param_where' => ['group_name' => $group_name],
            'count' => TRUE
        ));
        if ($count >= 1) {
            $this->form_validation->set_message('_groups', 'Nhóm này đã tồn tại !');
            return FALSE;
        }
        return TRUE;
    }

}
