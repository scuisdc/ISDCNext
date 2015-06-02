<?php session_start();?>
<head>
    <title>训练平台 四川大学软件学院信息安全与网络攻防协会</title><meta charset="utf-8">
    <?php require('../header.inc.php'); ?>
	<script src="/assets/js/jQuery.headroom.min.js" type="text/javascript"></script>
	<script src="/assets/js/jquery.min.js" type="text/javascript"></script>
	<script>
		function goto(id){
			window.location.href='./problemdescription.php?id='+id;
		}
        function viewCodes(id) {
            window.location.href='./viewCodes.php?id='+id;
        }
		$(function(){$("#SignOut").on("click", function () {
			location.href = "./signout.php";
		});});
	</script>

</head>
<?php $_home_class='""';$_blog_class='""';$_game_class='""';$_train_class='"active"';$_about_class='"dropdown"';require('../navi.inc.php'); ?>
<?php
    require_once('ioj-mission-start.php');
    require_once('./include/ioj-util-second.php');
?>

<?php
require "./glorious.php";
if (!$_SESSION["valid_user"]) {
    echo '<script>alert("当前用户没有登录，请登录");</script>';
    echo '<script>window.location.href="./index.php"</script>';
    exit;
}
?>

<header id="head" class="secondary"></header>

	<div class="container">
		<ol class="breadcrumb">
				<li><a href="index.php">训练平台</a></li>
				<li class="active">提交历史</li>
		</ol>

		<article class="col-md-12 maincontent">

			<header class="page-header">
				<h1 class="page-title">ISDC训练平台</h1>
			</header>
			<p></p>

			<table class="table text-center table-bordered table-hover table-striped">
				<tr>
				<th align="center">Submit_ID</th><th ALIGN="CENTER">Problem_ID</th><th ALIGN="CENTER">Submit_time</th><th ALIGN="CENTER">Status</th><th ALIGN="CENTER">Message</th>
				</tr>
				<tbody>
					<?php

                    $username = $_SESSION["valid_user"];
                    $db = new GloriousDB(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCUC_MYSQL_DBNAME);
                    $username;
                    if ($db->state() == 1) {
                        $db->setTable("user");
                        $db->where(["username" => $username]);
                        $res = $db->find(["ID"]);
                        $res = $res[0]; // unique user name
                        $userid = $res["ID"];
                    }
                    else {
                        die("Can not connect to the database");
                    }
                    $db->destroy();
                    $query = "select * from oj_submit, oj_source where (oj_submit.ID=oj_source.submit_ID and oj_submit.submiter_ID='".$userid."');";
                    $db1 = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);
                    if (mysqli_connect_errno()) {
                        die("Can not connect to the Database");
                    }
                    $db1->query("SET NAMES UTF8");
                    $res = $db1->query($query);
                    for ($i = 0; $i < $res->num_rows; $i ++) {
                        $row = $res->fetch_assoc();
                        $submit_id = $row["submit_ID"];
                        $problem_id = $row["problem_ID"];
                        $submit_time = $row["time"];
                        $status = $row["status"];
                        $message = $row["message"];
                        echo '<tr><td id="'.$submit_id.'"><a onclick="viewCodes(\''.$submit_id.'\')">'.$submit_id.'</a></td><td><a onclick="goto(\''.$problem_id.'\')">'.$problem_id.'</a></td><td>'. $submit_time.'</td><td>'. $status.'</td><td>'.$message.'</td></tr>';
                    }
                    $db1->close();

					?>
				</tbody>
			</table>
		</article>
</div>


<?php
require_once('../footer.inc.php');


?>
