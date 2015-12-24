<?php

class HomeController extends BackEndController {

    var $tablename = '';
    var $primary = 'id';

    function init() {
        $this->tablename = TBL_LOCATIONS;
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
            YiiMessage::raseSuccess("Successfully saved changes status for location(s)");
        }


        $this->addIconToolbar("Edit", Router::buildLink("locations", array("layout" => "edit")), "edit", 1, 1, "Please select a item from the list to edit");
        $this->addIconToolbar("New", Router::buildLink("locations", array("layout" => "new")), "new");
//        $this->addIconToolbarDelete();
        $this->addIconToolbar("Delete", Router::buildLink("locations", array("layout" => "remove")), "trash", 1, 1, "Please select a item from the list to Remove");
         $this->addBarTitle("Locations <small>[manager]</small>", "locations"); 

        $model = Location::getInstance();
        $items = $model->getItems();
        $pagination = $model->getPagination();

        $this->render('default', array('items' => $items,'pagination'=>$pagination));
    }
    
    public function actionNew() {
        $this->actionEdit();
    }

    // chi co super admin moi sua duoc 1 group
    public function actionEdit() {
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit location");
            $this->redirect(Router::buildLink("locations"));
        }

        setSysConfig("sidebar.display", 0);

        $this->addIconToolbar("Save", Router::buildLink("locations", array("layout" => "save")), "save");
        $this->addIconToolbar("Apply", Router::buildLink("locations", array("layout" => "apply")), "apply");
        $items = array();

        $cid = Request::getVar("cid", 0);

        if (is_array($cid))
            $cid = $cid[0];

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", Router::buildLink("locations", array("layout" => "cancel")), "cancel");
            $this->addBarTitle("Location <small>[New]</small>", "user");
            $this->pageTitle = "New location";
        } else {
            $this->addIconToolbar("Close", Router::buildLink("locations", array("layout" => "cancel")), "cancel");
            $this->addBarTitle("Location <small>[Edit]</small>", "user");
            $this->pageTitle = "Edit location";
        }

        $model = Location::getInstance();
        $item = $model->getItem();
        $lists = $model->getListEdit($item);
        $this->render('edit', array("item" => $item, "lists" => $lists));
    }

     function actionCancel() {
        $this->redirect(Router::buildLink("locations"));
    }
    
    function actionApply() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Location save succesfully");
        $this->redirect(Router::buildLink("locations", array("layout" => "edit", 'cid' => $cid)));
    }

    function actionSave() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Location save succesfully");
        $this->redirect(Router::buildLink("locations"));
    }

    // chi co super admin moi sua duoc 1 group
    function store() {
        global $mainframe, $db, $user;
        $post = $_POST;

        $model = Location::getInstance();
        global $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit Location");
            $this->redirect(Router::buildLink("locations"));
        }

        $id = Request::getVar("id", 0);

        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);
        $obj_tblLocation->load($id);        
        $obj_tblLocation->_ordering = isset($post['ordering']) ? $post['ordering'] : null;
        $obj_tblLocation->_old_parent = $obj_tblLocation->parentID;

        $obj_tblLocation->bind($post);
        $obj_tblLocation->store(); 

        return $obj_tblLocation->id;
    }
    
    function changeStatus($cid, $value) {
        global $user;
        $obj_tblLocation = YiiTables::getInstance(TBL_LOCATIONS);
        $obj_tblLocation->load($cid); 
        $obj_tblLocation->status = $value;
        $obj_tblLocation->store();
    }
    
     // chi co super admin moi duoc xoa group
    function actionRemove() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission remove location");
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
        YiiMessage::raseSuccess("Successfully remove location(s)");
        $this->redirect(Router::buildLink('locations'));
    } 
}
