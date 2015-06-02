<?php
/**
 * Created by PhpStorm.
 * User: secondwtq
 * Date: 15-3-19
 * Time: 下午4:24
 */

function ioj_check_db_error() {
    if (mysqli_connect_errno()) {
        echo "数据库连接失败！";
    }
}

function ioj_path_join() {
    $args = func_get_args();
    $paths = array();
    foreach ($args as $arg) {
        $paths = array_merge($paths, (array)$arg); }
    $paths = array_map(create_function('$p', 'return trim($p, "/");'), $paths);
    $paths = array_filter($paths);
    return join('/', $paths);
}