<?php

$cms = new GloriousDB(DBConfig::$DB_host, DBConfig::$DB_CMS_User, DBConfig::$DB_CMS_Pass, DBConfig::$DB_CMS_Name);

$cms->setTable('intro_column');
$intros = $cms->findall();
$cms->destroy();

$sidebar_template = '
   <aside class="col-md-2 sidebar">
    <ul class="nav nav-side">
        %s
    </ul>
   </aside>';
$list_select_template = '<li class="selected"><a>%s<b></b></a></li>';
$list_template = '<li><a href="%s">%s</a></li>';

$intro = '';
for ($i=0; $i<count($intros); $i++) {     
    if (!$intros[$i]['enable'])
        continue;
                
    $column_name = $intros[$i]['name'];
    if (array_key_exists("path", $intros[$i]))
        $path = './' . $intros[$i]['path'];
    else
        $path = '#';
    
    if ($column_name == $select_column_name)
        $intro .= sprintf($list_select_template, $column_name);
    else
        $intro .= sprintf($list_template, $path, $column_name);
}

echo sprintf($sidebar_template, $intro);

?>