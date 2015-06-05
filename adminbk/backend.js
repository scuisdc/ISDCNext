/// <reference path="typings/jquery/jquery.d.ts"/>

$('.ib-nav-list a').click(function (e) {
	e.preventDefault();
	$(this).tab('show');
});
$('td a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});
$(function () {
	//$('.ib-nav-list a:first').tab('show');
});
$('a#tab-member').click(function (e) {
    e.preventDefault();
    var data = $(this).attr('data');
    var label = new Array();
    /*var userlabel = $('#user-label');
     var sulabel = $('su-label');
     var cmslabel = $('cms-label');
     var bloglabel = $('blog-label');
     var ojlabel = $('oj-label');
     var ctflabel = $('ctf-label');
     var missionlabel = $('mission-label');
     var publiclabel = $('public-label');*/
    label[0] = $('div#user-label label input');
    label[1] = $('div#su-label label input');
    label[2] = $('div#cms-label label input');
    label[3] = $('div#blog-label label input');
    label[4] = $('div#oj-label label input');
    label[5] = $('div#ctf-label label input');
    label[6] = $('div#mission-label label input');
    label[7] = $('div#public-label label input');
    var i = 0;
    while (data){
        if (data % 2){
            label[i].attr('checked', 'checked');
        }
        data /= data;
        i++;
    }
    $(this).tab('show');
});
$('a#back-member').click(function (e) {
    e.preventDefault();
    var data = $(this).attr('data');
    var label = new Array();
    label[0] = $('div#user-label label input');
    label[1] = $('div#su-label label input');
    label[2] = $('div#cms-label label input');
    label[3] = $('div#blog-label label input');
    label[4] = $('div#oj-label label input');
    label[5] = $('div#ctf-label label input');
    label[6] = $('div#mission-label label input');
    label[7] = $('div#public-label label input');
    var i = 0;
    $(label).each(function (i,val){
        val.removeAttr('checked');
    });
    $(this).tab('show');
});

$('a#save-member').click(function (e) {
    e.preventDefault();
    var data = 0;
    var usrid = $('#user-privilege-usrid').html();
    var label = new Array();
    label[0] = $('div#user-label label input');
    label[1] = $('div#su-label label input');
    label[2] = $('div#cms-label label input');
    label[3] = $('div#blog-label label input');
    label[4] = $('div#oj-label label input');
    label[5] = $('div#ctf-label label input');
    label[6] = $('div#mission-label label input');
    label[7] = $('div#public-label label input');
    var i = 0;
    $(label).each(function (i,val){
        if (val.attr('checked')!=undefined){
            data += 1;
        }
        data *= 2;
    });
    $.post('./chmod.php',
        {
            privilege: data,
            usr: usrid
        },
        function(data,status){
            alert("Data: " + data + "\nStatus: " + status);
        });
    $(this).tab('show');
});