<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tournament extends CFormModel {

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
            $instance = new Tournament();
        }
        return $instance;
    }
    
    public function getItem($cid = null){
        if ($cid == null OR $cid == "")
            $cid = Request::getVar("tourID", 0);

        if (is_array($cid))
            $cid = $cid[0];
        if (isset($this->_items[$cid]))
            return $this->_items[$cid];

        $obj_tblTournament = YiiTables::getInstance(TBL_GS_TOURNAMEMANTS);
        $item = $obj_tblTournament->load($cid);
        $this->_items[$cid] = $item;
        return $item;
    }
    
    public function getLists($tourID = 0){
         $lists = array();
         $lists['locations'] = $this->getLocations();
         $lists['teams_joined'] = $this->getTeams($tourID);
         $lists['table_info'] = $this->getTableInfo($tourID);
         return $lists;
    }

    public function getLocations(){
        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);
        $locations = $obj_tblLocation->loads("*", 'parentID != 0 ', "lft ASC", null, 0);
        
        $arr_new = array();
        foreach($locations as $loc){
            $arr_new[$loc['id']] = $loc;
        }
        $locations = $arr_new;
        return $locations;
    }
    
    public function getTeams($tourID = 0){
        $db = Yii::app()->db;
        $command = $db->createCommand()->select("A.*, B.cdate joined_day, B.table_num, C.name location_name")
                ->from(TBL_GS_TEAMS . " A")
                ->rightJoin(TBL_GS_TEAM_REGISTER_TOUR . ' B', 'A.id = B.teamID')
                ->leftJoin(TBL_LOCATIONS . ' C', 'A.locationID = C.id')
                ->where("tourID = $tourID")
                ;
        $items = $command->queryAll();
        $arr_new = array();
        foreach($items as $item){
            $arr_new[$item['id']] = $item;
        }
        $items = $arr_new; 
        return $items;
    }
    
    public function getTableInfo(){
         
    }

}
