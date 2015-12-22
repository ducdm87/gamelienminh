<?php

class ManagerController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{menus}}";
    var $tbl_menuitem = "{{menu_item}}";
    var $item = null;
    var $item2 = null;
    var $items = array();
    
    private $model;
    private $request;

    function init() {        
        
         
        parent::init();
    }
    /*
     * For menu type
     */
    public function actionDisplay() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to manager extension");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $task = Request::getVar('task', "");
        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeState($cid, 1);
                else if ($task == "hidden")
                    $this->changeState($cid, 2);
                else
                    $this->changeState($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for extention");
        }else if ($task == "allowall.on" OR $task == "allowall.off") {
            $cids = Request::getVar('cid');
            
            $type = "On";
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "allowall.on"){
                    $this->changeState($cid, 1, "allowall");
                }
                else{
                    $type = "Off";
                    $this->changeState($cid, 0, "allowall");
                }
            }
            YiiMessage::raseSuccess("Successfully saved changes extention for allowall: $type");
        }else if($task == "delete"){
            $this->deleteExt();
        }
 
        $obj_ext = YiiExtensions::getInstance();
        $extension = $obj_ext->loadExts();

        $this->addIconToolbarDelete("Uninstall",'Uninstall');
        $this->addBarTitle("Extension Manager <small>[Manage]</small>", "user");

        $this->render('default', array("extentions" => $extension));
    }

    function changeState($cid, $value, $name = "status") {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify extension");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $obj_ext = YiiExtensions::getInstance();
        $obj_tblExt = $obj_ext->loadExt($cid);
        $obj_tblExt->$name = $value;
        $obj_tblExt->store();
    }
    
    function deleteExt()
    {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify extension");
            $this->redirect(Router::buildLink("cpanel"));
        }
        $cid = Request::getVar('cid');
        //$cid = 1;
        $obj_ext = YiiExtensions::getInstance();
        $obj_tblExt = $obj_ext->loadExt($cid);
        if($obj_tblExt->required == 1){
            YiiMessage::raseNotice("System is require extention: $obj_tblExt->name");
            $this->redirect(Router::buildLink("installer", array('view'=>'manager')));
        }
        
        //neu ma app: kiem tra menu co dang su dung ext nay khong thi unpublish di
        if($obj_tblExt->type == "app"){
            Yii::app()->db->createCommand()->update(TBL_MENU_ITEM, array('status'=>0),  'app = \''. $obj_tblExt->folder.'\'');
        }
        //neu ma module: kiem tra co module nao duoc tao ra khong thi unpublish di
        if($obj_tblExt->type == "module"){
//            $obj_module = YiiModule::getInstance();
//            $items = $obj_module->loadItems(null, 'module = \''. $obj_tblExt->folder.'\'');
            Yii::app()->db->createCommand()->update(TBL_MODULES, array('status'=>0),  'module = \''. $obj_tblExt->folder.'\'');
        }        
        //neu ma theme: thi kiem tra xem co dang la theme default khong
    }
}
