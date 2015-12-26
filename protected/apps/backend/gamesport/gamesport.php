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
    $mainframe->addIconSubMenu("Panel", Router::buildLink('gamesport'));
    $mainframe->addIconSubMenu("Back", Router::buildLink('gamesport', array('view'=>'tournaments')), $view ==  'tournaments');
    $tourID = Request::getVar('tourID',0);
    $mainframe->addIconSubMenu("Teams Joined", Router::buildLink('gamesport', array('view'=>'tournament','tourID'=>$tourID)), $view ==  'tournament');
    $mainframe->addIconSubMenu("Matches", Router::buildLink('gamesport', array('view'=>'matches','tourID'=>$tourID)), $view ==  'matches');
}

global $_list_tour_state;

$_list_tour_state = [];
$_list_tour_state[0] = "Giải mới";
$_list_tour_state[1] = "Cho phép đăng ký";
$_list_tour_state[2] = "Vòng loại";
$_list_tour_state[3] = "Vòng DE";
$_list_tour_state[4] = "Chung kết";
$_list_tour_state[5] = "Kết thúc";
