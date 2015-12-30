<?php

class PlayersController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{users}}";
    var $tbl_group = "{{users_group}}";

    function init() {
        include_once dirname(__FILE__) . '/../gamesport.php';
        parent::init();
    }

    function actionDisplay() {
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
            YiiMessage::raseSuccess("Successfully saved changes status for players(s)");
        }


        $this->addIconToolbar("Edit", Router::buildLink("gamesport", array("view" => "players", "layout" => "edit")), "edit", 1, 1, "Please select a item from the list to edit");
        $this->addIconToolbar("New", Router::buildLink("gamesport", array("view" => "players", "layout" => "new")), "new");
//        $this->addIconToolbarDelete();
        $this->addIconToolbar("Delete", Router::buildLink("gamesport", array("view" => "players", "layout" => "remove")), "trash", 1, 1, "Please select a item from the list to Remove");
        $this->addBarTitle("players <small>[manager]</small>", "players");
        addSubMenuGameSport('players');
        $model = Players::getInstance();
        $items = $model->getItemspPlayer();
        $pagination = $model->getPagination();

        $this->render('default', array('items' => $items, 'pagination' => $pagination));
    }

    function changeStatus($cid, $value) {
        global $user;
        if (!$bool = $user->modifyChecking($cid)) {
            YiiMessage::raseNotice("Your account not have permission to change status of tteam");
            $this->redirect(Router::buildLink("users", array('view' => 'user')));
            return false;
        }
        $obj_tblTeam = YiiTables::getInstance(TBL_GS_PLAYERS);
        $obj_tblTeam->load($cid); 
        $obj_tblTeam->status = $value;
        $obj_tblTeam->store();
    }

    function actionCancel() {
        $this->redirect(Router::buildLink("gamesport", array("view" => "players")));
    }

    function actionNew() {
        $this->actionEdit();
    }
     // chi co super admin moi sua duoc 1 group
    public function actionEdit() {
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit players");
            $this->redirect(Router::buildLink("gamesport"));
        }

        setSysConfig("sidebar.display", 0);

        $this->addIconToolbar("Save", Router::buildLink("gamesport", array("view" => "players", "layout" => "save")), "save");
        $this->addIconToolbar("Apply", Router::buildLink("gamesport", array("view" => "players", "layout" => "apply")), "apply");
        $items = array();

        $cid = Request::getVar("cid", 0);

        if (is_array($cid))
            $cid = $cid[0];

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", Router::buildLink("gamesport", array("view" => "players", "layout" => "cancel")), "cancel");
            $this->addBarTitle("Players <small>[New]</small>", "players");
            $this->pageTitle = "New Players";
        } else {
            $this->addIconToolbar("Close", Router::buildLink("gamesport", array("view" => "players", "layout" => "cancel")), "cancel");
            $this->addBarTitle("Players <small>[Edit]</small>", "players");
            $this->pageTitle = "Edit Players";
        }

        $model = Players::getInstance();
        $item = $model->getItem();

        $lists = $model->getListEdit($item);
        $this->render('edit', array("item" => $item, "lists" => $lists));
    }

    function actionApply() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Players save succesfully");
        $this->redirect(Router::buildLink("gamesport", array("view" => "players", "layout" => "edit", 'cid' => $cid)));
    }

    function actionSave() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Players save succesfully");
        $this->redirect(Router::buildLink("gamesport", array('view' => 'players')));
    }

     // chi co super admin moi sua duoc 1 group
    function store() {
        global $mainframe, $db, $user;
        $post = $_POST;

        $model = Players::getInstance();
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit Players");
            $this->redirect(Router::buildLink("gamesport", array('view' => 'players')));
        }

        $id = Request::getVar("id", 0);

        $obj_tblTeam = YiiTables::getInstance(TBL_GS_PLAYERS);
        $obj_tblTeam->load($id); 
        $obj_tblTeam->bind($post);
//        var_dump($obj_tblTeam); die;
        $obj_tblTeam->store();

        return $obj_tblTeam->id;
    }

    public function actionLogin() {

        $LoginForm = Request::getVar("LoginForm");
        if (Request::getVar("LoginForm") and ($LoginForm['username'] == "" || $LoginForm['password'] == "")) {
            YiiMessage::raseWarning("Type your username and password");
            $this->redirect(Router::buildLink("users", array("view" => "user", 'layout' => 'login')));
            return;
        }

        $model = new UserForm();
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            $session_id = session_id();
            // validate user input and redirect to the previous page if valid  

            if ($model->validate() && $model->login()) {
                $this->afterLogin($session_id, session_id());
                $this->redirect(Router::buildLink("cpanel"));
//                    $this->redirect("/backend/");
            } else {
                YiiMessage::raseWarning("Invalid your usename or password");
            }
        }
        $this->layout = "//login";
        $this->pageTitle = "Page login";
        $this->render('login');
    }

    public function actionLogout() {
//        Yii::app()->session['userbackend'] = null;
        Yii::app()->user->logout();
        $this->redirect(Router::buildLink("users", array("view" => "user", 'layout' => 'login')));
    }

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
                $item = $this->removeItem($cid,TBL_GS_PLAYERS);
            }
        }
        YiiMessage::raseSuccess("Successfully remove playist(s)");
        $this->redirect(Router::buildLink('gamesport', array('view' => 'Players')));
    }

    function actionTree() {
        global $user;
        $tmpl = Request::getVar('tmpl', null);
        $modelUser = new Users();
        $modelGroup = new Group();

        $this->addBarTitle("Users <small>[tree]</small>", "user");

        $groupID = Request::getVar('groupID', $user->groupID);
        $group = $modelGroup->getItem($user->groupID);

        if ($group->parentID != 1) {
            if (!$user->groupChecking($groupID)) {
                $group = $modelGroup->getItem($user->groupID);
                YiiMessage::raseNotice("Your account not have permission to visit page");
                $this->redirect(Router::buildLink("cpanel"));
            }
        }

        $group = $modelGroup->getItem($groupID);
        $list_user = $modelUser->getUsers($groupID, " leader DESC, id ASC ");
        $arr_group = $modelUser->getGroups($groupID);

        if ($tmpl == null)
            $this->render('tree', array("objGroup" => $group, "list_user" => $list_user, 'arr_group' => $arr_group));
        else if ($tmpl == 'app') {
            $this->render('treegroup', array("objGroup" => $group, "list_user" => $list_user, 'arr_group' => $arr_group));
            die;
        }
    }

}
