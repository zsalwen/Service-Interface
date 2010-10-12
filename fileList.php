<?
include 'security.php';
include 'functions-calendar.php';
mysql_connect();
mysql_select_db('core');
if ($_GET['date']){
	$today=$_GET['date'];
}else{
	$today = date('Y-m-d');
}
function id2name($id){
	$q="SELECT name FROM ps_users WHERE id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
return $d[name];
}
function defCount($packet_id){
	$c=0;
	$r=@mysql_query("SELECT name1, name2, name3, name4, name5, name6 from ps_packets WHERE packet_id='$packet_id'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[name1]){$c++;}
	if ($d[name2]){$c++;}
	if ($d[name3]){$c++;}
	if ($d[name4]){$c++;}
	if ($d[name5]){$c++;}
	if ($d[name6]){$c++;}
	return $c;
}
function EVdefCount($eviction_id){
	$c=0;
	$r=@mysql_query("SELECT name1, name2, name3, name4, name5, name6 from evictionPackets WHERE eviction_id='$eviction_id'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[name1]){$c++;}
	if ($d[name2]){$c++;}
	if ($d[name3]){$c++;}
	if ($d[name4]){$c++;}
	if ($d[name5]){$c++;}
	if ($d[name6]){$c++;}
	return $c;
}
?>
<style>
fieldset {
margin:0px;
padding:0px;
		}
legend	{
margin:0px;
padding:0px;
		}
ol	{
margin:0px;
padding:0px;
		}
li	{
margin:0px;
padding:0px;
padding-left:10px;
		}

</style>
<?
if (!$_GET[server]){
	echo "<form><table align='center'><tr><td>Enter Server ID: <input name='server'></td></tr></table></form>";
}else{
	$server=$_GET[server];
	echo "<h2>OTD Post-Service Schedule for $today - ".id2name($server)."'s Files</h2>";
	$q="SELECT DISTINCT circuit_court FROM ps_packets WHERE (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') AND estFileDate >= '$today'";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){?>
		<fieldset>
	<legend><?=$d[circuit_court]?></legend>
	<ol>
	<?
	$q2="SELECT packet_id, date_received, case_no FROM ps_packets WHERE (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') AND estFileDate >= '$today' AND circuit_court='$d[circuit_court]'";
	$x=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
	while ($dx=mysql_fetch_array($x,MYSQL_ASSOC)){
		if ($_COOKIE[psdata][level] == 'Operations'){
			$link="<a href='http://staff.mdwestserve.com/otd/order.php?packet=$dx[packet_id]' target='_Blank'>$dx[packet_id]</a>";
		}else{
			$link="$dx[packet_id]";
		}
		$defCount=defCount($dx[packet_id])
?><li><?=$link?> - <?=$dx[case_no]?> - <?=$defCount?> PAGE(S) X 2 SETS = <?=($defCount*2)?> PAGES TOTAL</li><?
}
	?>	
	</ol>
	</fieldset>
	<?
	}
	echo "<h2>EV Post-Service Schedule for $today - ".id2name($server)."'s Files</h2>";
	$q="SELECT DISTINCT circuit_court FROM evictionPackets WHERE (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') AND estFileDate >= '$today'";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){?>
		<fieldset>
	<legend><?=$d[circuit_court]?></legend>
	<ol>
	<?
	$q2="SELECT eviction_id, date_received, case_no FROM evictionPackets WHERE (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') AND estFileDate >= '$today' AND circuit_court='$d[circuit_court]'";
	$x=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
	while ($dx=mysql_fetch_array($x,MYSQL_ASSOC)){
		if ($_COOKIE[psdata][level] == 'Operations'){
			$link="<a href='http://staff.mdwestserve.com/ev/order.php?packet=$dx[eviction_id]' target='_Blank'>$dx[eviction_id]</a>";
		}else{
			$link="$dx[eviction_id]";
		}
		$EVdefCount=EVdefCount($dx[eviction_id])
?><li><?=$link?> - <?=$dx[case_no]?> - <?=$EVdefCount?> PAGE(S) X 2 SETS = <?=($EVdefCount*2)?> PAGES TOTAL</li><?
}
	?>	
	</ol>
	</fieldset>
	<?
	}
}?>
<script>document.title='Post-Service Document List For <?=$today?>'</script>