<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeController extends BackEndController {

    var $tablename = "{{modules}}";
    var $tbl_menu = '{{menus}}';
    var $primary = 'id';
    var $item = null;
    private $model;

    function init() {
        parent::init();
    }

    public function actionDisplay() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to view menu item");
            $this->redirect(Router::buildLink("menus", array("view" => 'menutype')));
        }

        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeStatus($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatus($cid, 2);
                else
                    $this->changeStatus($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for module");
        }

        $this->addIconToolbar("New", Router::buildLink("modules", array("layout" => "new")), "new");
        $this->addIconToolbar("Edit", Router::buildLink("modules", array("layout" => "edit")), "edit", 1, 1, "Please select a item from the list to edit");
        $this->addIconToolbar("Duplicate", Router::buildLink('modules', array('layout' => 'duplicate')), " fa fa-copy");
        $this->addIconToolbar("Publish", Router::buildLink("modules", array("layout" => "publish")), "publish");
        $this->addIconToolbar("Unpublish", Router::buildLink("modules", array("layout" => "unpublish")), "unpublish");
        $this->addIconToolbar("Delete", Router::buildLink("modules", array("layout" => "remove")), "trash", 1, 1, "Please select a item from the list to Remove");
        $this->addBarTitle("Modules <small>[manager]</small>", "user");

        $model = Module::getInstance();

        $items = $model->getItems();
        $lists = $model->getLists();
        $this->render('default', array("items" => $items, 'lists' => $lists));
    }

    public function actionNew() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add module");
            $this->redirect(Router::buildLink("cpanel"));
        }
        $this->pageTitle = "New module";
        
        $model = Module::getInstance();
        $items = $model->getModuleExtension();
        $lists = '';
        $this->render('new', array("items" => $items, "lists" => $lists));
    }

    public function actionEdit() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit module");
            $this->redirect(Router::buildLink("cpanel"));
        }

        $cid = Request::getVar('cid', "");
        setSysConfig("sidebar.display", 0);
        //check boolean id
        $model = Module::getInstance();
        $item = $model->getItem($cid);

        $lists = $model->getListEdit($item);

        $this->addIconToolbar("Save", Router::buildLink("modules", array("layout" => "save")), "save");
        $this->addIconToolbar("Apply", Router::buildLink("modules", array("layout" => "apply")), "apply");
        $this->addBarTitle("Module <small>[Edit]</small>", "user");
        $this->addIconToolbar("Close", Router::buildLink("modules", array("layout" => "cancel")), "cancel");
        $this->pageTitle = "Edit module";

        $this->render('edit', array("item" => $item, "lists" => $lists));
    }

    function actionAddModule(){
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit module");
            $this->redirect(Router::buildLink("cpanel"));
        }
        $cid = Request::getVar('cid', "");
        $model = Module::getInstance();
        $mod_id = $model->creatModule($cid);
        $this->redirect(Router::buildLink("modules", array("layout" => "edit", 'cid' => $mod_id)));
    }
    
    function actionApply() {
        $model = Module::getInstance();
        $cid = $model->storeItem();
        YiiMessage::raseSuccess("Successfully save Module(s)");
        $this->redirect(Router::buildLink("modules", array("layout" => "edit", 'cid' => $cid)));
    }

    function actionSave() {
        $model = Module::getInstance();
        $cid = $model->storeItem();
        YiiMessage::raseSuccess("Successfully save Module(s)");
        $this->redirect(Router::buildLink("modules"));
    }

    function actionDuplicate() {
        $cid = Request::getVar("cid", 0);
        $model = Module::getInstance();
        $result = $model->copyitem($cid);
        YiiMessage::raseSuccess("Successfully duplicate Module(s)");
        $this->redirect(Router::buildLink("modules"));
    }

    function actionCancel() {
        $this->redirect(Router::buildLink("modules"));
    }

    public function actionRemove($id = false) {

        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify module");
            $this->redirect(Router::buildLink("cpanel"));
        }
        $cids = Request::getVar("cid", 0);
        $model = Module::getInstance();
        $model->removeItem($cids);
        YiiMessage::raseSuccess("Successfully remove Module(s)");
        $this->redirect(Router::buildLink("modules"));
    }

    function actionPublish() {
        $cids = Request::getVar("cid", 0);

        if (count($cids) > 0) {
            foreach ($cids as $cid) {
                $this->changeStatus($cid, 1);
            }
        }
        YiiMessage::raseSuccess("Successfully publish Module(s)");
        $this->redirect(Router::buildLink("modules"));
    }

    function actionUnpublish() {
        $cids = Request::getVar("cid", 0);

        if (count($cids) > 0) {
            foreach ($cids as $cid) {
                $this->changeStatus($cid, 0);
            }
        }
        YiiMessage::raseSuccess("Successfully unpublish Module(s)");
        $this->redirect(Router::buildLink("modules"));
    }

    function changeStatus($cid, $value) {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify module");
            $this->redirect(Router::buildLink("cpanel"));
        }

        $obj_module = YiiModule::getInstance();
        $obj_row = $obj_module->loadItem($cid);
        $obj_row->status = $value;
        $obj_row->store();
    }

}
