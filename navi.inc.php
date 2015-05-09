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
                                    <li %s><a href="#">训练中心</a></li>
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
                                </ul>
                            </div>';
            $nav_list_template = '<li><a href="%s">%s</a></li>';
            
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

            echo sprintf($nav_template, $_home_class, $_blog_class, $_train_class, $_service_class, $service, $_about_class, $intro);
        ?>
    </div>
</div>