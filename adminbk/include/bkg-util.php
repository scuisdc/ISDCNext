<?php
/**
 * Created by PhpStorm.
 * User: Rune
 * Date: 2015/6/3
 * Time: 18:04
 */

function check_db_error($db) {
    if ($db->connect_errno) {
        echo "数据库连接失败！";
    }
}