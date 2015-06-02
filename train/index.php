<?php session_start();?>
<!DOCTYPE html>
<?php
if(isset($_SESSION['valid_user']))
{
	$userid = $_SESSION['valid_user'];
	echo '<meta http-equiv="refresh" content="0;url=http://www.scuisdc.com/train/problemlist.php"> ';
}

?>

<html lang="en">
<title>训练平台 四川大学信息安全与网络攻防协会</title>
<?php
	require('../header.inc.php');
	$_home_class='""';$_blog_class='""';$_game_class='""';$_train_class='"active"';$_about_class='"dropdown"';
	require_once('../navi.inc.php');
?>

<header id="head" class="secondary"></header>
<body>

	<div class="container">
		<ol class="breadcrumb">
				<li>训练平台</a></li>
				<li class="active">登录</li>
		</ol>
		<div class="row">
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title">登录</h1>
				</header>

				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">登录我们的训练平台</h3>
							<p class="text-center text-muted">没有账号？没关系，赶紧<a href="../blog/wp-login.php?action=register">注册</a>吧!<br />来这里体验最有FEEL的训练！</p>
							<hr />

							<form action="handle.php" method="post" name="form" id="form" class="form-horizontal" role="form">
							  <div class="form-group">
							    <label for="inputUsername" class="col-sm-2 control-label">Username</label>
							    <div class="col-sm-10">
							      <input type="text" class="form-control" id="userid" name="userid" placeholder="User Name">
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
							    <div class="col-sm-10">
							      <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password">
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="checkCode" class="col-sm-2 control-label"><img name="checkcode" src = "b.php" onclick="this.src='b.php?aa='+Math.random()"/></label>
							    <div class="col-sm-10">
							      <input type="text" class="form-control" id="checkCode" name="checkCode" placeholder="Check Code">
							    </div>
							  </div>
							  <hr />
							  <div class="form-group text-center">
							      <button type="submit" class="btn btn-action">Sign in</button>
							  </div>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>

	<?php
	require_once('../footer.inc.php');
	?>
</body>
</html>
