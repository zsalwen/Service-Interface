<?
include 'common.php';
if ($_GET[server]){
	$id = $_GET[server];
}else{
	$id = $_COOKIE['psdata']['user_id'];
}
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

<?
function countStatus($status,$id){
	$r=@mysql_query("select packet_id from standard_packets where process_status = '$status' and (server_id = '$id' or server_ida = '$id' or server_idb = '$id' or server_idc = '$id' or server_idd = '$id' or server_ide = '$id')");
	$count=mysql_num_rows($r);
	return $count;
}/*
function timeline($id,$note){
	$q1 = "SELECT timeline FROM standard_packets WHERE packet_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	$d1 = mysql_fetch_array($r1, MYSQL_ASSOC);
	$access=date('m/d/y g:i A');
	if ($d1[timeline] != ''){
		$notes = $d1[timeline]."<br>$access: ".$note;
	}else{
		$notes = $access.': '.$note;
	}
	$notes = addslashes($notes);
	$q1 = "UPDATE standard_packets set timeline='$notes' WHERE packet_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
}

if ($_GET[mail]){
	@mysql_query("update standard_packets set process_status = 'READY TO MAIL' where packet_id = '$_GET[mail]'");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[mail].' ready to mail','s'.$_GET[mail].' ready to mail by: '.$_COOKIE[psdata][name]);
	timeline($_GET['mail'],'Status updated to READY TO MAIL by: '.$_COOKIE[psdata][name]);
}
if ($_GET['print']){
	@mysql_query("update standard_packets set process_status = 'READY TO PRINT' where packet_id = $_GET[print]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET['print'].' ready to print','s'.$_GET['print'].' ready to print by: '.$_COOKIE[psdata][name]);
	timeline($_GET['print'],'Status updated to READY TO PRINT by: '.$_COOKIE[psdata][name]);
}
if ($_GET['affidavits']){
	@mysql_query("update standard_packets set process_status = 'READY FOR AFFIDAVITS' where packet_id = $_GET[affidavits]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[affidavits].' ready for affidavits','s'.$_GET[affidavits].' ready for affidavits by: '.$_COOKIE[psdata][name]);
	timeline($_GET['affidavits'],'Status updated to READY FOR AFFIDAVITS by: '.$_COOKIE[psdata][name]);
}
if ($_GET['qc']){
	@mysql_query("update standard_packets set process_status = 'AFFIDAVIT QUALITY CONTROL' where packet_id = $_GET[qc]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[qc].' ready for affidavit quality control','s'.$_GET[qc].' ready for affidavit quality control by: '.$_COOKIE[psdata][name]);
	timeline($_GET['qc'],'Status updated to AFFIDAVIT QUALITY CONTROL by: '.$_COOKIE[psdata][name]);
}
if ($_GET['returnAffs']){
	@mysql_query("update standard_packets set process_status = 'AWAITING SIGNED AFFIDAVITS', fileDate = NOW() where packet_id = $_GET[returnAffs]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[returnAffs].' waiting for signed affidavits, close date set to '.date('Y-m-d'),'s'.$_GET[returnAffs].' waiting for signed affidavits, close date set to '.date('Y-m-d').' by: '.$_COOKIE[psdata][name]);
	timeline($_GET['returnAffs'],'Status updated to AWAITING SIGNED AFFIDAVITS, close date set to '.date('Y-m-d').', by: '.$_COOKIE[psdata][name]);
}
if ($_GET['restart']){
	@mysql_query("update standard_packets set process_status = 'AWAITING RESTART' where packet_id = $_GET[restart]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[restart].' waiting for restart','s'.$_GET[restart].' waiting for restart by: '.$_COOKIE[psdata][name]);
	timeline($_GET['restart'],'Status updated to AWAITING RESTART by: '.$_COOKIE[psdata][name]);
}
if ($_GET['complete']){
	@mysql_query("update standard_packets set process_status = 'ORDER COMPLETE' where packet_id = $_GET[complete]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[complete].' order complete','s'.$_GET[complete].' order complete by: '.$_COOKIE[psdata][name]);
	timeline($_GET['complete'],'Status updated to ORDER COMPLETE by: '.$_COOKIE[psdata][name]);
}
if ($_GET['start']){
	@mysql_query("update standard_packets set process_status = 'IN PROGRESS' where packet_id = $_GET[start]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[start].' in progress','s'.$_GET[start].' in progress by: '.$_COOKIE[psdata][name]);
	timeline($_GET['start'],'Status updated to IN PROGRESS by: '.$_COOKIE[psdata][name]);
}
if ($_GET['courier']){
	@mysql_query("update standard_packets set process_status = 'WITH COURIER' where packet_id = $_GET[courier]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[courier].' with courier','s'.$_GET[courier].' with courier by: '.$_COOKIE[psdata][name]);
	timeline($_GET['courier'],'Status updated to WITH COURIER by: '.$_COOKIE[psdata][name]);
}
if ($_GET['payment']){
	@mysql_query("update standard_packets set process_status = 'AWAITING PAYMENT' where packet_id = $_GET[payment]");
	mail('service@mdwestserve.com','Standard Packet '.$_GET[payment].' awaiting payment','s'.$_GET[payment].' awaiting payment by: '.$_COOKIE[psdata][name]);
	timeline($_GET['payment'],'Status updated to AWAITING PAYMENT by: '.$_COOKIE[psdata][name]);
}
*/





