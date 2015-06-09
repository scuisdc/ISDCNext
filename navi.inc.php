<? session_start(); ?>

<div class="navbar navbar-inverse navbar-fixed-top headroom" >
    <div class="container">
        <div class="navbar-header">
            <!-- Button for smallest screens -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="/index.php"><img src="/assets/images/logo.png"></a>
        </div>
        
        <?php
            $ps = new GloriousDB(DBConfig::$DB_host, DBConfig::$DB_PS_User, DBConfig::$DB_PS_Pass, DBConfig::$DB_PS_Name);
            
            $nav_template = '<div class="navbar-collapse collapse">
                                <ul class="nav navbar-nav pull-right">
                                    <li %s><a href="/index.php">首页</a></li>
                                    <li %s><a href="#">博客</a></li>
                                    <li %s>
                                        <a class="dropdown-toggle" data-toggle="dropdown">训练中心<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="">Online Judge</a></li>
                                            <li><a href="">ISDCTF</a></li>
                                        </ul>
                                    </li>
                                    <li %s>
                                        <a class="dropdown-toggle" data-toggle="dropdown">公共服务<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            %s
                                        </ul>
                                    </li>
                                    <li %s>
                                        <a class="dropdown-toggle" data-toggle="dropdown">关于我们<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            %s
                                        </ul>
                                    </li>
                                    
                                    <form class="navbar-form navbar-left" role="search">
                                        <div class="form-group">
                                            <input type="text" class="nav-form-control" placeholder="Search" required>
                                        </div>
                                    </form>
                                    %s
                                </ul>
                            </div>';
            $nav_list_template = '<li><a href="%s">%s</a></li>';
            $user_info_template = '<li>
                                    <a class="dropdown-toggle" data-toggle="dropdown">%s<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="">用户中心</a></li>
                                        %s
                                        <hr />
                                        <li><a href="./usercenter/logreg/signout.php">注销</a></li>
                                    </ul>
                                </li>';
            $login_template = '<li><a href="/usercenter/logreg/login.php">登录/注册</a></li>';
            
            $ps->setTable('service');
            $services = $ps->findall();
            $ps->destroy();
            
            $service = '';
            for ($i=0; $i<count($services); $i++) {
                if (!$services[$i]['enable'])
                    continue;
                
                $service_name = $services[$i]['name'];
                if (array_key_exists("path", $services[$i]))
                    $path = '/services/' .$services[$i]['path'];
                else
                    $path = '#';
                
                $service .= sprintf($nav_list_template, $path, $service_name);
            }

            $cms = new GloriousDB(DBConfig::$DB_host, DBConfig::$DB_CMS_User, DBConfig::$DB_CMS_Pass, DBConfig::$DB_CMS_Name);

            $cms->setTable('intro_column');
            $intros = $cms->findall();
            $cms->destroy();

            $intro = '';
            for ($i=0; $i<count($intros); $i++) {
                if (!$intros[$i]['enable'])
                    continue;
                
                $column_name = $intros[$i]['name'];
                if (array_key_exists("path", $intros[$i]))
                    $path = '/intro/' . $intros[$i]['path'];
                else
                    $path = '#';
                
                $intro .= sprintf($nav_list_template, $path, $column_name);
            }

            if(isset($_SESSION['valid_user'])) {
                $userid = $_SESSION['valid_user'];
                
                $uc = new GloriousDB(DBConfig::$DB_host, DBConfig::$DB_UC_User, DBConfig::$DB_UC_Pass, DBConfig::$DB_UC_Name);
                $uc->setTable('user');
                $uc->where(['username' => $userid]);
                $user = $uc->find('*')[0];
                if ($user['privilege'] != 0 && $user['privilege'] != 1) {
                    $ifPrivilege = '<li><a href="">后台管理</a></li>';
                } else {
                    $ifPrivilege = '';
                }
                $userInfo = sprintf($user_info_template, $userid, $ifPrivilege);
            } else {
                $userInfo = $login_template;
            }

            echo sprintf($nav_template, $_home_class, $_blog_class, $_train_class, $_service_class, $service, $_about_class, $intro, $userInfo);
        ?>
    </div>
</div>