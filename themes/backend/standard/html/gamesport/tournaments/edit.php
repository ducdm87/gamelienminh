<?php
global $_list_tour_state, $_list_num_table, $_list_num_teams_DE;
?>
<form action="<?php echo Router::buildLink("gamesport", array('view' => 'tournaments')) ?>" method="post" name="adminForm" >
    <div class="row form-custom-css">
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
                                <label class="control-label col-md-2">Estimated</label>

                                <label class="control-label col-md-2" title="Estimated number of table">Table</label>
                                <div class="col-md-3"><?php echo buildHtml::select($_list_num_table, $item->number_table, "number_table"); ?></div>

                                <label class="control-label col-md-2" title="Number of teams in round DE">Teams in DE</label>
                                <div class="col-md-3"><?php echo buildHtml::select($_list_num_teams_DE, $item->number_teams_de, "number_teams_de"); ?></div>
                            </div>                            
                            <div class="form-group row">
                                <label class="control-label left col-md-2">Number teams</label>
                                <div class="col-md-10">
                                    <input placeholder="Maximum number of teams" type="text" name="number_teams" class="field-short" value="<?php echo $item->number_teams; ?>">
                                    <div class="goiy-sodoi">
                                        Số đội phải đảm bảo = (2^n) X "Teams in DE". <br />
                                        VD: 1 X 32 = 32 || 2 X 32 = 64 || 4 X 32 =128 || 8 X 32 = 256 || 16 X 32 = 512 v.v...
                                    </div>
                                </div>
                            </div>

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
                        <?php echo buildHtml::renderField("label", "ID", $item->id, "ID", null, "", 3, 9); ?>                        
                        <div class="form-group row">
                            <label class="control-label left col-md-3">Status</label>
                            <div class="col-md-9"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                        </div>
                        <?php echo buildHtml::renderField("calander", "startDate", $item->startDate, "Start Date", null, "", 3, 9); ?>
                        <?php echo buildHtml::renderField("calander", "endDate", $item->endDate, "End Date", null, "", 3, 9); ?>                                                                        
                        <?php echo buildHtml::renderField("calander", "cdate", $item->cdate, "Created", null, "", 3, 9); ?>
                        <?php echo buildHtml::renderField("label", "mdate", $item->mdate, "Modified",null, "",3,9); ?>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span><b>Image</b></span>
                        <div class="caption pull-right">
                            <a href="javascript:void(0)" class="label label-success" role="button" onclick="BrowseServer();">Add Thumbnail</a>
                        </div>
                    </div>
                    <div class="panel-body"> 
                        <div class="form-group row">
                            <input type="text" name="thumbnail" id="image_hiden" class="form-control" value="<?php echo $item->thumbnail ?>"/>

                        </div>
                        <div class="form-group row">
                            <div class="drapzon">
                                <div class="col-md-6 row container-thumbnail">
                                    <div class="thumbnail" style="height: 200px;">
                                        <a target="_blank" href="<?php echo $item->thumbnail ?>" alt="">
                                            <img src="<?php echo $item->thumbnail ?>" alt="" id="image_src" style="height:190px;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span><b>Seo info</b></span>
                    </div>
                    <div class="panel-body">
                        <?php echo buildHtml::renderField('textarea', "metakey", $item->metakey, "Meta Key", null, "", 3, 9); ?>
                        <?php echo buildHtml::renderField('textarea', "metadesc", $item->metadesc, "Meta Desc", null, "", 3, 9); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $item->id; ?>">    
</form> 