<?
/**
 * Alpha Mirror
 * This is the common include for a page to use the in-house mirror (READ-ONLY). 
 * When this page is called from our main site it should automatically redirect to alpha's web server
 * @author Patrick McGuire <patrick@mdwestserve.com>
 */
session_start();


if ($_SERVER['HTTP_HOST'] != 'alpha.mdwestserve.com'){ 
	header('Location: http://alpha.mdwestserve.com'.$_SERVER['REQUEST_URI']);
}






include 'security.php';
include 'functions.php';
db_connect('alpha.mdwestserve.com','core','root','zerohour');
include 'online_now.php';
// ok check for tos version here incase they never log out
 $templateDate=getTemplateDate('TOS');
 if ($_COOKIE[psdata][tos_date] != $templateDate[0]){ header ('Location: tos_review.php'); }
function timeline($id,$note){
	error_log("[".date('h:iA n/j/y')."] [".$_COOKIE[psdata][name]."] [".trim($id)."] [".trim($note)."] \n", 3, '/logs/timeline.log');

	mysql_select_db ('core');

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
	@mysql_query("insert into syslog (logTime, event) values (NOW(), 'Packet $id: $note')");
}
function opLog($event){
	//@mysql_query("insert into syslog (logTime, event) values (NOW(), '$event')");
}

?>
