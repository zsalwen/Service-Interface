<?
session_start();
date_default_timezone_set('America/New_York');
include 'security.php';
include 'functions.php';
db_connect('delta.mdwestserve.com','core','root','zerohour');
include 'online_now.php';
// ok check for tos version here incase they never log out
 $templateDate=getTemplateDate('TOS');
 if ($_COOKIE[psdata][tos_date] != $templateDate[0]){ header ('Location: tos_review.php'); }
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
function opLog($event){
	//@mysql_query("insert into syslog (logTime, event) values (NOW(), '$event')");
}
function washURI($uri){
	$return=str_replace('portal//var/www/dataFiles/service/orders/','PS_PACKETS/',$uri);
	$return=str_replace('data/service/orders/','PS_PACKETS/',$uri);
	$return=str_replace('portal/','',$return);
	$return=str_replace('http://mdwestserve.com','http://alpha.mdwestserve.com',$return);
	return $return;
}
?>
