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
class Post extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_Post');
        $this->load->library('Lb_string');
        $this->load->library('nestedset', array('model' => 'M_Category', 'table' => 'category'));

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
        //Co submit gui len
        if ($this->input->post('submit')) {
            $redirect = $this->lb_string->url_origin();
            $action = $this->input->post('action');
            $checkbox = $this->input->post('checkbox');
            if ($action == "delete" && is_array($checkbox)) {
                //Hanh dong xoa
                $flag = $this->M_Post->delete($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else if ($action == "publish" && is_array($checkbox)) {
                //Hanh dong xuat ban
                $flag = $this->M_Post->publish($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else if ($action == "unpublish" && is_array($checkbox)) {
                //Hanh dong bo xuat ban
                $flag = $this->M_Post->unpublish($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else {
                $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Bạn chưa chọn thao tác hoặc chưa chọn đối tượng!'));
            }
        }
        // pagination      
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = base_url() . 'backend_post/post/view';
        $config['total_rows'] = $this->M_Post->count_post();
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
            $data['list_post'] = $this->M_Post->view_post($config['per_page'], $page * $config['per_page']);
        }

        //print_r($data['list_post']);die;
        $data['authentication'] = $this->authentication;
        $data['meta_title'] = 'Tất cả bài viết';
        $data['active'] = 'view_post';
        $data['template'] = 'post/view';
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
            $this->form_validation->set_rules('post_name', 'Tên bài viết', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('image', 'Hình minh họa', 'trim|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|max_length[500]');
            $this->form_validation->set_rules('description', 'Mô tả', 'trim|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('post_content', 'Nội dung bài viết', 'trim|min_length[3]|required');
            $this->form_validation->set_rules('parent', 'Chuyên mục cha', 'trim|required|is_natural');
            $this->form_validation->set_rules('feature', 'Bài viết nổi bật', 'trim|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Post->_save(array(
                    'table' => 'post',
                    'data' => array(
                        'post_category' => (int) $this->input->post('parent'),
                        'post_name' => addslashes($this->input->post('post_name')),
                        'post_slug' => mb_strtolower(url_title($this->lb_string->removesign($this->input->post('post_name')))),
                        'post_keyword' => addslashes($this->input->post('keyword')),
                        'post_description' => addslashes($this->input->post('description')),
                        'post_content' => addslashes($this->input->post('post_content')),
                        'post_image' => str_replace(base_url(), '', $this->input->post('image')),
                        'post_publisher' => $this->authentication['id'],
                        'post_feature' => (int) $this->input->post('feature'),
                        'post_status' => (int) $this->input->post('post_status'),
                    ),
                    'date' => TRUE
                ));
                if ($flag >= 1) {
                    //them thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Thêm bài viết thành công',
                    ));
                } else {
                    //them that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Thêm bài viết thất bại!'
                    ));
                }
                redirect('backend_post/post/view');
            }
        }

        $data['dropdown_category'] = $this->nestedset->dropdown();
        $data['meta_title'] = "Thêm bài viết";
        $data['template'] = 'post/add';
        $data['active'] = 'add_post';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Edit post
    function edit($id = 0) {
        //Kiem tra xem tai lieu co ton tai hay khong
        $post = $this->M_Post->_get([
            'select' => '*',
            'table' => 'post',
            'param_where' => ['post_id' => $id]
        ]);
        if (!isset($post) || count($post) == 0) {
            $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Bài viết không tồn tại!'));
            redirect('backend_post/post/view');
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
            $this->form_validation->set_rules('post_name', 'Tên bài viết', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('image', 'Hình minh họa', 'trim|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|max_length[500]');
            $this->form_validation->set_rules('description', 'Mô tả', 'trim|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('post_content', 'Nội dung bài viết', 'trim|min_length[3]|required');
            $this->form_validation->set_rules('parent', 'Chuyên mục cha', 'trim|required|is_natural');
            $this->form_validation->set_rules('feature', 'Bài viết nổi bật', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Post->_save(array(
                    'table' => 'post',
                    'data' => array(
                        'post_category' => (int) $this->input->post('parent'),
                        'post_name' => addslashes($this->input->post('post_name')),
                        'post_slug' => mb_strtolower(url_title($this->lb_string->removesign($this->input->post('post_name')))),
                        'post_keyword' => addslashes($this->input->post('keyword')),
                        'post_description' => addslashes($this->input->post('description')),
                        'post_content' => addslashes($this->input->post('post_content')),
                        'post_image' => str_replace(base_url(), '', $this->input->post('image')),
                        'post_publisher' => $this->authentication['id'],
                        'post_feature' => (int) $this->input->post('feature'),
                        'post_status' => (int) $this->input->post('post_status'),
                    ),
                    'date' => TRUE,
                    'param_where' => ['post_id' => $id]
                ));
                if ($flag >= 1) {
                    //update thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Sửa bài viết thành công',
                    ));
                } else {
                    //update that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Không có gì được cập nhật!'
                    ));
                }
                redirect('backend_post/post/view');
            }
        }
        $data['post'] = $post;
        $data['dropdown_category'] = $this->nestedset->dropdown();
        $data['authentication'] = $this->authentication;
        $data['meta_title'] = "Sửa bài viết";
        $data['template'] = 'post/edit';
        $this->load->view('backend/layout/home', $data);
    }

    //Xoa tai lieu
    function del($id) {
        $id = (int) ($id);
        $data['post'] = $this->M_Post->_get(array(
            'select' => 'post_id, post_name, post_image',
            'table' => 'post',
            'param_where' => ['post_id' => $id]
        ));

        if (empty($data['post']) || !is_array($data['post'])) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Bài viết không tồn tại!',
            ));
            redirect('backend_post/post/view');
        } else {
            if (isset($_POST['submit'])) {
                $flag = $this->M_Post->_del(array(
                    'param_where' => ['post_id' => $id],
                    'table' => 'post'
                ));
                if ($flag >= 1) {
                    //Xoa thanh cong 
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Xóa bài viết thành công',
                    ));
                } else {
                    //Xóa that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Xóa bài viết thất bại!'
                    ));
                }
                $redirect = base64_decode($this->input->get('redirect'));
                redirect(isset($redirect) ? $redirect : 'backend_post/post/view');
            }
        }

        $data['meta_title'] = "Xóa bài viết";
        $data['template'] = 'post/del';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Callback Parent
    function _parent($parent = '', $json = NULL) {
        if (isset($json)) {
            $param = json_decode($json, TRUE);
            if (isset($param) && is_array($param)) {
                $children = $this->M_Category->_get([
                    'select' => 'id',
                    'table' => 'category',
                    'param_where' => [
                        'lft >=' => $param['lft'],
                        'rgt <=' => $param['rgt']
                    ],
                    'list' => TRUE
                ]);
                if (!empty($children) && is_array($children)) {
                    $tempChildren = NULL;
                    foreach ($children as $key => $val) {
                        $tempChildren[] = $val['id'];
                    }

                    if (in_array($parent, $tempChildren)) {
                        $this->form_validation->set_message('_parent', "Không thể chọn chuyên mục này làm cha");
                        return FALSE;
                    } else {
                        return TRUE;
                    }
                }
            }
        }
    }

}
