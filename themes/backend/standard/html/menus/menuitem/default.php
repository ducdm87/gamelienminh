<form action="<?php echo Router::buildLink('menus', array("view" => "menuitem")) ?>" method="post" name="adminForm" >
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
                        <?php echo $lists['filrer_menu']; ?>
                    </div>
                </div>
                <br/>            
                <table class="table table-bordered table-hover table-striped ">
                    <thead>
                        <tr>
                            <th width="2%"># </th>
                            <th width="3%">
                                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $items ? count($items) : 0; ?>);"> 
                            </th>
                            <th>Name</th>    
                            <th width="2%">level</th>    
                            <th width="5%" align="center">Status</th>
                            <th width="20%">Type</th>
                            <th width="15%">Modified</th>
                            <th width="4%">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($items) && $items): ?>                                
                            <?php
                            foreach ($items as $i => $item):
                                $link_edit = Router::buildLink('menus', array("view" => "menuitem", "layout" => 'edit', 'menu' => $item['menuID'], 'cid' => $item['id']));
                                $item['title'] = str_repeat(" &nbsp; &nbsp; &nbsp; ", $item['level'] -1 ) . " - " . $item['title'];
                                $item['params'] = json_decode($item['params']);
                                ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>                                        
                                    <td>
                                        <input id="cb<?php echo $i; ?>" type="checkbox" name="cid[]" value="<?php echo $item["id"]; ?>" onclick="isChecked(this.checked);">                                            
                                    </td>
                                    <td><a href="<?php echo $link_edit; ?>"><?php echo $item['title']; ?></a></td>                                        
                                    <td align="center"><?php echo $item['level']; ?></td>                                        

                                    <td align="center"><?php echo buildHtml::status($i, $item['status']); ?></td>
                                    <td>
                                        <?php
                                        if ($item['type'] == "app") {
                                            echo $item['app'] . " » " . $item['params']->view;
                                        } else {
                                            echo $item['type'];
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo date("H:i d/m/Y", strtotime($item['mdate'])); ?></td>
                                    <td><?php echo $item['id']; ?></td>
                                </tr>                                    
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <h3 class="text-center">Not menu item dispplay</h3>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">                
                <?php echo $pagination; ?>
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