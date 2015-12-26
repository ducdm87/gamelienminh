<?php

class TeamsController extends BackEndController {

    var $tablename = '';
    var $primary = 'id';

    function init() {
        $this->tablename = TBL_GS_TEAMS;
        include_once dirname(__FILE__) . '/../gamesport.php';
        parent::init();
    }

    /*
     * For menu type
     */

    public function actionDisplay() {
        global $mainframe, $user;

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
            YiiMessage::raseSuccess("Successfully saved changes status for team(s)");
        }


        $this->addIconToolbar("Edit", Router::buildLink("gamesport", array("view" => "teams", "layout" => "edit")), "edit", 1, 1, "Please select a item from the list to edit");
        $this->addIconToolbar("New", Router::buildLink("gamesport", array("view" => "teams", "layout" => "new")), "new");
//        $this->addIconToolbarDelete();
        $this->addIconToolbar("Delete", Router::buildLink("gamesport", array("view" => "teams", "layout" => "remove")), "trash", 1, 1, "Please select a item from the list to Remove");
        $this->addBarTitle("Teams <small>[manager]</small>", "teams");
        addSubMenuGameSport('teams');
        $model = Teams::getInstance();
        $items = $model->getItems();
        $pagination = $model->getPagination();

        $this->render('default', array('items' => $items, 'pagination' => $pagination));
    }

    public function actionNew() {
        $this->actionEdit();
    }

    // chi co super admin moi sua duoc 1 group
    public function actionEdit() {
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit tournament");
            $this->redirect(Router::buildLink("gamesport"));
        }

        setSysConfig("sidebar.display", 0);

        $this->addIconToolbar("Save", Router::buildLink("gamesport", array("view" => "teams", "layout" => "save")), "save");
        $this->addIconToolbar("Apply", Router::buildLink("gamesport", array("view" => "teams", "layout" => "apply")), "apply");
        $items = array();

        $cid = Request::getVar("cid", 0);

        if (is_array($cid))
            $cid = $cid[0];

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", Router::buildLink("gamesport", array("view" => "teams", "layout" => "cancel")), "cancel");
            $this->addBarTitle("Team <small>[New]</small>", "teams");
            $this->pageTitle = "New team";
        } else {
            $this->addIconToolbar("Close", Router::buildLink("gamesport", array("view" => "teams", "layout" => "cancel")), "cancel");
            $this->addBarTitle("Team <small>[Edit]</small>", "teams");
            $this->pageTitle = "Edit team";
        }

        $model = Teams::getInstance();
        $item = $model->getItem();

        $lists = $model->getListEdit($item);
        $this->render('edit', array("item" => $item, "lists" => $lists));
    }

    function actionCancel() {
        $this->redirect(Router::buildLink("gamesport", array('view' => 'teams')));
    }

    function actionApply() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Team save succesfully");
        $this->redirect(Router::buildLink("gamesport", array("view" => "teams", "layout" => "edit", 'cid' => $cid)));
    }

    function actionSave() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Team save succesfully");
        $this->redirect(Router::buildLink("gamesport", array('view' => 'teams')));
    }

    // chi co super admin moi sua duoc 1 group
    function store() {
        global $mainframe, $db, $user;
        $post = $_POST;

        $model = Teams::getInstance();
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit Team");
            $this->redirect(Router::buildLink("gamesport", array('view' => 'teams')));
        }

        $id = Request::getVar("id", 0);

        $obj_tblTeam = YiiTables::getInstance(TBL_GS_TEAMS);
        $obj_tblTeam->load($id); 
        $obj_tblTeam->bind($post);
        $obj_tblTeam->store();

        return $obj_tblTeam->id;
    }

    function changeStatus($cid, $value) {
        global $user;
        $obj_tblTeam = YiiTables::getInstance(TBL_GS_TEAMS);
        $obj_tblTeam->load($cid);
        $obj_tblTeam->status = $value;
        $obj_tblTeam->store();
    }

    // chi co super admin moi duoc xoa group
    function actionRemove() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission remove tournament");
            $this->redirect(Router::buildLink("cpanel"));
        }

        $cids = Request::getVar("cid", 0);

        if (count($cids) > 0) {
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                //check item first
                $item = $this->removeItem($cid);
            }
        }
        YiiMessage::raseSuccess("Successfully remove tournament(s)");
        $this->redirect(Router::buildLink('gamesport', array('view' => 'teams')));
    }

}
