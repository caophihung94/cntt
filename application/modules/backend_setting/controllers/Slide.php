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
class Slide extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_Setting');
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
        $data['list_item'] = $this->M_Setting->_get([
            'table' => 'slide',
            'select' => '*',
            'orderby' => 'position ASC',
            'list' => TRUE
        ]);

        $data['authentication'] = $this->authentication;
        $data['meta_title'] = 'Quản lí slide';
        $data['active'] = 'slide';
        $data['template'] = 'slide/view';
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
            $this->form_validation->set_rules('image', 'Ảnh', 'trim|required');
            $this->form_validation->set_rules('caption', 'Mô tả', 'trim|max_length[500]');
            $this->form_validation->set_rules('position', 'Vị trí', 'trim|required|is_natural');
            $this->form_validation->set_rules('publish', 'Trạng thái', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Setting->_save(array(
                    'table' => 'slide',
                    'data' => [
                        'image' => addslashes(str_replace(base_url(), '', $this->input->post('image'))),
                        'caption' => addslashes($this->input->post('caption')),
                        'link' => addslashes($this->input->post('link')),
                        'position' => (int) $this->input->post('position'),
                        'publish' => (int) $this->input->post('publish')
                    ]
                ));
                if ($flag >= 1) {
                    //them thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Thêm thành công',
                    ));
                } else {
                    //them that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Thêm thất bại!'
                    ));
                }
                redirect('backend_setting/slide/view');
            }
        }

        $data['meta_title'] = "Thêm ảnh";
        $data['template'] = 'slide/add';
        $data['active'] = 'slide';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Edit trang
    function edit($id = 0) {
        //Kiem tra xem page co ton tai hay khong
        $image = $this->M_Setting->_get([
            'select' => '*',
            'table' => 'slide',
            'param_where' => ['id' => $id]
        ]);
        if (!isset($image) || count($image) == 0) {
            $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Ảnh không tồn tại!'));
            redirect('backend_setting/slide/view');
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
            $this->form_validation->set_rules('image', 'Ảnh', 'trim|required');
            $this->form_validation->set_rules('caption', 'Mô tả', 'trim|max_length[500]');
            $this->form_validation->set_rules('position', 'Vị trí', 'trim|required|is_natural');
            $this->form_validation->set_rules('publish', 'Trạng thái', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Setting->_save(array(
                    'table' => 'slide',
                    'data' => [
                        'image' => addslashes(str_replace(base_url(), '', $this->input->post('image'))),
                        'caption' => addslashes($this->input->post('caption')),
                        'link' => addslashes($this->input->post('link')),
                        'position' => (int) $this->input->post('position'),
                        'publish' => (int) $this->input->post('publish')
                    ],
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
                redirect('backend_setting/slide/view');
            }
        }
        $data['image'] = $image;
        $data['meta_title'] = "Sửa ảnh";
        $data['template'] = 'slide/edit';
        $data['active'] = 'slide';
        $this->load->view('backend/layout/home', $data);
    }

    //Xoa 
    function del($id) {
        $id = (int) ($id);
        $data['block'] = $this->M_Setting->_get([
            'select' => '*',
            'table' => 'slide',
            'param_where' => ['id' => $id]
        ]);

        if (empty($data['block']) || !is_array($data['block'])) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Phần tử không tồn tại!',
            ));
            redirect('backend_setting/slide/view');
        } else {
            if (isset($_POST['submit'])) {
                $flag = $this->M_Setting->_del(array(
                    'param_where' => ['id' => $id],
                    'table' => 'slide'
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
                redirect(isset($redirect) ? $redirect : 'backend_setting/slide/view');
            }
        }

        $data['meta_title'] = "Xóa phần tử";
        $data['template'] = 'slide/del';
        $this->load->view('backend/layout/home', $data);
    }

}
