<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function addSubMenuGameSport($view = "tournaments")
{
    global $mainframe;
    $mainframe->addIconSubMenu("Panel", Router::buildLink('gamesport'));
    $mainframe->addIconSubMenu("Tournaments", Router::buildLink('gamesport', array('view'=>'tournaments')), $view ==  'tournaments');
    $mainframe->addIconSubMenu("Teams", Router::buildLink('gamesport', array('view'=>'teams')), $view ==  'teams');
    $mainframe->addIconSubMenu("Players", Router::buildLink('gamesport', array('view'=>'players')), $view ==  'players');
}

function addSubMenuGameSportTour($view = "tournaments")
{
    global $mainframe;
    $tourID = Request::getVar('tourID',0);
    $mainframe->addIconSubMenu("Panel", Router::buildLink('gamesport'));
    $mainframe->addIconSubMenu("Back", Router::buildLink('gamesport', array('view'=>'tournaments')));
    $mainframe->addIconSubMenu("Edit tournament", Router::buildLink('gamesport', array('view'=>'tournaments','layout'=>'edit','cid'=>$tourID)));
    $mainframe->addIconSubMenu("Teams Joined", Router::buildLink('gamesport', array('view'=>'tournament','tourID'=>$tourID)), $view ==  'tournament');
    $mainframe->addIconSubMenu("Matches", Router::buildLink('gamesport', array('view'=>'matches','tourID'=>$tourID)), $view ==  'matches');
}

global $_list_tour_state, $_list_num_table, $_list_num_teams_DE, $_list_num_teams_table;

$_list_tour_state = [];
$_list_tour_state[0] = "Giải mới";
$_list_tour_state[1] = "Cho phép đăng ký";
$_list_tour_state[2] = "Vòng loại";
$_list_tour_state[3] = "Vòng DE";
$_list_tour_state[4] = "Chung kết";
$_list_tour_state[5] = "Kết thúc";

$_list_num_table = [1,2,4,8,16,32]; // a
$_list_num_teams_DE = [16,32,64];  // b
$_list_num_teams_table = [8,16,32,64,128,256,512];  // b
// $_list_num_teams    

/*
 * so doi dang ky la x
 * so bang la a
 * so doi vao DE la b 
 *  => so doi can lay moi bang la c = b/a
 * so doi vao 1 bang la d = x/a; yeu cau d = 2^n * c
 *  => x = d * a = (2^n)*c*a = (2^n) *(b/a) * a = (2^n)*b
 *  do mỗi bảng có thể thiếu từ 1 đến 2 đội cho nên số 
 *             (2^n)*b >= x >= (2^n)*b - 2*a
 *              
 */


if(0){
    $query = "INSERT INTO `tbl_gs_teams` ( `name`, `alias`, `locationID`, `cdate`, `mdate`, `status`) 
        VALUES ";
    $arr_val = [];
    for($i=4;$i<68;$i++){
        $arr_val[] = "('Clan Sài Gòn $i', 'clan-sai-gon-$i', '21', now(), now(), '1')";
    }

    $query = $query . implode(", ", $arr_val);
    $command = Yii::app()->db->createCommand($query);
    $command->execute(); 
}

if(0){
    $query = "INSERT INTO `tbl_gs_team_register_tour` (`teamID`, `tourID`, `table_num`, `cdate`, `mdate`, `status`) 
        VALUES ";
    $arr_val = [];
    for($i=193;$i<=256;$i++){
        $arr_val[] = "('$i', '3', '0', now(), now(), '1')";
    }

    $query = $query . implode(", ", $arr_val);
    $command = Yii::app()->db->createCommand($query);
    $command->execute();
}

