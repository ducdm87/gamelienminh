/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function() {
//    maxDate: 'today'
    $(".datepicker").datepicker({dateFormat: 'yy-mm-dd', onSelect: function(datetext) {
            var d = new Date(); // for now
            datetext = datetext + " " + d.getHours() + ": " + d.getMinutes() + ": " + d.getSeconds();
            $(this).val(datetext);
        }, });
});

$(function() {
    //    arr_team_table
    // xoa 1 team ra khoi table
    $(document).delegate(".remove-team-table", "click", function() {
        var table_id, team_id, badge;
        table_id = $(this).attr('data-table');
        team_id = $(this).attr('data-id');
        GS_TOUR_remove_team_table(team_id, table_id);
    });
    // xoa toan bo team ra khoi table
    $(document).delegate(".remove-team-tables", "click", function() {
        var table_id, team_id, badge;
        table_id = $(this).attr('data-table');
        for (team_id in arr_team_table[table_id])
            GS_TOUR_remove_team_table(team_id, table_id);
    });

    // them 1 team vao table
    $(document).delegate(".add-team-totable", "click", function() {
        if ($(this).find('.fa-hand-o-right').hasClass('hide'))
            return;
        var table_id, team_id, badge;
        team_id = $(this).attr('data-id');
        table_id = $(".nav-tabs .tab-head.active").attr('data-table');
        GS_TOUR_add_team_table(team_id, table_id)
    });

    // them toan bo team cua 1 location vao table
    $(document).delegate(".add-teams-totable", "click", function() {
        var i, parent, list, table_id, team_id;
        parent = $(this).parent();
        list = $(parent).find('.list-team .data-team');
        table_id = $(".nav-tabs .tab-head.active").attr('data-table');
        console.log(list.length);
        for (i = 0; i < list.length; i++) {
            if ($(list[i]).find('.fa-hand-o-right').hasClass('hide'))
                continue;
            team_id = $(list[i]).attr('data-id');
            GS_TOUR_add_team_table(team_id, table_id);
            console.log(team_id);
        }
    });
});

function GS_TOUR_remove_team_table(team_id, table_id)
{
    // xoa khoi mang trong js
    arr_team_table[0][team_id] = arr_team_table[table_id][team_id];
    delete arr_team_table[table_id][team_id];
    // xoa hien thi trong table
    $("#tab-table-" + table_id + " .data-team-" + team_id).remove();
    // badge cua panel table (List team in table)
    badge = Object.keys(arr_team_table[table_id]).length;
    $(".nav-tabs .tab-head-" + table_id + " .badge").html(badge);
    badge = 0;
    for (team_table in arr_team_table) {
        if (team_table == 0)
            continue;
        badge = badge + Object.keys(arr_team_table[team_table]).length;
    }
    $(".badge-total-table").html(badge);

    // hien thi tro lai location
    $(".list-location .data-team-" + team_id + " .fa-hand-o-right").removeClass("hide");
    // hien thi bieu tuong cho parent
    $(".list-location .data-team-" + team_id).parent().parent().find(".add-teams-totable").removeClass('hide');
    var length = $(".list-location .data-team-" + team_id).parent().find(".fa-hand-o-right.hide").length;
    $(".list-location .data-team-" + team_id).parent().parent().find(".badge-location").html(length);
    processOrderTable(table_id);
}

function GS_TOUR_add_team_table(team_id, table_id)
{
    // them vao mang trong js
    arr_team_table[table_id][team_id] = arr_team_table[0][team_id];
    delete arr_team_table[0][team_id];

    // hien thi trong table        
    $("#tab-table-" + table_id + " .list-team-in-table .data-team-" + team_id).remove();
    var obj_team = arr_team_table[table_id][team_id];
    if (obj_team == undefined) {
        return;
    }
    var html_obj_team = $('<div />',
            {html: '<i class="fa fa-arrows-alt icon-move"> </i> ',
                class: 'ui-state-default item-team data-team-' + team_id
            });
    html_obj_team.appendTo("#tab-table-" + table_id + " .list-team-in-table");
    $('<a />', {'data-table': table_id, 'data-id': team_id,
        class: 'remove-team-table btn btn-default btn-xs btn-remove-item',
        html: ' <i class="fa fa-remove icon-remove"></i> '
    }).appendTo(html_obj_team);

    $("<span />", {text: " " + obj_team['name']}).appendTo(html_obj_team);

    // badge cua panel table (List team in table)
    badge = Object.keys(arr_team_table[table_id]).length;
    $(".nav-tabs .tab-head-" + table_id + " .badge").html(badge);
    badge = 0;
    for (team_table in arr_team_table) {
        if (team_table == 0)
            continue;
        badge = badge + Object.keys(arr_team_table[team_table]).length;
    }
    $(".badge-total-table").html(badge);

    // an khoi location
    $(".list-location .data-team-" + team_id + " .fa-hand-o-right").addClass("hide");

    // kiem tra va an bieu tuong cho parent        
    var parent = $(".list-location .data-team-" + team_id).parent();
    var length = $(parent).find(".fa-hand-o-right.hide").length;
    var length2 = $(parent).find(".fa-hand-o-right").length;
    $(parent).parent().find(".badge-location").html(length);
    if (length == length2) {
        $(parent).parent().find(".add-teams-totable").addClass('hide');
    }
    processOrderTable(table_id);
}


