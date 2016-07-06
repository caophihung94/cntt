<?php

class Lb_Authentication {

    public $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('MY_Model');
    }

    function check() {
        $authentication = $this->CI->session->userdata('authentication');
        if (empty($authentication || !is_array($authentication))) {
            return NULL;
        } else {
            $user = $this->CI->MY_Model->_get([
                'select' => 'id, name, email, group_id, status',
                'table' => 'user',
                'param_where' => [
                    'email' => $authentication['email'],
                    'password' => $authentication['password']
                ]
            ]);
            if (empty($user) || !is_array($user)) {
                $this->CI->session->unset_userdata('authentication');
                return NULL;
            } else {
                $permission = $this->CI->MY_Model->_get([
                    'select' => 'permission',
                    'table' => 'user_group',
                    'param_where' => [
                        'id' => $user['group_id']
                    ]
                ]);
                $user['permission'] = json_decode($permission['permission'], TRUE);
                return $user;
            }
        }
    }

}
