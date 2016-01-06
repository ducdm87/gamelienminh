 

<form action="<?php echo Router::buildLink('modules') ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="panel">            
            <div class="panel-body">
                <div class="row">  
                    <div class="col-lg-7">
                        <input type="text" name="filter_search" value="<?php echo Request::getVar('filter_search', ""); ?>" id="filter_search" /> 
                        <button type="submit" class="btn btn-primary btn-xs">Go</button>
                        <button type="reset" class="btn btn-primary btn-xs" onClick="document.getElementById('filter_search').value = '';
                                this.form.submit();" >Reset</button>
                    </div>
                    <div class="col-lg-5">
                        <?php echo $lists['filrer_posittion']; ?>
                    </div>
                </div>
                <br/>            
                <table class="adminlist" cellpadding="1">
                    <thead>
                        <tr>
                            <th width="2%" class="title"> #	</th>
                            <th width="3%" class="title"> <input type="checkbox" onclick="checkAll(<?php echo count($items); ?>);" value="" name="toggle"> </th>
                            <th class="title"> <a>Name</a></th>
                            <th class="title" width="3%"> <a>Status</a></th>
                            <th class="title" width="10%"> <a>Position</a></th>                
                            <th class="title" width="10%"> <a>Type</a></th>                
                            <th class="title" width="10%"> <a>Pages</a></th>
                            <th class="title"  width="3%"> <a>ID</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $k = 0;
                        foreach ($items as $i => $item) {
                            $link_edit = Router::buildLink("modules", array("layout" => "edit", 'cid' => $item['id']));
                            ?>
                            <tr class="row1">
                                <td><?php echo ($i + 1); ?></td>
                                <td><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $item['id'] ?>" name="cid[]" id="cb<?php echo ($i); ?>"></td>
                                <td><a href="<?php echo $link_edit; ?>"><?php echo $item['title']; ?></a></td>
                                <td><?php echo buildHtml::status($i, $item['status']); ?></td>
                                <td><?php echo $item['position']; ?></td>
                                <td><?php echo $item['module'] ?></td>
                                <td><?php echo ucfirst($item['menu']); ?> pages</td>
                                <td><?php echo $item['id'] ?></td>
                            </tr>
                            <?php
                            $k = 1 - $k;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">                
                <?php //echo $pagination; ?>
            </div>
        </div>
    </div>

    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="filter_order" value="">
    <input type="hidden" name="limitstart" value="">    
    <input type="hidden" name="task" value="">
    <input type="hidden" name="filter_order_Dir" value="">
    <input type="hidden" name="page" id="page" value="<?php echo Request::getVar('page', 1); ?>">    
    <input type="hidden" name="limit" value="<?php echo Request::getVar('limit', 15); ?>">
</form>




