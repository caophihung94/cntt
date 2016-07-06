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
class Setting extends MY_Controller {

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
    }

    //Edit
    function index() {
        //Kiem tra xem page co ton tai hay khong
        $setting = $this->M_Setting->_get([
            'select' => '*',
            'table' => 'setting'
        ]);

        //Kiem tra thu muc upload
        $dir = "source/users/{$this->authentication['id']}";
        if (!file_exists($dir)) {
            @mkdir("source/users/{$this->authentication['id']}");
        }

        $cookie_value = random_string('alnum', 16) . base64_encode("users/{$this->authentication['id']}");
        setcookie('RF', $cookie_value, time() + (86400), "/"); // 86400 = 1 day

        if (isset($_POST['submit'])) {
            $flag = $this->M_Setting->_save(array(
                'table' => 'setting',
                'data' => [
                    'company_name' => addslashes($this->input->post('company_name')),
                    'banner' => addslashes(str_replace(base_url(), '', $this->input->post('banner'))),
                    'title_website' => addslashes($this->input->post('title_website')),
                    'url' => addslashes($this->input->post('url')),
                    'email' => addslashes($this->input->post('email')),
                    'phone_number' => addslashes($this->input->post('phone_number')),
                    'address' => addslashes($this->input->post('address')),
                    'map' => addslashes($this->input->post('map')),
                    'facebook' => addslashes($this->input->post('facebook')),
                    'twitter' => addslashes($this->input->post('twitter')),
                    'yahoo' => addslashes($this->input->post('yahoo')),
                    'youtube' => addslashes($this->input->post('youtube')),
                    'keywords' => addslashes($this->input->post('keywords')),
                    'description' => $this->input->post('description')
                ],
                'param_where' => ['id' => 1]
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
            redirect('backend_setting/setting');
        }
        $data['setting'] = $setting;
        $data['meta_title'] = "Cài đặt trang";
        $data['template'] = 'setting';
        $data['active'] = 'setting';
        $this->load->view('backend/layout/home', $data);
    }

}
