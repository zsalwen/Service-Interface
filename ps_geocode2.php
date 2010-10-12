<?
include 'functions.php';
echo db_connect('delta.mdwestserve.com','intranet','root','zerohour'); 
	$q = "SELECT * FROM ps_users where id ='$_GET[id]'";
	$r = @mysql_query ($q) or die(mysql_error());
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	$makeLnL = $d[address].", ".$d[city].", ".$d[state]." ".$d[zip];
	$lnl = getLnL($makeLnL);
	$q = "UPDATE ps_users set lat='$lnl[2]', lng='$lnl[3]' where id ='$_GET[id]'";
	$r = @mysql_query ($q) or die(mysql_error());
?>
<script>
self.close()
</script>
