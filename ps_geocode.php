<?
include '../common/functions.php';
echo db_connect('delta.mdwestserve.com','intranet','root','zerohour'); 
	$q = "SELECT * FROM ps_packets where packet_id ='$_GET[id]'";
	$r = @mysql_query ($q) or die(mysql_error());
	$i=0;
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		while ($i < 4){$i++;
			$makeLnL = strtoupper($d["address$i"]).', '.strtoupper($d["city$i"]).', '.strtoupper($d["state$i"]).' '.strtoupper($d["zip$i"]);
			echo $makeLnL.'<br>';
			$lnl = getLnL($makeLnL);
			$j = 0;
			while ($j <= count($lnl)){
				echo $lnl[$j].'<br>';
				$j++;
			}
			$q2 = "UPDATE ps_packets set lat$i='$lnl[2]', lng$i='$lnl[3]' where packet_id ='$_GET[id]'";
			$r2 = @mysql_query ($q2) or die(mysql_error());
		}
	}
?>
<script>self.close()</script>