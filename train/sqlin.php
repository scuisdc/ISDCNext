<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/5/30
 * Time: 14:37
 */

function sqlin($str){
    $str = str_replace("|","",$str);
    $str = str_replace(",","",$str);
    $str = str_replace("&","",$str);
    $str = str_replace("=","",$str);
    $str = str_replace(" ","",$str);
    $str = str_replace(";","",$str);
    return $str;

}