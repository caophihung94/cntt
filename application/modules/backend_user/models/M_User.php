<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_User extends MY_Model{
    function __construct() {
        parent::__construct();
    }
    function index(){
        
    }
    //Đếm thành viên
    function count_user(){
        return $this->db->select('id')->from('user')->get()->num_rows();
    }
    
    //Tất cả chuyên mục
    function view($table = '', $limit = '', $start = ''){
        $user = $this->db
                ->select('user.id, user.name, user.email, user.group_id, user.status, user.created, user.updated, group_name')
                ->from('user')
                ->join('user_group','user.group_id = user_group.id','left')
                ->order_by('name ASC')
                ->limit($limit, $start)
                ->get()
                ->result_array();
        return $user;
        
    }
    
    //Xoa nhieu thanh vien dua vao checkbox
    public function delete_users($checkbox=NULL) {
    $this->db->where_in('id', $checkbox)->delete('user');
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //Xoa du lieu thanh cong
            return array(
                'status' => 'success',
                'message' => 'Xóa ('.  count($checkbox).') thành viên thành công!'
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Lỗi! Không có thành viên nào bị xóa!'
            );
        }
    }
    
    //Xuat ban
    public function active_users($checkbox=NULL) {
    $this->db->where_in('id', $checkbox)->update('user',  ['status' => 1]);
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //active thanh cong
            return array(
                'status' => 'success',
                'message' => 'Kích hoạt ('.  count($checkbox).') thành viên thành công!'
            );
            //redirect(base_url('backend_pages/pages/view_pages'));
        } else {
            return array(
                'status' => 'error',
                'message' => 'Kích hoạt thành viên thất bại!'
            );
        }
    }
    
    //Bo xuat ban
    public function deactivate_users($checkbox=NULL) {
    $this->db->where_in('id', $checkbox)->update('user',  ['status'=>0]);
        $flag = $this->db->affected_rows();
        if ($flag > 0) {
            //Banned user thanh cong
            return array(
                'status' => 'success',
                'message' => 'Cấm ('.  count($checkbox).') thành viên thành công!'
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Lỗi! Không có thành viên nào bị cấm!'
            );
        }
    }
    
    //group dropdown
    function group_dropdown(){
        $group = $this->_get([
            'select' => '*',
            'table' => 'user_group',
            'list' => TRUE
        ]);
        if(isset($group) && is_array($group)){
            $tempGroup = NULL;
            foreach ($group as $key => $val){
                $tempGroup[$val['id']] = $val['group_name'];
            }
            return $tempGroup;
        }
    }

}
