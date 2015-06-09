<? session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php $select_column_name = '提交建议'; echo $select_column_name;?> 四川大学信息安全与网络攻防协会</title>
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
                
				<p>想提点建议什么的？尽管写下来吧！</p>
                <br />
                <form method="post" id="suggest_form">
                    <div class="row">
				        <div class="col-sm-6">
				            <input class="form-control" type="text" name="fname" id="name" placeholder="姓名">
				        </div>
				        <div class="col-sm-6">
				            <input class="form-control" type="text" name="email" id="mail" placeholder="邮箱">
				        </div>
				    </div>
				    <br>
				    <div class="row">
				        <div class="col-sm-12">
				            <textarea name="message" id="message" placeholder="将你想说的都写下来吧" class="form-control" rows="9"></textarea>
				        </div>
				    </div>
				    <br>
				    <div class="row">
				        <div class="col-sm-12 text-right">
				            <input class="btn btn-warning" type="submit" value="提交" onclick="submit_suggest()">
				        </div>
				    </div>
				</form> 
            </article>
		</div>
    </div>
</body>
<?php require $_SERVER["DOCUMENT_ROOT"].'/footer.inc.php'; ?>
<script src="/assets/js/suggest.js"></script>
</html>