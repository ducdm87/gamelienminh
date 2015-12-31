 
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
                $matches['name'] = "";
                $matches['alias'] = "";
                $matches['tourID'] = Request::getVar('tourID', 0);                
                $matches['teamaID'] = $team_a['id'];
                $matches['teambID'] = $team_b['id'];
                $matches['round'] = 1;
                $matches['group'] = $table_num;
                $matches['subround'] = $round_num;
                $matches['ordering'] = $i;
                $matches_info[] = $matches;
            }
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