<div class="">
    <form action="<?php echo Router::buildLink("categories", array('layout'=>'save')) ?>" method="post" name="adminForm">
        <input type="hidden" name="id"  value="<?php echo $item->id; ?>"/>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span>Detail</span>
                </div>
                <div class="panel-body">
                    <?php echo buildHtml::renderField("text", "name", $item->name, "name", "form-control title-generate"); ?>
                    <?php echo buildHtml::renderField("text", "alias", $item->alias, "Alias", "form-control alias-generate", "Auto-generate from title"); ?>
                    
                    <div class="form-group row">
                        <label class="control-label left col-md-2">Feature</label>                        
                        <div class="col-md-10">
                            <select name="feature" class="">
                                <option value="1" <?php if ($item->feature == 1) echo 'selected=""'; ?> > On</option>
                                <option value="0" <?php if ($item->feature == 0) echo 'selected=""'; ?>> Off</option>                            
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="control-label left col-md-2">Scope</label>
                        <div class="col-md-10">
                           <?php echo $lists['scopes']; ?>
                        </div>
                    </div>
                    
                    <?php echo buildHtml::renderField('textarea', "description", $item->description, "Description"); ?>                       
                </div>
            </div>

        </div> 

        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <span><b>More info</b></span>
                </div>
                <div class="panel-body">                    
                    <?php echo buildHtml::renderField("calander", "cdate", $item->cdate, "Created",null, "",3,9); ?>
                    <?php echo buildHtml::renderField("label", "mdate", $item->mdate, "Modified",null, "",3,9); ?>
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Status</label>
                        <div class="col-md-9"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-info">
                <div class="panel-heading">
                    <span>Meta data</span>
                </div>
                <div class="panel-body">
                    <?php echo buildHtml::renderField('textarea', "metakey", $item->metakey, "Meta Key"); ?> 
                    <?php echo buildHtml::renderField('textarea', "metadesc", $item->metadesc, "Meta Desc"); ?> 
                </div> 
            </div> 
        </div> 
    </form>
</div>

<script>
    $(".selection-menu-select").change(function() {
        changeSelectMenu();
    });

    function changeSelectMenu() {
        var val = $(".selection-menu-select").val();
        var opts = $("#selection-menu").find("option");
        if (val == "all") {
//            $("#selection-menu").attr("disabled", true);
            $(".row-menu-select").hide();
        } else if (val == "none") {
//            $("#selection-menu").attr("disabled", true);            
            $(".row-menu-select").hide();
        } else {
//            $("#selection-menu").attr("disabled", false);
            $(".row-menu-select").show();
            $(".row-menu-select").removeClass("hide");
        }
    }
    changeSelectMenu();
</script>