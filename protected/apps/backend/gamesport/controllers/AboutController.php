<?php

class AboutController extends BackEndController {

    var $primary = 'id';

    function init() {
        parent::init();
    }
    /*
     * For menu type
     */
    public function actionDisplay() {
        global $mainframe, $user;        
         $this->addBarTitle("About <small>[Game sport manager]</small>", "user"); 
        $this->render('default');
    } 
    
}
