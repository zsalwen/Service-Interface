<?
mysql_connect();
mysql_select_db('core');
//include 'common.php';
function hardLog($str,$type){
	if ($type == "user"){
		$log = "/logs/user.log";
	}
	if ($type == "contractor"){
		$log = "/logs/contractor.log";
	}
	if ($type == "debug"){
		$log = "/logs/debug.log";
	}
	if ($log){
		error_log(date('h:iA n/j/y')." ".$_COOKIE[psdata][name]." ".$_SERVER["REMOTE_ADDR"]." ".trim($str)."\n", 3, $log);
	}
}
function timeline($id,$note){
 	error_log("[".date('h:iA n/j/y')."] [".$_COOKIE[psdata][name]."] [".trim($id)."] [".trim($note)."] \n", 3, '/logs/timeline.log');

	mysql_select_db ('core');
	hardLog("$note for packet $id",'user');

	$q1 = "SELECT timeline FROM ps_packets WHERE packet_id = '$id'";
	$r1 = @mysql_query ($q1) or die(mysql_error());
	$d1 = mysql_fetch_array($r1, MYSQL_ASSOC);
	$access=date('m/d/y g:i A');
	if ($d1[timeline] != ''){
		$notes = $d1[timeline]."<br>$access: ".$note;
	}else{
		$notes = $access.': '.$note;
	}
	$notes = addslashes($notes);
	$q1 = "UPDATE ps_packets set timeline='$notes' WHERE packet_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	//@mysql_query("insert into syslog (logTime, event) values (NOW(), 'Packet $id: $note')");
}
 function ev_timeline($id,$note){
	mysql_select_db ('core');
	hardLog("$note for eviction packet $id",'user');

	$q1 = "SELECT timeline FROM evictionPackets WHERE eviction_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	$d1 = mysql_fetch_array($r1, MYSQL_ASSOC);
	$access=date('m/d/y g:i A');
	if ($d1[timeline] != ''){
		$notes = $d1[timeline]."<br>$access: ".$note;
	}else{
		$notes = $access.': '.$note;
	}
	$notes = addslashes($notes);
	$q1 = "UPDATE evictionPackets set timeline='$notes' WHERE eviction_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	//@mysql_query("insert into syslog (logTime, event) values (NOW(), 'Packet $id: $note')");
}
function id2name($id){
	$q="SELECT name FROM ps_users WHERE id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
return $d[name];
}
function serverList2($packet,$table,$idType){
	$list='';
	$i=0;
	$fields="server_id";
	if ($idType != 'eviction_id'){
		$fields .= ", server_ida, server_idb, server_idc, server_idd, server_ide";
	}
	$q="SELECT $fields FROM $table WHERE $idType='$packet' LIMIT 0,1";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	if ($d[server_id] != 218 && $d[server_id] != ''){$i++;
		$list .= "<option value='$d[server_id]'>".id2name($d[server_id])."</option>";
	}
	if ($idType != 'eviction_id'){
		foreach(range('a','e') as $letter){
			$test="value='".$d["server_id$letter"]."'";
			if ($d["server_id$letter"] != 218 && $d["server_id$letter"] != '' && (strpos($list,$test) !== true)){$i++;
				$list .= "<option value='".$d["server_id$letter"]."'>".id2name($d["server_id$letter"])."</option>";
			}
		}
	}
	return $list;
}
if ($_POST[submit]){
	$q="INSERT INTO ps_penalties (packetID,product,defendantID,serverID,entryDate,entryID,desc) values ('$_POST[packet]','$_POST[svc]','$_POST[defendant]','$_POST[server]',NOW(),'".$_COOKIE[psdata][user_id]."','".addslashes(strtoupper($_POST[desc]))."')";
	@mysql_query($q) or die ("Query: $q<br>".mysql_error());
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
<style>
body, form {padding:0px;}
</style>
<form method="post" style='display:inline;'>
<input type='hidden' name='packet' value='<?=$_GET[packet]?>'>
<input type='hidden' name='svc' value='<?=$_GET[svc]?>'>
<input type='hidden' name='defendant' value='<?=$_GET[defendant]?>'>
<table style='background-color:#FF3300; padding:0px; border-collapse:collapse;' border='0'>
	<tr>
		<td><b>PENALIZE:</b> <select name='server'><?=serverList2($_GET[packet],$table,$idType)?></select><br><b>REASON:</b> <input size='30' name='desc'> <input type='submit' name='submit' value='Submit'></td>
	</tr>
</table>
</form>