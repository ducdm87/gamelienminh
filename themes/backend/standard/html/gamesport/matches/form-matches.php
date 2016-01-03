<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$allow_change;
foreach ($matches_info as $m_id => $matches) {
    $classTeam = "";
    if($matches['teambID'] > 0 and isset($teams_joined[$matches['teambID']])){
        $team_a = $teams_joined[$matches['teamaID']];
        $team_b = $teams_joined[$matches['teambID']];
    }else{
        
        $team_a = array("id"=>"?", "name"=>"Win of M".($matches['subround'] - 1).".". $matches['ordering']);
        $team_b = array("id"=>"?", "name"=>"Win of M".($matches['subround'] - 1).".". ($matches['ordering'] + 1));
        $classTeam = "win-of-mb";
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
                <div class="btn-group" data-toggle="tooltip" data-placement="bottom" title="Edit Matches: <?php echo $m_id ; ?>" data-matches="<?php echo $matches['id']; ?>">
                    <a class="btn btn-link match_identifier btn-edit-matches"  
                       data-toggle="modal" data-target="#show-form-edit-matches"
                       >
                        <?php echo $m_id ; ?>
                        <span class="glyphicon glyphicon-pencil" style="color: #4cae4c"></span>
                    </a>
                </div>
            </div>
        </td>
        <td class="td-content-table">
            <div class="main-item">
                <div class="item-team-bg boder-item-up item-team-a item-team-<?php echo $team_a['id']; ?> <?php echo $classTeam; ?>">
                    <div class="left-ct border-l-top team_id">
                        <?php echo $team_a['id']; ?>
                    </div>
                    <div class="right-ct">
                        <span class="team_name"> <?php echo $team_a['name']; ?> </span>
                    </div>
                </div>
                <?php if($team_a['id'] != $team_b['id'] OR ($team_a['id'] == $team_b['id'] AND $team_a['id'] == "?")){ ?>
                <div class="item-team-bg boder-item-dn item-team-b item-team-<?php echo $team_b['id']; ?> <?php echo $classTeam; ?>">
                    <div class="left-ct border-l-bottom team_id">
                        <?php echo $team_b['id']; ?>
                    </div>
                    <div class="right-ct">
                        <span class="team_name"> <?php echo $team_b['name']; ?> </span>
                    </div>
                </div>
                <?php } ?>
            </div>
        </td>
    </tr>
    <?php
}
?>