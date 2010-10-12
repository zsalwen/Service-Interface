<?
include 'common.php';
include 'lock.php';

include 'menu.php';
?><ol><?
$r=@mysql_query("select * from ps_history where action_type = 'Posted Papers'");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	$q="update ps_packets set service_status='MAILING AND POSTING' where packet_id = '$d[packet_id]' and service_status = 'IN PROGRESS'";
	//@mysql_query($q);
	echo "<li>".$q."</li>";
}
?></ol><?
include 'footer.php';
?>