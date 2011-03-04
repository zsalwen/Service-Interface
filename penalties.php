<?
mysql_connect();
mysql_select_db('core');
//include 'common.php';
function id2name($id){
	$q="SELECT name FROM ps_users WHERE id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
return $d[name];
}
function getName($packet,$i,$table,$idType){
	$q="SELECT name$i, onAffidavit$i FROM $table WHERE $idType='$packet' LIMIT 0,1";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	if ($idType == 'eviction_id' && $i == 1 && strtoupper($d[onAffidavit1]) != 'CHECKED'){
		return "ALL OCCUPANTS";
	}else{
		return $d["name$i"];
	}
}
function justDate($dt){
	$date=explode(' ',$dt);
	return $date[0];
}
function getTable($str){
	if ($str == 'OTD'){
		return 'ps_packets';
	}elseif ($str == 'EV'){
		return 'evictionPackets';
	}elseif ($str == 'S'){
		return 'standard_packets';
	}
}
function getIDType($str){
	if ($str == 'OTD' || $str == 'S'){
		return 'packet_id';
	}elseif ($str == 'EV'){
		return 'eviction_id';
	}
}
?>
<style>
body, form {padding:0px;}
</style>
<?
if ($_GET[id] && $_COOKIE[psdata][level] == 'Operations'){
	$id=$_GET[id];
}else{
	$id=$_COOKIE[psdata][user_id];
}
// If $_GET[display] variable is present, display 
$list='';
$i=0;
if ($_GET[display] != ''){
	$q1="SELECT * FROM ps_penalties WHERE serverID='$id' ORDER BY product, packetID DESC";
	$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
	while ($d1=mysql_fetch_array($r1,MYSQL_ASSOC)){$i++;
		$list .= "<tr><td>$d1[product]$d1[packetID]</td><td>".getName($d1[packetID],$d1[defendantID],getTable($d1[product]),getIDType($d1[product]))."</td><td>[".strtoupper(stripslashes($d1[description]))."] - ".justDate($d1[entryDate])."</td></tr>";
	}	
	if ($list != ''){
		echo "<table border='1' style='border-collapse:collapse;'><tr><td>File</td><td>Defendant</td><td>Description</td></tr>$list<tr><td colspan='3' align='right' style='font-weight:bold;'>TOTAL PENALTIES: $i</td></tr></table>";
	}
}
?>