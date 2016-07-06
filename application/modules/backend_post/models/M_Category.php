<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Category extends MY_Model{
    function __construct() {
        parent::__construct();
    }
    function index(){
        
    }
    //Xem danh mục
    function view_category($table = '', $limit = '', $start = '') {
        return $this->db->select('*')->from($table)->limit($limit, $start)->get()->result_array();
    }
    
    //Lấy chuyên mục
    function get_category_dropdown(){
        return $this->db->select('id, parent_id, cat_name')->from('category')->get()->result_array();
    }
    //Đếm chuyên mục
    function count_category(){
        return $this->db->select('id')->from('category')->get()->num_rows();
    }
    
        //Xoa nhieu chuyen muc dua vao checkbox
    public function delete($checkbox=NULL) {
    $this->db->where_in('id', $checkbox)->delete('category');
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //Xoa du lieu thanh cong
            return array(
                'status' => 'success',
                'message' => 'Xóa ('.  count($checkbox).') chuyên mục thành công!'
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Lỗi! Không có chuyên mục nào bị xóa!'
            );
        }
    }
    
    //Xuat ban
    public function publish($checkbox=NULL) {
    $this->db->where_in('id', $checkbox)->update('category',  ['publish' => 1]);
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //active thanh cong
            return array(
                'status' => 'success',
                'message' => 'Xuất bản ('.  count($checkbox).') chuyên mục thành công!'
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Xuất bản chuyên mục thất bại!'
            );
        }
    }
    
    //Bo xuat ban
    public function unpublish($checkbox=NULL) {
    $this->db->where_in('id', $checkbox)->update('category',  ['publish'=>0]);
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //Bo xuat ban thanh cong
            return array(
                'status' => 'success',
                'message' => 'Bỏ xuất bản ('.  count($checkbox).') chuyên mục thành công!'
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Lỗi! Không có chuyên mục nào bị bỏ xuất bản!'
            );
        }
    }
}
