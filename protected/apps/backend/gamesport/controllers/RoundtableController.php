<?php

class RoundtableController extends BackEndController {

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
        $model = Roundtable::getInstance();
        $tour_detail = $model->getItem($tourID);
        $lists = $model->getLists($tourID, $tour_detail); 
        
        $this->addBarTitle("Matches: <small>$tour_detail->name - Round table</small>", "tournaments"); 
        $this->addIconToolbar("Apply", Router::buildLink("gamesport", array("view"=>"roundtable", "layout" => "save","tourID"=>$tourID)), "apply");
        addSubMenuGameSportTour('roundtable');
        
        $this->render('form', array('tour_detail'=> $tour_detail,'lists' => $lists));
    }
       
    function actionSave() {
        $tourID = Request::getVar('tourID',0);
        $cur_table = Request::getVar('cur_table', 1);
        $this->store();
        YiiMessage::raseSuccess("Round table save succesfully");
        $this->redirect(Router::buildLink("gamesport", array('view'=>'roundtable', "tourID"=>$tourID,'cur_table'=>$cur_table)));
    }

    // chi co super admin moi sua duoc 1 group
    function store() {
        global $mainframe, $db, $user;
        $tourID = Request::getVar('tourID',0);
        $post = $_POST;
          
        $model = Roundtable::getInstance();
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to change Tournament");
            $this->redirect(Router::buildLink("gamesport", array('view'=>'tournament')));
        }
        
        $tourID = Request::getVar('tourID',0);
        $db = Yii::app()->db;        
        $matches_data_subround = json_decode($post['matches_data_subround']);
        $matches_make_first_data = $post['matches_make_first_data'];
       //if($matches_make_first_data == 1){
            $model->make_matches($tourID, $matches_data_subround);
       // }

        return true;
    }
}
