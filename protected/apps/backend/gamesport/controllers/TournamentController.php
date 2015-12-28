<?php

class TournamentController extends BackEndController {

    var $tablename = '';
    var $primary = 'id';

    function init() {
        $this->tablename = TBL_GS_TOURNAMEMANTS;
        include_once dirname(__FILE__). '/../gamesport.php';
        parent::init();
    }
    /*
     * For menu type
     */
    public function actionDisplay() {
        global $mainframe, $user; 
        $tourID = Request::getVar('tourID',0);
        $model = Tournament::getInstance();
        $tour_detail = $model->getItem($tourID);
        $lists = $model->getLists($tourID); 
       
        $this->addBarTitle("Tournament: <small>$tour_detail->name</small>", "tournaments"); 
        addSubMenuGameSportTour('tournament');
        
        $this->render('teamjoined', array('tour_detail'=> $tour_detail,'lists' => $lists));
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

        $this->addIconToolbar("Save", Router::buildLink("gamesport", array("view"=>"tournaments", "layout" => "save")), "save");
        $this->addIconToolbar("Apply", Router::buildLink("gamesport", array("view"=>"tournaments", "layout" => "apply")), "apply");
        $items = array();

        $cid = Request::getVar("cid", 0);

        if (is_array($cid))
            $cid = $cid[0];

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", Router::buildLink("gamesport", array("view"=>"tournaments", "layout" => "cancel")), "cancel");
            $this->addBarTitle("Tournament <small>[New]</small>", "tournaments");
            $this->pageTitle = "New tournament";
        } else {
            $this->addIconToolbar("Close", Router::buildLink("gamesport", array("view"=>"tournaments", "layout" => "cancel")), "cancel");
            $this->addBarTitle("Tournament <small>[Edit]</small>", "tournaments");
            $this->pageTitle = "Edit tournament";
        }

        $model = Tournaments::getInstance();
        $item = $model->getItem();
        
        $lists = $model->getListEdit($item);
        $this->render('edit', array("item" => $item, "lists" => $lists));
    }

     function actionCancel() {
        $this->redirect(Router::buildLink("gamesport", array('view'=>'tournaments')));
    }
    
    function actionApply() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Tournament save succesfully");
        $this->redirect(Router::buildLink("gamesport", array("view"=>"tournaments", "layout" => "edit", 'cid' => $cid)));
    }

    function actionSave() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Tournament save succesfully");
        $this->redirect(Router::buildLink("gamesport", array('view'=>'tournaments')));
    }

    // chi co super admin moi sua duoc 1 group
    function store() {
        global $mainframe, $db, $user;
        $post = $_POST;

        $model = Tournaments::getInstance();
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit Tournament");
            $this->redirect(Router::buildLink("gamesport", array('view'=>'tournaments')));
        }

        $id = Request::getVar("id", 0);

        $obj_tblTournament = YiiTables::getInstance(TBL_GS_TOURNAMEMANTS);
        $obj_tblTournament->load($id);        
        $obj_tblTournament->_ordering = isset($post['ordering']) ? $post['ordering'] : null;
        $obj_tblTournament->_old_parent = $obj_tblTournament->parentID;

        $obj_tblTournament->bind($post);
        $obj_tblTournament->store(); 

        return $obj_tblTournament->id;
    }
    
    function changeStatus($cid, $value) {
        global $user;
        $obj_tblTournament = YiiTables::getInstance(TBL_GS_TOURNAMEMANTS);
        $obj_tblTournament->load($cid); 
        $obj_tblTournament->status = $value;
        $obj_tblTournament->store();
    }
    
     // chi co super admin moi duoc xoa group
    function actionRemove() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission remove tournament");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $cids = Request::getVar("cid", 0);
        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                //check item first
                $item = $this->removeItem($cid);               
            }
        }
        YiiMessage::raseSuccess("Successfully remove tournament(s)");
        $this->redirect(Router::buildLink('gamesport', array('view'=>'tournaments')));
    } 
}
