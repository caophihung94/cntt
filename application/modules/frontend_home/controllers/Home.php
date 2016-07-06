<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_home');
        //Setting
        $this->setting = $this->M_home->_get([
            'table' => 'setting',
            'select' => '*'
        ]);

        //Menu
        $this->menu = NULL;
        $list_menu = $this->M_home->_get([
            'select' => 'id, menu_name',
            'table' => 'menu',
            'orderby' => 'menu_position ASC',
            'list' => TRUE
        ]);
        //Multi Menu
        if (!empty($list_menu)) {
            foreach ($list_menu as $key => $menu) {
                $this->menu['multiMenu'][$menu['menu_name'] . $key] = $this->M_home->_get([
                    'select' => 'id, page_name, page_slug',
                    'table' => 'page',
                    'param_where' => ['menu_id' => $menu['id']],
                    'orderby' => 'page_position ASC',
                    'list' => TRUE,
                ]);
            }
        }

        //Single menu
        $this->menu['singleMenu'] = $this->M_home->_get([
            'select' => 'id, page_name, page_slug',
            'table' => 'page',
            'param_where' => ['menu_id' => 0],
            'orderby' => 'page_position ASC',
            'list' => TRUE,
        ]);

        //Slider
        $this->slide = $this->M_home->_get([
            'table' => 'slide',
            'param_where' => ['publish' => 1],
            'select' => '*',
            'orderby' => 'position ASC',
            'list' => TRUE
        ]);
        //Bai viet noi bat
        $this->post_feature = $this->M_home->get_posts('feature', 4);

        //Sidebar
        $this->sidebar = $this->M_home->_get([
            'select' => '*',
            'table' => 'sidebar',
            'orderby' => 'position ASC',
            'list' => TRUE,
        ]);
    }

    public function index() {
        $data['setting'] = $this->setting;
        $categories = $this->M_home->_get([
            'select' => 'id, cat_name, slug',
            'table' => 'category',
            'orderby' => 'cat_position ASC',
            'list' => TRUE
        ]);
        if (!empty($categories) && is_array($categories)) {
            $dataCategories = NULL;
            foreach ($categories as $key => $category) {
                $dataCategories[$key]['category'] = $categories[$key];
                $dataCategories[$key]['posts'] = $this->M_home->_get([
                    'select' => 'post_id, post_name, post_slug, post_image, updated',
                    'table' => 'post',
                    'param_where' => [
                        'post_category' => $categories[$key]['id'],
                        'post_status' => 1
                    ],
                    'orderby' => 'post_feature DESC, updated DESC',
                    'limit' => 5,
                    'start' => 0,
                    'list' => TRUE
                ]);
            }
        }
        $data['dataCategories'] = $dataCategories;

        $data['menu'] = $this->menu;
        $data['slide'] = $this->slide;
        $data['post_feature'] = $this->post_feature;
        $data['sidebar'] = $this->sidebar;

        $data['template'] = 'frontend_home/home';
        $this->load->view('frontend/index', isset($data) ? $data : NULL);
    }

    //view single post
    public function single($post_id = 0) {
        $data['setting'] = $this->setting;
        $data['post_detail'] = $this->M_home->get_post_detail($post_id);
        (empty($data['post_detail'])) ? redirect(base_url()) : '';

        $data['meta_title'] = $data['post_detail']['post_name'];
        $data['meta_description'] = $data['post_detail']['post_description'];
        $data['meta_keyword'] = $data['post_detail']['post_keyword'];
        $data['meta_author'] = $data['post_detail']['name'];

        $data['menu'] = $this->menu;
        $data['slide'] = $this->slide;
        $data['post_feature'] = $this->post_feature;
        $data['sidebar'] = $this->sidebar;

        $data['breadcrumb'] = $this->breadcrumb($data['post_detail']['lft'], $data['post_detail']['rgt']);
        $data['related_posts'] = $this->M_home->related_post($post_id, $data['post_detail']['post_category'], 5);

        $data['template'] = 'frontend_home/single';
        $this->load->view('frontend/index', isset($data) ? $data : NULL);
    }

    //view single post
    public function document_detail($doc_id = 0) {
        $data['setting'] = $this->setting;
        $data['document_detail'] = $this->M_home->get_document_detail($doc_id);
        (empty($data['document_detail'])) ? redirect(base_url()) : '';

        $data['meta_title'] = $data['document_detail']['doc_name'];
        $data['meta_description'] = $data['document_detail']['doc_description'];
        $data['meta_keyword'] = $data['document_detail']['doc_keyword'];
        $data['meta_author'] = $data['document_detail']['doc_author'];

        $data['menu'] = $this->menu;
        $data['slide'] = $this->slide;
        $data['post_feature'] = $this->post_feature;
        $data['sidebar'] = $this->sidebar;

        $data['template'] = 'frontend_home/document_detail';
        $this->load->view('frontend/index', isset($data) ? $data : NULL);
    }

    //view static page
    public function page($page_id = 0) {
        $data['setting'] = $this->setting;
        $data['page_detail'] = $this->M_home->_get([
            'select' => '*',
            'table' => 'page',
            'param_where' => ['id' => $page_id]
        ]);
        (empty($data['page_detail'])) ? redirect(base_url()) : '';

        $data['meta_title'] = $data['page_detail']['page_name'];
        $data['meta_description'] = 'Giới thiệu khoa công nghệ thông tin trường ĐH Thành Đô';

        $data['menu'] = $this->menu;
        $data['slide'] = $this->slide;
        $data['post_feature'] = $this->post_feature;
        $data['sidebar'] = $this->sidebar;

        $data['template'] = 'frontend_home/page';
        $this->load->view('frontend/index', isset($data) ? $data : NULL);
    }

    //view posts by category
    public function post_by_category($cat_id = 1, $page = 1) {
        $data['setting'] = $this->setting;
        //kiem tra cat-id
        $data['category_detail'] = $this->M_home->get_category_by_id($cat_id);
        (empty($data['category_detail'])) ? redirect(base_url()) : '';
        $data['meta_title'] = $data['category_detail']['cat_name'];
        $data['meta_description'] = $data['category_detail']['description'];
        $data['meta_keyword'] = $data['category_detail']['keyword'];
        // pagination
        $config['attributes']['rel'] = FALSE;
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = base_url('chuyen-muc/' . $data['category_detail']['slug'] . '.' . $cat_id);
        $config['total_rows'] = $this->M_home->count_posts_by_category($cat_id);
        if ($config['total_rows'] > 0) {
            $config['per_page'] = 10;
            $config['num_links'] = 2;
            $config['full_tag_open'] = '<ul class="pagination pagination-md">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = '<li><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
            $config['last_link'] = '<li><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
            $config['prev_link'] = '<li>Prev</a></li>';
            $config['next_link'] = '<li>Next</a></li>';
            $config['cur_tag_open'] = '<li class="active"><span>';
            $config['cur_tag_close'] = '</span></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $total_pages = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page < 1) ? 1 : $page;
            $page = ($page > $total_pages) ? $total_pages : $page;
            $page = $page - 1;
            $this->pagination->initialize($config);
            $data['paginator'] = $this->pagination->create_links();

            if ($page >= 0) {
                $data['list_posts'] = $this->M_home->get_posts_by_cat($config['per_page'], $page * $config['per_page'], $cat_id);
            }
        } else {
            $data['message'] = 'Không có bài viết nào trong chuyên mục này!';
        }

        $data['menu'] = $this->menu;
        $data['slide'] = $this->slide;
        $data['post_feature'] = $this->post_feature;
        $data['sidebar'] = $this->sidebar;

        $data['breadcrumb'] = $this->breadcrumb($data['category_detail']['lft'], $data['category_detail']['rgt']);

        $data['template'] = 'frontend_home/post_by_category';
        $this->load->view('frontend/index', isset($data) ? $data : NULL);
    }

    //view document
    public function document($page = 1) {
        $data['setting'] = $this->setting;
        $data['meta_title'] = 'Đồ án của sinh viên khoa CNTT trường ĐH Thành Đô';
        $data['meta_description'] = 'Đồ án của sinh viên khoa CNTT trường ĐH Thành Đô';
        // pagination
        $config['attributes']['rel'] = FALSE;
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = base_url('do-an-tot-nghiep/page');
        $config['total_rows'] = $this->M_home->count_document();
        if ($config['total_rows'] > 0) {
            $config['per_page'] = 10;
            $config['num_links'] = 2;
            $config['full_tag_open'] = '<ul class="pagination pagination-md">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = '<li><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
            $config['last_link'] = '<li><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
            $config['prev_link'] = '<li>Prev</a></li>';
            $config['next_link'] = '<li>Next</a></li>';
            $config['cur_tag_open'] = '<li class="active"><span>';
            $config['cur_tag_close'] = '</span></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $total_pages = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page < 1) ? 1 : $page;
            $page = ($page > $total_pages) ? $total_pages : $page;
            $page = $page - 1;
            $this->pagination->initialize($config);
            $data['paginator'] = $this->pagination->create_links();

            if ($page >= 0) {
                $data['list_documents'] = $this->M_home->get_document($config['per_page'], $page * $config['per_page']);
            }
        } else {
            $data['message'] = 'Không có dữ liệu!';
        }

        $data['menu'] = $this->menu;
        $data['slide'] = $this->slide;
        $data['post_feature'] = $this->post_feature;
        $data['sidebar'] = $this->sidebar;

        $data['template'] = 'frontend_home/document';
        $this->load->view('frontend/index', isset($data) ? $data : NULL);
    }

    //Tim kiem
    public function search($page = 1) {
        $data['setting'] = $this->setting;
        $keyword = trim($this->input->get('keyword'));
        if (!empty($keyword)) {
            $keyword = strtolower(url_title($this->lb_string->removesign($keyword)));
            // pagination
            $config['attributes']['rel'] = FALSE;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
            $config['base_url'] = base_url('search');
            $config['total_rows'] = $this->M_home->count_search_result($keyword);
            if ($config['total_rows'] > 0) {
                $config['per_page'] = 10;
                $config['num_links'] = 2;
                $config['full_tag_open'] = '<ul class="pagination pagination-md">';
                $config['full_tag_close'] = '</ul>';
                $config['first_link'] = '<li><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
                $config['last_link'] = '<li><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
                $config['prev_link'] = '<li>Prev</a></li>';
                $config['next_link'] = '<li>Next</a></li>';
                $config['cur_tag_open'] = '<li class="active"><span>';
                $config['cur_tag_close'] = '</span></li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $total_pages = ceil($config['total_rows'] / $config['per_page']);
                $page = ($page < 1) ? 1 : $page;
                $page = ($page > $total_pages) ? $total_pages : $page;
                $page = $page - 1;
                $this->pagination->initialize($config);
                $data['paginator'] = $this->pagination->create_links();

                if ($page >= 0) {
                    $data['result'] = "Tìm thấy {$config['total_rows']} kết quả phù hợp";
                    $data['list_posts'] = $this->M_home->search($keyword, $config['per_page'], $page * $config['per_page']);
                }
            } else {
                $data['message'] = 'Không tìm thấy kết quả nào phù hợp';
            }
        } else {
            $data['message'] = 'Vui lòng nhập từ khóa!';
        }
        $data['menu'] = $this->menu;
        $data['slide'] = $this->slide;
        $data['post_feature'] = $this->post_feature;
        $data['sidebar'] = $this->sidebar;

        $data['template'] = 'frontend_home/search';
        $this->load->view('frontend/index', isset($data) ? $data : NULL);
    }

}
