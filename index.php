<?php

require 'config.php';

$result = mysql_query("SELECT * FROM channels WHERE 1");
$chlist = array();
while($row = mysql_fetch_assoc($result)) $chlist[$row['id']] = $row;

$ch = (int) (isset($_GET['ch'], $chlist[$_GET['ch']]) ? $_GET['ch'] : '1');
$q  = (int) (isset($_GET['q'],  $qlist[$_GET['q']])   ? $_GET['q']  : '0');
$no_channel = false;

$row = $chlist[$ch];
$ch_name = $row['name'];
$ch_id = $row['id'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=UTF-8">
<META NAME="AUTHOR" CONTENT="Roman Gemini">
<META NAME="CREATED" CONTENT="20110526;10190900">
<link rel="stylesheet" href="/style.css" type="text/css">
<title><?php echo $ch_name; ?> - TV-proxy v1.2</title>
</HEAD>
<BODY>

<div class="contents">
<!-- PAGE BEGIN -->

<TABLE class="inlay" style="width:100%; border-collapse:collapse;">
<TR><TD colspan="2" style="text-align:left; background:#ddd;"><span class="title">TV-proxy v1.2</span><br>Канал: <b><?php echo $ch_name; ?></b></TD></TR>
<TR><TD style="width:auto; text-align:center; vertical-align:top;">
<?php $stream_link = urlencode("/tv/${ch_id}.flv?q=${q}"); ?>
<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' id='player1' name='player1'>
   <param name='movie' value='/uppod.swf'>
   <param name='allowfullscreen' value='true'>
   <param name='allowscriptaccess' value='always'>
   <embed id='player1'
          name='player1'
          src='/uppod.swf'
          width='576px'
          height='432px'
          allowscriptaccess='always'
          allowfullscreen='true'
          flashvars='m=video&file=<?php echo $stream_link; ?>&auto=play'
   />
</object>
</TD>
<TD style="width:180px; text-align:left; background:#ddd; vertical-align:top;">
<B>Стискання потоку:</B>
<?php
foreach($qlist as $key => $pos) {
	if($q == $key)
		echo "<li><b>[" . $pos . "]</b></li>";
	else
		echo "<li><a href='/ch-${ch}?q=${key}'>" . $pos . "</a></li>";
}
?>
<br>
<B>Список каналів:</B><BR>
<?php
$result = mysql_query("select * from `channels` where 1 ORDER BY `name`");
if($result) {
	while($row = mysql_fetch_assoc($result)) {
		if($row['id'] != $ch)
			echo "<li><a href='ch-${row['id']}?q=${q}'>${row['name']}</a></li>";
		else
			echo "<li><b>[${row['name']}]</b></li>";
	}
}
?>
</TD>
</TR>
<TR><TD colspan="2" style="text-align:center; background:#ddd;">TV-proxy v1.2 on <a href="http://tv.tedirens.com">tv.tedirens.com</a></TD></TR>
</TABLE>

<!-- PAGE END -->
</div>

</BODY>
</HTML>