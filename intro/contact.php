<? session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php $select_column_name = '联系我们'; echo $select_column_name;?> 四川大学信息安全与网络攻防协会</title>
    <?php require $_SERVER["DOCUMENT_ROOT"].'/header.inc.php'; ?>
</head>

<body class="home">
    <?php
        $_home_class=$_blog_class=$_train_class=''; $_service_class='class="dropdown"'; $_about_class='class="active dropdown"';
        
        require $_SERVER["DOCUMENT_ROOT"].'/navi.inc.php';
    ?>

	<header id="head" class="secondary"></header>

	<div class="container">
		<ol class="breadcrumb">
			<li>关于我们</a></li>
			<li class="active"><?php echo $select_column_name; ?></li>
		</ol>

		<div class="row">
		
		    <?php require('./intro-aside.php'); ?>
			
			<article class="col-sm-9 maincontent">

				<header class="page-header">
					<h1 class="page-title"><?php echo $select_column_name; ?></h1>
                </header>
                
                <h4>微信 / Weixin</h4>
				<p>进退之间</p>
                <hr />
                <h4>微博 / Weibo</h4>
                <p>http://weibo.com/scuisdc</p>
                <hr />
                <h4>邮箱 / E-Mail</h4>
                <p>info[at]scuisdc.com(将[at]替换为@)</p>
                <hr />
                <h4>GitHub</h4>
                <p>https://github.com/scuisdc</p>
            </article>
		</div>
    </div>
</body>
<?php require $_SERVER["DOCUMENT_ROOT"].'/footer.inc.php'; ?>
</html>