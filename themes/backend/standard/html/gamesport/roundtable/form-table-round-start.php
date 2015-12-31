 
<table  class="table  table-bordered limited_width  no-border table-item-team-cbv table-round-<?php echo $table_style; ?> ">
    <tbody>
        <?php
        if ($matches_info == null) {
            $matches_info = array();            
            $_teams_table = array_values($teams_table);
            for ($i = 0; $i < $num_matches; $i++) {                 
                $team_a = $_teams_table[$i*2];
                $team_b = $_teams_table[$i*2 + 1];
                $matches = array();
                $matches['id'] = 0;
                $matches['name'] = "";
                $matches['alias'] = "";
                $matches['tourID'] = Request::getVar('tourID', 0);                
                $matches['teamaID'] = $team_a['id'];
                $matches['teambID'] = $team_b['id'];
                $matches['round'] = 1;
                $matches['group'] = $table_num;
                $matches['subround'] = $round_num;
                $matches['ordering'] = $i;
                $matches['m_class'] = "M{$table_num}_$i";
                $matches_info["M$table_num.$i"] = $matches;
            }
        }else {
            $arr_new = array();
            foreach ($matches_info as $matches) { 
                $matches['m_class'] = "M{$matches['group']}_".$matches['ordering'];
                $arr_new["M$table_num.". $matches['ordering']] = $matches;
            }
            $matches_info = $arr_new;
        }
         
        $params['num_matches'] = $num_matches;
        $params['allow_change'] = 1;
        $params['matches_info'] = $matches_info;
        $params['round_num'] = 1;
        $params['teams_joined'] = $teams_joined;
        $params['teams_table'] = $teams_table;
        $params['table_num'] = $table_num;
        echo $this->renderPartial('/html/gamesport/matches/form-matches', $params);
        ?>
    </tbody>
</table>
<script type="text/javascript">
    var arr_matches_table_<?php echo $table_num; ?> = <?php echo json_encode($matches_info); ?>
</script>