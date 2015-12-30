<?php
global $_list_tour_state;

$number_team_pass = $tour_detail->number_teams_de / $tour_detail->number_table;

?>

<div class="form-tournament-teamjoin">
    <form action="<?php echo Router::buildLink("gamesport", array('view' => 'tournament')); ?>" method="post" name="adminForm" >
        <div class="col-md-12">
            <div class="pannel panel-info">
                <div class="panel-body">  
                    <div>
                        <div>
                            <label class="control-label">Teams in DE:</label> <?php echo $tour_detail->number_teams_de; ?>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="tab-head active"><a data-toggle="tab" href="#tab-round"><b>Vòng Bảng</b></a></li>
                            <li class="tab-head"><a data-toggle="tab" href="#tab-round-de"><b>Vòng DE</b></a></li>
                            <li class="tab-head"><a data-toggle="tab" href="#tab-round-finish"><b>Vòng Chung Kết</b></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-round" class="tab-pane fade in active">
                                <ul class="nav nav-tabs">
                                    <?php
                                    for ($i = 1; $i <= $tour_detail->number_table; $i++) {
                                        $class = $i == 1 ? "active" : "";
                                        echo '<li class="tab-head ' . $class . '"><a data-toggle="tab" href="#tab-round-' . $i . '"><b>Bảng ' . chr(64 + $i) . '</b></a></li>';
                                    }
                                    ?>
                                </ul>
                                <div class="tab-content">
                                    <?php
                                    $arr_level = array();
                                    $max_round = 1;
                                    for ($j = 0; $j <= $tour_detail->number_team_table; $j++) {
                                        $val = $number_team_pass * pow(2, $j);
                                        if ($val > $tour_detail->number_team_table)
                                            break;
                                        $arr_level[] = $val;
                                        $max_round = $j;
                                    }
                                    $max_level = $arr_level[$max_round];
                                    $arr_level = array_reverse($arr_level);

                                    for ($i = 1; $i <= $tour_detail->number_table; $i++) {
                                        $team_table = $lists['arr_team_table'][$i];
                                        $class = $i == 1 ? "in active" : "";
                                        $num_team_table = count($team_table);
                                        ?>
                                        <div id="tab-round-<?php echo $i; ?>" class="tab-pane fade <?php echo $class; ?>">
                                            <?php
                                            $table_type = 1;
                                            if($num_team_table > $max_level){
                                                $table_type = 2;                                               
                                            }
                                            else if($num_team_table < $max_level) $table_type = 0;
                                            $start_round = $table_type == 2?0:1;
                                            $num_team_round = $num_team_table;                              
                                            $params = array("start_round"=>$start_round);
                                            $params['max_round'] = $max_round;
                                            $params['arr_level'] = $arr_level;
                                            $params['num_team_round'] = $num_team_round;
                                            
                                            echo $this->renderPartial('/html/gamesport/matches/form-table', $params);
                                            
                                            ?>
                                        </div>
                                    <?php }
                                    ?> 
                                </div>
                            </div>

                            <div id="tab-round-de" class="tab-pane fade"> noi dung 2 vong DE </div>
                            <div id="tab-round-finish" class="tab-pane fade"> noi dung 3 vong chung ket </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="tourID" value="<?php echo Request::getVar('tourID', 0); ?>">
        <input type="hidden" name="task" value="">
        <input type="hidden" name="filter_order_Dir" value="">
    </form>
</div>
