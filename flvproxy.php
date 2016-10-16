<?php

if($_GET['url']) {
	$fullpath = escapeshellarg($_GET['url']);
	$cmd = "/usr/local/bin/ffmpeg -i ${fullpath} -f flv -ar 22050 -ac 1 -ab 64 -b 480 -async 1 -deinterlace -g 250 - 2>/dev/null";
	header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
	header('Content-Type: video/x-flv');
	header('Content-Disposition: attachment; filename="compressed_stream.flv"');
	header(sprintf('Content-length: %d', 100000000));
	do_this($cmd);
}

function do_this($command) {
	$counting_size = 0;
	$proc = popen($command, "r");
	if(!$proc) return 1;
	while($data = fread($proc, 4096)) {
		set_time_limit(30);
		$counting_size += strlen($data);
		print $data;
		flush();
	}
	pclose($proc);
	return 0;
}

?>