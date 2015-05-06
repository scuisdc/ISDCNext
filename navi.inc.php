<?php
echo "<div class=\"navbar navbar-inverse navbar-fixed-top headroom\" >
		<div class=\"container\">
			<div class=\"navbar-header\">
				<!-- Button for smallest screens -->
				<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\"><span class=\"icon-bar\"></span> <span class=\"icon-bar\"></span> <span class=\"icon-bar\"></span> </button>
				<a class=\"navbar-brand\" href=\"/index.php\"><img src=\"/assets/images/logo.png\"></a>
			</div>
			<div class=\"navbar-collapse collapse\">
				<ul class=\"nav navbar-nav pull-right\">
					<li class=$_home_class ><a href=\"/index.php\">首页</a></li>
					<li class=$_blog_class><a href=\"/blog\">博客</a></li>
					<li class=$_train_class><a href=\"/train\">训练中心</a></li>
					<li class=$_game_class+\" dropdown\">
						<a class=\"dropdown-toggle\" data-toggle=\"dropdown\">公共服务<b class=\"caret\"></b></a>
						<ul class=\"dropdown-menu\">
							<li><a href=\"#\">竞赛信息</a></li>
							<li><a href=\"#\">安全图书馆</a></li>
							<li><a href=\"/services/\">教务算分</a></li>
						</ul>
					</li>
					<li class=$_about_class>
						<a class=\"dropdown-toggle\" data-toggle=\"dropdown\">关于我们<b class=\"caret\"></b></a>
						<ul class=\"dropdown-menu\">
							<li><a href=\"/introduction.php\">社团简介</a></li>
							<li><a href=\"/finace.php\">财务规范</a></li>
							<li><a href=\"#\">成员介绍</a></li>
							<li><a href=\"/contact.php\">联系我们</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>";
?>