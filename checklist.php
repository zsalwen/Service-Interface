<? include 'common.php';
?>
<style> td {font-size:9px;}</style>

<table><tr>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 0,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 50,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 100,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 150,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 200,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
</tr>
</table>

<table style="page-break-before:always"><tr>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 250,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 300,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 350,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 400,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
<td valign="top">
<?
$r=@mysql_query("select packet_id, date_received from ps_packets order by packet_id limit 450,50");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	echo "<input type='checkbox'> $d[packet_id] - $d[date_received]<br>";
}
?>
</td>
</tr>
</table>
