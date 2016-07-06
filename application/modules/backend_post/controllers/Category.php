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
class Category extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_Category');
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
                $flag = $this->M_Category->delete($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else if ($action == "publish" && is_array($checkbox)) {
                //Hanh dong xuat ban
                $flag = $this->M_Category->publish($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else if ($action == "unpublish" && is_array($checkbox)) {
                //Hanh dong bo xuat ban
                $flag = $this->M_Category->unpublish($checkbox);
                $this->session->set_flashdata('message_flashdata', $flag);
                redirect($redirect);
            } else {
                $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Bạn chưa chọn thao tác hoặc chưa chọn đối tượng!'));
            }
        }
        // pagination      
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = base_url() . '/backend_post/category/view/';
        $config['total_rows'] = $this->M_Category->count_category();
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

        //Lay danh sach chuyen muc, load tu Model va Phan trang
        $list_category = $this->M_Category->view_category('category', $config['per_page'], $page * $config['per_page']);
        if (!empty($list_category) && is_array($list_category)) {
            $num_category = count($list_category);
            $tempList = NULL;
            foreach ($list_category as $key => $val) {
                for ($i = 0; $i < $num_category; $i++) {
                    $val['breadcrumb'] = $this->breadcrumb($val['lft'], $val['rgt']);
                }
                $tempList[] = $val;
            }
            $data['list_category'] = $tempList;
        }
        $data['authentication'] = $this->authentication;
        $data['meta_title'] = 'Tất cả danh mục';
        $data['active'] = 'view_category';
        $data['template'] = 'category/view';
        $this->load->view('backend/layout/home', $data);
    }

    function add() {
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            $this->form_validation->set_rules('cat_name', 'Tên chuyên mục', 'trim|required|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('description', 'Mô tả', 'trim|required|min_length[3]|max_length[500]');
            $this->form_validation->set_rules('parent', 'Chuyên mục cha', 'trim|required|is_natural');
            $this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|max_length[255]');
            $this->form_validation->set_rules('position', 'Vị trí', 'required');
            $this->form_validation->set_rules('publish', 'Trạng thái xuất bản', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Category->_save(array(
                    'table' => 'category',
                    'data' => array(
                        'parent_id' => (int) $this->input->post('parent'),
                        'cat_name' => addslashes($this->input->post('cat_name')),
                        'slug' => mb_strtolower(url_title($this->lb_string->removesign($this->input->post('cat_name')))),
                        'description' => addslashes($this->input->post('description')),
                        'keyword' => addslashes($this->input->post('keyword')),
                        'cat_position' => $this->input->post('position'),
                        'publish' => (int) $this->input->post('publish')
                    ),
                    'date' => TRUE
                ));
                if ($flag >= 1) {
                    //them thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Thêm danh mục ' . $this->input->post('cat_name') . ' thành công',
                    ));
                    $this->nestedset->get(array('orderby' => 'level ASC, id ASC'));
                    $this->nestedset->recursive(0, $this->nestedset->set());
                    $this->nestedset->action();
                } else {
                    //them that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Thêm chuyên mục thất bại!'
                    ));
                }
                redirect('backend_post/category/view');
            }
        }

        $data['dropdown_category'] = $this->nestedset->dropdown('Chuyên mục gốc');
        $data['meta_title'] = "Thêm chuyên mục";
        $data['template'] = 'category/add';
        $data['active'] = 'add_category';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Edit category
    function edit($id = 0) {
        //Kiem tra xem chuyen muc co ton tai hay khong
        $category = $this->M_Category->_get([
            'select' => '*',
            'table' => 'category',
            'param_where' => ['id' => $id]
        ]);
        if (!isset($category) || count($category) == 0) {
            $this->session->set_flashdata('message_flashdata', array('status' => 'error', 'message' => 'Lỗi! Chuyên mục không tồn tại!'));
            redirect('backend_post/category/view');
        }
        if (isset($_POST['submit'])) {
            //Validate dữ liệu form
            $this->form_validation->set_rules('cat_name', 'Tên chuyên mục', 'trim|required|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('description', 'Mô tả', 'trim|min_length[5]|max_length[500]');
            $this->form_validation->set_rules('parent', 'Chuyên mục cha', 'trim|required|is_natural|callback__parent[' . json_encode(['parent_id' => $id, 'lft' => $category['lft'], 'rgt' => $category['rgt']]) . ']');
            $this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|max_length[255]');
            $this->form_validation->set_rules('position', 'Vị trí', 'required');
            $this->form_validation->set_rules('publish', 'Trạng thái xuất bản', 'trim|required|is_natural');
            $this->form_validation->set_error_delimiters('<div class="notification error png_bg"><a href="#" class="close"><img src="' . base_url() . 'template/backend/simplaAdmin/images/icons/cross_grey_small.png" title="Đóng thông báo này" alt="close"></a><div>', '</div></div>');

            if ($this->form_validation->run()) {
                $flag = $this->M_Category->_save(array(
                    'table' => 'category',
                    'data' => array(
                        'parent_id' => (int) $this->input->post('parent'),
                        'cat_name' => addslashes($this->input->post('cat_name')),
                        'slug' => mb_strtolower(url_title($this->lb_string->removesign($this->input->post('cat_name')))),
                        'description' => addslashes($this->input->post('description')),
                        'keyword' => addslashes($this->input->post('keyword')),
                        'cat_position' => $this->input->post('position'),
                        'publish' => (int) $this->input->post('publish')
                    ),
                    'date' => TRUE,
                    'param_where' => ['id' => $id]
                ));
                if ($flag >= 1) {
                    //update thanh cong
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'success',
                        'message' => 'Sửa danh mục ' . $this->input->post('title') . ' thành công',
                    ));
                    $this->nestedset->get(array('orderby' => 'level ASC, id ASC'));
                    $this->nestedset->recursive(0, $this->nestedset->set());
                    $this->nestedset->action();
                } else {
                    //update that bai
                    $this->session->set_flashdata('message_flashdata', array(
                        'status' => 'error',
                        'message' => 'Lỗi! Sửa chuyên mục thất bại!'
                    ));
                }
                redirect('backend_post/category/view');
            }
        }
        $data['category'] = $category;
        $data['dropdown_category'] = $this->nestedset->dropdown('Chuyên mục gốc');
        $data['meta_title'] = "Sửa chuyên mục";
        $data['template'] = 'category/edit';
        $data['authentication'] = $this->authentication;
        $this->load->view('backend/layout/home', $data);
    }

    //Xoa danh muc
    function del($id) {
        $id = (int) ($id);
        $data['category'] = $this->M_Category->_get(array(
            'select' => 'id, cat_name, lft, rgt',
            'table' => 'category',
            'param_where' => ['id' => $id]
        ));

        if (!isset($data['category']) || !is_array($data['category']) || count($data['category']) == 0) {
            $this->session->set_flashdata('message_flashdata', array(
                'status' => 'error',
                'message' => 'Danh mục không tồn tại!',
            ));
            redirect('backend_post/category/view');
        }

        //Dem so babi viet trong chuyen muc
        $num_post = $this->M_Category->_get([
            'select' => 'post_id',
            'table' => 'post',
            'param_where' => ['post_category' => $id],
            'count' => TRUE
        ]);
        (isset($num_post) && ($num_post > 0)) ? $data['num_post'] = $num_post : '';

        //Dem danh muc con
        $num_subCategory = $this->M_Category->_get([
            'select' => 'cat_id',
            'table' => 'category',
            'param_where' => [
                'lft >' => $data['category']['lft'],
                'rgt <' => $data['category']['rgt']
            ],
            'count' => TRUE
        ]);
        (isset($num_subCategory) && ($num_subCategory > 0)) ? $data['num_subCategory'] = $num_subCategory : '';

        if (isset($_POST['submit'])) {
            $flag = $this->M_Category->_del(array(
                'param_where' => ['id' => $id],
                'table' => 'category'
            ));
            if ($flag >= 1) {
                //Xoa thanh cong
                $this->session->set_flashdata('message_flashdata', array(
                    'status' => 'success',
                    'message' => 'Xóa danh mục ' . $data['category']['cat_name'] . ' thành công',
                ));
            } else {
                //Xóa that bai
                $this->session->set_flashdata('message_flashdata', array(
                    'status' => 'error',
                    'message' => 'Lỗi! Xóa danh mục thất bại!'
                ));
            }
            $redirect = base64_decode($this->input->get('redirect'));
            redirect(isset($redirect) ? $redirect : 'backend_post/category/view');
        }
        $data['meta_title'] = "Xóa danh mục";
        $data['template'] = 'category/del';
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
