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
	$('.ib-nav-list a:first').tab('show');
});
$('a.tab-member').click(function (e) {
    e.preventDefault();
    var usrid = this.parentNode.parentNode.firstChild;
    var usrname = usrid.nextSibling;
    $('#user-privilege-usrid').html(usrid.innerHTML);
    $('#user-privilege-usrname').html(usrname.innerHTML);
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
        console.log(data, i, label[i]);
        if (data % 2){
            label[i].attr('checked', 'checked');
        }
        else{
            label[i].attr('checked', '');
        }
        data = (data-data%2)/2;
        i++;
    }
    $(this).tab('show');
});
$('a.back-member').click(function (e) {
    e.preventDefault();
    var usrid = $('#user-privilege-usrid').html();
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
$('a.save-member').click(function (e) {
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
    $(label).each(function (i,val){
        console.log(val);
        if (val.attr('checked') == 'checked'){
            data += 1;
            console.log(i+":"+data);
        }
        data *= 2;
        console.log(i+":"+data);

    });
    data /= 2;
    console.log(data);
    $.post('./chmod.php',
        {
            privilege: data,
            usr: usrid
        },
        function(data,status){
            alert("Data: " + data + "\nStatus: " + status);
        }
    );
    $(label).each(function (i,val){
        val.removeAttr('checked');
    });
    console.log(data);
    console.log(usrid);
    $(this).tab('show');
});
$('a.del-member').click(function (e) {
    e.preventDefault();
    var usrid = $('#user-privilege-usrid').html();
    $.post('./rmusr.php',
        {
            usr: usrid
        },
        function(data,status){
            alert("Data: " + data + "\nStatus: " + status);
        }
    );
    console.log(usrid);
    $(this).tab('show');
});
$('div.checkbox label input').on('click', function (e){
    console.log($(this).attr('checked'));
    if ($(this).attr('checked')=='checked'){
        $(this).removeAttr('checked');
    }
    else{
        $(this).attr('checked','checked');
    }
});
$('a.service-enable').on('click', function (e){
    var val = $(this).attr('value');
    var able = $(this).html();
    var v = $(this);
    console.log(able);
    $.post('./chmodservice.php',
        {
            service: val,
            able: able
        },
        function(data,status){
            v.html(data);
        }
    );
});
$('a.bls-enable').on('click', function (e){
    var val = $(this).attr('value');
    var able = $(this).html();
    var v = $(this);
    console.log(able);

    $.post('./chmodart.php',
        {
            article: val,
            able: able
        },
        function(data,status){
            v.html(data);
        }
    );
});
$('a.blc-enable').on('click', function (e){
    var val = $(this).attr('value');
    var able = $(this).html();
    var v = $(this);
    console.log(able);

    $.post('./chmodartcom.php',
        {
            article: val,
            able: able
        },
        function(data,status){
            v.html(data);
        }
    );
});
$('a.comment-enable').on('click', function (e){
    var val = $(this).attr('value');
    var able = $(this).html();
    var v = $(this);
    console.log(able);

    $.post('./chmodcom.php',
        {
            comment: val,
            able: able
        },
        function(data,status){
            v.html(data);
        }
    );
});
$('a.comment-delete').on('click', function (e){
    var val = $(this).attr('value');
    var v = $(this);
    $.post('./rmcomment.php',
        {
            comment: val
        },
        function(data,status){
            v.parents('tr').remove();
        }
    );
});
$('a.article-delete').on('click', function (e){
    var val = $(this).attr('value');
    var v = $(this);
    $.post('./rmarticle.php',
        {
            article: val
        },
        function(data,status){
            v.parents('tr').remove();
        }
    );
});

$('a.p-auto').on('click', function (e){
    var val = $(this).attr('value');
    var able = $(this).html();
    var v = $(this);
    console.log(able);

    $.post('./chautop.php',
        {
            pid: val,
            able: able
        },
        function(data,status){
            v.html(data);
        }
    );
});
