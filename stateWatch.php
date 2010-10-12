<?
include 'common.php';
include 'lock.php';
//include 'menu.php';
$i=0;
echo "<style></style><table border='1'>";
$r=@mysql_query("SELECT * FROM ps_packets where 
									(state1a <> 'MD' and state1a <> 'md' and state1a <> '') or 
									(state1b <> 'MD' and state1b <> 'md' and state1b <> '') or 
									(state1c <> 'MD' and state1c <> 'md' and state1c <> '') or 
									(state1d <> 'MD' and state1d <> 'md' and state1d <> '') or 
									(state1e <> 'MD' and state1e <> 'md' and state1e <> '')
									");
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ $i++;
echo "<tr><td nowrap>$i) $d[packet_id]</td><td nowrap>$d[process_status]<br>$d[status]<br>$d[service_status]<br>$d[affidavit_status]<br>$d[filing_status]</td><td nowrap>".substr($d[date_received],0,10)."</td><td nowrap>$d[name1]</td><td nowrap>$d[address1], $d[state1]<br>$d[address1a], $d[state1a]<br>$d[address1b], $d[state1b]<br>$d[address1c], $d[state1c]<br>$d[address1d], $d[state1d]<br>$d[address1e], $d[state1e]</td><td nowrap>".id2name($d[server_id])."</td><td nowrap>".id2name($d[server_ida])."</td><td nowrap>".id2name($d[server_idb])."</td><td nowrap>".id2name($d[server_idc])."</td><td nowrap>".id2name($d[server_idd])."</td><td nowrap>".id2name($d[server_ide])."</td></tr>";
}
echo "</table>";
//include 'footer.php';
?>

