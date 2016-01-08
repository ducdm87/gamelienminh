<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MainmenuHelper {

    function getItems($menutype) {
        $obj_menu = YiiMenu::getInstance();
        $arr_menu = $obj_menu->getMenu($menutype);
        if (is_array($arr_menu) AND count($arr_menu)) {
            $arr_menu = json_encode($arr_menu);
            $arr_menu = json_decode($arr_menu);

            $childs = array();
            foreach ($arr_menu as $menu) {
                $childs[$menu->parentID][$menu->id] = $menu;
            }

            foreach ($arr_menu as $menu)
                if (isset($childs[$menu->id]))
                    $menu->data_child = $childs[$menu->id];

            $arr_menu = $childs[1];
        }
        return $arr_menu;
    }

    function showNodeMenu($items, $showChildren = 1) {
        $url = isset($items->url) ? $items->url : $items->link;
        echo '<li>';
        echo '<a class="" href="' . $url . '">' . $items->title . '</a>';
        if ($showChildren == 1 AND isset($items->data_child)) {
            $level = $items->level + 1;
            echo '<ul class="children level-' . $level . '">';
            foreach ($items->data_child as $item) {
                $this->showNodeMenu($item, $showChildren);
            }
            echo '</ul>';
        }
        echo '</li>';
    }

}
