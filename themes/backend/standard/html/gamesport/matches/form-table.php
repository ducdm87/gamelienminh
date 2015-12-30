<?php
// $max_level so team roi da, vong 1
// $table_type: 1 ; so team dung bang $max_level
              //  2: vượt số team, cần tổ chức vòng 0
              //  0: < số team, se co doi duoc dac cach di tiep
$num_team_table = count($teams_table);
$table_type = 1;
$start_round = 1;
if ($num_team_table > $max_level) {
    $table_type = 2;
    $start_round = 0;
} else if ($num_team_table < $max_level)
    $table_type = 0;
$num_team_round = $num_team_table;
?>
<div class="standings-container">
    <div class="round-tab matches-main-content">
        <div class="overthrow_bracket overthrow">
            <div class="roud-standing-matches">
                <div class="rounds">
                    <table class="table table-striped table-bordered limited_width  border-table cach-top table-col-round">
                        <thead>
                            <tr>
                                <?php for ($j = $start_round; $j <= $max_round; $j++) { ?>
                                    <th><b>Round <?php echo $j ?></b></th>
                                <?php } ?>
                                <th><b style="color:red;">Team pass</b></th>
                            </tr>
                            <tr>
                                <?php
                                $table_style = 1;
                                for ($j = $start_round; $j <= $max_round; $j++) {
                                    $team_pass = $arr_level[$j];
                                    $num_matches = $num_team_round - $team_pass;

                                    echo '<td>';
                                    $params = array();

                                    $params['table_style'] = $table_style;
                                    $params['table_num'] = $table_num;
                                    $params['round_num'] = $j;
                                    $params['num_matches'] = $num_matches;
                                    $params['matches_info'] = $matches_info;
                                    $params['num_team_round'] = $num_team_round;
                                    $params['teams_joined'] = $teams_joined;
                                    if($table_style == 1){
                                        $params['teams_table'] = $teams_table;
                                        echo $this->renderPartial('/html/gamesport/matches/form-table-round-start', $params);
                                    }else{
                                        echo $this->renderPartial('/html/gamesport/matches/form-table-round', $params);
                                    }
                                    echo '</td>';
                                    $table_style++;
                                    $num_team_round = $team_pass;
                                }
                                ?>
                                <td>
                                </td>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>