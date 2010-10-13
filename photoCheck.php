<?
mysql_connect();
mysql_select_db('core');
$_SESSION[serverCount]='';
$_SESSION[fileCount]='';
function id2name($id){
	$q="SELECT name FROM ps_users WHERE id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[name];
}
function byteConvert(&$bytes){
        $b = (int)$bytes;
        $s = array('B', 'kB', 'MB', 'GB', 'TB');
        if($b < 0){
            return "0 ".$s[0];
        }
        $con = 1024;
        $e = (int)(log($b,$con));
        return '<b>'.number_format($b/pow($con,$e),0,',','.').' '.$s[$e].'</b>'; 
}
function testLink($file){
	$file = str_replace('http://mdwestserve.com/ps/affidavits/','/data/service/scans/',$file);
	$file = str_replace('http://mdwestserve.com/affidavits/','/data/service/scans/',$file);
	if(file_exists($file)){
		$size = filesize($file);
		return 0;
	}else{
		return 1;
	}
}
function testLink2($file){
	$file = str_replace('http://mdwestserve.com/ps/photographs/','/data/service/photos/',$file);
	$file = str_replace('http://mdwestserve.com/photographs/','/data/service/photos/',$file);
	if(file_exists($file)){
		$size = filesize($file);
		return 0;
	}else{
		return 1;
	}
}
function colorCode($days){
if ($days == 'UNIDENTIFIABLE'){ return "OOFFFF"; }
if ($days <= 15){ return "00FF00"; }
if ($days > 15 && $days <= 30){ return "ffFF00"; }
if ($days > 30){ return "ff0000"; }
return "FFFFFF";
}

function photoCount($packet){
	$count=0;
	$r=@mysql_query("SELECT photoID FROM ps_photos WHERE packetID='$packet' LIMIT 0,1");
	$d=mysql_fetch_array($r,MYSQL_ASSOC))
	if ($d[photoID]){
		$count++;
	}
	return $count;
}
function photoCheckList($server_id,$display){
	$i=0;
	$lateTotal='';
	$data .= "<div id='$server_id' style='display:$display;'><table align='center' border='1' style='border-collapse:collapse; border-style:solid 1px; padding:0px;'><tr><td>#</td><td>Filing Date</td><td># of Days Late</td><td>Photo Links (if they exist)</td><td>Packet #</td></tr>";
	$r=@mysql_query("select * from ps_packets WHERE server_id='$server_id' AND service_status = 'MAILING AND POSTING' and status <> 'CANCELLED' order by date_received DESC");
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
		if (photoCount($d[packet_id]) == 0){
			if (testLink2($d[photo1c]) == 1){$_SESSION[fileCount]++;
				$fileCount++;
				$now=time();
				if ($d[fileDate] != '0000-00-00'){
					$fileDate=strtotime($d[fileDate]);
					$late=number_format(($now-$fileDate)/86400,0);
					$lateTotal=$lateTotal+$late;
				}else{
					$late="UNIDENTIFIABLE";
				}
				$data .= "<tr bgcolor='".colorCode($late)."'><td>$fileCount</td><td>$d[fileDate]</td><td align='center'>$late</td><td>".$d[photo1a].' '.$d[photo1b]."</td><td><a href='wizard.php?jump=$d[packet_id]-1&photojump=1' target='_blank'>$d[packet_id]</a></td></tr>";
			}
		}
	}
	$avg=number_format($lateTotal/$fileCount,2);
	$data .= "</table></div><center style='font-size:16px; padding:0px;'>".id2name($server_id)." has $fileCount files missing photographs, over an average of $avg days.</center>";
	return $data;
}?>	
<script>
function hideshow(which){
	if (!document.getElementById)
		return
	if (which.style.display=="block")
		which.style.display="none"
	else
		which.style.display="block"
}
</script>
<style>
table, div, legend {padding:0px;}
fieldset {padding:0px; width:650px;}
</style>
<?
if ($_COOKIE[psdata][level] == 'Operations'){
	$q="select DISTINCT server_id from ps_packets WHERE service_status = 'MAILING AND POSTING' and status <> 'CANCELLED' and server_id <> '192' and server_id <> '' order by date_received DESC";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$_SESSION[serverCount]++;?>
		<center><fieldset><legend><a onClick="hideshow(document.getElementById('<?=$d[server_id]?>'))"><?=id2name($d[server_id]);?> (click to expand)</a></legend><?=photoCheckList($d[server_id],'none');?></fieldset></center>
<?	}
	echo "<script>document.title='".$_SESSION[serverCount]." Servers ".$_SESSION[fileCount]." Services Missing Photos';</script>";
}else{
	echo photoCheckList($_COOKIE[psdata][user_id],'block');
	echo "<script>document.title='".$_SESSION[fileCount]." Services Missing Photos';</script>";
}
?>