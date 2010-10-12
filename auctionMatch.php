<? 
session_start();
@mysql_connect () or die(mysql_error());
include 'security.php';






include 'functions.php';
hardLog('Auction Match Report','user');
include 'lock.php';

$i=0;
function auctionMatch($client_file){
$today = date('Y-m-d');
mysql_select_db ('intranet');
$q="select * from schedule_items where file='$client_file' and sale_date > '$today' and item_status = 'ON SCHEDULE'";
$r=@mysql_query($q);
$d=mysql_fetch_array($r,MYSQL_ASSOC);
return $d[sale_date];
}
mysql_select_db ('core');

if ($_GET[all]){
$q="SELECT * from ps_packets where 
									client_file <> '' and 
									process_status <> 'DUPLICATE' and 
									process_status <> 'DUPLICATE/DIFF-PDF' and 
									process_status <> 'DAMAGED PDF' and 
									process_status <> 'FILE COPY' and
									service_status <> 'CANCELLED' and
									filing_status <> 'CANCELLED' and
									filing_status <> 'DO NOT FILE' 
										order by packet_id DESC";
}else{
$q="SELECT * from ps_packets where 
									client_file <> '' and 
									process_status <> 'DUPLICATE' and 
									process_status <> 'DUPLICATE/DIFF-PDF' and 
									process_status <> 'DAMAGED PDF' and 
									process_status <> 'FILE COPY' and
									service_status <> 'CANCELLED' and
									filing_status <> 'CANCELLED' and
									filing_status <> 'FILED WITH COURT' and
									filing_status <> 'FILED BY CLIENT' and
 									filing_status <> 'FILED WITH COURT - FBS' and
									filing_status <> 'DO NOT FILE' 
										order by packet_id DESC";
}
$r=@mysql_query($q) or die(mysql_error());
echo "<style>table { border-collapse:collapse; font-size:12px; }</style><table border='1' width='100%'>
			<tr>
				<td>Service Status</td>
				<td>Affidavit Status</td>
				<td>Filing Status</td>
				<td>Court</td>
				<td align='center'><strong>Auction Date</strong></td>
				<td>Server</td>
				<td>Client</td>
				<td>Service</td>
			</tr>	
				";
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){ 
	if($d[client_file]){
	if ($d[filing_status] == "FILED WITH COURT" || $d[filing_status] == "FILED WITH COURT - FBS"){
		$color='#99ff99';
	}elseif($d[filing_status] == "READY TO SIGN"){
		$color='#ffff99';
	}elseif($d[filing_status] == "PREP TO FILE"){
		$color='#FFFF99';
	}else{
		$color='#FF9999';
	}
	$servers='';
	if ($d[server_ida]){
		$servers=', '.id2name($d[server_ida]);
	}
	if ($d[server_idb]){
		$servers.=', '.id2name($d[server_idb]);
	}
	if ($d[server_idc]){
		$servers.=', '.id2name($d[server_idc]);
	}
	if ($d[server_idd]){
		$servers.=', '.id2name($d[server_idd]);
	}
	if ($d[server_ide]){
		$servers.=', '.id2name($d[server_ide]);
	}
	$return = auctionMatch($d[client_file]);
	if ($return){
	echo "<tr bgcolor='$color'>
		<td>$d[process_status]</td>
		<td>$d[affidavit_status]</td>
		<td>$d[filing_status]</td>
		<td>$d[circuit_court]</td>
		<td bgcolor='FFFFFF' align='center'><strong>$return</strong></td>
		<td>".id2name($d[server_id]).$servers."</td>
		<td>$d[client_file]</td>
		<td><a href='order.php?packet=$d[packet_id]' target='_Blank'>$d[packet_id]</a></td>
		</tr>";
		$i++;
	}}
}
?>
</table>
<script>document.title='<?=$i?> Auctions';</script>
<meta http-equiv="refresh" content="120" />


