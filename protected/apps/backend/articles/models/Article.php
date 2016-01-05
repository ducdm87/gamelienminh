<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Article extends CFormModel {

    private $table = "{{articles}}";
    private $table_categories = "{{categories}}";
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
            $instance = new Article ();
        }
        return $instance;
    }

    function getItems($limit = 20, $start = 0, $where = array()) {
        global $user;
        $obj_table = YiiArticle::getInstance();

        $page = Request::getVar("page", 1);
        $limit = Request::getVar('limit', 15);
        $start = ($page - 1) * $limit;
        $cond = $this->buildWhere();

        $items = $obj_table->getItems(null, $cond, $orderBy = "A.id desc", $limit, $start);
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
        $obj_table = YiiArticle::getInstance();
        $total = $obj_table->getTotal($cond, "A");

        return $total;
    }

    function buildWhere($cid = null) {
        global $user;
        $cond = array();
        $filter_created_by = Request::getVar('filter_created_by', $user->id);
        $filter_state = Request::getVar('filter_state', -2);
        $filter_search = Request::getVar("filter_search", "");

        if ($filter_state == 2) {
            $cond [] = " A.feature = 1 ";
        } else if ($filter_state != -2) {
            $cond [] = " A.status = $filter_state ";
        }

        if ($filter_created_by != -2) {
            $cond [] = " A.created_by = $filter_created_by ";
        } else {
            $obj_user = new YiiUser();
            $all_user = $obj_user->getUserInGroup($user->groupID, 'id', true);
            $all_user = implode(",", $all_user);
            $cond [] = " A.created_by IN($all_user) ";
        }

        if (trim($filter_search) != "") {
            $cond[] = " A.title like '%$filter_search%' ";
        }

        if (count($cond))
            $cond = implode(" AND ", $cond);
        else
            $cond = null;

        return $cond;
    }

    function getList() {
        global $user;
        $list = array();

        $filter_created_by = Request::getVar('filter_created_by', $user->id);
        $filter_state = Request::getVar('filter_state', -2);

        $obj_user = new YiiUser();
        $all_user[] = array("value" => -2, "text" => "- Select User -");
        //$all_user = array_merge($all_user, $obj_user->getUsers(null, 'id value, username text'));
        $all_user = array_merge($all_user, $obj_user->getUserInGroup($user->groupID, 'id value, username text', true));
        $list['filter_created_by'] = buildHtml::select($all_user, $filter_created_by, "filter_created_by", "filter_created_by", "onchange=\"document.adminForm.submit();\"");

        $items = array();
        $items[] = array("value" => -2, "text" => "- Select state -");
        $items[] = array("value" => 0, "text" => "Unpublish");
        $items[] = array("value" => 1, "text" => "Publish");
        $items[] = array("value" => 2, "text" => "Featured");
        $list['filter_state'] = buildHtml::select($items, $filter_state, "filter_state", "filter_state", "onchange=\"document.adminForm.submit();\"");


        return $list;
    }

    public function storeItem() {
        global $mainframe, $user;

        $cid = Request::getVar("id", 0);

        $obj_table = YiiArticle::getInstance();
        $obj_table = $obj_table->loadItem($cid);
        $obj_table->bind($_POST);

        if ($obj_table->id == 0) {
            $obj_table->created_by = $user->id;
        } else {
            // check quyen so huu
            global $user;
            if (!$bool = $user->modifyChecking($obj_table->created_by)) {
                $obj_users = YiiUser::getInstance();
                $item_user = $obj_users->getUser($obj_table->created_by);
                YiiMessage::raseNotice("Your account not have permission to modify resource of: $item_user->username");
                $this->redirect(Router::buildLink("articles"));
                return false;
            }
        }
        $obj_table->modified_by = $user->id;

        $obj_table->store();

        YiiMessage::raseSuccess("Successfully save Article");
        return $obj_table->id;
    }

    function copyitem($cid) {

        global $mainframe, $user;

        $obj_table = YiiArticle::getInstance();
        $obj_table = $obj_table->loadItem($cid, "*", false);
        $obj_table->id = 0;
        $obj_table->title = $obj_table->title . " copy";
        $obj_table->alias = $obj_table->alias . "-copy";
        $obj_table->status = 0;
        $obj_table->store();
        return $obj_table->id;
    }

    // for edit

    public function getItem($cid) {
        $obj_table = YiiArticle::getInstance();
        $result = $obj_table->loadItem($cid);
        return $result;
    }

    public function getListEdit($mainItem) {
        $list = array();

        $obj_module = YiiCategory::getInstance();
        $items = $obj_module->loadItems('id value, name text', "scope = 'articles'");
        $list['category'] = buildHtml::select($items, $mainItem->catID, "catID", "", "size=7");

        $items = array();
        $items[] = array("value" => 0, "text" => "Unpublish");
        $items[] = array("value" => 1, "text" => "Publish");
        $items[] = array("value" => -1, "text" => "Hidden");
        $list['status'] = buildHtml::select($items, $mainItem->status, "status");

        $items = array();
        $items[] = array("value" => 0, "text" => "Disable");
        $items[] = array("value" => 1, "text" => "Enable");
        $list['feature'] = buildHtml::select($items, $mainItem->feature, "feature");

        return $list;
    }

    public function deleteRecord($id) {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->command->delete($this->table, 'id=:id', array('id' => $id));

            return $transaction->commit();
            ;
        } catch (Exception $e) {
            Yii::log('Eror!: ' + $e->getMessage());

            return $transaction->rollback();
            ;
        }
    }

}
