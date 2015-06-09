<?php session_start();?>
<!DOCTYPE html>
<?php
if(isset($_SESSION['valid_user']))
{
	$userid = $_SESSION['valid_user'];
	echo '<meta http-equiv="refresh" content="0;url=http://www.scuisdc.com"> ';
}
?>

<html lang="en">
<head>
    <title>注册 四川大学信息安全与网络攻防协会</title>
    <?php require('../../header.inc.php'); ?>
</head>
    <?php
        $_home_class=$_blog_class='';$_train_class=$_service_class=$_about_class='class="dropdown"';
        require_once('../../navi.inc.php');
    ?>

<header id="head" class="secondary"></header>
<body>

	<div id="username" class="alert alert-danger hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>输入邮箱或者用户名信息含有敏感字符！！！</strong>
	</div>
	<div id="blank" class="alert alert-danger hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>存在输入为空的表单项！！！</strong>
	</div>
	<div id="email_val" class="alert alert-danger hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>邮箱号不符合规范！！！</strong>
	</div>

	<div id="passwd_val" class="alert alert-danger hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>输入密码未超过6位！！！</strong>
	</div>

	<div id="dberror" class="alert alert-danger hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>链接数据库失败，请稍后重试！！！</strong>
	</div>

	<div id="exist" class="alert alert-danger hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>注册的用户名或者邮箱号已存在，请重试！！！</strong>
	</div>

	<div id="success" class="alert alert-success hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>注册成功，正在跳转！！！</strong>
	</div>


	<div class="container">
		<ol class="breadcrumb">
			<li>用户中心</a></li>
			<li class="active">注册</li>
		</ol>
		<div class="row">
			<article class="col-xs-12 maincontent">
                <header class="page-header">
					<h1 class="page-title">注册</h1>
				</header>

				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">欢迎加入ISDC</h3>
							<p class="text-center text-muted">已经注册？赶紧<a href="./login.php">登陆</a>我们的网站吧!</p>
							<hr />

							<form action="handleregister.php" id="form" method="post" name="form" id="form" class="form-horizontal" role="form">

							<div class="form-group">
							    <label for="email" class="col-sm-2 control-label">邮&nbsp;&nbsp;&nbsp;&nbsp;箱</label>
							    <div class="col-sm-10">
							      <input type="email" class="form-control" id="email" name="email" placeholder="Email">
							    </div>
							</div>

							  <div class="form-group">
							    <label for="inputUsername" class="col-sm-2 control-label">用户名</label>
							    <div class="col-sm-10">
							      <input type="text" class="form-control" id="userid" name="userid" placeholder="User Name">
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="inputPassword" class="col-sm-2 control-label">密&nbsp;&nbsp;&nbsp;&nbsp;码</label>
							    <div class="col-sm-10">
							      <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password">
							    </div>
							  </div>
							  <hr />
							  <div class="form-group text-center">
							      <span id="subbtn" class="btn btn-warning btn-lg">注&nbsp;册</span>
							  </div>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</body>

<?php
require_once('../../footer.inc.php');
?>

<script>
		$(function() {
			document.addEventListener('keydown', function(event) {
				if (event.keyCode == 13){
					$("#subbtn").click();
				}
			},false);
			String.prototype.contains = function(it) { return this.indexOf(it) != -1; };
			// 为String类添加了一个contains方法来鉴定是否存在着非法字符
			$("#subbtn").on('click', function() {
				var email = $("#email").val();
				var userid = $("#userid").val();
				var passwd = $("#passwd").val();
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (!email || !userid || !passwd) {
					$("#blank").toggleClass("hidden");
				}
				else if(email.contains(" ") || email.contains("-") || email.contains("'") || 		email.contains("<") || email.contains(">") || email.contains("&")) {
					$("#username").toggleClass("hidden");
				}
				else if (userid.contains(" ") || userid.contains("-") || userid.contains("'") || userid.contains("<") || userid.contains(">") || userid.contains("&")){
					$("#username").toggleClass("hidden");
				}
				else if (!filter.test(email)) {
					$("#email_val").toggleClass("hidden");
				}
				else if (passwd.length < 6) {
					$("#passwd_val").toggleClass("hidden");
				}
				else {
					$.post("handleregister.php", {email:email, passwd:passwd, userid:userid}, function(data){
						if (data == "dberror") {
							$("#dberror").toggleClass("hidden");
						}
						else if (data == "exist") {
							$("#exist").toggleClass("hidden");
						}
						else {
							$("#success").toggleClass("hidden");
							setTimeout(function(){console.log("successfully reigstered");}, 5000);
							window.location.href="../index.php"
						}
					});
				}
			});
		});
</script>
</html>
