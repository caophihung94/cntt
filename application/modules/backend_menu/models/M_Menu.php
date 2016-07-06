<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Menu extends MY_Model{
    function __construct() {
        parent::__construct();
    }
    //Lay danh sach page
    function get_list_pages(){
        return $this->db
                ->select('id, page_name, page_position')
                ->from('page')
                ->order_by('page_position ASC')
                ->get()
                ->result_array();
    }
}
