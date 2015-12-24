
<form action="<?php echo Router::buildLink("gamesport", array('view'=>'tournaments')) ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span><b>General</b></span>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <?php echo buildHtml::renderField("text", "name", $item->name, "name", "form-control title-generate"); ?>
                            <?php echo buildHtml::renderField("text", "alias", $item->alias, "Alias", "form-control alias-generate", "Auto-generate from title"); ?>
                            <div class="form-group row">
                                <label class="control-label left col-md-2">Parent Item</label>
                                <div class="col-md-10"><?php echo $lists['parentID']; ?></div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label left col-md-2">Ordering</label>
                                <div class="col-md-10"><?php echo $lists['ordering']; ?></div>
                            </div>
                            <?php echo buildHtml::renderField('textarea', "introtext", $item->introtext, "Description"); ?>
                            <?php echo buildHtml::renderField('editor', "fulltext", $item->fulltext, "Content"); ?>
                        </div> 
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-info"> 
                    <div class="panel-heading">
                        <span><b>More info</b></span>
                    </div>      
                    <div class="panel-body">                                    
                        <div class="form-group row">
                            <label class="control-label left col-md-3">Status</label>
                            <div class="col-md-9"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                        </div>
                        <?php echo buildHtml::renderField("calander", "startDate", $item->startDate, "Start Date", null, "", 3, 9); ?>
                        <?php echo buildHtml::renderField("calander", "endDate", $item->endDate, "End Date", null, "", 3, 9); ?>                                                                        
                        <?php echo buildHtml::renderField("calander", "cdate", $item->cdate, "Created", null, "", 3, 9); ?>
                        <?php echo buildHtml::renderField("calander", "mdate", $item->mdate, "Modified", null, "", 3, 9); ?>
                    </div>
               </div>
                            
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span><b>Seo info</b></span>
                    </div>
                    <div class="panel-body">
                        <?php echo buildHtml::renderField('textarea',"metakey", $item->metakey, "Meta Key",null, "", 3, 9); ?>
                        <?php echo buildHtml::renderField('textarea',"metadesc", $item->metadesc, "Meta Desc",null, "", 3, 9); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $item->id; ?>">    
</form> 