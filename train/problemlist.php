<?php session_start(); ?>
<?php header('charset=utf-8');?>
<!DOCTYPE html>

<html>
<head>
	<title>训练平台 四川大学软件学院信息安全与网络攻防协会</title>
	<?php require('../header.inc.php'); ?>
	<script src="/assets/js/jQuery.headroom.min.js" type="text/javascript"></script>
	<script src="/assets/js/jquery.min.js" type="text/javascript"></script>
	<script>
		function goto(id){
			window.location.href='./problemdescription.php?id='+id;
		}
		$(function(){$("#SignOut").on("click", function () {
			location.href = "./signout.php";
		});});
	</script>
	<style>
		.signoutb{
			margin-bottom: 5px;
			margin-left: 8px;
		}
		.btn-primary {
			color:#FFEFD7; ient(top, #FF9B22 0%, #FF8C00 100%);
			background-image: none;
		}
	</style>
</head>
<body>

<?php $_home_class='""';$_blog_class='""';$_game_class='""';$_train_class='"active"';$_about_class='"dropdown"';require('../navi.inc.php'); ?>
<?php
    require_once('ioj-mission-start.php');
    require_once('./include/ioj-util-second.php');
?>

<header id="head" class="secondary"></header>

	<div class="container">
		<ol class="breadcrumb">
				<li><a href="index.php">训练平台</a></li>
				<li class="active">答题列表</li>
		</ol>

		<article class="col-md-12 maincontent">

			<header class="page-header">
				<h1 class="page-title">ISDC训练平台</h1>
			</header>

			<?php
				if (isset($_SESSION['valid_user'])) {
					$username=$_SESSION['valid_user'];
			?>

			<div class="text-right">
				<div class="dropdown">
				<button class="btn btn-success dropdown-toggle btn-sm" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
	    			<?php echo $username; ?>
	    			<span class="caret"></span>
	  			</button>
				  <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
				    <li role="presentation"><a role="menuitem" tabindex="-1" href="./getUserHistory.php">提交历史</a></li>
				    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" id="SignOut">注销</a></li>
				  </ul>
				</div>
			</div>

			<?php
				} else {
					echo '<script>window.location.href="./index.php";</script>';
				}
			?>
			<p></p>

			<table class="table text-center table-bordered table-hover table-striped">
				<tr>
				    <th align="center">ID</th>
                    <th align="center">name</th>
                    <th align="center">type</th>
                    <th align="center">start time</th>
                    <th align="center">end time</th>
                    <th align="center">rank</th>
                    <th align="center">accepted</th>
                    <th align="center">submitted</th>
				</tr>
				<tbody>
                <?php
                    $db = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);
                    ioj_check_db_error();
                    $db->query("set character set 'utf8'");
                    $db->query("set names 'utf8'");
                    $problems = $db->query("select * from " . ISDCOJ_MYSQL_TBISSUE);
                    while($row = $problems->fetch_array(MYSQLI_ASSOC)) {
                        $ptitle = $row[$IOJ_ISSUESC["title"]];
                        $pid = $row[$IOJ_ISSUESC["id"]];
                        $endtime = $row[$IOJ_ISSUESC["end"]];
                        $starttime = $row[$IOJ_ISSUESC["begin"]];
                        $language = $row[$IOJ_ISSUESC["language"]];
                        $rank = $row[$IOJ_ISSUESC["rank"]];
                        $numofacc = $row[$IOJ_ISSUESC["numofAC"]];
                        $numofsub = $row[$IOJ_ISSUESC["numofSUB"]];
                        $memlim = $row[$IOJ_ISSUESC["space_comp"]];
                        $timelim = $row[$IOJ_ISSUESC["time_comp"]];
                        $is_auto = $row[$IOJ_ISSUESC["is_auto"]];
                        $description = $row[$IOJ_ISSUESC["description"]];
                        $in = $row[$IOJ_ISSUESC["in"]];
                        $out = $row[$IOJ_ISSUESC["out"]];
                        $enable = $row[$IOJ_ISSUESC["enable"]];
                        $type = $row[$IOJ_ISSUESC["type"]];
                        echo '<tr><td id="'.$pid.'">'. $pid.'</td>';
                        if ($enable)
                            echo '<td><a onclick="goto(\''.$pid.'\')">'.$ptitle.'</a></td>';
                        else
                            echo '<td>'.$ptitle.'</td>';
                        echo '<td>'. $IOJ_TYPE[$type] .'</td>'.
                            '<td>'. $starttime.'</td>'.
                            '<td>'. $endtime.'</td>'.
                            '<td>'. $rank.'</td>'.
                            '<td>'. $numofacc.'</td>'.
                            '<td>'.$numofsub.'</td></tr>';
                    }
                    $problems->close();
                    $db->close();

                    ?>
				</tbody>
			</table>
		</article>
</div>

	<?php
	require_once('../footer.inc.php');
	?>
</body>
</html>
