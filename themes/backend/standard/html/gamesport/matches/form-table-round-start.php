 
<table  class="table  table-bordered limited_width  no-border table-item-team-cbv table-round-<?php echo $table_style; ?> ">
    <tbody>
        <?php
        $arr_new = array();
            foreach ($matches_info as $matches) { 
                $matches['m_class'] = "M{$matches['subround']}_".$matches['ordering'];
                $arr_new["M".$matches['subround'].".". $matches['ordering']] = $matches;
            }
            $matches_info = $arr_new;
         
        $params['matches_info'] = $matches_info;
        $params['round_num'] = 1;
        $params['teams_joined'] = $teams_joined;
        $params['teams_table'] = $teams_table;
        $params['table_num'] = $table_num;
        echo $this->renderPartial('/html/gamesport/matches/form-matches', $params);
        ?>
    </tbody>
</table> 