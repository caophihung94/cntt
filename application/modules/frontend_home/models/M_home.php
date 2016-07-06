<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Home extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('Lb_string');
    }

    //dem tat ca bai viet
    function count_posts() {
        return $this->db->select('post_id')->from('post')->where('post_status', 1)->get()->num_rows();
    }

    //dem tat ca bai viet
    function count_document() {
        return $this->db->select('doc_id')->from('document')->where('doc_status', 1)->get()->num_rows();
    }

    //dem tat ca bai viet theo chuyen muc
    function count_posts_by_category($cat_id = 1) {
        //lay lft, rgt cua thu muc hien tai
        $data = $this->_get([
            'select' => 'lft, rgt',
            'table' => 'category',
            'param_where' => ['id' => $cat_id]
        ]);
        //lay danh sach thu muc con cua thu muc hien tai
        $children = $this->_get([
            'select' => 'id',
            'table' => 'category',
            'param_where' => [
                'lft >=' => $data['lft'],
                'rgt <=' => $data['rgt'],
                'publish' => 1
            ],
            'list' => TRUE
        ]);
        if (isset($children) && is_array($children)) {
            $tempChildren = NULL;
            foreach ($children as $key => $val) {
                $tempChildren[] = $val['id'];
            }
        }
        return $this->db->select('post_id')->from('post')->where_in('post_category', $tempChildren)->where('post_status', 1)->get()->num_rows();
    }

    function get_posts($type = 'latest', $limit = '10', $start = '1') {
        if (isset($type) && $type == 'random') {
            $total_posts = $this->count_posts();
            if ($total_posts > 0) {
                $start = ($total_posts >= $limit) ? rand(0, $total_posts - $limit) : 0;
                return $this->db
                                ->select('post_id, post_name, post_slug, post_image, post_publisher, post.updated, user.name')
                                ->from('post')
                                ->where('post_status', 1)
                                ->join('user', 'post.post_publisher = user.id')
                                ->order_by('post.updated DESC')
                                ->limit($limit, $start)
                                ->get()
                                ->result_array();
            }
        } elseif (isset($type) && $type == 'latest') {
            $total_posts = $this->count_posts();
            if ($total_posts > 0) {
                return $this->db->select('post_id, post_name, post_slug, post_image, post_publisher, post.updated, user.name')
                                ->from('post')
                                ->where('post_status', 1)
                                ->join('user', 'post.post_publisher = user.id')
                                ->order_by('post.updated DESC')
                                ->limit($limit)
                                ->get()
                                ->result_array();
            }
        } elseif (isset($type) && $type == 'feature') {
            $total_posts = $this->count_posts();
            if ($total_posts > 0) {
                return $this->db->select('post_id, post_name, post_slug, post_image, updated')
                                ->from('post')
                                ->where(['post_feature' => 1, 'post_status' => 1])
                                ->order_by('updated DESC, created DESC')
                                ->limit($limit)
                                ->get()
                                ->result_array();
            }
        }
    }

    //lay chi tiet bai viet
    function get_post_detail($post_id = 0) {
        return $this->db
                        ->select('post_id, post_category, post_name,post_content, post_slug, post_keyword, post_description, post_image, post.updated, category.lft, category.rgt, user.name')
                        ->from('post')
                        ->where(['post_id' => $post_id, 'post_status' => 1])
                        ->join('category', 'category.id = post.post_category')
                        ->join('user', 'user.id = post.post_publisher')
                        ->get()
                        ->row_array();
    }

    //lay chi tiet document
    function get_document_detail($doc_id = 0) {
        return $this->db
                        ->select('doc_id, doc_name, doc_slug, doc_file, doc_keyword, doc_description, doc_image, doc_author, instructor, doc_yearPublish, doc_publisher, document.updated, user.name')
                        ->from('document')
                        ->where('doc_id', $doc_id)
                        ->where('doc_status', 1)
                        ->join('user', 'user.id = document.doc_publisher')
                        ->get()
                        ->row_array();
    }

    //lay chi tiet danh muc
    function get_category_by_id($id = 0) {
        return $this->db
                        ->select('*')
                        ->from('category')
                        ->where(['id' => $id, 'publish' => 1])
                        ->get()
                        ->row_array();
    }

    //tim kiem
    function search($keyword = '', $limit = '10', $start = '1') {
        return $this->db
                        ->select('post_id, post_name, post_slug, post_image, post.updated, user.name')
                        ->from('post')
                        ->where("post_slug LIKE '%{$keyword}%'")
                        ->where('post_status', 1)
                        ->join('user', 'user.id = post.post_publisher')
                        ->order_by('updated DESC')
                        ->limit($limit, $start)
                        ->get()
                        ->result_array();
    }

    //dem so ket qua tim kiem
    function count_search_result($keyword = '') {
        return $this->db
                        ->select('post_id')
                        ->from('post')
                        ->where("post_slug LIKE '%{$keyword}%'")
                        ->where('post_status', 1)
                        ->get()
                        ->num_rows();
    }

    //lay bai viet theo chuyen muc
    function get_posts_by_cat($limit = '10', $start = '1', $cat_id) {
        //lay lft, rgt cua thu muc hien tai
        $data = $this->_get([
            'select' => 'lft, rgt',
            'table' => 'category',
            'param_where' => ['id' => $cat_id]
        ]);
        //lay danh sach thu muc con cua thu muc hien tai
        $children = $this->_get([
            'select' => 'id',
            'table' => 'category',
            'param_where' => [
                'lft >=' => $data['lft'],
                'rgt <=' => $data['rgt'],
                'publish' => 1
            ],
            'list' => TRUE
        ]);
        if (isset($children) && is_array($children)) {
            $tempChildren = NULL;
            foreach ($children as $key => $val) {
                $tempChildren[] = $val['id'];
            }
        }
        return $this->db
                        ->select('post_id, post_name, post_slug, post_image, post.updated, user.name')
                        ->from('post')
                        ->where('post_status', 1)
                        ->where_in('post.post_category', $tempChildren)
                        ->join('user', 'user.id = post.post_publisher')
                        ->order_by('post_feature DESC, post.updated DESC')
                        ->limit($limit, $start)
                        ->get()
                        ->result_array();
    }

    //Get document
    function get_document($limit = 10, $start = 1) {
        return $this->db
                        ->select('doc_id, doc_name, doc_slug, doc_image, doc_publisher, document.updated, user.name')
                        ->from('document')
                        ->where('doc_status', 1)
                        ->join('user', 'user.id = document.doc_publisher')
                        ->order_by('doc_feature DESC, document.updated DESC')
                        ->limit($limit, $start)
                        ->get()
                        ->result_array();
    }

    //get related posts
    function related_post($post_id, $cat_id = 1, $limit = 10) {
        $total_posts = $this->count_posts_by_category($cat_id);
        if ($total_posts > 0) {
            return $this->db
                            ->select('post_id, post_name, post_slug, updated')
                            ->from('post')
                            ->where(['post_category' => $cat_id, 'post_status' => 1, 'post_id !=' => $post_id])
                            ->order_by('updated DESC')
                            ->limit($limit, 0)
                            ->get()
                            ->result_array();
        }
    }

}
