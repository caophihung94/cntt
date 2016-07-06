<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Document extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    //Count bai viet
    function count_post($type = '') {
        return $this->db->from('document')->count_all_results();
    }

    //Lay danh sach bai viet
    function view_post($limit = '', $start = '', $type = '') {
        $this->db->select('doc_id, doc_name, doc_author, doc_status, doc_feature');
        $this->db->from('document');
        $this->db->order_by('updated DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }
}
