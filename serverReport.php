<?
include 'common.php';


include 'menu.php';
function psTotalPosted($serverID){

	$r = mysql_query("SELECT packet_id FROM ps_history where action_type = 'Posted Papers' and serverID = '$serverID' ");
	$a = mysql_num_rows($r);
	return $a;
}
function psTotalServed($serverID){
	$r = mysql_query("SELECT packet_id FROM ps_history where action_type = 'Served Resident' and serverID = '$serverID' ");
	$b = mysql_num_rows($r);

	$r = mysql_query("SELECT packet_id FROM ps_history where action_type = 'Served Defendant' and serverID = '$serverID' ");
	$c = mysql_num_rows($r);
	$served = $b + $c;
	return $served;
}
?>
<table width="100%" align="center" border="1" style="border-collapse:collapse">
<?
$q="SELECT * from ps_users where level = 'Gold Member'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$served=psTotalServed($d[id]);
	$posted=psTotalPosted($d[id]);
	if (($served > '0') && ($posted > '0')){
?>
<tr>
	<td><?=$d[name]?></td>
    <td>Posted: <?=$posted?></td>
    <td>Served: <?=$served?></td>
    <td>Server Grade: <?=(number_format($served/($served+$posted), 2))*100;?>%</td>
</tr>
<?
}
} ?>
</table>
<?
include 'footer.php';

?>