<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Location extends CFormModel {

    private $table = '{{users_group}}';
    private $command;
    private $connection;
    private $_items = array();

    function __construct() {
        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Location();
        }
        return $instance;
    }

    public function getItems($cid = null) {
        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);

        $cond = $this->buildWhere($cid);
        $page = Request::getVar("page", 1);
        $limit = Request::getVar('limit', 15);
        $start = ($page - 1) * $limit;
        // execute
        $items = $obj_tblLocation->loads("*", $cond, "lft ASC", $limit, $start);
        $arr_new = array();
        foreach ($items as $item) {
            $arr_new[$item['id']] = $item;
        }
        $items = $arr_new;

        return $items;
    }

    function getPagination($cid = null) {
        $total = $this->getTotal($cid);
        $page = Request::getVar('page', 1);
        $limit = Request::getVar('limit', 15);
        return fnShowPagenationBack($total, $limit, $page);
    }

    function getTotal($cid = null) {
        $cond = $this->buildWhere($cid);
        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);
        $total = $obj_tblLocation->getTotal($cond);
        return $total;
    }

    function buildWhere($cid = null) {
        $cond = array();
        if ($cid == null)
            $cid = Request::getVar('filter_cid', null);
        $cond[] = " parentID != 0 ";
        if ($cid != null) {
            $item = $this->getItem($cid);
            if ($item->lft > 0 and $item->rgt > 0)
                $cond[] = " lft >=  $item->lft AND rgt <= $item->rgt ";
        }
        
        $filter_search = Request::getVar("filter_search", "");

        if (trim($filter_search) != "") {
            $cond[] = " name like '%$filter_search%' ";
        }

        if (count($cond))
            $cond = implode(" AND ", $cond);
        else
            $cond = null;
        return $cond;
    }

    function getItem($cid = null) {
        if ($cid == null OR $cid == "")
            $cid = Request::getVar("cid", 0);

        if (is_array($cid))
            $cid = $cid[0];
        if (isset($this->_items[$cid]))
            return $this->_items[$cid];

        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);
        $item = $obj_tblLocation->load($cid);
        $this->_items[$cid] = $item;
        return $item;
    }

    function getListEdit($main_item) {
        $cid = Request::getVar("cid", 0);
        $lists = array();

        $items = array();

        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);
        $obj_user = YiiUser::getInstance();
        $condition = "";
        if ($main_item->id != 0) {
            $condition = "(`lft` <" . $main_item->lft . " OR `lft` > " . $main_item->rgt . ")";
        }

        $results = $obj_tblLocation->loads('id value, name text, level', $condition, 'lft ASC', null);
        $items = array_merge($items, $results);
        $lists['parentID'] = buildHtml::select($items, $main_item->parentID, "parentID", "", "size=10", "&nbsp;&nbsp;&nbsp;", "-");


        $items = array();
        if ($main_item->id != 0) {
            $condition = "parentID = " . $main_item->parentID;
            $results = $obj_tblLocation->loads('id value, name text, level', $condition, 'lft ASC', null);
            $items = array_merge($items, $results);
            $lists['ordering'] = buildHtml::select($items, $cid, "ordering", "", "size=5");
        } else {
            $lists['ordering'] = "Ordering this item after save first";
        }


        return $lists;
    }
 

    

}
