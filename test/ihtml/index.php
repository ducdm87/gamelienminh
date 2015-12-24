<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="description" content=""><meta name="author" content="">
    <title>HTML GS 1</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Add custom CSS here -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/icon.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- JavaScript -->
    <script src="js/jquery-1.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script src="js/main.js"></script>
    <script src="js/imagePreview.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery_002.js"></script>

    <script src="js/ckfinder.js" type="text/javascript"></script>

    <script src="js/sb-admin.js"></script>

    <!-- Page Specific Plugins -->    
    <script src="js/jquery.js"></script>
    <script src="js/tables.js"></script>
</head><!--head-->
<body>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Back end</a>
            </div><!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                            <i class="fa fa-dashboard"></i> System<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="">
                                <a href="#"> <i class="fa fa-folder"></i> Dashboard</a>
                            </li>                         <li class="">
                                <a href="#"> <i class="fa fa-folder"></i> Config</a>
                            </li>                    
                        </ul>
                    </li> 

                    <li class="">
                        <a href="#"> <i class="fa fa-folder"></i> Users</a>
                    </li>  
                    <li class="active current">
                        <a href="#"> <i class="fa fa-file fa-spin"></i> Menus</a>
                    </li>                  

                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                            <i class="fa fa-caret-square-o-down"></i> Applications 
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="">
                                <a href="#"> <i class="fa fa-folder"></i> Categories</a>
                            </li>                         <li class="">
                                <a href="#"> <i class="fa fa-file"></i> Articles</a>
                            </li>                         <li class="">
                                <a href="#"> <i class="fa fa-film"></i> Videos</a>
                            </li>                     
                        </ul>
                    </li> 

                    <li class="">
                        <a href="#"> <i class="fa fa-folder"></i> Modules</a>
                    </li>                 <li class="">
                        <a href="#"> <i class="fa fa-folder"></i> Themes</a>
                    </li>                                     <li class="dropdown ">            
                        <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                            <i class="fa fa-caret-square-o-down"></i> Installer 
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="">
                                <a href="#"> <i class="fa fa-folder"></i> Install</a>
                            </li>                                 <li class="">
                                <a href="#"> <i class="fa fa-folder"></i> Manager</a>
                            </li>                             
                        </ul> 
                    </li>                    

                </ul>

                <ul class="nav navbar-nav navbar-right navbar-user">
                    <li>
                        <a href="#" class="dropdown-toggle" target="_blank"> Time server: 03:00:41 23/12/2015 </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle" target="_blank"> Visit site</a>
                    </li>
                    <li class="dropdown messages-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages <span class="badge">7</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">7 New Messages</li>
                            <li class="message-preview">
                                <a href="#">
                                    <span class="avatar"><img src="images/50x50.htm"></span>
                                    <span class="name">John Smith:</span>
                                    <span class="message">Hey there, I wanted to ask you something...</span>
                                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                                </a>
                            </li>                               
                            <li class="divider"></li>
                            <li><a href="#">View Inbox <span class="badge">7</span></a></li>
                        </ul>                
                    </li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> admin <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>                
                            <li class="divider"></li>                    
                            <li><a href="#"> <i class="fa fa-power-off"></i> Logout</a></li>                
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav><!--Sidebar top left-->
        <div id="page-wrapper">
            <div id="toolbar-box">
                <div class="t"><div class="t"><div class="t"></div></div> </div>
                <div class="m">
                    <div id="toolbar" class="toolbar">
                        <table class="toolbar"><tbody>
                                <tr>
                                    <td id="toolbar-new" class="button">
                                        <a class="toolbar" onclick="javascript:submitbutton('/backend/?app=menus&amp;view=menutype&amp;layout=new', '1')" href="#">
                                            <span title="Creat" class="icon-32-new">
                                            </span>
                                            Creat
                                        </a>
                                    </td> <td id="toolbar-edit" class="button">
                                        <a class="toolbar" onclick="javascript:if (document.adminForm.boxchecked.value == 0) {
                                                    alert('Please select a item from the list to edit');
                                                } else {
                                                    submitbutton('/backend/?app=menus&amp;view=menutype&amp;layout=edit', '1')
                                                }" href="#">
                                            <span title="Edit" class="icon-32-edit">
                                            </span>
                                            Edit
                                        </a>
                                    </td> <td id="toolbar-publish" class="button">
                                        <a class="toolbar" onclick="javascript:submitbutton('/backend/?app=menus&amp;view=menutype&amp;layout=publish', '1')" href="#">
                                            <span title="Publish" class="icon-32-publish">
                                            </span>
                                            Publish
                                        </a>
                                    </td> <td id="toolbar-unpublish" class="button">
                                        <a class="toolbar" onclick="javascript:submitbutton('/backend/?app=menus&amp;view=menutype&amp;layout=unpublish', '1')" href="#">
                                            <span title="Unpublish" class="icon-32-unpublish">
                                            </span>
                                            Unpublish
                                        </a>
                                    </td> <td id="toolbar-trash" class="button">
                                        <a class="toolbar" onclick="javascript:if (document.adminForm.boxchecked.value == 0) {
                                                    alert('Please select a item from the list to Remove');
                                                } else {
                                                    submitbutton('/backend/?app=menus&amp;view=menutype&amp;layout=remove', '1')
                                                }" href="#">
                                            <span title="Delete" class="icon-32-trash">
                                            </span>
                                            Delete
                                        </a>
                                    </td>                        </tr>
                            </tbody></table>
                    </div>
                    <div class="header icon-48-user"> Menu type <small>[manager]</small> </div>                    <div class="clr"></div>
                </div>
                <div class="b"><div class="b"> <div class="b"></div> </div> </div>
            </div><!--menu tool content-->
            
            
            
            
            <div id="main-content-backend" class="full-screen-target">
                <div class="main-tab">
                    <ul class="season-level-tab group-nav ">
                        <li class="group-name"><span>Giải đấu</span></li>
                        <li>
                            <a href="#group_A_vong_bang" data-toggle="tab">Giải đấu vòng bảng</a>
                        </li>
                        <li>
                            <a href="#group_A_1_32" data-toggle="tab">Giải đấu 1/32</a>
                        </li>
                        <li class="active">
                            <a href="#group_A_chung_ket" data-toggle="tab">Giải đấu Chung kết</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="group_A_vong_bang" class="tab-pane group-standings-pane active">
                            <div class="standings-container">
                                <div class="table-round-tab cach-top">
                                    <ul class="season-level-tab group-nav ">
                                        <li class="group-name"><span>Vòng bảng</span></li>
                                        <?php for($i=1;$i<=8;$i++){?>
                                        <li>
                                            <a href="#group_<?php echo $i?>" data-toggle="tab">Bảng <?php echo $i?></a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                    <div class="tab-content">
                                        <?php for($i=1;$i<=8;$i++){?>
                                        <div id="group_<?php echo $i?>" class="group-bang tab-pane" data-group_index="0">
                                            <div class="standings-container">
                                                <div class="standings-matches-tab cach-top">
                                                     <ul class="season-level-tab group-nav ">
                                                        <li class="group-name"><span>Bảng <?php echo $i?></span></li>
                                                        <li>
                                                            <a href="#group_standings<?php echo $i?>" data-toggle="tab">Standings</a>
                                                        </li>
                                                        <li>
                                                            <a href="#group_matches<?php echo $i?>" data-toggle="tab">Matches</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div id="group_standings<?php echo $i?>" class="group-matches-pane tab-pane" data-group_index="0">
                                                            <div class="standings-container">
                                                                <div class="round-tab standings-main-content">
                                                                    <div class="standings-container">
                                                                        <table class="table table-striped table-bordered limited_width standings border-table cach-top">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Rank</th>
                                                                                <th>Participant Name</th>
                                                                                <th>Challonge User</th>
                                                                                <th>Match History</th>
                                                                            </tr>
                                                                         </thead>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td rowspan="32">1</td>
                                                                                <td>Team 1</td>
                                                                                <td>-</td>
                                                                                <td>Team 2</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Team 1</td>
                                                                                <td>-</td>
                                                                                <td>Team 2</td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="group_matches<?php echo $i?>" class="group-matches-pane tab-pane" data-group_index="0">
                                                            <div class="standings-container">
                                                                <div class="round-tab matches-main-content">
                                                                    <div class="overthrow_bracket overthrow">
                                                                        <div class="roud-standing-matches">
                                                                            <div id="rounds-cKU3lt3ffl" class="rounds">
                                                                                <table class="table table-striped table-bordered limited_width  border-table cach-top table-col-round">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <?php for($j=1;$j<=6;$j++){?>
                                                                                            <th>Round <?php echo $j ?></th>
                                                                                            <?php }?>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                            <table  class="table  table-bordered limited_width  no-border table-item-team-cbv">
                                                                                                <tbody>
                                                                                                <?php for($it=1;$it<=8;$it++){?>
                                                                                                    <tr>
                                                                                                        <td class="td-head-end-table">
                                                                                                            <div class="head-item-team">
                                                                                                                <div class="dropdown">
                                                                                                                    <a class="btn btn-link match_identifier dropdown-toggle" data-toggle="dropdown">
                                                                                                                        <?php echo $it ?>
                                                                                                                        <b class="caret"></b>
                                                                                                                    </a>
                                                                                                                    <ul class="dropdown-menu">
                                                                                                                        <li>
                                                                                                                        <a href="#" data-toggle="modal" data-href="#">Match Details</a>
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
                                                                                                    
                                                                                                <?php }?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                                
                                                                                            </td>
                                                                                            <td>
                                                                                                <table  class="table  table-bordered limited_width  no-border table-item-team-cbv table-round-2 ">
                                                                                                <tbody>
                                                                                                <?php for($it2=1;$it2<=4;$it2++){?>
                                                                                                    
                                                                                                    <tr>
                                                                                                        <td class="td-boder-lk">
                                                                                                            <div class="end-item-tem"><div class="boder-gom"></div></div>
                                                                                                            <div class="ke-ngang-end"></div>
                                                                                                        </td>
                                                                                                        <td class="td-head-end-table">
                                                                                                            <div class="head-item-team">
                                                                                                                <div class="btn-group">
                                                                                                                    <a class="btn btn-link match_identifier dropdown-toggle" data-toggle="dropdown">
                                                                                                                        <?php echo $it2 ?>
                                                                                                                        <span class="caret"></span>
                                                                                                                    </a>
                                                                                                                    <ul class="dropdown-menu enabled">
                                                                                                                        <li>
                                                                                                                        <a href="#" data-toggle="modal" data-href="#">Match Details</a>
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
                                                                                                <?php }?>
                                                                                                </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td>
                                                                                                <table  class="table  table-bordered limited_width  no-border table-item-team-cbv table-round-3">
                                                                                                <tbody>
                                                                                                <?php for($it2=1;$it2<=2;$it2++){?>
                                                                                                    
                                                                                                    <tr>
                                                                                                        <td class="td-boder-lk td-boder-lk-3">
                                                                                                            <div class="end-item-tem"><div class="boder-gom"></div></div>
                                                                                                            <div class="ke-ngang-end"></div>
                                                                                                        </td>
                                                                                                        <td class="td-head-end-table">
                                                                                                            <div class="head-item-team">
                                                                                                                <div class="btn-group">
                                                                                                                    <a class="btn btn-link match_identifier dropdown-toggle" data-toggle="dropdown">
                                                                                                                        <?php echo $it2 ?>
                                                                                                                        <span class="caret"></span>
                                                                                                                    </a>
                                                                                                                    <ul class="dropdown-menu enabled">
                                                                                                                        <li>
                                                                                                                        <a href="#" data-toggle="modal" data-href="#">Match Details</a>
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
                                                                                                <?php }?>
                                                                                                </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td>
                                                                                                <table  class="table  table-bordered limited_width  no-border table-item-team-cbv table-round-4">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class="td-boder-lk td-boder-lk-4">
                                                                                                            <div class="end-item-tem"><div class="boder-gom"></div></div>
                                                                                                            <div class="ke-ngang-end"></div>
                                                                                                        </td>
                                                                                                        <td class="td-head-end-table">
                                                                                                            <div class="head-item-team">
                                                                                                                <div class="btn-group">
                                                                                                                    <a class="btn btn-link match_identifier dropdown-toggle" data-toggle="dropdown">
                                                                                                                        <?php echo $it2 ?>
                                                                                                                        <span class="caret"></span>
                                                                                                                    </a>
                                                                                                                    <ul class="dropdown-menu enabled">
                                                                                                                        <li>
                                                                                                                        <a href="#" data-toggle="modal" data-href="#">Match Details</a>
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
                                                                                                </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td colspan="2"></td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                </table>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div><!--end vòng bảng-->
                        <div id="group_A_1_32" class="group-matches-pane tab-pane" data-group_index="0">
                            <div class="standings-container">
                                group_A_1_32
                            </div>
                        </div>
                        <div id="group_A_chung_ket" class="group-matches-pane tab-pane" data-group_index="0">
                            <div class="standings-container">
                                group_A_chung_ket
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--main-content-CBV-->
            
            
            
            
        </div><!--page-wrapper -CBV-->
    </div><!--end wapper-->
</body>
</html>