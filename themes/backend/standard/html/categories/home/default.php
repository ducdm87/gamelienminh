 
<form name="adminForm" method="post" action="<?php echo Router::buildLink("categories"); ?>">   

    <div class="row">
        <div class="panel">            
            <div class="panel-body">
                <div class="row">  
                    <div class="col-lg-7">
                        <input type="text" name="filter_search" value="<?php echo Request::getVar('filter_search', ""); ?>" id="filter_search"  onchange="document.adminForm.submit();" /> 
                        <button type="submit" class="btn btn-primary btn-xs">Go</button>
                        <button type="reset" class="btn btn-primary btn-xs" onClick="$('#filter_search').val('');
                                $('#page').val(1);
                                $('#filter_cid').val('');
                                this.form.submit();" >Reset</button>
                    </div>
                    <div class="col-lg-5"> </div>
                </div>
                <br/>            
                <table class="adminlist" cellpadding="1">
                    <thead>
                        <tr>
                            <th width="2%" class="title"> #	</th>
                            <th width="3%" class="title"> <input type="checkbox" onclick="checkAll(<?php echo count($items); ?>);" value="" name="toggle"> </th>
                            <th class="title"> <a>Name</a></th>
                            <th class="title" width="3%"> <a>Status</a></th>
                            <th class="title" width="7%"> <a>Feature</a></th>                                
                            <th class="title" width="12%"> <a>Scope</a></th>                                
                            <th class="title"  width="5%"> <a>ID</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $k = 0;
                        foreach ($items as $i => $item) {
                            $link_edit = Router::buildLink("categories", array('layout' => 'edit', 'cid' => $item['id']));
                            ?>
                            <tr class="row1">
                                <td><?php echo ($i + 1); ?></td>
                                <td align="center"><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $item['id'] ?>" name="cid[]" id="cb<?php echo ($i); ?>"></td>
                                <td><a href="<?php echo $link_edit; ?>"><?php echo $item['name']; ?></a></td>                     
                                <td align="center"><?php echo buildHtml::status($i, $item['status']); ?></td>
                                <td align="center"><?php echo buildHtml::changState($i, $item['feature'], "feature."); ?></td>
                                <td align="center">
                                    <?php echo isset($lists['scopes'][$item['scope']]) ? $lists['scopes'][$item['scope']] : ""; ?>
                                </td>                    
                                <td align="center"><?php echo $item['id'] ?></td>
                            </tr>
                            <?php
                            $k = 1 - $k;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">                
                <?php echo $pagination; ?>
            </div>
        </div>        
    </div>

    <input type="hidden" value="0" name="boxchecked">
    <input type="hidden" value="" name="filter_order">
    <input type="hidden" value="" name="filter_order_Dir">
    <input type="hidden" value="" name="task" />
    <input type="hidden" name="page" id="page" value="<?php echo Request::getVar('page', 1); ?>">    
    <input type="hidden" name="limit" value="<?php echo Request::getVar('limit', 15); ?>">
</form>




