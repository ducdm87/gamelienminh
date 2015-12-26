<?php global $_list_tour_state; 
 var_dump($tour_detail);

?>
<form action="<?php echo Router::buildLink("gamesport", array('view'=>'tournament')); ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="panel">            
            <div class="panel-body"> 
                 
            </div>
        </div>
        <div class="panel-footer">                
            
        </div>
    </div>

    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="filter_order" value="">
    <input type="hidden" name="page" id="page" value="<?php echo Request::getVar('page',1); ?>">    
    <input type="hidden" name="limit" value="<?php echo Request::getVar('limit',15); ?>">
    <input type="hidden" name="filter_cid" id="filter_cid" value="<?php echo Request::getVar('filter_cid',''); ?>">
    <input type="hidden" name="task" value="">
    <input type="hidden" name="filter_order_Dir" value="">
</form>