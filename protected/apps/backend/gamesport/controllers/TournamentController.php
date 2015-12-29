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
        $lists = $model->getLists($tourID, $tour_detail); 
        
        $this->addBarTitle("Tournament: <small>$tour_detail->name</small>", "tournaments"); 
        $this->addIconToolbar("Apply", Router::buildLink("gamesport", array("view"=>"tournament", "layout" => "save","tourID"=>$tourID)), "apply");
        addSubMenuGameSportTour('tournament');
        
        $this->render('teamjoined', array('tour_detail'=> $tour_detail,'lists' => $lists));
    }
       
    function actionSave() {
        $tourID = Request::getVar('tourID',0);
        $this->store();
        YiiMessage::raseSuccess("Tournament save succesfully");
        $this->redirect(Router::buildLink("gamesport", array('view'=>'tournament', "tourID"=>$tourID)));
    }

    // chi co super admin moi sua duoc 1 group
    function store() {
        global $mainframe, $db, $user;
        $post = $_POST;

        $arr_team_table = Request::getVar('arr_team_table',null);
        $arr_team_table = json_decode($arr_team_table, true);
        
        $model = Tournament::getInstance();
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to change Tournament");
            $this->redirect(Router::buildLink("gamesport", array('view'=>'tournament')));
        }

        $tourID = Request::getVar('tourID',0);
        $db = Yii::app()->db;
         
        foreach($arr_team_table as $table_num => $team_tables){
            if(count($team_tables)){
                $stt = 1;
                foreach($team_tables as $teamID => $team){
                    if($team == null) continue;
                    if($team['ordering'] == null OR $team['ordering'] == 0){
                        $team['ordering'] = $stt;
                    }
                    $query = "UPDATE " . TBL_GS_TEAM_REGISTER_TOUR 
                                . " SET table_num = $table_num"
                                    . " ,ordering = ". $team['ordering']
                                    . " ,mdate = now()"
                                    . " ,modified_by = $user->id"
                                . " WHERE tourID = $tourID AND teamID = $teamID"
                            ;
                   $command = $db->createCommand($query);
                  
                   $command->execute();
                   $stt++;
                }
            }
        }
 
        return true;
    }
}
