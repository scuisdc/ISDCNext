<?php session_start();?>
<head>
    <title>训练平台 四川大学软件学院信息安全与网络攻防协会</title><meta charset="utf-8">
    <?php require('../header.inc.php'); ?>
	<script src="/assets/js/jQuery.headroom.min.js" type="text/javascript"></script>
	<script src="/assets/js/jquery.min.js" type="text/javascript"></script>
    <style media="screen">
        #editor {
            height: 400px;
            overflow: hidden;
        }
    </style>
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

$id = $_GET['id'];
if (!is_numeric($id)) {
    echo '<script>window.location.href="./hhh"</script>';
    exit;
}

?>

<header id="head" class="secondary"></header>

	<div class="container">
		<ol class="breadcrumb">
				<li><a href="index.php">训练平台</a></li>
				<li><a href="getUserHistory.php">提交历史</a></li>
                <li class="active">详细代码</li>
		</ol>

		<article class="col-md-12 maincontent">

			<header class="page-header">
				<h1 class="page-title">ISDC训练平台</h1>
			</header>
			<p></p>

			<table class="table text-center table-bordered table-hover table-striped">
					<?php
                    $db = new GloriousDB(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);
                    function getContent($path) {
                        $contents = file_get_contents($path);
                        // $contents = nl2br($contents);
                        $contents = htmlspecialchars($contents);
                        $contents = str_replace("\t", "    ", $contents);
                        $ret = "";
                        $ret .= '<pre id="editor">';
                        $ret .= $contents;
                        $ret .= "</pre>";
                        fclose($fp);
                        return $ret;
                    }
                    if ($db->state() == 1) {
                        $db->setTable("oj_submit");
                        $db->where(["ID" => $id]);
                        $res = $db->find();
                        $res = $res[0];
                        $problem = $res["problem_ID"];
                        $language = $res["language"];
                        $time = $res["time"];
                        $db->setTable("oj_source");
                        $db->where(["submit_ID" => $id]);
                        $res = $db->find(["file_path"]);
                        $codes = getContent($res[0]["file_path"]);
                        switch ($language) {
                            case '0':
                                $language = "C";
                                break;
                            case '1':
                                $language = "C++";
                                break;
                            case "2":
                                $language = "Python";
                                break;
                            case "3":
                                $language = "Java";
                                break;
                            default:
                                $language = "Not Mentioned";
                                # code...
                                break;
                        }
                        echo "<p>提交ID:".$id."</p>";
                        echo "<p>问题ID:".$problem."</p>";
                        echo '<p>使用语言:<span id="lang">'.$language."</span></p>";
                        echo "<p>提交时间:".$time."</p><br />";
                        echo $codes;
                    }
                    else {
                        die("Can not connect to the database");
                    }

                    $db->destroy();
					?>
			</table>
		</article>
</div>

<script src="src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/textmate");
    editor.setReadOnly(true);

    function getHighlight () {
        var sel = document.getElementById('lang').innerHTML;
        console.log(sel);
        if (sel == 'C' || sel == 'C++')
            editor.getSession().setMode("ace/mode/c_cpp");
        else if (sel == 'Java')
            editor.getSession().setMode("ace/mode/java");
        else if (sel == 'Python')
            editor.getSession().setMode("ace/mode/python");
    }
    window.onload = getHighlight;
</script>

<?php
require_once('../footer.inc.php');


?>
