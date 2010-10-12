<?
include 'common.php';
function rangeLinks($exStart,$exStop,$server){
	$r1=@mysql_query("SELECT packet_id FROM ps_packets WHERE (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') ORDER BY packet_id ASC LIMIT 0,1") or die (mysql_error());
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	$i=floor($d1[packet_id]/1000)-1;
	$q="SELECT packet_id FROM ps_packets ORDER BY packet_id DESC LIMIT 0,1";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	$end=$d[packet_id]/1000;
	$end=ceil($end);
	$list .= "<table align='center'><tr><td>";
	while ($i < ($end-1)){$i++;
		$start=$i;
		$stop=$i+1;
		if ($start != $exStart && $stop != $exStop){
			$newList = "<td><div style='border: 1px solid black; width: 100px;'><center><a href='?server=$server&start=$start&stop=$stop'>";
			$start=$start*1000;
			$stop=$stop*1000;
			$newList .= "RANGE $start-$stop</a></center></div></td>";
			$r2=@mysql_query("SELECT packet_id FROM ps_packets WHERE (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') AND packet_id >= '$start' AND packet_id < '$stop' ORDER BY packet_id ASC LIMIT 0,1") or die (mysql_error());
			$d2=mysql_fetch_array($r2,MYSQL_ASSOC);
			if ($d2[packet_id] != ''){
				$list .= $newList;
			}
		}
	}
	$list .= "</tr></table>";
	return $list;
}
$server=$_GET[server];
if (!$_GET[stop]){
	$q="SELECT packet_id FROM ps_packets ORDER BY packet_id DESC LIMIT 0,1";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	$end=$d[packet_id]/1000;
	$end=ceil($end);
}else{
	$end=$_GET[stop];
}
if (!$_GET[start]){
	$r1=@mysql_query("SELECT packet_id FROM ps_packets WHERE server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server' ORDER BY packet_id DESC LIMIT 0,1") or die (mysql_error());
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	//echo "<div style='border: 1px solid red;'>START: $d1[packet_id]</div>";
	$i=floor($d1[packet_id]/1000)-1;
}else{
	$i=$_GET[start]-1;
}
echo rangeLinks($_GET[start],$_GET[stop],$server);
echo "<table align='center'><tr>";
while ($i < ($end-1)){$i++;
	$start=$i*1000;
	$stop=($i+1)*1000;
	$packetList='';
	$fileCount='';
	$q="SELECT packet_id FROM ps_packets WHERE packet_id >= '$start' AND packet_id < '$stop' AND (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') ORDER BY packet_id ASC";
	$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$fileCount++;
		$packetList .= "$d[packet_id]<br>";
	}
	if ($packetList != ''){
		echo "<td valign='top'><div style='border: 1px solid black; width: 100px;'><center>RANGE $start-$stop<br>($fileCount)</center>$packetList</div></td>";
	}
}
echo "</tr></table>";
?>