<?
include 'common.php';
include 'lock.php';



include 'menu.php';

$r=@mysql_query("select * from knownip order by hits DESC limit 0,10");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	echo "<fieldset style='border:double 5px;'><legend>$d[ip] x $d[hits] @ $d[lastSeen]</legend>$d[whois]</fieldset>";
}
include 'footer.php';

?>