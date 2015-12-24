<?php

class HomeController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{menus}}";
    var $tbl_menuitem = "{{menu_item}}";
    var $item = null;
    var $item2 = null;
    var $items = array();

    function init() {
        parent::init();
    }
    /*
     * For menu type
     */
    public function actionDisplay() {
        global $mainframe, $user;        
         $this->addBarTitle("Game sport <small>[manager]</small>", "user"); 
//         setSysConfig("sidebar.display", 0);
        $this->render('default');
    } 
    
}
