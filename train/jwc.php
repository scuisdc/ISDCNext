
<?php

header("content-Type: text/html; charset=Utf-8"); 
require_once('Parser.php');


function getPt($scores)
{
	if($scores >= 95){return 4;}
	else if($scores >= 90){return 3.8;}
	else if($scores >= 85){return 3.6;}
	else if($scores >= 80){return 3.2;}
	else if($scores >= 75){return 2.7;}
	else if($scores >= 70){return 2.2;}
	else if($scores >= 65){return 1.7;}
	else if($scores >= 60){return 1.0;}
	else return 0;
}

$login_url = 'http://202.115.47.141/loginAction.do';

$zjh = $_POST['zjh'];
$mm = $_POST['mm'];


$postvar['zjh'] = $zjh;
$postvar['mm'] = $mm;

$cookie_file = tempnam('./temp','cookie');
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_URL, $login_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postvar);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
curl_exec($ch);
curl_close($ch);
/*set the option of the curl function */
$send_url='http://202.115.47.141/gradeLnAllAction.do?type=ln&oper=sxinfo&lnsxdm=001#qb_001?type=ln&oper=sxinfo&lnsxdm=001#qb_001';
$ch = curl_init($send_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
$contents = curl_exec($ch);
curl_close($ch);
unlink($cookie_file);

$contents = mb_convert_encoding($contents, "utf8", "gb2312");
use HtmlParser\Parser;

$htmlparser = new Parser($contents);
$body_array = $htmlparser->find('td[align=center]');

$count = 0;

$length = count($body_array);
$j = 0;


for($i = 0; $i < $length; $i ++)
{
	$temp = $body_array[$i]->getPlainText();
	if($i % 7 != 1 && $i % 7 != 3)
	{
		$printoutarr[$j] = $temp;
		$j ++;
	}
}


$sum = 0;
$points = 0;
$GPA_scores = 0;
$GPA = 0;
$avg = 0;
$j = 0;
for ($i = 3; $i < count($printoutarr); $i += 5)
{
	if(strcmp($printoutarr[$i], "必修") == 0)
	{
		$number[$j] = $printoutarr[$i - 1];
		$number[$j + 1] = $printoutarr[$i + 1];
		$j += 2;
	}
}

echo "<br >";
$index = 0;
while($index < count($number))
{
	$sum += intval($number[$index]) * intval($number[$index + 1]);
	$GPA_scores += intval($number[$index])*getPt($number[$index + 1]);
	$points += intval($number[$index]);
	$index += 2;
}

$avg = number_format($sum / $points, 2);
$GPA = number_format($GPA_scores / $points, 2);

/*
 * 接下来这部分用于打印出所有的成绩信息
 * 
 * */
 
$length = count($printoutarr); 
$count = 0;

echo "课程号  课程名  学分  情况  成绩<br />";

for($i = 0; $i < $length; $i ++)
{
	$count ++;
	if($count % 5 == 0)
	{
		echo $printoutarr[$i];
		echo "<br />";
	}
	else {
		echo $printoutarr[$i];
		echo "&nbsp;&nbsp;";
	}
}

echo "<br />加权平均分为".$avg."<br />";
echo "<br />GPA分数为".$GPA."<br />";

?>
