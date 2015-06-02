<!DOCTYPE html>

<html>
<head>
	<title>训练平台 四川大学软件学院信息安全与网络攻防协会</title>
	<?php
	session_start();
	if (!isset($_SESSION['valid_user'])) {
		echo '<script>window.location.href="index.php";</script>';
	}
	require('../header.inc.php');
	?>
	<script src="/assets/js/jQuery.headroom.min.js" type="text/javascript"></script>
	<script src="/assets/js/jquery.min.js" type="text/javascript"></script>
	<style>
		.btn-primary { 
			color:#FFEFD7; ient(top, #FF9B22 0%, #FF8C00 100%); 
			background-image: none; 
		}
		.pds{
			margin-bottom: 20px;
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
				<li><a href="problemlist.php">答题列表</a></li>
				<li class="active">题目描述</li>
		</ol>
		<?php
			function getfilecontent($filedir)
			{
				$str = "";
				$file = fopen($filedir, "r");
				if($file)
				{
					$ch = fgetc($file);
                                while(!feof($file))
                                {
                                        $str = $str.$ch;
                                        $ch = fgetc($file);
                                }
                                return $str;
				}
				else echo "no such file";
			}

            $db = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);
            ioj_check_db_error();
            $db->query("set character set 'utf8'");
            $db->query("set names 'utf8'");
			$id=$_GET["id"];
            if (!is_numeric($id)){
                header("Location: http://www.scuisdc.com/hhh");
            }
			//$id = $db->real_escape_string($id);
			$query = "SELECT * FROM " . ISDCOJ_MYSQL_TBISSUE . " where ID=".$id;
			$result = $db->query($query);
			if($result){
                $row = $result->fetch_array(MYSQLI_ASSOC);
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
                if (!$enable){
                    header("Location: http://www.scuisdc.com/hhh");
                }
                echo '<div class="page-header" align="center">
							<h1>'.$pid.'  '.$ptitle.'</h1><br/>
							<h6><small>Start Time: '.$starttime.'  '.'End Time: '.$endtime.'</small></h6><br>
							<h6><small>Time Limit: '.$timelim.'  '.'Memory Limit: '.$memlim.'</small></h6><br>
						</div>';

                echo '<div class="panel panel-default">
                    <div class="panel-body">';
                $i = 0;
                while ($language){
                    $li = $language % 2;
                    if ($li){
                        echo "<kbd>" . $IOJ_LANGUAGE[$i] . "</kbd>  ";
                    }
                    $i += 1;
                    $language /= 2;
                }
                echo '</div></div>';

                echo '<div class="panel panel-default">
						  <div class="panel-heading">Description</div>
						  <div class="panel-body">'.
						  getfilecontent($description)
						  .'</div>
						</div>';
				echo '<div class="panel panel-default">
						  <div class="panel-heading">Input</div>
						  <div class="panel-body">'.
						    getfilecontent($in)
						  .'</div>
						</div>';
				echo '<div class="panel panel-default">
						  <div class="panel-heading">Output</div>
						  <div class="panel-body">'.
						    getfilecontent($out)
						  .'</div>
						</div>';
			}
            else {
                header("Location: http://www.scuisdc.com/hhh");
            }
			$time = time();
			$endtime = strtotime($endtime);
			if ($time < $endtime) {
				echo'<div class align="center">
				<button type="button" id="SubmitButton" class="btn btn-primary pds">Submit</button>

				<script>
				  $("#SubmitButton").on("click", function () {
						location.href = "./submit.php?id='.$id.'"; })
				</script>
				</div>';
			}
            $result->close();
			$db->close();
		?>
</div>
<?php require('../footer.inc.php');?>
</body>
</html>
