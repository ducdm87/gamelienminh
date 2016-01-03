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
        $cur_table = Request::getVar('cur_table', 1);
        $lists['locations'] = $this->getLocations();
        $lists['teams_joined'] = $this->getTeams($tourID, $cur_table);
        $lists['table_info'] = $this->getTableInfo($tourID, $cur_table);
        $matches_info = $this->getMatchesInfo($tourID, $cur_table);

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
            foreach ($arr_team_table as $table_num => &$team_tables) {
                $arr_new = array();
                foreach ($team_tables as $teamID => $team) {
                    // var_dump($team); die;
                }
            }
        }
        for ($i = 0; $i <= $main_item->number_table; $i++) {
            if (!isset($arr_team_table[$i]))
                $arr_team_table[$i] = array();
        }

        $lists['arr_team_table'] = $arr_team_table;

        if (count($matches_info)) {
            $arr_new = array();
            foreach ($matches_info as $matches) {
                $matches['m_class'] = "M{$matches['subround']}_" . $matches['ordering'];
                $arr_new[$matches['subround']][] = $matches;
            }
            $matches_info = $arr_new;
        }

        $lists['matches_info'] = $matches_info;
        $lists['cur_table'] = Request::getVar('cur_table', 1);

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

    public function getTeams($tourID = 0, $cur_table = 1, & $total_team = 0) {
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

    public function getTableInfo($tourID = 0, $cur_table = 1) {
        
    }

    public function getMatchesInfo($tourID = 0, $cur_table = 1) {
        $db = Yii::app()->db;
        $command = $db->createCommand()->select("A.*")
                ->from(TBL_GS_MATCHES . " A")
                ->where("A.tourID = $tourID AND (A.round = 1 OR A.round = 0  ) AND A.group = $cur_table")
                ->order('A.round ASC, A.ordering')
        ;
        $items = $command->queryAll();
        return $items;
    }

    function make_matches($tourID, $matches_data_subround) {
        global $user;
        $db = Yii::app()->db;
        $obj_team = YiiTables::getInstance(TBL_GS_TEAMS, null, true);
        $arr_matches_id = array();
        foreach ($matches_data_subround as $num_round => $matches_data_table) {
            if ($matches_data_table == null)
                continue;
            $arr_matches_id[$num_round] = array();
            
            foreach($matches_data_table as $matches_intable){
                $team_a = $obj_team->load($matches_intable->teamaID);
                $matches_intable->teama_name = $team_a->name;
                $matches_intable->teama_alias = $team_a->alias;
                $team_b = $obj_team->load($matches_intable->teambID);
                $matches_intable->teamb_name = $team_b->name;
                $matches_intable->teamb_alias = $team_b->alias;

                $matches_intable->name = "$matches_intable->teama_name VS $matches_intable->teamb_name";
                $matches_intable->alias = "$matches_intable->teama_alias-vs-$matches_intable->teamb_alias";

                $query = "INSERT INTO " . TBL_GS_MATCHES
                        . " SET id = $matches_intable->id "
                        . " , `name` = '$matches_intable->name'"
                        . " ,`alias` = '$matches_intable->alias'"
                        . " , tourID = '$matches_intable->tourID'"
                        . " , teamaID = '$matches_intable->teamaID'"
                        . " , teambID = '$matches_intable->teambID'"
                        . " , `round` = '$matches_intable->round'"
                        . " , `group` = '$matches_intable->group'"
                        . " , subround = '$matches_intable->subround'"
                        . " , `ordering` = '$matches_intable->ordering'"
                        . " , `cdate` = now()"
                        . " , `mdate` = now()"
                        . " , `status` = 1"
                        . " , `created_by` = $user->id"
                        . " , `modified_by` = $user->id"
                        . " ON DUPLICATE KEY UPDATE  `name` = '$matches_intable->name'"
                        . " , `alias` = '$matches_intable->alias'"
                        . " , teamaID = '$matches_intable->teamaID'"
                        . " , teambID = '$matches_intable->teambID'"
                        . " , ordering = '$matches_intable->ordering'"
                        . " , `mdate` = now()"
                        . " , `status` = 1"
                        . " , `modified_by` = $user->id"
                ;
                $command = $db->createCommand($query);
                $result = $command->execute();
                $arr_matches_id[$num_round][] = $db->getLastInsertID();
            }
        }

        // tao cac tran dau cua vong tiep theo
        $cur_table = Request::getVar('cur_table', 1);
        $team_intable = $this->getTeams($tourID, $cur_table);
        $tour_detail = $this->getItem($tourID);
        $number_team_pass = $tour_detail->number_teams_de / $tour_detail->number_table;
        $arr_level = array();
        for ($j = 0; $j <= $tour_detail->number_team_table; $j++) {
            $val = $number_team_pass * pow(2, $j);
            if ($val > $tour_detail->number_team_table)
                break;
            $arr_level[] = $val;
            $max_round = $j;
        }
        $max_level = $arr_level[$max_round];
        $arr_level = array_reverse($arr_level);
        
        for ($i = $num_round + 1; $i < count($arr_level); $i++) {
            $num_matches = $arr_level[$i];
            $arr_insertedID = $arr_matches_id[$i - 1];
            for ($j = 0; $j < $num_matches; $j++) {
                $teamaID = $arr_insertedID[$j * 2]*-1;
                $teambID = $arr_insertedID[$j * 2 + 1]*-1;
                $subround = $i ;
                $query = "INSERT INTO " . TBL_GS_MATCHES
                        . " SET tourID = '$tourID'"
                        . " , teamaID = '$teamaID'"
                        . " , teambID = '$teambID'"
                        . " , `round` = '1'"
                        . " , `group` = '$cur_table'"
                        . " , subround = '$subround'"
                        . " , `ordering` = $j"
                        . " , `cdate` = now()"
                        . " , `mdate` = now()"
                        . " , `status` = 1"
                        . " , `created_by` = $user->id"
                        . " , `modified_by` = $user->id"
                        . " ON DUPLICATE KEY UPDATE  ordering = $j"
                        . " , teamaID = '$teamaID'"
                        . " , teambID = '$teambID'"
                        . " , `round` = '1'"
                        . " , `group` = '$cur_table'"
                        . " , subround = '$subround'"
                        . " , `mdate` = now()"
                        . " , `status` = 1"
                        . " , `modified_by` = $user->id"
                ;
                $command = $db->createCommand($query);
                $result = $command->execute();
                $arr_matches_id[$subround][] = $db->getLastInsertID();
            }
        }
    }

}
