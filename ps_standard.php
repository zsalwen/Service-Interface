<?
include 'common.php';
hardLog("loaded active standard files list.",'contractor');




?>
<style>
legend { border:double 3px #0000FF;
		background-color:#CCFFFF;
		padding:5px;
		}
fieldset	{
		background-color:#CCCCCC;
		}
table {
		background-color:#FFFFFF;
		}
body	{
		background-color:#999999;
		font-size:10px;
		}
</style>
<div style="text-align:center; font-size:25px;"><a href="ps_worksheet.php?svc=presale<?=$all?>"><?=$count1?> Presale Cases</a> | <a href="ps_worksheet.php?svc=Eviction<?=$all?>"><?=$count2?> Eviction Cases</a> | <a href="ps_standard.php"><?=$count3?> Standard Cases</a></div> 

<?

function countStatus($status){
	$r=@mysql_query("select packet_id from standard_packets where process_status = '$status' and (server_id = '".$_COOKIE['psdata']['user_id']."' or server_ida = '".$_COOKIE['psdata']['user_id']."' or server_idb = '".$_COOKIE['psdata']['user_id']."' or server_idc = '".$_COOKIE['psdata']['user_id']."' or server_idd = '".$_COOKIE['psdata']['user_id']."' or server_ide = '".$_COOKIE['psdata']['user_id']."') ");
	$count=mysql_num_rows($r);
	return $count;
}






function whoIs($id){
	$q="SELECT display_name FROM attorneys WHERE attorneys_id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
return $d[display_name];
}

function hasAffs($packet){
$r=@mysql_query("SELECT packet FROM affidavits WHERE product = 'S' and packet = '$packet' and status = 'visible'");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
return $d[packet];
}




