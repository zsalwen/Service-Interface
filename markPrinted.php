<?
include 'common.php';
function mkAlert($alertStr,$entryID,$serverID,$packetID){
	mysql_select_db('core');
	@mysql_query("INSERT INTO ps_alert (alertStr, entryID, entryTime, serverID, packetID) VALUES ('$alertStr', '$entryID', NOW(), '$serverID', '$packetID')");
}
if ($_GET['print'] && $_GET[packet]){
	$printAlert="PRINTING PACKET ".$_GET[packet];
	hardLog("PRINTING AFFIDAVITS FOR PACKET ".$_GET[packet],'contractor');
	$printID=$_GET['print'];
	$packet=$_GET[packet];
	mkAlert($printAlert,$printID,$printID,$packet);
	// advance affidavit counter
	if($_GET[svc] == 'Eviction'){
		$table = 'evictionPackets';
		$idType = 'eviction_id';
		$aff="evictionAff";
		$varia="id";
	}else{
		$table = 'ps_packets';
		$idType = 'packet_id';
		$aff="liveAffidavit";
		$varia="packet";
	}
	$yes=0;
	$link2="http://service.mdwestserve.com/".$aff.".php?".$varia."=".$_GET[packet];
	$q="select server_id, server_ida, server_idb, server_idc, server_idd, server_ide from $table where $idType='$_GET[packet]'";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$data=mysql_fetch_array($r,MYSQL_ASSOC);
	// server 1
	if ($_GET['print'] == $data[server_id]){
		@mysql_query("update $table set svrPrint='1' where $idType='$_GET[packet]'"); 
		psActivity("servicePrinted");
		$yes++;
	}
	foreach (range('a','e') as $letter){
		// servers 2-6
		if ($_GET['print'] == $data["server_id$letter"]){
			@mysql_query("update $table set svrPrint$letter='1' where $idType='$_GET[packet]'"); 
			psActivity("servicePrinted");
			$yes++;
		}
	}
	if ($yes > 0){
		echo "<script>window.location='$link2';</script>";
	}
}
?>