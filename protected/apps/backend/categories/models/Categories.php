<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Categories extends CFormModel {

    private $table = "{{categories}}";
    private $tbl_menu = '{{menus}}';
    private $primary = 'id';
    private $command;
    private $connection;

    function __construct() {
        parent::__construct();

        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Categories();
        }
        return $instance;
    }

    public function getItems($cid = null) {
        $obj_category = YiiCategory::getInstance();
        $cond = $this->buildWhere($cid);
        
        $page = Request::getVar("page", 1);
        $limit = Request::getVar('limit', 15);
        $start = ($page - 1) * $limit;
        $items = $obj_category->loadItems("*", $cond, "lft ASC", $limit, $start);
        return $items;
    }

    public function getList() {
        $obj_category = YiiCategory::getInstance();
        $lists = array();
        $items = $obj_category->getScope();
        $arr_new = array();
        foreach ($items as $item) {
            $arr_new[$item['value']] = $item['text'];
        }
        $lists['scopes'] = $arr_new;
        return $lists;
    }

    function getPagination($cid = null) {
        $total = $this->getTotal($cid);
        $page = Request::getVar('page', 1);
        $limit = Request::getVar('limit', 15);
        return fnShowPagenationBack($total, $limit, $page);
    }

    function getTotal($cid = null) {
        $cond = $this->buildWhere($cid);
        $obj_tblTournament = YiiTables::getInstance(TBL_CATEGORIES);
        $total = $obj_tblTournament->getTotal($cond);
        return $total;
    }

    function buildWhere($cid = null) {
        $cond = array();
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

    function storeItem() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify category");
            $this->redirect(Router::buildLink("categories"));
        }

        $cid = Request::getVar("id", 0);

        $obj_item = YiiCategory::getInstance();
        $obj_item = $obj_item->loadItem($cid, "*", false);

        $obj_item->bind($_POST);
        if ($obj_item->id == 0) {
            $obj_item->created_by = $user->id;
        }
        $obj_item->modified_by = $user->id;
        $obj_item->store();

        YiiMessage::raseSuccess("Successfully save Category");
        return $obj_item->id;
    }
    
    function copyitem($cid)
    {
       
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify menu item");
            return false;
        } 
  
        $obj_item = YiiCategory::getInstance();        
        $obj_item = $obj_item->loadItem($cid, "*", false);
        $obj_item->id = 0;
        $obj_item->name = $obj_item->name . " copy";
        $obj_item->alias = $obj_item->alias . "-copy";
        $obj_item->status = 0;
        $obj_item->store();
        return $obj_item->id;
    }

    function getListEdit($mainitem) {
        $obj_category = YiiCategory::getInstance();
        $lists = array();
        $items = $obj_category->getScope();

        $lists['scopes'] = buildHtml::select($items, $mainitem->scope, "scope", "scope");
        return $lists;
    }

}

?> 