$(function() {
    $(".sortable").sortable({
        update: function(event, ui) {
            var table_id;
            table_id = $(".nav-tabs .tab-head.active").attr('data-table');
            processOrderTable(table_id);
        }
    });


    // $( ".sortable" ).disableSelection();
});

function processOrderTable(table_id)
{
    var items, i, team_id;
    items = $("#tab-table-" + table_id + " .item-team");
    for (i = 0; i < items.length; i++) {
        team_id = $(items[i]).find(".remove-team-table").attr('data-id');
        arr_team_table[table_id][team_id]['ordering'] = i + 1;
    }
    $("#arr_team_table").val(JSON.stringify(arr_team_table));
}


// thay doi team cho vong bang, round 0,1
$(function() {
    $(".btn-change-team").click(function(event) {
        data_match = $(this).attr('data-matche');
        data_matchID = $(this).attr('data-matche-id');
        data_table = $(this).attr('data-table');
        data_team = $(this).attr('data-team');
        data_teamID = $(this).attr('data-teamid');        
        var round_offset = $(".rounds-table").offset();

        console.log(event.pageX, event.pageY);
        console.log(round_offset);

        pos_left = event.pageX - round_offset.left - (162 - 10);
        pos_top = event.pageY - round_offset.top - 10;

        $(".list-team-matches-table-" + data_table).show();
        $(".list-team-matches-table-" + data_table).val(data_teamID);
        $(".list-team-matches-table-" + data_table).attr({'data-matche': data_match, 'data-matche-id':data_matchID,
                    'data-table': data_table, 'data-team': data_team,'cur-team':data_teamID});
        $(".list-team-matches-table-" + data_table).css({top: pos_top + "px", left: pos_left + "px"});
    });

    $(document).delegate(".list-team-matches", "change", function() {
        data_match = $(this).attr('data-matche');
        data_matchID = $(this).attr('data-matche-id');
        data_table = $(this).attr('data-table');
        data_team = $(this).attr('data-team');
        data_oldTeamID = $(this).attr('cur-team');
        data_teamID = $(this).val();
        data_team_name = $(this).find("option:selected").text();
         
         // xoa text, name cua cai khac bi thay the
        $(".item-team-"+data_teamID +" .team_id").text('');
        $(".item-team-"+data_teamID +" .team_name").text('');
        
        $(".item-team-"+data_teamID).removeClass("item-team-"+data_teamID);
         
        
       var parent =  $("#rounds-table-"+data_table +" ."+data_match+" .main-item");
       $(parent).find("."+data_team).addClass("item-team-"+data_teamID);
       $(parent).find("."+data_team).removeClass("item-team-"+data_oldTeamID);
       $(parent).find("."+data_team+" .team_id").text(data_teamID);
       $(parent).find("."+data_team+" .team_name").html(data_team_name);
       $(parent).find("."+data_team+" .btn-change-team").attr("data-teamID", data_teamID);
       $(".list-team-matches-table-" + data_table).attr({ 'cur-team':data_teamID});
       var arr_name = "arr_matches_table_"+data_table;
       var arr_ = window[arr_name];
       if(data_team == "item-team-a")
            arr_[data_matchID]['teamaID'] = data_teamID;
        else 
            arr_[data_matchID]['teambID'] = data_teamID;
       initmatches_data_table();
    });
    initmatches_data_table();

});

function initmatches_data_table()
{
    var data = [];
    for(var i=1;i<=number_table;i++){
        arr_name = "arr_matches_table_"+i;
        arr_ = window[arr_name];
        data[i] = arr_;
    }    
    $("#matches_data_table").val(JSON.stringify(data));
}

