<!DOCTYPE html>
<html>
	
<head>
	<meta charset="utf-8">
	<title>ISDCNext Backend</title>
	<?php require_once("../header.inc.php"); ?>
    <link rel="stylesheet" href="backend.css">
</head>

<body>
	<?php
    require_once("../navi.inc.php");
    require_once("./private/next_config.php");
    session_start();
    header('charset=utf-8');
    if (isset($_SESSION['valid_user'])) {
        $username = $_SESSION['valid_user'];
    }
    else {
        header("Location: http://www.scuisdc.com");
    }
    $ucdb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_UCDBNAME);
    $tpdb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_TPDBNAME);
    $psdb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_PSDBNAME);
    $bldb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_BLDBNAME);
    $cmsdb = new mysqli(ISDCBK_MYSQL_HOST, ISDCBK_MYSQL_USER, ISDCBK_MYSQL_PWD, ISDCBK_MYSQL_CMSDBNAME);
    $privilege = [
        0 => 0, //用户
        1 => 0, //超级管理员
        2 => 0, //CMS
        3 => 0, //博客
        4 => 0, //oj
        5 => 0, //ctf
        6 => 0, //任务中心
        7 => 0, //公告服务
    ];
    $ucdb->query("set character set 'utf8'");
    $ucdb->query("set names 'utf8'");
    $tpdb->query("set character set 'utf8'");
    $tpdb->query("set names 'utf8'");
    $psdb->query("set character set 'utf8'");
    $psdb->query("set names 'utf8'");
    $bldb->query("set character set 'utf8'");
    $bldb->query("set names 'utf8'");
    $cmsdb->query("set character set 'utf8'");
    $cmsdb->query("set names 'utf8'");
    $ucsearch = "SELECT `privilege` FROM " . ISDCBK_MYSQL_USRTBNAME . " WHERE `username`='".$username."'";
    $result = $ucdb->query($ucsearch);
    if (!$result){
        //header("Location: http://www.scuisdc.com/hhh");
        exit();
    }
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $numpri = $row["privilege"];
    $i = 0;
    if ($numpri == 1){
        echo "<script>alert('not admin.');</script>";
        //header("Location: http://www.scuisdc.com/");
    }
    while($numpri){
        $privilege[$i] = $numpri % 2;
        $numpri /= 2;
        $i += 1;
    }
    $result->close();
    //$ucdb->close();


    ?>
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
	    <div class="container">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	
	            <a class="navbar-brand" href="/index.php"><img src="assets/images/logo.png"></a>
	        </div>
	    </div>
	</div>
	
	<header id="head" class="secondary"></header>
	
	<div class="container">
		
	<ol class="breadcrumb" id="breadcrumb-header">
		<li>后台管理</li>
		<li class="active">管理</li>
        <?php
        echo "";

        ?>

    </ol>
    <?php
    if (!$privilege[0]){
        echo "<script>alert('user is locked.');</script>";
        header("Location: http://www.scuisdc.com/");
    }
    else{
    ?>
	<div class="ib-flex-container">
		<ul class="nav nav-stacked nav-pills ib-nav-list" id="nav-left">
            <?php
            $is_active = ' class="active"';
            if($privilege[1]) {
                echo '<li'.$is_active.'><a id="tab-member" href="#right-content-member">Member</a></li>';
                $is_active = '';
            }
            if($privilege[2]) {
                echo '<li'.$is_active.'><a id="tab-CMS" href="#right-content-CMS">CMS</a></li>';
                $is_active = '';
            }
            if($privilege[3]) {
                echo '<li'.$is_active.'><a id="tab-blog" href="#right-content-blog">Blog</a></li>';
                $is_active = '';
            }
            if($privilege[4]) {
                echo '<li'.$is_active.'><a id="tab-oj" href="#right-content-oj">Online Judge</a></li>';
                $is_active = '';
            }
            if($privilege[5]) {
                echo '<li'.$is_active.'><a id="tab-ctf" href="#right-content-ctf">CTF</a></li>';
                $is_active = '';
            }
            if($privilege[6]) {
                echo '<li'.$is_active.'><a id="tab-mission" href="#right-content-mission">Mission</a></li>';
                $is_active = '';
            }
            if($privilege[7]) {
                echo '<li'.$is_active.'><a id="tab-public" href="#right-content-public">Public Service</a></li>';
                $is_active = '';
            }
            ?>
        </ul>
		<div class="panel panel-default" id="right-panel">
			<div class="panel-body tab-content">
                <?php if($privilege[1]) { ?>
                    <div class="tab-pane fade" id="modify-member">
                        <h4>修改权限</h4>
                        <hr />
                        <div id="user-privilege">
                            <div>
                                <span id="user-privilege-usrid"></span>
                                <span id="user-privilege-usrname"></span>
                            </div>
                            <div class="checkbox" id="user-label">
                                <label>
                                    <input type="checkbox" value="">
                                    用户
                                </label>
                            </div>
                            <div class="checkbox" id="su-label">
                                <label>
                                    <input type="checkbox" value="">
                                    超级管理员
                                </label>
                            </div>
                            <div class="checkbox" id="cms-label">
                                <label>
                                    <input type="checkbox" value="">
                                    CMS
                                </label>
                            </div>
                            <div class="checkbox" id="blog-label">
                                <label>
                                    <input type="checkbox" value="">
                                    博客
                                </label>
                            </div>
                            <div class="checkbox" id="oj-label">
                                <label>
                                    <input type="checkbox" value="">
                                    oj
                                </label>
                            </div>
                            <div class="checkbox" id="ctf-label">
                                <label>
                                    <input type="checkbox" value="">
                                    ctf
                                </label>
                            </div>
                            <div class="checkbox" id="mission-label">
                                <label>
                                    <input type="checkbox" value="">
                                    任务中心
                                </label>
                            </div>
                            <div class="checkbox" id="public-label">
                                <label>
                                    <input type="checkbox" value="">
                                    公告服务
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <a id="back-member" href="#right-content-member">Back</a>
                            </div>
                            <div class="col-md-2 col-md-offset-2">
                                <a id="save-member" href="#right-content-member">Save</a>
                            </div>
                            <div class="col-md-2 col-md-offset-2">
                                <a id="del-member" href="#right-content-member">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade active in" id="right-content-member">
                        <h4>成员管理</h4>
                        <hr />
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>user name</th>
                                    <th>dispaly name</th>
                                    <th>email</th>
                                    <th>isdc mail</th>
                                    <th>register time</th>
                                    <th>modify privilege</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ucsearch = "SELECT * FROM " . ISDCBK_MYSQL_USRTBNAME;
                            $users = $ucdb->query($ucsearch);
                            while ($row = $users->fetch_array(MYSQLI_ASSOC)){
                                $usrid = $row['ID'];
                                $usrname = $row['username'];
                                $usrdis = $row['displayname'];
                                $usremail = $row['email'];
                                $usrisdcmail = $row['isdcmail'];
                                $usrregistertime = $row['register_time'];
                                $usrprivilege = $row['privilege'];
                                echo '<tr><th>'.$usrid.'</th>'.
                                    '<td>'.$usrname.'</td>'.
                                    '<td>'.$usrdis.'</td>'.
                                    '<td>'.$usremail.'</td>'.
                                    '<td>'.$usrisdcmail.'</td>'.
                                    '<td>'.$usrregistertime.'</td>'.
                                    '<td><a class="tab-member" href="#modify-member" data="'.$usrprivilege.'">Modify</a></td>'.
                                    '</tr>';
                            }
                            $users->close();

                            ?>
                            </tbody>
                        </table>

                    </div>
                <?php } ?>
                <?php if($privilege[2]) { ?>
                    <div class="tab-pane fade" id="right-content-CMS">
                        <ul class="nav nav-pills ib-nav-list ib-subsubnav" role="tablist">
                            <li class="active"><a href="#page-cms-man1">反馈</a></li>
                            <li><a href="#page-cms-man2">学期</a></li>
                            <li><a href="#page-cms-man3">账务</a></li>
                            <li><a href="#page-cms-man4">banner</a></li>
                            <li><a href="#page-cms-man5">intro</a></li>
                            <li><a href="#page-cms-man6">intro column</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="page-cms-man1">
                                <h4>反馈</h4>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>status</th>
                                        <th>name</th>
                                        <th>email</th>
                                        <th>content</th>
                                        <th>dealer_ID</th>
                                        <th>view</th>
                                        <th>deal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cmssearch = "SELECT * FROM `" . ISDCBK_MYSQL_CMSDBNAME."`.`".ISDCBK_MYSQL_CMSCONTACTTBNAME."`;";
                                    echo $cmssearch;
                                    $contacts = $cmsdb->query($cmssearch);
                                    while ($row = $contacts->fetch_array(MYSQLI_ASSOC)){
                                        $contactsid = $row['ID'];
                                        $contactstatus = $row['status'];
                                        $contactname = $row['name'];
                                        $contactemail = $row['email'];
                                        $contactcontent = $row['content'];
                                        $contactdealer = $row['dealer_ID'];
                                        if ($contactstatus){
                                            $conts_string = 'done';
                                        }
                                        else{
                                            $conts_string = 'wait';
                                        }
                                        echo '<tr><th>'.$contactsid.'</th>'.
                                            '<td>'.$contactstatus.'</td>'.
                                            '<td>'.$contactname.'</td>'.
                                            '<td>'.$contactemail.'</td>'.
                                            '<td>'.$contactcontent.'</td>'.
                                            '<td>'.$contactdealer.'</td>'.
                                            '<td><a class="contact-view" value="'.$contactsid.'">view</a></td>'.
                                            '<td><a class="contact-deal" value="'.$contactsid.'">deal</a></td>'.
                                            '</tr>';
                                    }
                                    $contacts->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="page-cms-man2">
                                <h4>course semester</h4>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>year</th>
                                        <th>semester</th>
                                        <th>start time</th>
                                        <th>end time</th>
                                        <th>enable</th>
                                        <th>modify</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cmssearch = "SELECT * FROM `" . ISDCBK_MYSQL_CMSDBNAME."`.`".ISDCBK_MYSQL_CMSSMSTBNAME."`;";
                                    echo $cmssearch;
                                    $semesters = $cmsdb->query($cmssearch);
                                    while ($row = $semesters->fetch_array(MYSQLI_ASSOC)){
                                        $semesterid = $row['ID'];
                                        $semesteryear = $row['year'];
                                        $semester = $row['semester'];
                                        $semesterst = $row['start_time'];
                                        $semesteret = $row['end_time'];
                                        $semesterenable = $row['enable'];
                                        if ($semesterenable){
                                            $smsenable_string = 'enable';
                                        }
                                        else{
                                            $smsenable_string = 'disable';
                                        }
                                        echo '<tr><th>'.$semesterid.'</th>'.
                                            '<td>'.$semesteryear.'</td>'.
                                            '<td>'.$semester.'</td>'.
                                            '<td>'.$semesterst.'</td>'.
                                            '<td>'.$semesteret.'</td>'.
                                            '<td><a class="semester-enable">'.$smsenable_string.'</a></td>'.
                                            '<td><a class="semester-modify" value="'.$semesterid.'">Modify</a></td>'.
                                            '</tr>';
                                    }
                                    $semesters->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="page-cms-man3">
                                <h4>finace</h4>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>month</th>
                                        <th>income</th>
                                        <th>outcome</th>
                                        <th>expense</th>
                                        <th>delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cmssearch = "SELECT * FROM `" . ISDCBK_MYSQL_CMSDBNAME."`.`".ISDCBK_MYSQL_CMSFNCPTBNAME."`;";
                                    echo $cmssearch;
                                    $finaces = $cmsdb->query($cmssearch);
                                    while ($row = $finaces->fetch_array(MYSQLI_ASSOC)){
                                        $fpid = $row['ID'];
                                        $fpmonth = $row['month'];
                                        $fpincome = $row['income_count'];
                                        $fpoutcome = $row['outcome_count'];
                                        $fpexpense = $row['expense_count'];
                                        echo '<tr><th>'.$fpid.'</th>'.
                                            '<td>'.$fpmonth.'</td>'.
                                            '<td>'.$fpincome.'</td>'.
                                            '<td>'.$fpoutcome.'</td>'.
                                            '<td>'.$fpexpense.'</td>'.
                                            '</tr>';
                                    }
                                    $finaces->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="page-cms-man4">
                                <h4>banner</h4>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>title</th>
                                        <th>subtitle</th>
                                        <th>button_text</th>
                                        <th>button_link</th>
                                        <th>pic_path</th>
                                        <th>enable</th>
                                        <th>modify</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cmssearch = "SELECT * FROM `" . ISDCBK_MYSQL_CMSDBNAME."`.`".ISDCBK_MYSQL_CMSBANNERTBNAME."`;";
                                    echo $cmssearch;
                                    $banners = $cmsdb->query($cmssearch);
                                    while ($row = $banners->fetch_array(MYSQLI_ASSOC)){
                                        $bannerid = $row['ID'];
                                        $bannertitle = $row['title'];
                                        $bannersubtitle = $row['subtitle'];
                                        $bannerbtext = $row['button_text'];
                                        $bannerblink = $row['button_link'];
                                        $bannerppath = $row['pic_path'];
                                        $bannerenable = $row['enable'];
                                        if ($bannerenable){
                                            $benable_string = 'enable';
                                        }
                                        else{
                                            $benable_string = 'enable';
                                        }
                                        echo '<tr><th>'.$bannerid.'</th>'.
                                            '<td>'.$bannertitle.'</td>'.
                                            '<td>'.$bannersubtitle.'</td>'.
                                            '<td>'.$bannerbtext.'</td>'.
                                            '<td>'.$bannerblink.'</td>'.
                                            '<td>'.$bannerppath.'</td>'.
                                            '<td>'.$bannerblink.'</td>'.
                                            '<td>'.$benable_string.'</td>'.
                                            '<td>modify</td>'.
                                            '</tr>';
                                    }
                                    $banners->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="page-cms-man5">
                                <h4>intro_column</h4>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>name</th>
                                        <th>path</th>
                                        <th>enable</th>
                                        <th>modify</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cmssearch = "SELECT * FROM `" . ISDCBK_MYSQL_CMSDBNAME."`.`".ISDCBK_MYSQL_CMSINTROCTBNAME."`;";
                                    echo $cmssearch;
                                    $introcs = $cmsdb->query($cmssearch);
                                    while ($row = $introcs->fetch_array(MYSQLI_ASSOC)){
                                        $introcid = $row['ID'];
                                        $introcname = $row['name'];
                                        $introcpath = $row['path'];
                                        $introcenable = $row['enable'];
                                        if ($introcenable){
                                            $icenable_string = 'enable';
                                        }
                                        else{
                                            $icenable_string = 'enable';
                                        }
                                        echo '<tr><th>'.$introcid.'</th>'.
                                            '<td>'.$introcname.'</td>'.
                                            '<td>'.$introcpath.'</td>'.
                                            '<td>'.$icenable_string.'</td>'.
                                            '<td>modify</td>'.
                                            '</tr>';
                                    }
                                    $introcs->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="page-cms-man6">
                                <h4>intro</h4>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>title</th>
                                        <th>subtitle</th>
                                        <th>button_text</th>
                                        <th>button_link</th>
                                        <th>pic_path</th>
                                        <th>enable</th>
                                        <th>modify</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cmssearch = "SELECT * FROM `" . ISDCBK_MYSQL_CMSDBNAME."`.`".ISDCBK_MYSQL_CMSINTROTBNAME."`;";
                                    echo $cmssearch;
                                    $intros = $cmsdb->query($cmssearch);
                                    while ($row = $intros->fetch_array(MYSQLI_ASSOC)){
                                        $introid = $row['ID'];
                                        $introtitle = $row['title'];
                                        $introasidetitle = $row['aside_title'];
                                        $introcontent = $row['content'];
                                        $introorder = $row['order'];
                                        $introtype = $row['type'];
                                        $introenable = $row['enable'];
                                        if ($introenable){
                                            $ienable_string = 'enable';
                                        }
                                        else{
                                            $ienable_string = 'enable';
                                        }
                                        echo '<tr><th>'.$introid.'</th>'.
                                            '<td>'.$introtitle.'</td>'.
                                            '<td>'.$introasidetitle.'</td>'.
                                            '<td>'.$introcontent.'</td>'.
                                            '<td>'.$introorder.'</td>'.
                                            '<td>'.$introtype.'</td>'.
                                            '<td>'.$ienable_string.'</td>'.
                                            '<td>modify</td>'.
                                            '</tr>';
                                    }
                                    $intros->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr />
                    </div>
                <?php } ?>
                <?php if($privilege[3]) { ?>
                    <div class="tab-pane fade" id="right-content-blog">
                        <ul class="nav nav-pills ib-nav-list ib-subsubnav" role="tablist">
                            <li class="active"><a href="#page-blog-man1">博文管理</a></li>
                            <li><a href="#page-blog-man2">评论管理</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="page-blog-man1">
                                <h4>博文管理</h4>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>category</th>
                                        <th>author</th>
                                        <th>post_date</th>
                                        <th>title</th>
                                        <th>status</th>
                                        <th>comment_status</th>
                                        <th>last_modified</th>
                                        <th>read_count</th>
                                        <th>comment_count</th>
                                        <th>delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $blsearch = "SELECT * FROM `" . ISDCBK_MYSQL_BLDBNAME."`.`".ISDCBK_MYSQL_BLATBNAME."`;";
                                    echo $blsearch;
                                    $articles = $bldb->query($blsearch);
                                    while ($row = $articles->fetch_array(MYSQLI_ASSOC)){
                                        $articleid = $row['ID'];
                                        $categoryid = $row['category_ID'];
                                        $authorid = $row['author_ID'];
                                        $postdate = $row['post_date'];
                                        $title = $row['title'];
                                        $status = $row['status'];
                                        $commentstatus = $row['comment_status'];
                                        $lastmodified = $row['last_modified'];
                                        $readcount = $row['readcount'];
                                        $commentcount = $row['commentcount'];
                                        if ($status){
                                            $bls_string = 'enable';
                                        }
                                        else{
                                            $bls_string = 'disable';
                                        }
                                        if ($commentstatus){
                                            $blc_string = 'enable';
                                        }
                                        else{
                                            $blc_string = 'disable';
                                        }
                                        echo '<tr><th>'.$articleid.'</th>'.
                                            '<td>'.$categoryid.'</td>'.
                                            '<td>'.$authorid.'</td>'.
                                            '<td>'.$postdate.'</td>'.
                                            '<td>'.$title.'</td>'.
                                            '<td><a class="bls-enable" value="'.$articleid.'">'.$bls_string.'</a></td>'.
                                            '<td><a class="blc-enable" value="'.$articleid.'">'.$blc_string.'</a></td>'.
                                            '<td>'.$lastmodified.'</td>'.
                                            '<td>'.$readcount.'</td>'.
                                            '<td>'.$commentcount.'</td>'.
                                            '<td><a class="article-delete" value="'.$articleid.'">Delete</a></td>'.
                                            '</tr>';
                                    }
                                    $articles->close();

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="page-blog-man2">
                                <h4>评论管理</h4>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>artical</th>
                                        <th>commenter</th>
                                        <th>comment_date</th>
                                        <th>view</th>
                                        <th>status</th>
                                        <th>delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $blsearch = "SELECT * FROM `" . ISDCBK_MYSQL_BLDBNAME."`.`".ISDCBK_MYSQL_BLCTBNAME."`;";
                                    echo $blsearch;
                                    $comments = $bldb->query($blsearch);
                                    while ($row = $comments->fetch_array(MYSQLI_ASSOC)){
                                        $commentid = $row['ID'];
                                        $articleid = $row['article_ID'];
                                        $commenterid = $row['commenter_ID'];
                                        $commentdate = $row['comment_date'];
                                        $status = $row['status'];
                                        if ($status){
                                            $cstatus_string = 'enable';
                                        }
                                        else{
                                            $cstatus_string = 'disable';
                                        }
                                        echo '<tr><th>'.$commentid.'</th>'.
                                            '<td>'.$articleid.'</td>'.
                                            '<td>'.$commenterid.'</td>'.
                                            '<td>'.$commentdate.'</td>'.
                                            '<td><a class="comment-enable" value="'.$commentid.'">view</a></td>'.
                                            '<td><a class="comment-enable" value="'.$commentid.'">'.$cstatus_string.'</a></td>'.
                                            '<td><a class="comment-delete" value="'.$commentid.'">Delete</a></td>'.
                                            '</tr>';
                                    }
                                    $comments->close();

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($privilege[4]) { ?>
                    <div class="tab-pane fade" id="right-content-oj">
                        <h4>oj管理</h4>
                        <hr />
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>auto</th>
                                <th>type</th>
                                <th>lang</th>
                                <th>title</th>
                                <th>time</th>
                                <th>memory</th>
                                <th>start_time</th>
                                <th>end_time</th>
                                <th>desc</th>
                                <th>input</th>
                                <th>output</th>
                                <th>ratio</th>
                                <th>enable</th>
                                <th>modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ojsearch = "SELECT * FROM `" . ISDCBK_MYSQL_TPDBNAME."`.`".ISDCBK_MYSQL_OJPTBNAME."`;";
                            echo $ojsearch;
                            $problems = $psdb->query($ojsearch);
                            while ($row = $problems->fetch_array(MYSQLI_ASSOC)){
                                $pid = $row['ID'];
                                $pis_auto = $row['is_auto'];
                                $ptype = $row['type'];
                                $planguage = $row['language_limit'];
                                $ptitle = $row['title'];
                                $ptl = $row['time_limit'];
                                $pml = $row['memory_limit'];
                                $pst = $row['start_time'];
                                $pet = $row['end_time'];
                                $pdescription = $row['description'];
                                $pinput = $row['input'];
                                $poutput = $row['output'];
                                $pratio = $row['ratio'];
                                $pac = $row['accepted'];
                                $psb = $row['submitted'];
                                $penable = $row['enable'];
                                if ($pis_auto){
                                    $auto_string = 'auto';
                                }
                                else{
                                    $auto_string = 'not';
                                }
                                if ($penable){
                                    $penable_string = 'enable';
                                }
                                else{
                                    $penable_string = 'disable';
                                }


                                echo '<tr><th>'.$pid.'</th>'.
                                    '<td><a class="p-auto" value="'.$pid.'">'.$auto_string.'</a></td>'.
                                    '<td>'.$ptype.'</td>'.
                                    '<td>'.$planguage.'</td>'.
                                    '<td>'.$ptitle.'</td>'.
                                    '<td>'.$ptl.'</td>'.
                                    '<td>'.$pml.'</td>'.
                                    '<td>'.$pst.'</td>'.
                                    '<td>'.$pet.'</td>'.
                                    '<td><a class="oj-modify" url="'.$pdescription.'">modify</a></td>'.
                                    '<td><a class="oj-modify" url="'.$pinput.'">modify</a></td>'.
                                    '<td><a class="oj-modify" url=">'.$poutput.'">modify</a></td>'.
                                    '<td>'.$pratio.'</td>'.
                                    '<td>'.$penable.'</td>'.
                                    '</tr>';
                            }
                            $problems->close();

                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php if($privilege[5]) { ?>
                    <div class="tab-pane fade" id="right-content-ctf">
                        <h4>ctf管理</h4>
                        <hr />
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>start_time</th>
                                <th>end_time</th>
                                <th>type</th>
                                <th>enable</th>
                                <th>modify</th>
                                <th>delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ctfsearch = "SELECT * FROM `" . ISDCBK_MYSQL_TPDBNAME."`.`".ISDCBK_MYSQL_CTFSTBNAME."`;";
                            echo $ctfsearch;
                            $sets = $psdb->query($ctfsearch);
                            while ($row = $sets->fetch_array(MYSQLI_ASSOC)){
                                $sid = $row['ID'];
                                $sname = $row['name'];
                                $sst = $row['start_time'];
                                $set = $row['end_time'];
                                $stype = $row['type'];
                                $senable = $row['enable'];
                                if ($senable){
                                    $senable_string = 'enable';
                                }
                                else{
                                    $senable_string = 'disable';
                                }


                                echo '<tr><th>'.$sid.'</th>'.
                                    '<td>'.$sname.'</td>'.
                                    '<td>'.$sst.'</td>'.
                                    '<td>'.$set.'</td>'.
                                    '<td>'.$stype.'</td>'.
                                    '<td><a class="ctf-enable" value="'.$sid.'">'.$senable_string.'</a></td>'.
                                    '<td><a class="ctf-modify" value="'.$sid.'">modify</a></td>'.
                                    '<td><a class="ctf-delete" value="'.$sid.'">delete</a></td>'.
                                    '</tr>';
                            }
                            $sets->close();

                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php if($privilege[6]) { ?>
                    <div class="tab-pane fade" id="right-content-mission">
                        <h4>任务管理</h4>
                        <hr />
                    </div>
                <?php } ?>
                <?php if($privilege[7]) { ?>
                    <div class="tab-pane fade" id="right-content-public">
                        <h4>公共服务管理</h4>
                        <hr />
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>service name</th>
                                <th>path</th>
                                <th>enable</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $pssearch = "SELECT * FROM `" . ISDCBK_MYSQL_PSDBNAME."`.`".ISDCBK_MYSQL_SERVICETBNAME."`;";
                            $services = $psdb->query($pssearch);
                            while ($row = $services->fetch_array(MYSQLI_ASSOC)){
                                $serviceid = $row['ID'];
                                $servicename = $row['name'];
                                $servicepath = $row['path'];
                                $serviceenable = $row['enable'];
                                if ($serviceenable){
                                    $enable_string = 'enable';
                                }
                                else{
                                    $enable_string = 'disable';
                                }
                                echo '<tr><th>'.$serviceid.'</th>'.
                                    '<td>'.$servicename.'</td>'.
                                    '<td>'.$servicepath.'</td>'.
                                    '<td><a class="service-enable" value="'.$serviceid.'">'.$enable_string.'</a></td>'.
                                    '</tr>';
                            }
                            $services->close();

                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>

			</div>
		</div>
	</div>
	</div>
    <?php
    }
    $ucdb->close();
    $bldb->close();
    $cmsdb->close();
    $psdb->close();
    $tpdb->close();
    ?>
	
	<?php require_once("../footer.inc.php"); ?>
	<script src="backend.js"></script>

</body>
	
</html>