<?php
session_start();
require_once("./private/isdcoj-config.php");
require_once("./ioj-mission-start.php");
$id = $_GET['id'];
if(!isset($_SESSION['valid_user'])){
    // echo '<script>alert("没有登陆！");</script>';
}
$username = $_SESSION['valid_user'];

$db = new mysqli(ISDCOJ_MYSQL_HOST, ISDCOJ_MYSQL_USER, ISDCOJ_MYSQL_PWD, ISDCOJ_MYSQL_DBNAME);

// ioj_check_db_error();
$db->query("set character set 'utf8'");
$db->query("set names 'utf8'");
$id=$_GET["id"];
if (!is_numeric($id)){
    header("Location: http://www.scuisdc.com/hhh");
}
//$id = $db->real_escape_string($id);
$query = "SELECT * FROM " . ISDCOJ_MYSQL_TBISSUE . " where ID=".$id;
$result = $db->query($query);
if($row = $result->fetch_array(MYSQLI_ASSOC)){
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
}
else {
    header("Location: http://www.scuisdc.com/hhh");
}
?>



<html>
  <head>
    <title>训练平台 四川大学软件学院信息安全与网络攻防协会</title>
    <?php require('../header.inc.php');?>
    <script src="/assets/js/jQuery.headroom.min.js" type="text/javascript"></script>
    <script src="/assets/js/jquery.min.js" type="text/javascript"></script>

    <script>
	function initcaptcha() {
	    console.log("changed");
	    $("#captcha").click();
	}
    </script>

    <style>
      .submitform{
        margin-top: 20px;
      }

      #editor {
          text-align: left;
          margin-bottom: 30px;
          height: 600px;
          border: gray solid 2px;
          overflow: hidden;
          padding-top: 30px;
      }
    </style>
  </head>
<?php $_home_class='""';$_blog_class='""';$_game_class='""';$_train_class='"active"';$_about_class='"dropdown"';require('../navi.inc.php'); ?>

  <body onload="initcaptcha()">
    <header id="head" class="secondary"></header>

    <div class="container">
    <ol class="breadcrumb">
        <li><a href="index.php">训练平台</a></li>
        <li><a href="problemlist.php">答题列表</a></li>
        <?php echo '<li><a href="problemdescription.php?id='.$id.'">题目描述</a></li>'?>
        <li class="active">结果提交</li>
      </ol>
      <header class="page-header">
            <h1 class="page-title">结果提交</h1>
      </header>

      <form class="form-horizontal submitform" role="form" action="save.php" method="post" name="form" id="form" align="center">
          <input id="codes" name="textarea" type="hidden" value=""></input>
          <div class="form-group text-center">
          <label for="inputProblemID" class="col-sm-2 control-label">Problem ID</label>
          <div class="col-sm-4">
            <?php echo '<input type="text" class="form-control" id="id" name="id" value="'.$id.'" readonly>'?>
          </div>
        </div>
        <div class="form-group text-center">
          <label for="inputUsername" class="col-sm-2 control-label">User Name</label>
          <div class="col-sm-4">
            <?php echo '<input type="text" class="form-control" id="username" name="username" value="'.$username.'" readonly>'?>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-sm-2 control-label">Language</label>
          <div class="col-sm-4">
            <select name="language_sel" id="lang" class="form-control">
            <?php
              $i = 0;
              while($language != 0) {
                  $valid = $language % 2;
                  if ($valid) {
                      echo '<option value="'.$i.'">'.$IOJ_LANGUAGE[$i].'</option>';
                  }
                  $i = $i + 1;
                  $language /= 2;
              }

            ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-sm-2 control-label">Code</label>
          <div class="col-sm-10">
            <pre id="editor"></pre>
          </div>
        </div>
        <div class="form-group">
          <label for="checkCode" class="col-sm-2 control-label"><img name="checkcode" id="captcha" src = "checkcode.php" onclick="this.src='checkcode.php?aa='+Math.random()"/></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="checkCode" name="checkCode" placeholder="Check Code">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-1">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div>
      </form>
  </div>
    <?php require('../footer.inc.php');?>

    <script src="src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/textmate");
        document.addEventListener("click", function(){
            var language = document.getElementById('lang');
            var sel = language.options[language.selectedIndex].text;
            console.log(sel);
            if (sel == 'C' || sel == 'C++')
                editor.getSession().setMode("ace/mode/c_cpp");
            else if (sel == 'Java')
                editor.getSession().setMode("ace/mode/java");
            else if (sel == 'Python')
                editor.getSession().setMode("ace/mode/python");

            var codes = editor.getSession().getValue();
            console.log(codes);
            document.getElementById('codes').value = codes;
        }, false);
    </script>


  </body>
</html>
