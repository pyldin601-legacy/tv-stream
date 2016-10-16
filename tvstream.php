<?php

require 'config.php';

$result = mysql_query("SELECT * FROM channels WHERE 1");

$chlist = array();

while($row = mysql_fetch_assoc($result)) $chlist[$row['id']] = $row;

$ch = (int) (isset($_GET['ch'], $chlist[$_GET['ch']]) ? $_GET['ch'] : '1');
$q  = (int) (isset($_GET['q'],  $qlist[$_GET['q']])   ? $_GET['q']  : '0');

$ch_name   = $chlist[$ch]['name'];
$ch_short  = $chlist[$ch]['ch'];
$ch_id     = $chlist[$ch]['id'];
$ch_url    = $chlist[$ch]['url'];
$ch_ref    = $chlist[$ch]['referer'];
$ch_asp    = $chlist[$ch]['aspect'];

$client = $_SERVER['REMOTE_ADDR'];
$log = $cfg['log'];

$ffmpeg_params = array('ar' => "44100",	'ac' => "1", 'ab' => "64k", 'b'	=> "320k", 'maxrate' => "320k",	'bufsize' => "128k", 'g' => 1000, 'f' => "flv");

if($q == 0) {
	$resolution = "240x" . (int) (240 / $ch_asp);
	$command_line = "/usr/local/bin/ffmpeg -i ${ch_url} -ar 44100 -ac 2 -ab 96k -b 320k -maxrate 320k -bufsize 128k -s $resolution -g 1000 -f flv -";
} elseif($q == 1) {
	$resolution = "384x" . (int) (384 / $ch_asp);
	$command_line = "/usr/local/bin/ffmpeg -i ${ch_url} -ar 44100 -ac 2 -ab 128k -b 400k -s $resolution -g 1000 -f flv -";
} elseif($q == 2)
	$command_line = "/usr/local/bin/ffmpeg -i ${ch_url} -acodec copy -vcodec copy -f flv -";


header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
header('Content-Type: video/x-flv');
header('Content-Disposition: attachment; filename="television_channel_' . $ch_short . '.flv"');

do_this($command_line);

function do_this($command) {
	$proc = popen($command, "r");
	if(!$proc) return 1;
	while($data = fread($proc, 4096)) {
		$counting_size += strlen($data);
		echo $data;
		flush();
	}
	pclose($proc);
}

?>