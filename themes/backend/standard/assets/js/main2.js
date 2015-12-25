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

