<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Roundtable extends CFormModel {

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
            $instance = new Roundtable();
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
        $matches_info = $this->getMatchesInfo($tourID);
        
        $arr_team_loc = array();
        if (count($lists['teams_joined'])) {
            foreach ($lists['teams_joined'] as $team) {
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
                $arr_team_table[$team['table_num']][$team['id']] = $new_team;
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
        
        if(count($matches_info)){
            $arr_new = array();
            foreach($matches_info as $matches){
            $matches['m_class'] = "M{$matches['group']}_".$matches['ordering'];
                $arr_new[$matches['round']][$matches['group']][$matches['subround']][] = $matches;                
            }
            $matches_info = $arr_new;
        }
        $lists['matches_info'] = $matches_info;
        
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
                ->order('A.round ASC, A.ordering')
        ;
        $items = $command->queryAll();
        return $items;
    }
    
    function make_matches($tourID, $matches_data_table)
    {
        global $user;
        $db = Yii::app()->db;
        $obj_team = YiiTables::getInstance(TBL_GS_TEAMS, null, true);
       
        foreach($matches_data_table as $matches_intable){
            if($matches_intable == null) continue;
            foreach($matches_intable as $table){
                if($table->name == ""){
                    $team_a = $obj_team->load($table->teamaID);
                    $table->teama_name = $team_a->name;
                    $table->teama_alias = $team_a->alias;
                    $team_b = $obj_team->load($table->teambID);
                    $table->teamb_name = $team_b->name;
                    $table->teamb_alias = $team_b->alias;
                    
                    $table->name = "$table->teama_name VS $table->teamb_name";
                    $table->alias = "$table->teama_alias-vs-$table->teamb_alias";                    
                }
                $query = "INSERT INTO ". TBL_GS_MATCHES
                            ." SET id = $table->id "
                            ." , `name` = '$table->name'"
                            ." ,`alias` = '$table->alias'"
                            ." , tourID = '$table->tourID'"
                            ." , teamaID = '$table->teamaID'"
                            ." , teambID = '$table->teambID'"
                            ." , `round` = '$table->round'"
                            ." , `group` = '$table->group'"
                            ." , subround = '$table->subround'"
                            ." , `ordering` = '$table->ordering'"
                            ." , `cdate` = now()"
                            ." , `mdate` = now()"
                            ." , `status` = 1"
                            ." , `created_by` = $user->id"
                            ." , `modified_by` = $user->id"
                        ." ON DUPLICATE KEY UPDATE  `name` = '$table->name'"
                                ." , `alias` = '$table->alias'"
                                ." , teamaID = '$table->teamaID'"
                                ." , teambID = '$table->teambID'"
                                ." , ordering = '$table->ordering'"
                                ." , `mdate` = now()"
                                ." , `status` = 1"
                                ." , `modified_by` = $user->id"
                        ;
                $command = $db->createCommand($query);                
                $command->execute();
            }
        }
    }

}