function openSvc($affidavit_status,$process_status){

?>
<fieldset><legend><b><?=strtoupper($affidavit_status);?></b></legend>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
	<tr style='background-color:#FFFFCC'>
		<td width="5%">Order</td>
		<td width="25%">Documents</td>
		<td width="10%">Client</td>
		<td width="15%">Notes</td>
		<td width="20%">Options</td>
		<td width="5%" nowrap='nowrap'>Case Number</td>
		<td width="5%" nowrap='nowrap'>Close Date</td>
	</tr><?
$r=@mysql_query("SELECT otd, fileDate, affidavitType, date_received, client_file, addlDocs, attorneys_id, service_status, client_file, case_no, packet_id, date_received, affidavit_status, process_status, oldOTD,  FROM standard_packets WHERE process_status = '$process_status' and affidavit_status='$affidavit_status' and (server_id = '".$_COOKIE['psdata']['user_id']."' or server_ida = '".$_COOKIE['psdata']['user_id']."' or server_idb = '".$_COOKIE['psdata']['user_id']."' or server_idc = '".$_COOKIE['psdata']['user_id']."' or server_idd = '".$_COOKIE['psdata']['user_id']."' or server_ide = '".$_COOKIE['psdata']['user_id']."') order by packet_id");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	echo "<tr style='background-color:";
	if(hasAffs($d[packet_id])){ echo "#CCFFFF"; }else{ echo "#99FF99"; } 
	echo "'>
			<td width='5%'>
			<li>S-$d[packet_id]</li>";
			if($d[oldOTD]){
				echo "<li>OTD$d[oldOTD]</li>";
			}
	echo "	</td>
			<td width='25%'>".$d[addlDocs]."</td>
			<td width='10%'>".whoIs($d[attorneys_id])." $d[client_file]</td>
			<td width='20%'>".strtoupper($d[server_notes])."</td>
			<td width='20%'>
			";
if ($d[affidavit_status] == 'PRESALE OTD'){ echo "<li><a href='http://service.mdwestserve.com/s_customInstructions.php?packet=$d[packet_id]'>INSTRUCTIONS</a></li>"; }
		$src=str_replace('portal//var/www/dataFiles/service/orders/','PS_PACKETS/',$d[otd]);
		$src=str_replace('data/service/orders/','PS_PACKETS/',$src);
		$src=str_replace('portal/','',$src);
?>
<li><a href="<?=$src?>" target="_Blank">Papers to serve </a></li>
<li><a href="standardBuilder.php" target="_Blank">Enter Affidavit Information</a></li>
<?


					
	$rX=@mysql_query("select * from affidavits where packet = '$d[packet_id]' and serverX = '".$_COOKIE['psdata']['user_id']."' and product = 'S' and status= 'visible' ");
	while($dX=mysql_fetch_array($rX,MYSQL_ASSOC)){
		echo "<li><a href='http://service.mdwestserve.com/standardWizard.php?id=$dX[id]' target='_Blank' style='font-size:12px'>View</a> <a href='http://service.mdwestserve.com/standardBuilder.php?edit=$dX[id]' target='_Blank'  style='font-size:12px'>Edit</a> <a href='http://service.mdwestserve.com/standardBuilder.php?delete=$dX[id]' target='_Blank'  style='font-size:12px'>Delete</a> $dX[processor]</li>";
	}

/*
if ($process_status == 'WITH COURIER'){ echo "<li><a href='?status=$process_status&complete=$d[packet_id]'>Complete Order</a></li></li>"; }
if ($process_status == 'AWAITING SIGNED AFFIDAVITS'){ echo "<li><a href='?status=$process_status&complete=$d[packet_id]'>Complete Order</a></li><li><a href='?status=$process_status&courier=$d[packet_id]'>With Courier</a></li><li><a href='?status=$process_status&payment=$d[packet_id]'>Awaiting Payment</a></li>"; }
if ($process_status == 'AWAITING RESTART'){ echo "<li><a href='?status=$process_status&complete=$d[packet_id]'>Complete Order</a></li><li><a href='?status=$process_status&start=$d[packet_id]'>Start Order</a></li>"; }
if ($process_status == 'READY TO PRINT'){ echo "<li><a href='?status=$process_status&returnAffs=$d[packet_id]'>Sent and Waiting for Server Affidavits</a></li>"; }
if ($process_status == 'AFFIDAVIT QUALITY CONTROL'){ echo "<li><a href='?status=$process_status&print=$d[packet_id]'>Above are all Ready to Print</a></li>"; }
if ($process_status == 'READY FOR AFFIDAVITS'){ echo "<li><a href='?status=$process_status&qc=$d[packet_id]'>Affidavit Quality Control</a></li>"; }
if ($process_status == 'IN PROGRESS'){ echo "<li><a href='?status=$process_status&mail=$d[packet_id]'>Ready to Mail</a></li>"; }
if ($process_status == 'READY TO MAIL' || $process_status == 'IN PROGRESS'){ echo "<li><a href='?status=$process_status&affidavits=$d[packet_id]'>Ready for Affidavits</a></li>"; }
*/			
			echo "
			</td>
			<td width='5%' nowrap='nowrap'>$d[case_no]</td>
			<td width='5%' nowrap='nowrap'>$d[fileDate]</td>
		 </tr>";
}
?>
</table></fieldset>
<? }?>
<div>
<table align="center" border="2">
	<tr>
		<td>Select Process Status</td>
		<?
		$r2=@mysql_query("select distinct process_status from standard_packets where process_status <> 'PURGE QUEUE' and ( server_id = '".$_COOKIE['psdata']['user_id']."' or server_ida = '".$_COOKIE['psdata']['user_id']."' or server_idb = '".$_COOKIE['psdata']['user_id']."' or server_idc = '".$_COOKIE['psdata']['user_id']."' or server_idd = '".$_COOKIE['psdata']['user_id']."' or server_ide = '".$_COOKIE['psdata']['user_id']."' ) ");
		while($d2=mysql_fetch_array($r2,MYSQL_ASSOC)){
		echo "<td><a href='?status=$d2[process_status]'>$d2[process_status] (".countStatus($d2[process_status]).")</a></td>";
		}
		?>
	</tr>
</table>
</div>
<div align="center" style="font-size:20px; background-color:#fff; border:solid 1px #F00;">Currently Viewing <?=$_GET[status]?></div>
<?

if($_GET[status]){

$r=@mysql_query("select distinct affidavit_status from standard_packets where process_status = '$_GET[status]' and (server_id = '".$_COOKIE['psdata']['user_id']."' or server_ida = '".$_COOKIE['psdata']['user_id']."' or server_idb = '".$_COOKIE['psdata']['user_id']."' or server_idc = '".$_COOKIE['psdata']['user_id']."' or server_idd = '".$_COOKIE['psdata']['user_id']."' or server_ide = '".$_COOKIE['psdata']['user_id']."') order by packet_id");
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	openSvc($d[affidavit_status],$_GET[status]);
}
}

?>