function whoIs($id){
	$q="SELECT display_name FROM attorneys WHERE attorneys_id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
return $d[display_name];
}





function openSvc($affidavit_status,$process_status,$id){

?>
<fieldset><legend><b><?=strtoupper($affidavit_status);?></b></legend>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
	<tr style='background-color:#FFFFCC'>
		<td width="5%">Order</td>
		<td width="5%">Received</td>
		<td width="35">Documents</td>
		<td width="15%">Client</td>
		<td width="15%">Template</td>
		<td width="20%">Options</td>
		<td width="5%" nowrap='nowrap'>Case Number</td>
		<td width="5%" nowrap='nowrap'>Close Date</td>
	</tr><?
$r=@mysql_query("SELECT fileDate, affidavitType, date_received, client_file, addlDocs, attorneys_id, service_status, client_file, case_no, packet_id, date_received, affidavit_status, process_status FROM standard_packets WHERE process_status = '$process_status' and affidavit_status='$affidavit_status' and (server_id = '$id' or server_ida = '$id' or server_idb = '$id' or server_idc = '$id' or server_idd = '$id' or server_ide = '$id') order by packet_id");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	echo "<tr style='background-color:#99FF99'>
			<td width='5%'>
			<li>S-$d[packet_id]</li>
			</td>
			<td width='5%'>".substr($d[date_received],0,10)."</td>
			<td width='35%'>".$d[addlDocs]."</td>
			<td width='15%'>".whoIs($d[attorneys_id])." $d[client_file]</td>
			<td width='20%'>$d[affidavitType]</td>
			<td width='15%'>
			";
			

	$rX=@mysql_query("select * from affidavits where packet = '$d[packet_id]' and product = 'S' and serverX = '$id' and status= 'visible' ");
	while($dX=mysql_fetch_array($rX,MYSQL_ASSOC)){
		echo "<li><a href='http://staff.mdwestserve.com/wizard.php?id=$dX[id]' target='_Blank' style='font-size:12px'>Open affidavit </a> prepared by $dX[processor]</li>";
	}


			
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
		$r2=@mysql_query("select distinct process_status from standard_packets where server_id = '$id' or server_ida = '$id' or server_idb = '$id' or server_idc = '$id' or server_idd = '$id' or server_ide = '$id'");
		while($d2=mysql_fetch_array($r2,MYSQL_ASSOC)){
		echo "<td><a href='?status=$d2[process_status]'>$d2[process_status] (".countStatus($d2[process_status],$id).")</a></td>";
		}
		?>
	</tr>
</table>
</div>
<div align="center" style="font-size:20px; background-color:#fff; border:solid 1px #F00;">Currently Viewing <?=$id;?> <?=$_GET[status]?></div>
<?

if($_GET[status]){

$r=@mysql_query("select distinct affidavit_status from standard_packets where process_status = '$_GET[status]' and (server_id = '$id' or server_ida = '$id' or server_idb = '$id' or server_idc = '$id' or server_idd = '$id' or server_ide = '$id') order by packet_id");
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	openSvc($d[affidavit_status],$_GET[status],$id);
}
}

?>