<?php
define(APP_NAME,'App');

include 'MagoxPHP/begin.php';

// 测试数据库操作
$tag = array();
$tag['tname']='geyan';
$db = M('tag');
$data = $db->add($tag);
$updates = array();
$updates['tname'] = 'hohohftetrrttro';
$up = $db->where( array('tid'=>array('eq',30)) )->create($updates,'update')->save();
$del = $db->where( array('tname'=>array('eq','geyan')) )->del();

p($data);
p($up);
P($del);