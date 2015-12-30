<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Teams extends CFormModel {

    private $table = '{{users_group}}';
    private $command;
    private $connection;
    private $_items = array();
    var $_primary = 'id';
    var $_tablename = "{{menus}}";
    var $_message = "";
    var $_db = null;   
    
    function __construct() {
        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Teams();
        }
        return $instance;
    }

    public function getItems($cid = null) {
        $obj_tblTournament = YiiTables::getInstance(TBL_GS_TEAMS);

        $cond = $this->buildWhere($cid);
        $page = Request::getVar("page", 1);
        $limit = Request::getVar('limit', 15);
        $start = ($page - 1) * $limit;
        // execute
        $items = $obj_tblTournament->loads("*", $cond, "cdate DESC", $limit, $start);
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
        $obj_tblTournament = YiiTables::getInstance(TBL_GS_TEAMS);
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

    function getItem($cid = null) {
        if ($cid == null OR $cid == "")
            $cid = Request::getVar("cid", 0);

        if (is_array($cid))
            $cid = $cid[0];
        if (isset($this->_items[$cid]))
            return $this->_items[$cid];

        $obj_tblTournament = YiiTables::getInstance(TBL_GS_TEAMS);
        $item = $obj_tblTournament->load($cid);
        $this->_items[$cid] = $item;
        return $item;
    }

    function getListEdit($main_item) {
        $cid = Request::getVar("cid", 0);
        $lists = array();

        $db = Yii::app()->db;
        $command = $db->createCommand()->select("A.id, A.name")
                ->from(TBL_GS_TOURNAMEMANTS . " A")
                ->rightJoin(TBL_GS_TEAM_REGISTER_TOUR . ' B', 'A.id = B.tourID')
                ->rightJoin(TBL_GS_TEAMS . ' C', 'C.id = B.teamID')
                ->where(" B.teamID= 1")
                ->group(" A.id")
                ->order('A.startDate DESC');
        $lists['tournaments'] = $command->queryAll();
        
        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);
        $locations = $obj_tblLocation->loads("*", 'parentID != 0 ', "lft ASC", null, 0);
        
        $arr_new = array();
        foreach($locations as $loc){
            $arr_new[$loc['id']] = $loc;
        }
        $lists['locations'] = $arr_new;
        
        return $lists;
    }
    
    function ListTeam($tourID="0",$field = "*", $conditions = null, $orderBy = "", $limit = 10, $start = 0){
        
        if($orderBy == "" OR $orderBy == null){
            $pname = $this->_primary;
            if(isset($this->$pname))
                $orderBy = " $this->_primary DESC ";
        }
        $db = Yii::app()->db;
        $command = $db->createCommand()->select("A.name")
                ->from( TBL_GS_PLAYERS ." A")
                ->leftJoin(TBL_GS_PLAYER_REGISTER_TEAM . " B", "A.id = B.playerID ")
                ->leftJoin(TBL_GS_TOURNAMEMANTS . " C", "C.id = B.tourID ")
                ->where(" B.tourID = $tourID ")
                //->group(" A.id ")
                ;
        if($orderBy != null AND $orderBy != "") $command->order($orderBy);
        if($limit != null)$command->limit($limit, $start);

        $results = $command->queryColumn();
        return $results;
    }
 

    

}
