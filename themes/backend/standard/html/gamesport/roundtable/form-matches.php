<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$allow_change;
foreach ($matches_info as $m_id => $matches) {
    $team_a = $teams_joined[$matches['teamaID']];
    $classTeamB = "";
    if($matches['teambID'] != 0 and isset($teams_joined[$matches['teambID']]))
        $team_b = $teams_joined[$matches['teambID']];
    else{
        $team_b = array("id"=>"?", "name"=>"Win of M0.". $matches['ordering']);
        $classTeamB = "win-of-mb";
    }
    
    
    ?>
    <tr class="<?php echo $matches['m_class']; ?>">
        <td class="td-boder-lk">
            <div class="matche-head">
                <div class="end-item-tem"><div class="boder-gom"></div></div>
                <div class="ke-ngang-end"></div>
            </div>
        </td>
        <td class="td-head-end-table">
            <div class="head-item-team">
                <div class="btn-group">
                    <a class="btn btn-link match_identifier dropdown-toggle" data-toggle="dropdown">
                        <?php echo $m_id; ?>
                    </a>
                </div>
            </div>
        </td>
        <td class="td-content-table">
            <div class="main-item">
                <div class="item-team-bg boder-item-up item-team-a item-team-<?php echo $team_a['id']; ?>">
                    <div class="left-ct border-l-top team_id">
                        <?php echo $team_a['id']; ?>
                    </div>
                    <div class="right-ct">
                        <span class="team_name"> <?php echo $team_a['name']; ?> </span>
                        <i data-matche="<?php echo $matches['m_class']; ?>" 
                           data-matche-id="<?php echo $m_id; ?>" 
                           data-subround="<?php echo $round_num; ?>" 
                           data-team="item-team-a" data-teamID="<?php echo $team_a['id']; ?>" 
                           class="fa fa-caret-down btn-change-team"></i>
                    </div>
                </div>
                <?php if($team_a['id'] != $team_b['id']){ ?>
                <div class="item-team-bg boder-item-dn item-team-b item-team-<?php echo $team_b['id']; ?> <?php echo $classTeamB; ?>">
                    <div class="left-ct border-l-bottom team_id">
                        <?php echo $team_b['id']; ?>
                    </div>
                    <div class="right-ct">
                        <span class="team_name"> <?php echo $team_b['name']; ?> </span>
                        <?php
                        if($classTeamB == ""){
                        ?>
                        <i data-matche="<?php echo $matches['m_class']; ?>"
                           data-matche-id="<?php echo $m_id; ?>" 
                           data-subround="<?php echo $round_num; ?>" 
                           data-team="item-team-b" data-teamID="<?php echo $team_b['id']; ?>"
                           class="fa fa-caret-down btn-change-team"></i>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </td>
    </tr>
    <?php
}

?>