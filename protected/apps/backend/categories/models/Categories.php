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

    public function getItems() {
        $obj_category = YiiCategory::getInstance();
        $items = $obj_category->loadItems();
        return $items;
    }

    public function getList() {
        $obj_category = YiiCategory::getInstance();
        $lists = array();
        $items = $obj_category->getScope();
        $arr_new = array();
        foreach($items as $item){
            $arr_new[$item['value']] = $item['text'];
        }
        $lists['scopes'] = $arr_new;
        return $lists;
    }

    function getListEdit($mainitem) {
        $obj_category = YiiCategory::getInstance();
        $lists = array();
        $items = $obj_category->getScope();
        
        $lists['scopes'] = buildHtml::select($items, $mainitem->scope, "scope",  "scope");        
        return $lists;
    }

}

?> 