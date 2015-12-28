<?php global $_list_tour_state;
?>
<div class="form-tournament-teamjoin">
    <form action="<?php echo Router::buildLink("gamesport", array('view' => 'tournament')); ?>" method="post" name="adminForm" >
        
        <div class="col-md-6">
            <div class="pannel panel-primary">
                <div class="panel-heading">
                    <span><b>List team by location <span class="badge"><?php echo count($lists['teams_joined']); ?></span></b></span>
                </div>
                <div class="panel-body"> 
                    <?php
                    $list_location = $lists['locations'];
                    $lists_teams_joined = $lists['teams_joined_loc'];
                    $count_selected = 0;
                    echo '<ul class="list-location">';
                    foreach ($list_location as $location) {
                        $location['name'] = str_repeat("&nbsp; &nbsp; &nbsp;", ($location['level'] - 1)) . "+ " . $location['name'];
                        echo '<li>';
                        $str_one_loc = "";
                        $list_teams_joined = null;
                        if (isset($lists_teams_joined[$location['id']])) {
                            $list_teams_joined = $lists_teams_joined[$location['id']];
                            $str_one_loc = '<ul class="list-team">';
                            $_count_selected = 0;
                            foreach ($list_teams_joined as $team) {                                
                                $str_one_loc .= '<li class="data-team data-team-'.$team['id'].' add-team-totable" data-id="'.$team['id'].'">';
                                if($team['table_num'] > 0){
                                        $str_one_loc .= $team['name'] . " (" . $team['id'] . ")";
                                        $str_one_loc .= ' <i class="fa fa-hand-o-right hide"></i>';
                                    
                                    $_count_selected++;
                                    $count_selected ++;
                                }else{
                                    $str_one_loc .= $team['name'] . " (" . $team['id'] . ")";
                                    $str_one_loc .= ' <i class="fa fa-hand-o-right"></i>';
                                }


                                $team['thumbnail'];
                                $str_one_loc .= '</li>';
                            }
                            $str_one_loc .= '</ul>';
                            echo $location['name'] 
                                    .' <span class="badge badge-location">'.$_count_selected.'</span> / '
                                    .' <span class="badge ">'.count($list_teams_joined).'</span>';
                            if($_count_selected == count($list_teams_joined))
                                echo ' <i class="fa fa-hand-o-right fa-2x hide add-teams-totable"></i>';
                            else echo ' <i class="fa fa-hand-o-right fa-2x add-teams-totable"></i>';; 
                            echo $str_one_loc;
                        } else {
                            echo $location['name'];
                        }
                        echo '</li>';
                    }
                    echo '</ul>';
                    ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="pannel panel-info">
                <div class="panel-heading">
                    <span><b>List team in table</b> <span class="badge badge-total-table"><?php echo $count_selected ; ?></span></span>
                </div>
                <div class="panel-body"> 
                    <?php
                    $number_table = $tour_detail->number_table;
                    ?>
                    <div>
                        <ul class="nav nav-tabs">
                            <?php
                            for ($i = 1; $i <= $number_table; $i++) {
                                $lass = " ";
                                if($i == 1) $lass="active ";
                                $key_table = $i;
                                $list_team = $lists['arr_team_table'][$key_table];
                                echo '<li class="tab-head '.$lass.' tab-head-'.$i.'" data-table="'.$i.'"><a data-toggle="tab" href="#tab-table-'.$i.'"><b>Table '.chr(64+$i).'</b>  <span class="badge">'.count($list_team).'</span></a></li>';
                            }
                            ?>
                        </ul>
                        <div class="tab-content">
                             <?php
                            for ($i = 1; $i <= $number_table; $i++) {
                                $lass = " ";
                                if($i == 1) $lass = " in active ";                            
                                echo '<div id="tab-table-'.$i.'" class="tab-pane fade '.$lass.'">';                            
                                    $key_table = $i;
                                    $list_team = $lists['arr_team_table'][$key_table];
                                    echo '<div class="col-md-12 list-team-in-table">';
                                        foreach($list_team as $team){
                                            echo '<div class="col-md-6 data-team-'.$team['id'].'">';
                                                echo $team['name'] ."- ". $team['id'];
                                                echo ' <a class="remove-team-table btn btn-default btn-xs" data-id="'.$team['id'].'" data-table="'.$key_table.'">'
                                                        . '<i class="fa fa-remove"></i>'
                                                     . '</a>';
                                            echo '</div>';
                                        }
                                    echo '</div>';
                                    echo '<div class="clr"></div> <hr />';
                                    echo '<a class="remove-team-tables btn btn-default" data-table="'.$key_table.'">'
                                            . '<i class="fa fa-remove fa-2x"> Reset Table</i>'
                                        . '</a>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var arr_team_table = <?php echo json_encode($lists['arr_team_table']); ?>;
        </script>
        <input type="hidden" name="boxchecked" value="0">
        <input type="hidden" name="filter_order" value="">
        <input type="hidden" name="page" id="page" value="<?php echo Request::getVar('page', 1); ?>">    
        <input type="hidden" name="limit" value="<?php echo Request::getVar('limit', 15); ?>">
        <input type="hidden" name="filter_cid" id="filter_cid" value="<?php echo Request::getVar('filter_cid', ''); ?>">
        <input type="hidden" name="task" value="">
        <input type="hidden" name="filter_order_Dir" value="">
    </form>
</div>