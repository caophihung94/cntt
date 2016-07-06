<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Post extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    //Count bai viet
    function count_post($type = '') {
        //neu co bo loc
        if (isset($_GET['filter'])) {
            $status = $this->input->get('status');
            $hot = $this->input->get('hot');
            if (isset($status) && $status != '')
                $where['post.post_status'] = $status;
            if (isset($hot) && $hot != '')
                $where['post.post_feature'] = $hot;
        }

        if (isset($where) && is_array($where) && count($where)) {
            $this->db->where($where);
        }
        $this->db->from('post');
        return $this->db->count_all_results();
    }

    //Lay danh sach bai viet
    function view_post($limit = '', $start = '', $type = '') {
        //neu co bo loc
        if (isset($_GET['filter'])) {
            $status = $this->input->get('status');
            $hot = $this->input->get('hot');
            if (isset($status) && $status != '')
                $where['post.post_status'] = $status;
            if (isset($hot) && $hot != '')
                $where['post.post_feature'] = $hot;
        }
        $this->db->select(
                'post.post_id, post.post_name, post.post_status, post.post_feature, category.cat_name, user.name'
        );
        $this->db->from('post');
        $this->db->join('category', 'category.id = post.post_category', 'left');
        $this->db->join('user', 'user.id = post.post_publisher', 'left');
        if (isset($where) && is_array($where) && count($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('post.updated DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    //Xoa nhieu chuyen muc dua vao checkbox
    public function delete($checkbox = NULL) {
        $this->db->where_in('post_id', $checkbox)->delete('post');
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //Xoa du lieu thanh cong
            return array(
                'status' => 'success',
                'message' => 'Xóa (' . count($checkbox) . ') bài viết thành công!'
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Không có bài viết nào bị xóa!'
            );
        }
    }

    //Xuat ban
    public function publish($checkbox = NULL) {
        $this->db->where_in('post_id', $checkbox)->update('post', ['post_status' => 1]);
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //active thanh cong
            return array(
                'status' => 'success',
                'message' => 'Xuất bản (' . count($checkbox) . ') bài viết thành công!'
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Xuất bản bài viết thất bại!'
            );
        }
    }

    //Bo xuat ban
    public function unpublish($checkbox = NULL) {
        $this->db->where_in('post_id', $checkbox)->update('post', ['post_status' => 0]);
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //Bo xuat ban thanh cong
            return array(
                'status' => 'success',
                'message' => 'Bỏ xuất bản (' . count($checkbox) . ') bài viết thành công!'
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Không có bài viết nào bị bỏ xuất bản!'
            );
        }
    }

}
