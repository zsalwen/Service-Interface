<?
include 'common.php';
include 'lock.php';
//include 'menu.php';
?>
<style>
td {font-size:10px}

</style>
<?
$i=0;
//opLog($_COOKIE[psdata][name]." Loaded System Log");
$q="select * from syslog order by logTime DESC limit 0,15";
$r=@mysql_query($q);
echo "<table width='100%'><tr><td><table width='100%'><tr><td>".date('Y-m-d H:i:j').'</td><td>Current System Time</td></tr>
';
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ $i++;
echo "<tr bgcolor='".row_color($i,'ffcccc','ffffcc')."'><td nowrap='nowrap'>$d[logTime]</td><td nowrap='nowrap'>$d[event]</td></tr>
";
}
echo "</table></td><td>";

$q="select * from syslog order by logTime DESC limit 15,15";
$r=@mysql_query($q);
echo "<table width='100%'><tr><td>".date('Y-m-d H:i:j').'</td><td>Current System Time</td></tr>
';
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ $i++;
echo "<tr bgcolor='".row_color($i,'ffcccc','ffffcc')."'><td nowrap='nowrap'>$d[logTime]</td><td nowrap='nowrap'>$d[event]</td></tr>
";
}
echo "</table></td></tr></table>";
//include 'footer.php';
?>
<meta http-equiv="refresh" content="600" />





