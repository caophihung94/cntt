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
class Page extends MY_Controller {

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

    function view($page = 1) {
        $data['list_page'] = $this->M_Menu->get_list_pages();
        $data['authentication'] = $this->authentication;
        $data['meta_title'] = 'Tất cả trang';
        $data['active'] = 'view_page';
        $data['template'] = 'page/view';
        $this->load->view('backend/layout/home', $data);
    }

    function add() {
        //Kiem tra thu muc upload
        $dir = "source/users/{$this->authentication['id']}";
        if (!file_exists($dir)) {
            @mkdir("source/users/{$this->authentication['id']}");
        }

        $cookie_value = random_string('alnum', 16) . base64_encode("users/{$this->authentication['id']}");
        setcookie('RF', $cookie_value, time() + (86400), "/"); // 86400 = 1 day

        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            $this->form_validation->set_rules('page_name', 'Tên trang', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('menu', 'Menu', 'trim|is_natural');
            $this->form_validation->set_rules('page_content', 'Nội dung', 'trim|required|min_length[3]');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Menu->_save(array(
                    'table' => 'page',
                    'data' => array(
                        'page_name' => addslashes($this->input->post('page_name')),
                        'menu_id' => (int) $this->input->post('menu'),
                        'page_slug' => mb_strtolower(url_title($this->lb_string->removesign($this->input->post('page_name')))),
                        'page_content' => addslashes($this->input->post('page_content')),
                        'page_position' => (int) $this->input->post('page_position')
                    )
                ));
                if ($flag >= 1) {
                    //them thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Thêm trang thành công',
                    ));
                } else {
                    //them that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Thêm trang thất bại!'
                    ));
                }
                redirect('backend_menu/page/view');
            }
        }

        $data['list_menu'] = $this->M_Menu->_get([
            'table' => 'menu',
            'select' => '*',
            'orderby' => 'menu_position ASC',
            'list' => TRUE
        ]);

        $data['meta_title'] = "Thêm trang";
        $data['template'] = 'page/add';
        $data['active'] = 'add_page';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Edit trang
    function edit($id = 0) {
        //Kiem tra xem page co ton tai hay khong
        $page = $this->M_Menu->_get([
            'select' => '*',
            'table' => 'page',
            'param_where' => ['id' => $id]
        ]);
        if (!isset($page) || count($page) == 0) {
            $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Menu không tồn tại!'));
            redirect('backend_menu/page/view');
        }

        //Kiem tra thu muc upload
        $dir = "source/users/{$this->authentication['id']}";
        if (!file_exists($dir)) {
            @mkdir("source/users/{$this->authentication['id']}");
        }

        $cookie_value = random_string('alnum', 16) . base64_encode("users/{$this->authentication['id']}");
        setcookie('RF', $cookie_value, time() + (86400), "/"); // 86400 = 1 day

        if (isset($_POST['submit'])) {
            ///Validate dữ liệu form
            $this->form_validation->set_rules('page_name', 'Tên trang', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('menu', 'Menu', 'trim|is_natural');
            $this->form_validation->set_rules('page_content', 'Nội dung', 'trim|required|min_length[3]');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Menu->_save(array(
                    'table' => 'page',
                    'data' => array(
                        'page_name' => addslashes($this->input->post('page_name')),
                        'menu_id' => (int) $this->input->post('menu'),
                        'page_slug' => mb_strtolower(url_title($this->lb_string->removesign($this->input->post('page_name')))),
                        'page_content' => addslashes($this->input->post('page_content')),
                        'page_position' => (int) $this->input->post('page_position')
                    ),
                    'param_where' => ['id' => $id]
                ));
                if ($flag >= 1) {
                    //update thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Sửa thành công',
                    ));
                } else {
                    //update that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Không có gì được cập nhật!'
                    ));
                }
                redirect('backend_menu/page/view');
            }
        }
        $data['list_menu'] = $this->M_Menu->_get([
            'table' => 'menu',
            'select' => '*',
            'orderby' => 'menu_position ASC',
            'list' => TRUE
        ]);
        $data['page'] = $page;
        $data['authentication'] = $this->authentication;
        $data['meta_title'] = "Sửa trang";
        $data['template'] = 'page/edit';
        $this->load->view('backend/layout/home', $data);
    }

    //Xoa 
    function del($id) {
        $id = (int) ($id);
        $data['page'] = $this->M_Menu->_get([
            'select' => '*',
            'table' => 'page',
            'param_where' => ['id' => $id]
        ]);

        if (empty($data['page']) || !is_array($data['page'])) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Trang không tồn tại!',
            ));
            redirect('backend_menu/page/view');
        } else {
            if (isset($_POST['submit'])) {
                $flag = $this->M_Menu->_del(array(
                    'param_where' => ['id' => $id],
                    'table' => 'page'
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
                redirect(isset($redirect) ? $redirect : 'backend_menu/page/view');
            }
        }

        $data['meta_title'] = "Xóa trang";
        $data['template'] = 'page/del';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

}
