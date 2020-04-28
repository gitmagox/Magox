<?php
define(M_APP_NAME,'App');

include 'MagoxPHP/begin.php';

// 测试数据库操作
$tag = array();
$tag['tname']='geyan';
$db = M('tags');
$data = $db->add($tag);
$updates = array();
$updates['title'] = 'hohohftetrrttro';
$up = $db->where( array('tid'=>array('eq',30)) )->add($updates);
$del = $db->where( array('tname'=>array('eq','geyan')) )->del();

p($data);
p($up);
P($del);