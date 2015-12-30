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

    public function getItem($cid = null) {
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

    public function getLists($tourID = 0, $main_item) {
        $lists = array();
        $lists['locations'] = $this->getLocations();
        $lists['teams_joined'] = $this->getTeams($tourID);
        $lists['table_info'] = $this->getTableInfo($tourID);
        $lists['matches_info'] = $this->getMatchesInfo($tourID);
        
        $arr_team_loc = array();
        if (count($lists['teams_joined'])) {
            foreach ($lists['teams_joined'] as $team) {
                $tab_num = $team['table_num'];
                $tab_num = $tab_num<=$main_item->number_table?$tab_num:0;
                $team['table_num'] = $tab_num;
                $arr_team_loc[$team['locationID']][] = $team;
            }
        }

        $lists['teams_joined_loc'] = $arr_team_loc;
        
        $arr_team_table = array();
        
        if (count($lists['teams_joined'])) {
            foreach ($lists['teams_joined'] as $team) {
                $new_team = array();
                $new_team['id'] = $team['id'];
                $new_team['name'] = $team['name'];
                $new_team['table_num'] = $team['table_num'];
                $new_team['ordering'] = $team['ordering'];
                $tab_num = $team['table_num'];
                $tab_num = $tab_num<=$main_item->number_table?$tab_num:0;
                $arr_team_table[$tab_num][$team['id']] = $new_team;
            }
            foreach($arr_team_table as $table_num => &$team_tables){
                $arr_new = array();
                foreach($team_tables as $teamID => $team){
                   // var_dump($team); die;
                }
            }
        }
        for($i=0;$i<=$main_item->number_table;$i++){
            if(!isset($arr_team_table[$i]) ) $arr_team_table[$i] = array();
        }
        
        $lists['arr_team_table'] = $arr_team_table;
        
                
        return $lists;
    }

    public function getLocations() {
        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);
        $locations = $obj_tblLocation->loads("*", 'parentID != 0 ', "lft ASC", null, 0);

        $arr_new = array();
        foreach ($locations as $loc) {
            $arr_new[$loc['id']] = $loc;
        }
        $locations = $arr_new;
        return $locations;
    }

    public function getTeams($tourID = 0, & $total_team = 0) {
        $db = Yii::app()->db;
        $command = $db->createCommand()->select("A.id, A.name, A.locationID, A.thumbnail, A.ordering, B.cdate joined_day, B.table_num, C.name location_name")
                ->from(TBL_GS_TEAMS . " A")
                ->rightJoin(TBL_GS_TEAM_REGISTER_TOUR . ' B', 'A.id = B.teamID')
                ->leftJoin(TBL_LOCATIONS . ' C', 'A.locationID = C.id')
                ->order('B.ordering')
                ->where("tourID = $tourID")
        ;
        $items = $command->queryAll();
        $arr_new = array();
        $total_team = count($items);
        foreach ($items as $item) {
            $arr_new[$item['id']] = $item;
        }
        $items = $arr_new;
        return $items;
    }

    public function getTableInfo($tourID = 0) {
        
    }

    public function getMatchesInfo($tourID = 0) {
        $db = Yii::app()->db;
        $command = $db->createCommand()->select("A.*")
                ->from(TBL_GS_MATCHES . " A")
                ->where("tourID = $tourID")
        ;
        $items = $command->queryAll();
        return $items;
    }

}
