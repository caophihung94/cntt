<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of MY_Controller
 *
 * @author caohung
 */
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    //Menu   
    function menu($param, $parent = 0) {
        $str = '';
        $ext = 'hoc-';
        foreach ($param as $key => $value) {
            if ($value['parent_id'] == $parent) {
                $str .= '<li><a href="' . $ext . $value['link'] . '-' . $value['cat_id'] . '">' . $value['cat_name'] . '</a>';
                $id = $value['cat_id'];
                unset($param[$key]);
                $this->menu($param, $id);
                $str .= '</li>';
            }
        }
        return $str;
    }

    function ordered_menu($array, $parent_id = 0) {
        $temp_array = array();
        foreach ($array as $element) {
            if ($element['parent_id'] == $parent_id) {
                $element['subs'] = $this->ordered_menu($array, $element['id']);
                $temp_array[] = $element;
            }
        }
        return $temp_array;
    }

    function html_ordered_menu($array, $parent_id = 0) {
        $menu_html = '';
        foreach ($array as $element) {
            if ($element['parent_id'] == $parent_id) {
                $menu_html .= '<li><a href="' . $element['slug'] . '">' . $element['cat_name'] . '</a>';
                $menu_html .= $this->html_ordered_menu($array, $element['id']);
                $menu_html .= '</li>';
            }
        }
        $menu_html .= '</ul>';
        return $menu_html;
    }

    //cURL
    function myCurl($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode;
    }

    //Ping sitemap
    function ping_sitemap() {
        $this->myCurl(base_url('sitemap/C_sitemap/sitemap'));
        //Google
        $url = "https://www.google.com/webmasters/sitemaps/ping?sitemap=" . base_url('sitemap.xml');
        $this->myCurl($url);
        //Bing / MSN
        $url = "http://www.bing.com/webmaster/ping.aspx?siteMap=" . base_url('sitemap.xml');
        $this->myCurl($url);
    }

    //breadcrumb
    function breadcrumb($lft = 0, $rgt = 0) {
        $data = $this->MY_Model->_get([
            'select' => 'id, cat_name, slug',
            'table' => 'category',
            'param_where' => [
                'lft <=' => $lft,
                'rgt >=' => $rgt
            ],
            'orderby' => 'lft ASC',
            'list' => TRUE
        ]);
        return $data;
    }

    //Children
    function children($lft = 0, $rgt = 0) {
        $data = $this->MY_Model->_get([
            'select' => 'cat_id',
            'table' => 'category',
            'param_where' => [
                'lft >=' => $lft,
                'rgt <=' => $rgt
            ],
            'list' => TRUE
        ]);
        return $data;
    }

    //Tính lượt xem
    function views($page_id) {
        if (!$this->session->userdata('session_' . $page_id)) {//Kiểm tra nếu chưa xem lần nào, tức là chưa có session
            //thì set session cho bài viết này
            $this->session->set_userdata('session_' . $page_id, 1);
            //Tăng lượt view của bài viết lên 1
            $old_view = $this->M_home->get_views($page_id);
            $new_view = (int) $old_view + 1;
            $this->M_home->set_views($new_view, $page_id);
            return $new_view;
        } else {
            return $this->M_home->get_views($page_id);
        }
    }
}