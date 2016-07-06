<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author caohu
 */
class Menu extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_Menu');
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

    function view() {
        $data['list_menu'] = $this->M_Menu->_get([
            'table' => 'menu',
            'select' => '*',
            'orderby' => 'menu_position ASC',
            'list' => TRUE
        ]);

        $data['authentication'] = $this->authentication;
        $data['meta_title'] = 'Tất cả menu';
        $data['template'] = 'menu/view';
        $data['active'] = 'menu';
        $this->load->view('backend/layout/home', $data);
    }

    function add() {
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            $this->form_validation->set_rules('menu_name', 'Tên menu', 'trim|required|max_length[60]');
            $this->form_validation->set_rules('menu_position', 'Vị trí menu', 'trim|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Menu->_save(array(
                    'table' => 'menu',
                    'data' => array(
                        'menu_name' => addslashes($this->input->post('menu_name')),
                        'menu_position' => (int) $this->input->post('menu_position')
                    )
                ));
                if ($flag >= 1) {
                    //them thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Thêm menu thành công',
                    ));
                } else {
                    //them that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Thêm menu thất bại!'
                    ));
                }
                redirect('backend_menu/menu/view');
            }
        }

        $data['meta_title'] = "Thêm menu";
        $data['template'] = 'menu/add';
        $data['active'] = 'menu';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Edit menu
    function edit($id = 0) {
        //Kiem tra xem page co ton tai hay khong
        $menu = $this->M_Menu->_get([
            'select' => '*',
            'table' => 'menu',
            'param_where' => ['id' => $id]
        ]);
        if (!isset($menu) || count($menu) == 0) {
            $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Menu không tồn tại!'));
            redirect('backend_menu/menu/view');
        }

        if (isset($_POST['submit'])) {
            ///Validate dữ liệu form
            $this->form_validation->set_rules('menu_name', 'Tên menu', 'trim|required|max_length[60]');
            $this->form_validation->set_rules('menu_position', 'Vị trí menu', 'trim|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Menu->_save(array(
                    'table' => 'menu',
                    'data' => array(
                        'menu_name' => addslashes($this->input->post('menu_name')),
                        'menu_position' => (int) $this->input->post('menu_position')
                    ),
                    'param_where' => ['id' => $id]
                ));
                if ($flag >= 1) {
                    //update thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Cập nhật thành công',
                    ));
                } else {
                    //update that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Không có gì được cập nhật!'
                    ));
                }
                redirect('backend_menu/menu/view');
            }
        }
        $data['menu'] = $menu;
        $data['authentication'] = $this->authentication;
        $data['meta_title'] = "Sửa menu";
        $data['template'] = 'menu/edit';
        $data['active'] = 'menu';
        $this->load->view('backend/layout/home', $data);
    }

    //Xoa 
    function del($id) {
        $id = (int) ($id);
        $data['menu'] = $this->M_Menu->_get([
            'select' => '*',
            'table' => 'menu',
            'param_where' => ['id' => $id]
        ]);

        if (empty($data['menu']) || !is_array($data['menu'])) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Menu không tồn tại!',
            ));
            redirect('backend_menu/menu/view');
        } else {
            //Xem trong menu con page nao khonng
            $num_page = $this->M_Menu->_get([
                'table' => 'page',
                'param_where' => ['menu_id' => $id],
                'count' => TRUE
            ]);
            if ($num_page == 0) {
                //Khong co page nao => xoa
                if (isset($_POST['submit'])) {
                    $flag = $this->M_Menu->_del(array(
                        'param_where' => ['id' => $id],
                        'table' => 'menu'
                    ));
                    if ($flag >= 1) {
                        //Xoa thanh cong tai lieu
                        $this->session->set_flashdata('message_flashdata', array(
                            'status' => 'success',
                            'message' => 'Xóa thành công',
                        ));
                    } else {
                        //Xóa that bai
                        $this->session->set_flashdata('message_flashdata', array(
                            'status' => 'error',
                            'message' => 'Lỗi! Xóa thất bại!'
                        ));
                    }
                    $redirect = base64_decode($this->input->get('redirect'));
                    redirect(isset($redirect) ? $redirect : 'backend_menu/menu/view');
                }
            } else {
                //Con page => khong xoa
                $this->session->set_flashdata('message_flashdata', array(
                    'status' => 'error',
                    'message' => "Còn $num_page trang trong menu này. Vui lòng di chuyển các trang đó sang menu khác rồi thử lại!"
                ));
                $redirect = base64_decode($this->input->get('redirect'));
                redirect(isset($redirect) ? $redirect : 'backend_menu/menu/view');
            }
        }

        $data['meta_title'] = "Xóa menu";
        $data['template'] = 'menu/del';
        $data['authentication'] = $this->authentication;
        $data['active'] = 'menu';
        $this->load->view('backend/layout/home', $data);
    }

}
