
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
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                        </div>                       
                        <?php echo buildHtml::renderField("calander", "cdate", $item->cdate, "Created", null, "", 3, 9); ?>
                        <?php echo buildHtml::renderField("calander", "mdate", $item->mdate, "Modified", null, "", 3, 9); ?>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Location</label>
                            <div class="col-md-9">
                                <span id="location-name"><?php echo $lists['locations'][$item->locationID]['name']; ?></span>
                                <div class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal-change-location">Change Location</div>
                                <input type="hidden" name="locationID" id="location-id" value="<?php echo $item->locationID; ?>" />
                            </div>
                        </div> 
                        <?php
                        if(count($lists['tournaments'])){
                        ?>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Tournament</label>
                                <div class="col-md-9">
                                    <a href=""><?php echo $lists['tournaments'][0]['name']; ?></a>
                                    <div class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal-joined-tour">Joined tour</div>
                                </div>
                            </div>
                        <?php } ?>
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
                        <span><b>Meta data</b></span>
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

<div id="myModal-joined-tour" class="modal fade" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Joined tour</h4>
      </div>
      <div class="modal-body">
            <?php
            var_dump($lists['tournaments']);
            ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>      
</div>

<div id="myModal-change-location" class="modal fade" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change location</h4>
      </div>
      <div class="modal-body">
            <?php
            var_dump($lists['locations']);
            ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>      
</div>