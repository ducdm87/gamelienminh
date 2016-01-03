 
<table  class="table  table-bordered limited_width  no-border table-item-team-cbv table-round-<?php echo $round_num; ?> ">
    <tbody>
        <?php
        if ($matches_info == null) {
            $matches_info = array();            
            $_teams_table = array_values($teams_table);
            for ($i = 0; $i < $num_matches; $i++) {                 
                $matches = array();
                $matches['id'] = 0;
                $matches['name'] = "";
                $matches['alias'] = "";
                $matches['tourID'] = Request::getVar('tourID', 0);
                $matches['round'] = 1;
                $matches['group'] = $table_num;
                $matches['subround'] = $round_num;
                $matches['ordering'] = $i;
                $matches['m_class'] = "M{$round_num}_$i";
                
                $team_a = $_teams_table[$i*2];
                $team_b = $_teams_table[$i*2 + 1];
                if($round_num == 0){
                    $team_a = $_teams_table[$i*3];
                    $team_b = $_teams_table[$i*3 + 1];
                }else if($round_num == 1){
                    if($i<$before_matches){
                        $team_b['id'] = 0;
                        $team_a = $_teams_table[$i*3+2];
                    }else{
                        $team_a = $_teams_table[$before_matches*3 + ($i- $before_matches)*2];
                        $team_b = $_teams_table[$before_matches*3 + ($i- $before_matches)*2 + 1];
                    }
                }
                $matches['teamaID'] = $team_a['id'];
                $matches['teambID'] = $team_b['id'];
                $matches_info["M$round_num.$i"] = $matches;
            }
            if($table_type == 0){
                $matches = array();
                $matches['id'] = 0;
                $matches['name'] = "";
                $matches['alias'] = "";
                $matches['tourID'] = Request::getVar('tourID', 0);
                $matches['round'] = 1;
                $matches['group'] = $table_num;
                $matches['subround'] = $round_num;
                $matches['ordering'] = $num_matches;
                $matches['m_class'] = "M{$round_num}_$num_matches";
                $team_a = $_teams_table[$i*2];
                $matches['teamaID'] = $team_a['id'];
                $matches['teambID'] = $team_a['id'];
                $matches_info["M$round_num.$num_matches"] = $matches;
            }
             
        }else {
            $arr_new = array();
            foreach ($matches_info as $i=>$matches) {
                if($i<$before_matches){
                    $matches['teambID'] = 0;
                }
                $matches['m_class'] = "M{$matches['subround']}_".$matches['ordering'];
                $arr_new["M$round_num.". $matches['ordering']] = $matches;
            }
            $matches_info = $arr_new;
        }
         
        $params['num_matches'] = $num_matches;
        $params['allow_change'] = 1;
        $params['matches_info'] = $matches_info;
        $params['round_num'] = $round_num;
        $params['teams_joined'] = $teams_joined;
        $params['teams_table'] = $teams_table;
        $params['table_num'] = $table_num;
        $params['before_matches'] = $before_matches;
        echo $this->renderPartial('/html/gamesport/roundtable/form-matches', $params);
        ?>
    </tbody>
</table>
<script type="text/javascript">
    var arr_matches_table_<?php echo $round_num; ?> = <?php echo json_encode($matches_info); ?>
</script>