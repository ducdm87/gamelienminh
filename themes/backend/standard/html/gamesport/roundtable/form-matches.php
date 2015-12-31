<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$allow_change;
foreach ($matches_info as $m_id => $matches) {
     
    $team_a = $teams_joined[$matches['teamaID']];
    $team_b = $teams_joined[$matches['teambID']];
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
            <div class="main-item">
                <div class="item-team-bg boder-item-up item-team-a item-team-<?php echo $team_a['id']; ?>">
                    <div class="left-ct border-l-top team_id">
                        <?php echo $team_a['id']; ?>
                    </div>
                    <div class="right-ct">
                        <span class="team_name"> <?php echo $team_a['name']; ?> </span>
                        <i data-matche="<?php echo $matches['m_class']; ?>" 
                           data-matche-id="<?php echo $m_id; ?>" 
                           data-table="<?php echo $table_num; ?>" 
                           data-team="item-team-a" data-teamID="<?php echo $team_a['id']; ?>" 
                           class="fa fa-caret-down btn-change-team"></i>
                    </div>
                </div>
                <div class="item-team-bg boder-item-dn item-team-b item-team-<?php echo $team_b['id']; ?>">
                    <div class="left-ct border-l-bottom team_id">
                        <?php echo $team_b['id']; ?>
                    </div>
                    <div class="right-ct">
                        <span class="team_name"> <?php echo $team_b['name']; ?> </span>
                        <i data-matche="<?php echo $matches['m_class']; ?>"
                           data-matche-id="<?php echo $m_id; ?>" 
                           data-table="<?php echo $table_num; ?>" 
                           data-team="item-team-b" data-teamID="<?php echo $team_b['id']; ?>"
                           class="fa fa-caret-down btn-change-team"></i>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php
}

?>