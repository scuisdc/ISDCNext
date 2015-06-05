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
                    <div class="tab-pane fade" id="right-content-member">
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
                                    '<td><a id="tab-member" href="#modify-member" data="'.$usrprivilege.'">Modify</a></td>'.
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
                        <h4>CMS管理</h4>
                        <hr />
                    </div>
                <?php } ?>
                <?php if($privilege[3]) { ?>
                    <div class="tab-pane fade active in" id="right-content-blog">
                        <ul class="nav nav-pills ib-nav-list ib-subsubnav" role="tablist">
                            <li class="active"><a href="#page-blog-man1">博客管理 1</a></li>
                            <li><a href="#page-blog-man2">博客管理 2</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="page-blog-man1">
                                <h4>博客管理 1</h4>
                                <hr />
                            </div>
                            <div class="tab-pane fade" id="page-blog-man2">
                                <h4>博客管理 2</h4>
                                <hr />
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($privilege[4]) { ?>
                    <div class="tab-pane fade" id="right-content-oj">
                        <h4>oj管理</h4>
                        <hr />
                    </div>
                <?php } ?>
                <?php if($privilege[5]) { ?>
                    <div class="tab-pane fade" id="right-content-ctf">
                        <h4>ctf管理</h4>
                        <hr />
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
                    </div>
                <?php } ?>

<!--                <div class="tab-pane fade" id="right-content-index">-->
<!--					<h4>主页管理</h4>-->
<!--					<hr />-->
<!--				</div>-->
<!--				<div class="tab-pane fade" id="right-content-training">-->
<!--					<ul class="nav nav-pills ib-nav-list ib-subsubnav" role="tablist">-->
<!--						<li class="active"><a href="#page-training-man1">训练平台 1</a></li>-->
<!--						<li><a href="#page-training-man2">训练平台 2</a></li>-->
<!--					</ul>-->
<!--					<div class="tab-content">-->
<!--						<div class="tab-pane fade active in" id="page-training-man1">-->
<!--							<h4>训练平台 1</h4>-->
<!--							<hr />-->
<!--						</div>-->
<!--						<div class="tab-pane fade" id="page-training-man2">-->
<!--							<h4>训练平台 2</h4>-->
<!--							<hr />-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->

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