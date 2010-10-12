<?
include 'common.php';
include 'menu.php';
if ($_GET[reload]){
$r=@mysql_query('SELECT * from ftpLog order by logID DESC limit 0,20');
?><meta http-equiv="refresh" content="20" /><?
}else{
$r=@mysql_query('SELECT * from ftpLog order by logID DESC');
}
echo "<table border='1' width='100%'>";
echo "<tr><td>0</td><td>".date('Y-m-d')."</td><td>".date('H:i:j')."</td><td>Current Server Time</td></tr>";

while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
echo "<tr><td>$d[logID]</td><td>$d[logDate]</td><td>$d[logTime]</td><td>$d[logAction]</td></tr>";
}
echo "</table>";
include 'footer.php';
?>