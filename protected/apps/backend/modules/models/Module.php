<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Module extends CFormModel {

    private $table = "{{extensions}}";
    private $tbl_menu = '{{menus}}';
    private $primary = 'id';
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
            $instance = new Module();
        }
        return $instance;
    }

    public function getItems() {
        $obj_module = YiiModule::getInstance();
        $items = $obj_module->loadItems();
        return $items;
    }

    function getLists() {
        $lists = array();
        $filrer_posittion = Request::getVar('filrer_posittion', -1);

        $obj_menu = YiiMenu::getInstance();
        $obj_module = YiiModule::getInstance();

        $tbl_MP = YiiTables::getInstance(TBL_MODULE_POSITION);
        $items = $tbl_MP->loads("temp, position", null, " temp DESC");

        $str_html = '<select id="filrer_posittion" class="form-control" style="width: 180px; height: 25px;" name="filrer_posittion" onChange=" this.form.submit();">' . "\r\n";
        $str_html .= "<option value='-1'> -- Select posittion --</option>";
        $cur_temp = "";
        foreach ($items as $k => $item) {
            if ($cur_temp != $item['temp']) {
                if ($cur_temp != "")
                    $str_html .= '</optgroup>' . "\r\n";
                $str_html .= '<optgroup label="' . $item['temp'] . '">' . "\r\n";
                $cur_temp = $item['temp'];
            }
            if ($filrer_posittion == $item['position'])
                $str_html .= '<option value="' . $item['position'] . '" selected ="">' . $item['position'] . '</option>' . "\r\n";
            else
                $str_html .= '<option value="' . $item['position'] . '">' . $item['position'] . '</option>' . "\r\n";
            if ($k == count($items) - 1)
                $str_html .= '</optgroup>' . "\r\n";
        }
        $str_html .= "</select>";
        $lists['filrer_posittion'] = $str_html;
        return $lists;
    }

    function storeItem() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify module");
            $this->redirect(Router::buildLink("cpanel"));
        }

        $cid = Request::getVar("id", 0);

        $obj_module = YiiModule::getInstance();
        $obj_row = $obj_module->loadItem($cid);
        $obj_row->bind($_POST);

        $menu_selected = Request::getVar('selection-menu-select', 'selected');
        $obj_row->params = json_encode($_POST['params']);
        $obj_row->menu = $menu_selected;
        $obj_row->store();

        if ($menu_selected == 'all') {
            $query = "DELETE FROM " . TBL_MODULE_MENUITEM_REF . " WHERE moduleID = $obj_row->id ";
            Yii::app()->db->createCommand($query)->query();

            $query = "INSERT INTO " . TBL_MODULE_MENUITEM_REF . " SET moduleID = $obj_row->id, menuID = 0 ";
            Yii::app()->db->createCommand($query)->query();
        } else if ($menu_selected == 'selected' AND isset($_POST['selection-menu'])) {
            $menuids = $_POST['selection-menu'];
            foreach ($menuids as $menuid) {
                $query = "REPLACE INTO " . TBL_MODULE_MENUITEM_REF . " SET moduleID = $obj_row->id, menuID = $menuid ";
                Yii::app()->db->createCommand($query)->query();
            }
        } else {
            $query = "DELETE FROM " . TBL_MODULE_MENUITEM_REF . " WHERE moduleID = $obj_row->id ";
            Yii::app()->db->createCommand($query)->query();
        }
        return $obj_row->id;
    }

    function copyitem($cids) {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify module");
            return false;
        }
        if (!is_array($cids))
            $cids = array($cids);
        foreach ($cids as $cid) {
            $obj_module = YiiModule::getInstance();
            $obj_row = $obj_module->loadItem($cid);
            $obj_row->id = 0;
            $obj_row->title = $obj_row->title . " copy";
            $obj_row->alias = $obj_row->alias . "-copy";
            $obj_row->status = 0;
            $obj_row->store();

            $query = "SELECT menuID FROM " . TBL_MODULE_MENUITEM_REF . " WHERE moduleID = $cid ";
            $list_menuID = Yii::app()->db->createCommand($query)->queryColumn();
            if (count($list_menuID)) {
                foreach ($list_menuID as $menuid) {
                    $query = "REPLACE INTO " . TBL_MODULE_MENUITEM_REF . " SET moduleID = $obj_row->id, menuID = $menuid ";
                    Yii::app()->db->createCommand($query)->query();
                }
            }
        }
        return true;
    }

    function removeItem($cids) {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify module");
            return false;
        }
        if (!is_array($cids))
            $cids = array($cids);
        foreach ($cids as $cid) {
            $obj_module = YiiModule::getInstance();
            $obj_row = $obj_module->loadItem($cid);
            $obj_row->remove();

            $query = "DELETE FROM " . TBL_MODULE_MENUITEM_REF . " WHERE moduleID = $obj_row->id ";
            Yii::app()->db->createCommand($query)->query();
        }
        return true;
    }

    public function getModuleExtension() {
        $obj_extension = YiiExtensions::getInstance();
        $items = $obj_extension->loadExts('*', '`type` = \'module\'');
        return $items;
    }

    function creatModule($ext_id) {
        $obj_extension = YiiExtensions::getInstance();
        $obj_ext = $obj_extension->loadExt($ext_id);

        $obj_module = YiiModule::getInstance();
        $obj_row = $obj_module->loadItem(0);
        $obj_row->title = $obj_ext->title;
        $obj_row->alias = $obj_ext->alias;
        $obj_row->module = $obj_ext->name;
        $obj_row->status = 0;
        $obj_row->store();
        return $obj_row->id;
    }

    public function getItem($cid) {
        global $mainframe;
        $obj_module = YiiModule::getInstance();
        $obj_row = $obj_module->loadItem($cid);

        $path = Yii::app()->basePath . '/extensions/modules/' . $obj_row->module;
        $module_xml_file = $path . "/" . $obj_row->module . ".xml";

        if (!file_exists($module_xml_file)) {
            YiiMessage::raseWarning("Error! file xml module is not existing!.");
            $mainframe->redirect(Yii::app()->createUrl("/modules"));
        }
        $params = sysLoadXmlParam($module_xml_file, $obj_row->params);
        $obj_row->params = $params;

        return $obj_row;
    }

    function getListEdit($mainItem) {
        $moduleID = Request::getInt('cid', "");

        $lists = array();
        $obj_menu = YiiMenu::getInstance();
        $obj_module = YiiModule::getInstance();

        $items = $obj_menu->loadMenus();
        $items_xref = $obj_module->loadXrefMenu($moduleID);

        $attr = "";
        $meu_seletec = "selected";
        if ($mainItem->menu == "none") {
            $attr = 'disabled="disabled"';
        } else if ($mainItem->menu == "all") {
            $attr = 'disabled="disabled"';
        }


        $str_html = '<select id="selection-menu" class="inputbox" multiple="multiple" ' . $attr . ' size="15" name="selection-menu[]" style="min-width: 180px;">';
        foreach ($items as $item) {
            $str_html .= '<optgroup label="' . $item['title'] . '">';
            $_items = $item["_items"];
            foreach ($_items as $_item) {
                $str = str_repeat("&nbsp; &nbsp; ", $_item['level'] - 1);

                if ($mainItem->menu == "all") {
                    $str_html .= '<option value="' . $_item['id'] . '" selected ="">' . $str . $_item['title'] . '</option>';
                } else if ($mainItem->menu == "none") {
                    $str_html .= '<option value="' . $_item['id'] . '">' . $str . $_item['title'] . '</option>';
                } else {
                    if (in_array($_item['id'], $items_xref))
                        $str_html .= '<option value="' . $_item['id'] . '" selected ="">' . $str . $_item['title'] . '</option>';
                    else
                        $str_html .= '<option value="' . $_item['id'] . '">' . $str . $_item['title'] . '</option>';
                }
            }
            $str_html .= '</optgroup>';
        }

        $str_html .= "</select>";
        $lists['selection-menu'] = $str_html;
//                position
        $tbl_MP = YiiTables::getInstance(TBL_MODULE_POSITION);
        $items = $tbl_MP->loads("temp, position", null, " temp DESC");

        $str_html = '<div style="position: relative;">';
        $str_html .= '<select id="combobox-position" class="form-control" style="width: 180px; height: 25px;">' . "\r\n";
        $cur_temp = "";
        foreach ($items as $k => $item) {
            if ($cur_temp != $item['temp']) {
                if ($cur_temp != "")
                    $str_html .= '</optgroup>' . "\r\n";
                $str_html .= '<optgroup label="' . $item['temp'] . '">' . "\r\n";
                $cur_temp = $item['temp'];
            }
            if ($mainItem->position == $item['position'])
                $str_html .= '<option value="' . $item['position'] . '" selected ="">' . $item['position'] . '</option>' . "\r\n";
            else
                $str_html .= '<option value="' . $item['position'] . '">' . $item['position'] . '</option>' . "\r\n";
            if ($k == count($items) - 1)
                $str_html .= '</optgroup>' . "\r\n";
        }
        $str_html .= "</select>";
        $str_html .= '<input id="position" class="form-control" type="text" value="' . $mainItem->position . '" name="position" style="position: absolute; z-index: 1000; left: 0px; top: 0px; width: 162px; height: 25px; padding: 3px;">' . "\r\n";
        $str_html .= '</div>';
        $str_html .= '<script> $(window).ready(function($) {
                                $("#combobox-position").change(function(){
                                    var cur_pos = $("#combobox-position").val();
                                    $("#position").val(cur_pos);
                                });
                            });</script>';
        $lists['position'] = $str_html;
        
        $items = array();
        $items[] = array("value" => 0, "text" => "Unpublish");
        $items[] = array("value" => 1, "text" => "Publish");
        $items[] = array("value" => -1, "text" => "Hidden");
        $lists['status'] = buildHtml::select($items, $mainItem->status, "status");
        return $lists;
    }

}

?> 