<div class="nav-agency">
		<div class="navbar navbar-static-top"> 
		<!-- navbar-fixed-top -->
		<div class="navbar-inner">
		<div class="container"><a class="brand" href="/index.html"><img src="/assets/img/logo_dark.png" alt="Logo"></a>
		<div id="main-nav">
		<div class="nav-collapse collapse">
			<ul class="nav">
				<li id="index"><a href="/index.html">首页</a></li>
				<li id="blog"><a href="/blog">博客</a></li>
				<li id=""><a href="">活动</a></li>
				<li id="train"><a href="">训练平台</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:">关于我们 <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="/introduction.html">协会简介</a></li>
						<li><a href="">成员介绍</a></li>
						<li><a href="">联系我们</a></li>
					</ul>
				</li>
			</ul>
		</div>
		</div>
		</div>
		</div>
		</div>
</div>


<script type="text/javascript">
        $(document).ready(function () {

            var showCaseItems = $('.show-case-item').hide();

            var splashes = $('.splash').hide();

            splashes.eq(0).show();
            showCaseItems.eq(0).show();

            var prevIndex = -1;
            var nextIndex = 0;
            var currentIndex = 0;

            $('#banner-pagination li a').click(function () {

                nextIndex = parseInt($(this).attr('rel'));

                if (nextIndex != currentIndex) {
                    $('#banner-pagination li a').html('<img src="/assets/img/slidedot.png" alt="slide"/>');
                    $(this).html('<img src="/assets/img/slidedot-active.png" alt="slide"/>');
                    currentIndex = nextIndex;
                    if (prevIndex < 0) prevIndex = 0;

                    splashes.eq(prevIndex).css({ opacity: 1 }).animate({ opacity: 0 }, 500, function () {
                        $(this).hide();
                    });
                    splashes.eq(nextIndex).show().css({ opacity: 0 }).animate({ opacity: 1 }, 500, function () { });

                    showCaseItems.eq(prevIndex).css({ opacity: 1 }).animate({ opacity: 0 }, 500, function () {
                        $(this).hide();
                        showCaseItems.eq(nextIndex).show().css({ opacity: 0 }).animate({ opacity: 1 }, 200, function () { });
                    });

                    prevIndex = nextIndex;
                }
                return false;
            });

        });
    $(function() {
        $('#train').addClass('active');
    });

    </script>