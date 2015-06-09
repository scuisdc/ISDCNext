<!DOCTYPE html>
<html lang="en">

<head>
    <title>四川大学信息安全与网络攻防协会</title>
    <?php require('./header.inc.php'); ?>
</head>

<body class="home">
    <?php
        $_home_class='class="active"'; $_blog_class='';$_train_class=$_service_class=$_about_class='class="dropdown"';
        
        require('./navi.inc.php');
        
        $cms = new GloriousDB(DBConfig::$DB_host, DBConfig::$DB_CMS_User, DBConfig::$DB_CMS_Pass, DBConfig::$DB_CMS_Name);

        // Slides
        $cms->setTable("index_banner");
        $banners = $cms->findall();

        $indicator_template = '<li data-target="#carousel-example-generic" data-slide-to="%d" %s></li> ';
        $item_template = '
            <div class="item %s">
                <header id="head" style="background: %s no-repeat; background-size:cover">
                <div class="container">
                    <div class="row">
                        <h1 class="lead">%s</h1>
                        <p class="tagline">%s</p>
                        <p><a class="btn btn-warning btn-lg" role="button" href="%s">%s</a></p>
                    </div>
                </div>
                </header>
            </div>';

        $slides = '<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">';
        $indicators = '<ol class="carousel-indicators">';
        $items = '<div class="carousel-inner" role="listbox">';

        $first_flag = 1;
        for ($i=0; $i < count($banners); $i++) {
            if (!$banners[$i]['enable'])
                continue;
            
            $banner_id = $i;
            $banner_title = $banners[$i]['title'];
            $banner_subtitle = $banners[$i]['subtitle'];
            $banner_btntext = $banners[$i]['button_text'];
            $banner_btnurl = $banners[$i]['button_link'];
            if (array_key_exists('bg_pic_path', $banners[$i])) {
                $banner_bg = $banners[$i]['bg_pic_path'];
                if (substr($banner_bg, 0, 1) != '#')
                    $banner_bg = 'url(' . $banners[$i]['bg_pic_path'] . ')';
            } else {
                $banner_bg = '#181015';
            }
            
            if ($first_flag) {
                $first_flag = 0;
                $indicators .= sprintf($indicator_template, $banner_id, 'class=active');
                $items .= sprintf($item_template, 'active', $banner_bg, $banner_title,  $banner_subtitle, $banner_btnurl, $banner_btntext);
            } else {
                $indicators .= sprintf($indicator_template, $banner_id, '');
                $items .= sprintf($item_template, '', $banner_bg, $banner_title,  $banner_subtitle, $banner_btnurl, $banner_btntext);
            }
        }

        $indicators .= "</ol>";
        $items .= "</div>";
        $slides .= $indicators . $items . "</div>";

        echo $slides;
    ?>

    <div class="container text-center">
        <br>
        <br>
        <h3 class="thin">A WAY TO HACKER!</h3>
        <p class="text-muted">无关乎基础与天赋，只在乎你是否一往无前</p>
    </div>

    <div class="jumbotron top-space">
        <div class="container">
            <h2 class="text-center thin">这学期我们都做些什么</h2>
            <h5 class="text-center thin">先甭管计划赶不赶得上变化，但没有计划就是寸步难行</h5>
            <div class="row">
                <div class="col-md-3 col-sm-6 highlight">
                    <div class="h-caption">
                        <h4><i class="fa fa-cogs fa-5"></i>基础技能学习</h4>
                    </div>
                    <div class="h-body text-center">
                        <p>打实基础技能是最为重要的一步，不好高、不骛远、不激进。我们每周六的授课将从算法数据结构与计算机网络切入，打实基础技能。</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 highlight">
                    <div class="h-caption">
                        <h4><i class="fa fa-flash fa-5"></i>信息安全入门</h4>
                    </div>
                    <div class="h-body text-center">
                        <p>只有实践才是最好的掌握方式，我们要深刻贯彻这一点。每周日下午的信息安全实践，从信息获取到漏洞发掘再到信息隐藏，Let's Hack。</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 highlight">
                    <div class="h-caption">
                        <h4><i class="fa fa-heart fa-5"></i>精彩活动继续</h4>
                    </div>
                    <div class="h-body text-center">
                        <p>我们将会邀请工作一线的前辈们来传传道，邀请数字图像、软件工程协会的老师们学长们来通通气。并且素拓、聚餐一个都不少。</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 highlight">
                    <div class="h-caption">
                        <h4><i class="fa fa-flag fa-5"></i>竞赛能力丰收</h4>
                    </div>
                    <div class="h-body text-center">
                        <p>何愁没有机会展现自己，我们将会尽量详细的提供信息安全类比赛的信息，并且在允许的范围内提供尽可能的帮助。让大家都有机会能够参与其中。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        // Course
        $cms->setTable("course_semester");
        $semesters = $cms->findall();

        $semester_template = '<h2 class="text-center top-space">%s年%s时间安排</h2><br>';
        $table_template = '<div class="row">
                    <h3>%s</h3>
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th width="10%%">周数</th>
                                <th width="12%%">日期</th>
                                <th width="14%%">时间</th>
                                <th width="12%%">主讲人</th>
                                <th width="30%%">主讲内容</th>
                                <th width="22%%">资料</th>
                            </tr>
                            %s
                        </tbody>
                    </table>
                </div>';
        $td_template = '<tr %s>
                        <td>第%s周</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        </tr>';
        $data_template = '<a href="%s">%s</a> ';

        $course = '<div class="container">';
        
        $current_date = strtotime(date('Y-m-d'));
        for ($i=0; $i<count($semesters); $i++) {
            
            if (!$semesters[$i]['enable']) {
                continue;
            }
            
            $start_time = strtotime($semesters[$i]['start_time']);
            $end_time = strtotime($semesters[$i]['end_time']);
            if ($current_date <= $start_time || $current_date >= $end_time)
                continue;
            
            $semester_id = $semesters[$i]['ID'];
            $year = $semesters[$i]['year'];
            $semester_type = $semesters[$i]['semester'];
            switch ($semester_type) {
                case 0:
                    $semester_chinese = '秋季学期';
                    break;
                case 1:
                    $semester_chinese = '春季学期';
                    break;
                case 2:
                    $semester_chinese = '寒假';
                    break;
                case 3:
                    $semester_chinese = '暑假';
                    break;
                default:
                    $semester_chinese = '未知学期';
                    break;
            }
            $semester = sprintf($semester_template, $year, $semester_chinese);
            $course .= $semester;
            
            
            $cms->setTable('course_part');
            $cms->where(['semester_ID' => $semester_id]);
            $parts = $cms->find();
            
            $part = '';
            for ($j=0; $j<count($parts); $j++) {
                if (!$parts[$j]['enable'])
                    continue;
                
                $part_id = $parts[$j]['ID'];
                $part_name = $parts[$j]['name'];
                
                $cms->setTable('course_schedule');
                $cms->where(['part_ID' => $part_id]);
                $schedules = $cms->find();
                
                $schedule = '';
                $previous_day = strtotime('00:00:00');
                for ($k=0; $k<count($schedules); $k++) {
                    if (!$schedules[$k]['enable'])
                        continue;
                    
                    $schedule_id = $schedules[$k]['ID'];
                    $week = $schedules[$k]['week'];
                    $day = strtotime($schedules[$k]['day']);
                    $start_time = strtotime($schedules[$k]['start_time']);
                    $end_time = strtotime($schedules[$k]['end_time']);
                    $host = $schedules[$k]['host'];
                    $content = $schedules[$k]['content'];
                    
                    $date = date('n月j日', $day);
                    if ($start_time == strtotime('00:00:00') || $end_time == strtotime('00:00:00'))
                        $time = 'N/A';
                    else
                        $time = date('H:i', $start_time) . '-' . date('H:i', $end_time);
                    
                    if ($current_date <= $day && $current_date > $previous_day)
                        $if_this_week = 'class="success"';
                    else
                        $if_this_week = '';
                    $previous_day = $day;
                    
                    $cms->setTable('course_data');
                    $cms->where(['schedule_ID' => $schedule_id]);
                    $datas = $cms->find();
                    
                    $data = '';
                    for ($l=0; $l<count($datas); $l++) {
                        if (!$datas[$l]['enable'])
                            continue;
                        
                        $file_path = $datas[$l]['file_path'];
                        $type = $datas[$l]['type'];
                        switch ($type) {
                            case 0:
                                $type_chinese = 'PPT';
                                break;
                            case 1:
                                $type_chinese = '资料';
                                break;
                            case 2:
                                $type_chinese = '前期准备';
                                break;
                            case 3:
                                $type_chinese = '作业';
                                break;
                            case 4:
                                $type_chinese = '解答';
                                break;
                            default:
                                $type_chinese = '其他';
                                break;
                        }
                        
                        $data .= sprintf($data_template, $file_path, $type_chinese);
                    }
                    
                    $schedule .= sprintf($td_template, $if_this_week, $week, $date, $time, $host, $content, $data);
                }
                
                $part .= sprintf($table_template, $part_name, $schedule);
            }
            
            $course .= $part;
        }

        $course .= '</div>';

        echo $course;
    ?>
</body>

<?php require('./footer.inc.php'); ?>
</html>