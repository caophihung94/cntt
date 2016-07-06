<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nestedset {

    private $CI;
    public $checked = NULL;
    public $params = NULL;
    public $data = NULL;
    public $count = 0;
    public $count_level = 0;
    public $lft = NULL;
    public $rgt = NULL;
    public $level = NULL;

    function __construct($params = NULL) {
        $this->CI = & get_instance();
        $this->params = $params;
        $this->CI->load->model(array($this->params['model']));
        $this->checked = NULL;
        $this->count = 0;
        $this->count_level = 0;
        $this->lft = NULL;
        $this->rgt = NULL;
        $this->level = NULL;
    }

    public function get($param = NULL) {
        $model = $this->params['model'];
        if (isset($param['param_where']) && is_array($param['param_where']) && count($param['param_where'])) {
            $this->data = $this->CI->$model->_getwhere(array(
                'select' => 'id, cat_name, parent_id, lft, rgt, level',
                'table' => $this->params['table'],
                'list' => TRUE,
                'param_where' => $param['param_where'],
                'orderby' => isset($param['orderby']) ? $param['orderby'] : 'lft ASC'
            ));
        } else {
            $this->data = $this->CI->$model->_get(array(
                'select' => 'id, cat_name, parent_id, lft, rgt, level',
                'table' => $this->params['table'],
                'list' => TRUE,
                'orderby' => isset($param['orderby']) ? $param['orderby'] : 'lft ASC'
            ));
        }
    }

    public function set() {
        if (isset($this->data) && is_array($this->data)) {
            $arr = NULL;
            foreach ($this->data as $key => $val) {
                $arr[$val['id']][$val['parent_id']] = 1;
                $arr[$val['parent_id']][$val['id']] = 1;
            }
            return $arr;
        }
    }

    public function recursive($start = 0, $arr = NULL) {
        $this->lft[$start] = ++$this->count;
        $this->level[$start] = $this->count_level;
        if (isset($arr) && is_array($arr)) {
            foreach ($arr as $key => $val) {
                if ((isset($arr[$start][$key]) || isset($arr[$key][$start])) && (!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))) {
                    $this->count_level++;
                    $this->checked[$start][$key] = 1;
                    $this->checked[$key][$start] = 1;
                    $this->recursive($key, $arr);
                    $this->count_level--;
                }
            }
        }
        $this->rgt[$start] = ++$this->count;
    }

    function action() {
        if (isset($this->level) && is_array($this->level) && isset($this->lft) && is_array($this->lft) && isset($this->rgt) && is_array($this->rgt)) {
            $data = NULL;
            foreach ($this->level as $key => $val) {
                $data[] = array(
                    'id' => $key,
                    'level' => $val,
                    'lft' => $this->lft[$key],
                    'rgt' => $this->rgt[$key],
                );
            }
            $model = $this->params['model'];
            $this->CI->$model->_savebatch(array(
                'table' => $this->params['table'],
                'data' => $data,
                'field' => 'id'
            ));
        }
    }

    public function dropdown($text = '', $param = NULL) {
        $this->get($param);
        if (isset($this->data) && is_array($this->data)) {
            $temp = NULL;
            if(!empty($text) && $text != ''){
                $temp[0] = $text;
            }
            foreach ($this->data as $key => $val) {
                $temp[$val['id']] = str_repeat('&emsp;&emsp;+ ', (($val['level'] > 0) ? ($val['level'] - 1) : 0)) . $val['cat_name'];
            }
            return $temp;
        }
    }

    public function children($param = NULL) {
        $model = $this->params['model'];
        $catalogues = NULL;
        $param['andparent'] = (isset($param['andparent']) && ($param['andparent'] == TRUE)) ? '=' : '';
        if (isset($param['lft']) && isset($param['rgt'])) {
            $catalogues['lft'] = $param['lft'];
            $catalogues['rgt'] = $param['rgt'];
        } else if (isset($param['id'])) {
            $catalogues = $this->CI->$model->_getwhere(array(
                'select' => 'id, lft, rgt',
                'table' => 'articles_catalogue',
                'param_where' => array(
                    'id' => $param['id'],
                )
            ));
        }
        if ($catalogues == NULL)
            return NULL;
        if (isset($param['count']) && $param['count'] == TRUE) {
            $children = $this->CI->$model->_getwhere(array(
                'select' => 'id',
                'table' => $this->params['table'],
                'count' => TRUE,
                'param_where' => array(
                    'lft >' . $param['andparent'] . '' => $catalogues['lft'],
                    'rgt <' . $param['andparent'] . '' => $catalogues['rgt'],
                )
            ));
            return $children;
        } else {
            $temp = NULL;
            $children = $this->CI->$model->_getwhere(array(
                'select' => 'id',
                'table' => $this->params['table'],
                'list' => TRUE,
                'param_where' => array(
                    'lft >' . $param['andparent'] . '' => $catalogues['lft'],
                    'rgt <' . $param['andparent'] . '' => $catalogues['rgt'],
                )
            ));
            if (isset($children) && is_array($children) && count($children)) {
                foreach ($children as $key => $val) {
                    $temp[] = $val['id'];
                }
                return $temp;
            }
            return NULL;
        }
    }

    public function breadcrumb($lang, $lft = 0, $rgt = 0) {
        $breadcrumb = $this->CI->Model_articles_category->view('id, title', array('lang' => $lang, 'lft <=' => $lft, 'rgt >=' => $rgt), 0, 1000, 'lft ASC');
        if (isset($breadcrumb) && is_array($breadcrumb)) {
            $st = '';
            foreach ($breadcrumb as $key => $val) {
                $st = $st . $val['title'] . ' > ';
            }
            return $st;
        }
    }

}
