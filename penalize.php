<?
mysql_connect();
mysql_select_db('core');
include 'common.php';
function serverList2($packet,$table,$idType){
	$list='';
	$i=0;
	$q="SELECT server_id, server_ida, server_idb, server_idc, server_idd, server_ide FROM $table WHERE $idType='$packet' LIMIT 0,1";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	if ($d[server_id] != 218 && $d[server_id] != ''){$i++;
		$list .= "<option value='$d[server_id]'>".id2name($d[server_id])."</option>";
	}
	foreach(range('a','e') as $letter){
		$test="value='".$d["server_id$letter"]."'";
		if ($d["server_id$letter"] != 218 && $d["server_id$letter"] != '' && (strpos($list,$test) !== true)){$i++;
			$list .= "<option value='".$d["server_id$letter"]."'>".id2name($d["server_id$letter"])."</option>";
		}
	}
	return $list;
}
if ($_POST[submit]){
	@mysql_query("INSERT INTO ps_penalties (packetID, product, defendantID, serverID, entryDate, entryID, desc) VALUES ('$_POST[packet]', '$_POST[svc]', '$_POST[defendant]', '$_POST[server]',NOW(), '".$_COOKIE[psdata][user_id]."', '".addslashes(strtoupper($_POST[desc]))."')");
	$entry=$_COOKIE[psdata][name]." Penalized ".id2name($_POST[server])." For ".$_POST[desc];
	if ($_POST[svc] == 'EV'){
		ev_timeline($_POST[packet],$entry);
	}else{
		timeline($_POST[packet],$entry);
	}
	echo "<h1>PENALTY ACKNOWLEDGED.</h1>";
}
if ($_GET[svc] == 'EV'){
	$idType='eviction_id';
	$table='evictionPackets';
}elseif($_GET[svc] == 'OTD'){
	$idType='packet_id';
	$table='ps_packets';
}
?>
<form method="post">
<input type='hidden' name='packet' value='<?=$_GET[packet]?>'>
<input type='hidden' name='svc' value='<?=$_GET[svc]?>'>
<input type='hidden' name='defendant' value='<?=$_GET[defendant]?>'>
<table style='background-color:#FF3300;'>
	<tr>
		<td><b>PENALIZE:</b> <select name='server'><?=serverList2($_GET[packet],$table,$idType)?></select> <b>REASON:</b> <input size='30' name='desc'> <input type='submit' name='submit' value='Submit'></td>
	</tr>
</table>
</form>