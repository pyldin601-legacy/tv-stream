<?php

global $cfg, $link, $qlist;

$cfg['db_host'] = 'localhost';
$cfg['db_user'] = 'root';
$cfg['db_pass'] = 'GDk4F/so';
$cfg['db_path'] = 'tvproxy';

$cfg['lq_size'] = '240x180';
$cfg['lq_vbr']  = '160k';
$cfg['lq_abr']  = '32k';

$cfg['log'] = $_SERVER['DOCUMENT_ROOT'] . '/log';

$qlist = array(-1 => '64K audio', 0 => '320K', 1 => '512K', 2 => 'SAMEQ');

$link = mysql_connect($cfg['db_host'], $cfg['db_user'], $cfg['db_pass']);

mysql_select_db($cfg['db_path'], $link);
mysql_query("set names 'utf8'");

function db_close() {
	global $link;
	mysql_close($link);
}

?>