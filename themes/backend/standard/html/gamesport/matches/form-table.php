<div class="standings-container">
    <div class="round-tab matches-main-content">
        <div class="overthrow_bracket overthrow">
            <div class="roud-standing-matches">
                <div class="rounds">
                    <table class="table table-striped table-bordered limited_width  border-table cach-top table-col-round">
                        <thead>
                            <tr>
                                <?php for ($j = $start_round; $j <= $max_round; $j++) { ?>
                                    <th>Round <?php echo $j ?></th>
                                <?php } ?>
                                    <th>Team pass</th>
                            </tr>
                            <tr>
                                <?php
                                $table_num = 1;
                                for ($j = $start_round; $j <= $max_round; $j++) {
                                    $team_pass = $arr_level[$j];
                                    $num_matches = $num_team_round - $team_pass;

                                    echo '<td>';
                                    $params = array();
                                    
                                    $params['class_table'] = "table-round-$table_num";
                                    $params['num_matches'] = $num_matches;
                                    echo $this->renderPartial('/html/gamesport/matches/form-table-round', $params);
                                    echo '</td>';
                                    $table_num++;
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