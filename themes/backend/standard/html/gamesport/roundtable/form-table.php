<?php
// $max_level so team roi da, vong 1
// $table_type: 1 ; so team dung bang $max_level
//  2: vượt số team, cần tổ chức vòng 0
//  0: < số team, se co doi duoc dac cach di tiep
$num_team_table = count($teams_table);
$table_type = 1;
$start_round = 1;
$to_round = 1;
if ($num_team_table > $max_level) {
    $table_type = 2;
    $to_round = 1;
    $start_round = 0;
} else if ($num_team_table < $max_level){
    $table_type = 0;
    $start_round = 1;
    $to_round = 2;
}
$num_team_round = $num_team_table;
?>
<div class="standings-container">
    <div class="round-tab matches-main-content">
        <div class="overthrow_bracket overthrow">
            <div class="roud-standing-matches">
                <div class="rounds-table" id="rounds-table-<?php echo $table_num; ?>">
                    <?php
                    echo '<select class="list-team-matches list-team-matches-table-' . $table_num . '">';
                    foreach ($teams_table as $teamID => $team)
                        echo '<option value="' . $teamID . '">' . $team['name'] . '</option>';
                    echo '</select>';
                    ?>
                    <table class="table table-striped table-bordered limited_width  border-table cach-top table-col-round">
                        <thead>
                            <tr>
                                <?php for ($j = $start_round; $j <= 1; $j++) { ?>
                                    <th><b>Round <?php echo $j ?></b></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $before_matches = 0;
                                for ($j = $start_round; $j <= 1; $j++) {
                                    $team_pass = $arr_level[$j];
                                    $num_matches = $num_team_round - $team_pass;
                                    echo '<td>';
                                    $params = array();

                                    $params['table_style'] = $j;
                                    $params['table_num'] = $table_num;
                                    $params['round_num'] = $j;
                                    $params['num_matches'] = $num_matches;
                                    $params['matches_info'] = null;
                                    if (isset($matches_info[$j]))
                                        $params['matches_info'] = $matches_info[$j];
                                    $params['num_team_round'] = $num_team_round;
                                    $params['teams_joined'] = $teams_joined;
                                    $params['teams_table'] = $teams_table;
                                    $params['before_matches'] = $before_matches;
                                    $params['table_type'] = $table_type;
                                    echo $this->renderPartial('/html/gamesport/roundtable/form-table-round-start', $params);
                                    echo '</td>';
                                    $num_team_round = $team_pass;
                                    $before_matches = $num_matches;
                                }
                                ?>
                            </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var number_subround = <?php echo (2 - $start_round); ?>;
</script>