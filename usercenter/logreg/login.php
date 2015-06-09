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
    <title>登录 四川大学信息安全与网络攻防协会</title>
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
		<strong>输入的用户名信息含有敏感字符！！！</strong>
	</div>

	<div id="captchaerror" class="alert alert-danger hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>输入的验证码不正确！！！</strong>
	</div>

	<div id="blank" class="alert alert-danger hidden" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>存在输入为空的表单项！！！</strong>
	</div>

    <div id="dberror" class="alert alert-danger hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>链接数据库失败，请稍后重试！！！</strong>
	</div>


	<div id="success" class="alert alert-success hidden" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<strong>登陆成功，正在跳转！！！</strong>
	</div>

	<div class="container">
		<ol class="breadcrumb">
			<li>用户中心</a></li>
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
							<h3 class="thin text-center">登录ISDC网站</h3>
							<p class="text-center text-muted">没有账号？没关系，赶紧<a href="./register.php">注册</a>吧!</p>
							<hr />

							<form action="handlelogin.php" method="post" name="form" id="form" class="form-horizontal" role="form">
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
							  <div class="form-group">
							    <label for="checkCode" class="col-sm-2 control-label"><img name="checkcode" src = "b.php" onclick="this.src='b.php?aa='+Math.random()"/></label>
							    <div class="col-sm-10">
							      <input type="text" class="form-control" id="captcha" name="checkCode" placeholder="Check Code">
							    </div>
							  </div>
							  <hr />
							  <div class="form-group text-center">
							      <span id="subbtn" class="btn btn-warning btn-lg">登&nbsp;录</span>
							  </div>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>

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
			var userid = $("#userid").val();
			var passwd = $("#passwd").val();
			var user_captcha = $("#captcha").val();
			if (!userid || !passwd || !user_captcha) {
				$("#blank").toggleClass("hidden");
			}
			else if(userid.contains(" ") || userid.contains("-") || userid.contains("'") || userid.contains("<") || userid.contains(">") || userid.contains("&")) {
				$("#username").toggleClass("hidden");
			} else {
				$.post("handlelogin.php", {user:user_captcha, userid:userid, passwd:passwd}, function(data){
                    console.log(data);
					if (data == "captchaerror") {
						$("#captchaerror").toggleClass("hidden");
					} else if (data == "dberror") {
						$("#dberror").toggleClass("hidden");
					} else if (data == "nouser") {
                        $("#nouser").toggleClass("hidden");
                    } else if (data == "success"){
                        $("#success").toggleClass("hidden");
                        setTimeout(function(){console.log("successfully login");}, 5000);
                        window.location.href="../../index.php";
                    }
				});

			}
		});
	});
</script>
</body>
</html>
