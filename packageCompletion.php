<meta http-equiv="refresh" content="300" />
<?
session_start();
mysql_connect();
mysql_select_db('core');
//hardLog("loaded package completion list.",'contractor');
$_SESSION[packets]=0;
$_SESSION[missing]=0;
$_SESSION[completed]=0;
function id2attorney($id){
	$q="SELECT display_name FROM attorneys WHERE attorneys_id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	
	if ($id == 1){
		$type = ", Service Type B";
	}elseif($id == 70){
		$type = ", Service Type D";
	}elseif($id == 56){
		$type = ", Service Type C";
	}else{
		$type = ", Service Type A";
	}
	return $d[display_name].$type;
}
if ($_GET[server]){
	$id = $_GET[server];
}else{
	$id = $_COOKIE['psdata']['user_id'];
}
function id2server($id){
	$q=@mysql_query("SELECT name from ps_users where id='$id'") or die(mysql_error());
	$d=mysql_fetch_array($q, MYSQL_ASSOC);
	return $d[name];
}

$_SESSION[server]=id2server($id);

function array_find($needle, $haystack, $search_keys = false) {
        if(!is_array($haystack)) return 999;
        foreach($haystack as $key=>$value) {
            $what = ($search_keys) ? $key : $value;
            if(strpos($what, $needle)!==false) return $key;
        }
        return 999;
}


function requestClose($id){

	$r=@mysql_query("select timeline from ps_packets where packet_id = '$id'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	$timeline = explode('<br>',$d[timeline]);

	$disp = array_find('Dispatched', $timeline);
	$close = array_find($_SESSION[server].' Completing', $timeline);
	
	return $timeline[$disp].' '.$timeline[$close]; 
}
function packageDates($id){
	$r=@mysql_query("select * from ps_packages where id = '$id'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	return "Dispatched on $d[assign_date], Original $d[description]";
}
function dataEntryDeadline($date){
	$parts = explode('-',$date);
	$time =   mktime(0, 0, 0, $parts[1],   $parts[2]-3,   $parts[0]);
	return 'Data Entry Due by '.date('m/d/Y',$time);
}
function packageInfo($package_id,$id){
	$r=@mysql_query("SELECT * FROM ps_packets WHERE (server_id = '$id' OR server_ida = '$id' OR server_idb = '$id' OR server_idc = '$id' OR server_idd = '$id' OR server_ide = '$id') and process_status = 'ASSIGNED' and package_id = '$package_id' order by packet_id");
	$return = "<ol>";
	while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
		if ($d[request_close] || $d[request_closea] || $d[request_closeb] || $d[request_closec] || $d[request_closed] || $d[request_closee]){
			$return .= "<li style='background-color:#ccFFcc;'>".dataEntryDeadline($d[estFileDate]).", Attorney: ".id2attorney($d[attorneys_id]).", Packet: $d[packet_id], Court: $d[circuit_court] ($d[state1] $d[state1a] $d[state1b] $d[state1c] $d[state1d] $d[state1e])<br>".requestClose($d[packet_id])."</li>";
			$_SESSION[packets]=$_SESSION[packets]+1;
			$_SESSION[completed]=$_SESSION[completed]+1;
		}else{
			$return .= "<li style='background-color:#FFcccc;'>".dataEntryDeadline($d[estFileDate]).", Attorney: ".id2attorney($d[attorneys_id]).", Packet: $d[packet_id], Court: $d[circuit_court] ($d[state1] $d[state1a] $d[state1b] $d[state1c] $d[state1d] $d[state1e])<br>".requestClose($d[packet_id])."</li>";
			$_SESSION[packets]=$_SESSION[packets]+1;
			$_SESSION[missing]=$_SESSION[missing]+1;
		}
	}
	$return .= "<ol>";
	return $return;
}
// end functions
echo "<table><tr><td><div align='center' style='background-color:#fff'>Data Entry Status / Data Entry Due Dates (currently only OTD files)</div>";
$r=@mysql_query("SELECT distinct package_id FROM ps_packets WHERE (server_id = '$id' OR server_ida = '$id' OR server_idb = '$id' OR server_idc = '$id' OR server_idd = '$id' OR server_ide = '$id') and process_status = 'ASSIGNED' order by package_id");
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	echo "<fieldset><legend>Service Package #$d[package_id], ".packageDates($d[package_id])."</legend>".packageInfo($d[package_id],$id)."</fieldset>";
}
echo "</td></tr></table>";
?>
<style>
body { background-color:#000; }
fieldset { background-color:#ccc; }
legend { background-color:#fff; border:solid 1px #000; } 

</style>
<title>Assigned: <?=$_SESSION[packets];?>, Awaiting Quality Control: <?=$_SESSION[completed];?>, Awaiting Data Entry: <?=$_SESSION[missing];?></title>