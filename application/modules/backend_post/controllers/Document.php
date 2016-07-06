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
class Document extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_Document');
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
        // pagination      
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = base_url() . 'backend_post/document/view';
        $config['total_rows'] = $this->M_Document->count_post();
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

        //Lay danh sach tai lieu
        if ($page >= 0) {
            $data['list_document'] = $this->M_Document->view_post($config['per_page'], $page * $config['per_page']);
        }

        //print_r($data['list_post']);die;
        $data['meta_title'] = 'Tất cả đồ án';
        $data['active'] = 'view_document';
        $data['template'] = 'document/view';
        $data['authentication'] = $this->authentication;
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
            $this->form_validation->set_rules('doc_file', 'Tài liệu', 'trim|required|callback__filetype');
            $this->form_validation->set_rules('doc_image', 'Hình minh họa', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('doc_name', 'Tên đồ án', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|max_length[500]');
            $this->form_validation->set_rules('description', 'Mô tả', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('author', 'Tác giả', 'trim|min_length[3]|max_length[60]');
            $this->form_validation->set_rules('instructor', 'Giảng viên hướng dẫn', 'trim|min_length[3]|max_length[60]');
            $this->form_validation->set_rules('doc_yearPublish', 'Năm bảo vệ', 'trim|greater_than_equal_to[1800]|less_than_equal_to[' . date('Y') . ']');
            $this->form_validation->set_rules('doc_feature', 'Tài liệu nổi bật', 'trim|required|is_natural');
            $this->form_validation->set_rules('doc_status', 'Trạng thái', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Document->_save(array(
                    'table' => 'document',
                    'data' => [
                        'doc_name' => addslashes($this->input->post('doc_name')),
                        'doc_slug' => mb_strtolower(url_title($this->lb_string->removesign($this->input->post('doc_name')))),
                        'doc_keyword' => addslashes($this->input->post('keyword')),
                        'doc_description' => addslashes($this->input->post('description')),
                        'doc_file' => str_replace(base_url(), '', $this->input->post('doc_file')),
                        'doc_image' => str_replace(base_url(), '', $this->input->post('doc_image')),
                        'doc_author' => addslashes($this->input->post('author')),
                        'instructor' => addslashes($this->input->post('instructor')),
                        'doc_yearPublish' => $this->input->post('doc_yearPublish'),
                        'doc_publisher' => $this->authentication['id'],
                        'doc_feature' => (int) $this->input->post('doc_feature'),
                        'doc_status' => (int) $this->input->post('doc_status'),
                    ],
                    'date' => TRUE
                ));
                if ($flag) {
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
                redirect('backend_post/document/view');
            }
        }

        $data['meta_title'] = "Thêm đồ án";
        $data['template'] = 'document/add';
        $data['active'] = 'add_document';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Edit document
    function edit($id = 0) {
        //Kiem tra xem tai lieu co ton tai hay khong
        $document = $this->M_Document->_get([
            'select' => '*',
            'table' => 'document',
            'param_where' => ['doc_id' => $id]
        ]);
        if (!isset($document) || count($document) == 0) {
            $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Tài liệu không tồn tại!'));
            redirect('backend_post/document/view');
        }

        //Kiem tra thu muc upload
        $dir = "source/users/{$this->authentication['id']}";
        if (!file_exists($dir)) {
            @mkdir("source/users/{$this->authentication['id']}");
        }

        $cookie_value = random_string('alnum', 16) . base64_encode("users/{$this->authentication['id']}");
        setcookie('RF', $cookie_value, time() + (86400), "/"); // 86400 = 1 day

        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            $this->form_validation->set_rules('doc_file', 'Tài liệu', 'trim|required|callback__filetype');
            $this->form_validation->set_rules('doc_image', 'Hình minh họa', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('doc_name', 'Tên đồ án', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|max_length[500]');
            $this->form_validation->set_rules('description', 'Mô tả', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('author', 'Tác giả', 'trim|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('instructor', 'Giảng viên hướng dẫn', 'trim|min_length[3]|max_length[60]');
            $this->form_validation->set_rules('doc_yearPublish', 'Năm bảo vệ', 'trim|greater_than_equal_to[1800]|less_than_equal_to[' . date('Y') . ']');
            $this->form_validation->set_rules('doc_feature', 'Tài liệu nổi bật', 'trim|required|is_natural');
            $this->form_validation->set_rules('doc_status', 'Trạng thái', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Document->_save(array(
                    'table' => 'document',
                    'data' => array(
                        'doc_name' => addslashes($this->input->post('doc_name')),
                        'doc_slug' => mb_strtolower(url_title($this->lb_string->removesign($this->input->post('doc_name')))),
                        'doc_keyword' => addslashes($this->input->post('keyword')),
                        'doc_description' => addslashes($this->input->post('description')),
                        'doc_file' => str_replace(base_url(), '', $this->input->post('doc_file')),
                        'doc_image' => str_replace(base_url(), '', $this->input->post('doc_image')),
                        'doc_author' => addslashes($this->input->post('author')),
                        'instructor' => addslashes($this->input->post('instructor')),
                        'doc_yearPublish' => $this->input->post('doc_yearPublish'),
                        'doc_publisher' => $this->authentication['id'],
                        'doc_feature' => (int) $this->input->post('doc_feature'),
                        'doc_status' => (int) $this->input->post('doc_status'),
                    ),
                    'date' => TRUE,
                    'param_where' => ['doc_id' => $id]
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
                redirect('backend_post/document/view');
            }
        }
        $data['document'] = $document;
        $data['authentication'] = $this->authentication;
        $data['meta_title'] = "Sửa đồ án";
        $data['active'] = 'add_document';
        $data['template'] = 'document/edit';
        $this->load->view('backend/layout/home', $data);
    }

    //Xoa tai lieu
    function del($id) {
        $id = (int) ($id);
        $data['document'] = $this->M_Document->_get(array(
            'select' => 'doc_name',
            'table' => 'document',
            'param_where' => ['doc_id' => $id]
        ));

        if (empty($data['document'])) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Tài liệu không tồn tại!',
            ));
            redirect('backend_post/document/view');
        } else {
            if (isset($_POST['submit'])) {
                $flag = $this->M_Document->_del(array(
                    'param_where' => ['doc_id' => $id],
                    'table' => 'document'
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
                redirect(isset($redirect) ? $redirect : 'backend_post/document/view');
            }
        }

        $data['meta_title'] = "Xóa đồ án";
        $data['template'] = 'document/del';
        $data['active'] = 'add_document';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Callback filetype
    public function _filetype($filetype = '') {
        $type = pathinfo($filetype, PATHINFO_EXTENSION);
        if ($type == 'pdf' || $type == 'doc' || $type == 'docx') {
            return TRUE;
        } else {
            $this->form_validation->set_message('_filetype', 'Định dạng file không hợp lệ');
            return FALSE;
        }
    }

}
