
<form action="<?php echo Router::buildLink("gamesport", array('view'=>'players')) ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span><b>General</b></span>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <?php echo buildHtml::renderField("text", "name", $item->name, "Name", "form-control title-generate"); ?>
                            <?php echo buildHtml::renderField("text", "alias", $item->alias, "Alias", "form-control alias-generate", "Auto-generate from title"); ?>
                            <?php echo buildHtml::renderField("text", "idCard", $item->idCard, "idCard", "form-control"); ?>
                            <?php echo buildHtml::renderField("text", "mobile", $item->mobile, "Mobile", "form-control"); ?>
                            <?php echo buildHtml::renderField("calander", "birthday", $item->birthday, "Birthday"); ?>
                            <?php echo buildHtml::renderField("text", "address", $item->address, "Address", "form-control"); ?>
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
      <div class="modal-body col-xs-12 no-padding">
        <div class="list-tour-left col-xs-6 no-padding">
            <ul class="nav nav-pills nav-stacked">            
                <?php
                $items_tour = $lists['tournaments'];
                    foreach ($items_tour as $i => $item) {
                        $link_edit = Router::buildLink("gamesport", array('view'=>'tournaments', 'layout' => 'edit', "cid" => $item['id']));
                        $link_items = Router::buildLink('gamesport', array('view'=>'tournaments','filter_cid'=>$item['id'])); 
                        $link_detail = Router::buildLink('gamesport', array('view'=>'tournament', "tourID" => $item['id'])); 
                        ?>
                            <li class="item-tour">
                                <?php echo '<a onClick="show_team_tourteam('.$item['id'].',\''.$item['name'].'\')">'. $item['name'] . '</a>';?>
                            </li>   
                            
                        <?php
                    };
                ?>
            </ul>
        </div>
          <div class="main-show-team col-xs-6 no-padding">
              <ul class="show_list_team"></ul>
          </div>
      </div><div class=" clearfix"></div>
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
            <div class="panel-body" style="overflow-y: auto; height: 200px;">          
                <ul style="list-style: none; margin: 0; padding: 0">
                    <?php
                    $items=$lists['locations'];
                    if (isset($items) && $items) {
                        foreach ($items as $i => $item) {
                            $link_edit = Router::buildLink("locations", array('layout' => 'edit', "cid" => $item['id']));
                            $item['_name'] = str_repeat("&nbsp; &nbsp; &nbsp; &nbsp; ", $item['level'] -  1 ) . " - " . $item['name'];
                            $link_items = Router::buildLink('locations', array('filter_cid'=>$item['id'])); 
                            ?>
                             <li>
                                <?php
                                if ($item['level'] == 0)
                                    echo $item['_name'];
                                else
                                    echo '<a onClick="teamChangeLocation('.$item['id'].',\''.$item['name'].'\')">' . $item['_name'] . '</a>';
                                ?>
                            </li>                                 
                            <?php
                        };
                    } ?>
                </ul>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>      
</div>