/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
//    maxDate: 'today'
    $( ".datepicker").datepicker({ dateFormat: 'yy-mm-dd', onSelect: function(datetext){
        var d = new Date(); // for now
        datetext=datetext+" "+d.getHours()+": "+d.getMinutes()+": "+d.getSeconds();
        $(this).val(datetext);
    },});
});

$(function(){
    //    arr_team_table
    // xoa 1 team ra khoi table
    $( ".remove-team-table").click(function(){
        var table_id, team_id, badge;
        table_id = $(this).attr('data-table');
        team_id = $(this).attr('data-id');
        GS_TOUR_remove_team_table(team_id, table_id);
    });
    // xoa toan bo team ra khoi table
    $( ".remove-team-tables").click(function(){
        var data_table, data_id, badge;
        data_table = $(this).attr('data-table');        
        for(team_id in arr_team_table[data_table])
            GS_TOUR_remove_team_table(team_id, data_table);
    });
    
    // them 1 team vao table
    $( ".add-team-totable").click(function(){
        if($(this).find('.fa-hand-o-right').hasClass('hide')) return;
        var table_id, team_id, badge;
        team_id = $(this).attr('data-id');
        table_id = $(".nav-tabs .tab-head.active").attr('data-table');
        GS_TOUR_add_team_table(team_id, table_id)
    });
    
    // them toan bo team cua 1 location vao table
    $( ".add-teams-totable").click(function(){
        
    });
});

function GS_TOUR_remove_team_table(team_id, table_id)
{
    // xoa khoi mang trong js
        arr_team_table[0][team_id] = arr_team_table[table_id][team_id];
        delete arr_team_table[table_id][team_id];
        // xoa hien thi trong table
        $("#tab-table-"+table_id+" .data-team-"+team_id).remove();
        // badge cua panel table (List team in table)
        badge = Object.keys(arr_team_table[table_id]).length;
        $(".nav-tabs .tab-head-"+table_id +" .badge").html(badge);
        badge = 0;
        for(team_table in arr_team_table){
            if(team_table == 0) continue;
            badge = badge + Object.keys(arr_team_table[team_table]).length;
        }
        $(".badge-total-table").html(badge);
        
        // hien thi tro lai location
        $(".list-location .data-team-"+team_id +" .fa-hand-o-right").removeClass("hide");
        // hien thi bieu tuong cho parent
        $(".list-location .data-team-"+team_id).parent().parent().find(".add-teams-totable").removeClass('hide');
        var length = $(".list-location .data-team-"+team_id).parent().find(".fa-hand-o-right.hide").length;
        $(".list-location .data-team-"+team_id).parent().parent().find(".badge-location").html(length);
}

function GS_TOUR_add_team_table(team_id, table_id)
{
    // them vao mang trong js
        arr_team_table[table_id][team_id] = arr_team_table[0][team_id];        
        delete arr_team_table[0][team_id];
        
        // hien thi trong table        
        $("#tab-table-"+table_id+" .data-team-"+team_id).remove();
        
        // badge cua panel table (List team in table)
        badge = Object.keys(arr_team_table[table_id]).length;
        $(".nav-tabs .tab-head-"+table_id +" .badge").html(badge);
        badge = 0;
        for(team_table in arr_team_table){
            if(team_table == 0) continue;
            badge = badge + Object.keys(arr_team_table[team_table]).length;
        }
        $(".badge-total-table").html(badge);
        
        // an khoi location
        $(".list-location .data-team-"+team_id +" .fa-hand-o-right").addClass("hide");
        // kiem tra va an bieu tuong cho parent        
        var length = $(".list-location .data-team-"+team_id).parent().find(".fa-hand-o-right.hide").length;
        var length2 = $(".list-location .data-team-"+team_id).parent().find(".fa-hand-o-right").length;
        $(".list-location .data-team-"+team_id).parent().parent().find(".badge-location").html(length);
        if(length == length2){
            $(".list-location .data-team-"+team_id).parent().parent().find(".add-teams-totable").addClass('hide');
        }
}

