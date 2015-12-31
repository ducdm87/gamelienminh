<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$allow_change;
for ($k = 0; $k < $num_matches; $k++) {
    $matches = $matches_info[$k];    
    $team_a = $teams_joined[$matches['teamaID']];
    $team_b = $teams_joined[$matches['teambID']];
    ?>
    <tr>
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
                        <?php echo "M$round_num.$k"; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu enabled">
                        <li>
                            <a href="#" data-toggle="modal" data-target="#myModal1">Match Details</a>
                        </li>
                    </ul>
                </div>
            </div>
        </td>
        <td class="td-content-table">
            <div class="main-item" id="<?php echo "M$round_num.$k"; ?>">
                <div class="item-team-bg boder-item-up item-team-a">
                    <div class="left-ct border-l-top">
                        <?php echo $team_a['id']; ?>
                    </div>
                    <div class="right-ct"><?php echo $team_a['name']; ?> 
                        <i data-matche="<?php echo "M$round_num.$k"; ?>" 
                           data-table="<?php echo $table_num; ?>" 
                           data-team="item-team-a" 
                           class="fa fa-caret-down btn-change-team"></i>
                    </div>
                </div>
                <div class="item-team-bg boder-item-dn item-team-b">
                    <div class="left-ct border-l-bottom">
                        <?php echo $team_b['id']; ?>
                    </div>
                    <div class="right-ct"><?php echo $team_b['name']; ?> 
                        <i data-matche="<?php echo "M$round_num.$k"; ?>" 
                           data-table="<?php echo $table_num; ?>" 
                           data-team="item-team-b" 
                           class="fa fa-caret-down btn-change-team"></i>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php
}

?>