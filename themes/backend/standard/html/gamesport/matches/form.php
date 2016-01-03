<?php
global $_list_tour_state;
$number_team_pass = $tour_detail->number_teams_de / $tour_detail->number_table;
?>

<div class="form-matches">
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
                                        $teams_table = $lists['arr_team_table'][$i];
                                        $class = $i == 1 ? "in active" : "";
                                        ?>
                                        <div id="tab-round-<?php echo $i; ?>" class="tab-pane fade <?php echo $class; ?>">
                                            <?php
                                            $params['max_round'] = $max_round;
                                            $params['arr_level'] = $arr_level;
                                            $params['max_level'] = $max_level;
                                            $params['table_num'] = $i;
                                            $params['teams_joined'] = $lists['teams_joined'];

                                            $params['matches_info'] = $lists['matches_info'][1][$i];
                                            $params['teams_table'] = $teams_table;
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
        <input type="hidden" name="matches_data_table" id="matches_data_table" value="">
        <input type="hidden" name="task" value="">
        <input type="hidden" name="filter_order_Dir" value="">
    </form>
</div>
<script>
    var number_table = <?php echo $tour_detail->number_table; ?>;
</script>
<div>
    <div class="modal fade" id="show-form-edit-matches" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content detail-matches">
                <div class="modal-header">
                    <button type="button" class="btn-form close" data-dismiss="modal" aria-label="Apply">
                        <i style="color: #d43f3a" class="glyphicon glyphicon-remove-sign"></i>
                    </button>
                    <button type="button" class="btn-form apply-form">
                        <i style="color: #4cae4c" class="glyphicon glyphicon-check"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Match Details</h4>
                </div>

                <div class="modal-body">
                    <div class="matchup">
                        <div class="participant">
                            <div class="contents">
                                <img class="portrait" width="52" height="52" src="//kxcdn.challonge.com/assets/gravatar-abc23b5a7783ffd0211076b4f0146082.png" alt="">
                                <div class="name"> team 1 </div>
                            </div>
                            <div class="footer-team"><span>-</span></div>
                        </div>
                        <div class="versus"> vs </div>
                        <div class="participant">
                            <div class="contents">
                                <img class="portrait" width="52" height="52" src="//kxcdn.challonge.com/assets/gravatar-abc23b5a7783ffd0211076b4f0146082.png" alt="">
                                <div class="name"> team 1 </div>
                            </div>
                            <div class="footer-team"><span>-</span></div>
                        </div>
                    </div>
                </div><div class="clearfix"></div>
                <div class="modal-footer">
                    <div class="overall-score-set">
                        <div class="score">
                            <div class="divider"><h6>Thông tin trận đấu: </h6></div><div class="clearfix"></div>
                            <div class="match-details-end"> 
                                <ul>
                                    <li>Thời gian: </li>
                                    <li>Địa điểm: </li>
                                    <li>Thành viên: </li>
                                </ul>
                            </div>
                        </div><div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>