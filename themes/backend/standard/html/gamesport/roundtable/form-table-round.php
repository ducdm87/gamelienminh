 
<table  class="table  table-bordered limited_width  no-border table-item-team-cbv table-round-<?php echo $table_style; ?> ">
    <tbody>
        <?php
        if ($matches_info != null) {
            for ($k = 1; $k <= $num_matches; $k++) {
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
                                    <?php echo $k ?>
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
                            <div class="item-team-bg boder-item-up">
                                <div class="left-ct border-l-top">
                                    1
                                </div>
                                <div class="right-ct">
                                    Team 1
                                </div>
                            </div>
                            <div class="item-team-bg boder-item-dn">
                                <div class="left-ct border-l-bottom">
                                    3
                                </div>
                                <div class="right-ct">
                                    Team 3
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php
            }
        }
        ?>
    </tbody>
</table>