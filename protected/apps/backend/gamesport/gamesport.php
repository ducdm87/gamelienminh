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