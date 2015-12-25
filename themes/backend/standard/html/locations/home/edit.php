
<form action="<?php echo Router::buildLink("locations") ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="panel panel-primary">             
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="panel">                         
                        <div class="panel-body">
                            <?php echo buildHtml::renderField("text", "name", $item->name, "Name", "form-control title-generate"); ?>
                            <?php echo buildHtml::renderField("text", "alias", $item->alias, "Alias", "form-control alias-generate", "Auto-generate from title"); ?>
                            <div class="form-group row">
                                <label class="control-label left col-md-2">Status</label>
                                <div class="col-md-10"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="control-label left col-md-2">Parent Item</label>
                                <div class="col-md-10"><?php echo $lists['parentID']; ?></div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label left col-md-2">Ordering</label>
                                <div class="col-md-10"><?php echo $lists['ordering']; ?></div>
                            </div>                           
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $item->id; ?>">    
</form> 