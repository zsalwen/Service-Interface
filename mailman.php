<?
include 'common.php';

function washURI2($uri){
	$return=str_replace('portal//var/www/dataFiles/service/orders/','PS_PACKETS/',$uri);
	$return=str_replace('data/service/orders/','PS_PACKETS/',$return);
	$return=str_replace('portal/','',$return);
	//$return=str_replace('http://mdwestserve.com','http://alpha.mdwestserve.com',$return);
	return $return;
}

$_SESSION[printed]=0;
$_SESSION[ready]=0;
$_SESSION[letters]=0;
function statusColor($status){
	if ($status == "UNKNOWN"){ return "#FFcccc"; }
	if ($status == "Printed Awaiting Postage"){ $_SESSION[printed]++; return "#FFFFcc"; }
	if ($status == "Mailed First Class and Certified Return Receipt"){ return "#ccFFcc"; }
	if ($status == "Mailed First Class"){ return "#ccccFF"; }
	if ($status == "Mailed by Client"){ return "#999999"; }
	$_SESSION[ready]++;
	return "#00ff00";
}

function getPacketData($packet){
	$q="select * from ps_packets where packet_id = '$packet'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);//$data = "<td>$d[packet_id]-$defendant</td>";	
	$data .= "<tr bgcolor='".statusColor($d[mail_status])."'>
<td nowrap class='noprint'>
	<li><a href='?mail4=$packet'>Open Papers to Print (And Mark Printed)</a></li>
	";
	$data .= "</td><td nowrap class='noprint' style='background-color:#FF0000;'>";
	if($_COOKIE[psdata][level] == "Operations"){
	$data .= "<a style='background-color:#000000; color:#FFFFFF' href='?mail5=$packet'><strong>CloseOut</strong></a>";
	}
	$data .= "</td>";
	if(1 == "1"){
	$_SESSION[letters] = $_SESSION[letters]+2;
	$data .= "<td><a target='_Blank' href='greencard.php?packet=$packet&def=1&card=return'>$packet-1</a>";
	if($d['address1a']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=1&add=a&card=return'>$packet-1a</a>";	
	}
	if ($d['address1b']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=1&add=b&card=return'>$packet-1b</a>";	
	}
	if ($d['address1c']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=1&add=c&card=return'>$packet-1c</a>";	
	}
	if ($d['address1d']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=1&add=d&card=return'>$packet-1d</a>";	
	}
	if ($d['address1e']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=1&add=e&card=return'>$packet-1e</a>";	

	}
	if($d['address2']){	
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=2&card=return'>$packet-2</a>";	
	}
	if($d['address2a']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=2&add=a&card=return'>$packet-2a</a>";	
	}
	if ($d['address2b']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=2&add=b&card=return'>$packet-2b</a>";	
	}
	if ($d['address2c']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=2&add=c&card=return'>$packet-2c</a>";	
	}
	if ($d['address2d']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=2&add=d&card=return'>$packet-2d</a>";	
	}
	if ($d['address2e']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=2&add=e&card=return'>$packet-2e</a>";	
	}
	if($d['address3']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=3&card=return'>$packet-3</a>";
	}
	if($d['address3a']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=3&add=a&card=return'>$packet-3a</a>";	
	}
	if ($d['address3b']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=3&add=b&card=return'>$packet-3b</a>";
	}
	if ($d['address3c']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=3&add=c&card=return'>$packet-3c</a>";	
	}
	if ($d['address3d']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=3&add=d&card=return'>$packet-3d</a>";	
	}
	if ($d['address3e']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=3&add=e&card=return'>$packet-3e</a>";	
	}
	if($d['address4']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=4&card=return'>$packet-4</a>";
	}
	if($d['address4a']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=4&add=a&card=return'>$packet-4a</a>";
	}
	if ($d['address4b']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=4&add=b&card=return'>$packet-4b</a>";	
	}
	if ($d['address4c']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=4&add=c&card=return'>$packet-4c</a>";
	}
	if ($d['address4d']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=4&add=d&card=return'>$packet-4d</a>";	
	}
	if ($d['address4e']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=4&add=e&card=return'>$packet-4e</a>";	
	}
	if($d['address5']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=5&card=return'>$packet-5</a>";	
	}
	if($d['address5a']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=5&add=a&card=return'>$packet-5a</a>";	
	}
	if ($d['address5b']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=5&add=b&card=return'>$packet-5b</a>";	
	}
	if ($d['address5c']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=5&add=c&card=return'>$packet-5c</a>";	
	}
	if ($d['address5d']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=5&add=d&card=return'>$packet-5d</a>";	
	}
	if ($d['address5e']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=5&add=e&card=return'>$packet-5e</a>";	
	}
	if($d['address6']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=6&card=return'>$packet-6</a>";	
	}
	if($d['address6a']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=6&add=a&card=return'>$packet-6a</a>";	
	}
	if ($d['address6b']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=6&add=b&card=return'>$packet-6b</a>";	
	}
	if ($d['address6c']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=6&add=c&card=return'>$packet-6c</a>";	
	}
	if ($d['address6d']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=6&add=d&card=return'>$packet-6d</a>";	
	}
	if ($d['address6e']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=6&add=e&card=return'>$packet-6e</a>";	
	}
	if ($d['pobox']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=1&add=PO&card=return'>$packet-1PO</a>";	
	}
	if ($d['pobox'] && $d['name2']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=2&add=PO&card=return'>$packet-2PO</a>";	
	}
	if ($d['pobox'] && $d['name3']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=3&add=PO&card=return'>$packet-3PO</a>";	
	}
	if ($d['pobox'] && $d['name4']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=4&add=PO&card=return'>$packet-4PO</a>";
	}
	if ($d['pobox'] && $d['name5']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=5&add=PO&card=return'>$packet-5PO</a>";	
	}
	if ($d['pobox'] && $d['name6']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=6&add=PO&card=return'>$packet-6PO</a>";	
	}
	if ($d['pobox2']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=1&add=PO2&card=return'>$packet-1PO2</a>";	
	}
	if ($d['pobox2'] && $d['name2']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=2&add=PO2&card=return'>$packet-2PO2</a>";	
	}
	if ($d['pobox2'] && $d['name3']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=3&add=PO2&card=return'>$packet-3PO2</a>";	
	}
	if ($d['pobox2'] && $d['name4']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=4&add=PO2&card=return'>$packet-4PO2</a>";
	}
	if ($d['pobox2'] && $d['name5']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=5&add=PO2&card=return'>$packet-5PO2</a>";	
	}
	if ($d['pobox2'] && $d['name6']){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= ", <a target='_Blank' href='greencard.php?packet=$packet&def=6&add=PO2&card=return'>$packet-6PO2</a>";	
	}
	if ($d['processor_notes']){
		$data .= '<br>'.$d['processor_notes'];	
	}
	$data .= '</td>';
	}else{
	$data .= "</td><td>";
	}
	$data .= "</a></td>";
	$data .= "<td";
	if ($d[rush] == 'checked'){
		$data .= " bgcolor='#FF0000'";
	}elseif($d[priority] == 'checked'){
		$data .= " bgcolor='#00FFFF'";
	}
	$data .=">".$d["affidavit_status"];
	if ($d[rush] == 'checked'){
		$data .= "<br>RUSH";
	}elseif($d[priority] == 'checked'){
		$data .= " <br>PRIORITY";
	}
	$data .="</td>";	
	$data .= "<td>".$d["mail_status"]."</td>";	
	return $data;
}

function getEvictionData($eviction){
	$q="select * from evictionPackets where eviction_id = '$eviction'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$data .= "<tr bgcolor='".statusColor($d[mail_status])."'>
<td nowrap class='noprint'>
	<li><a href='?mail6=$eviction'>Open Papers to Print (And Mark Printed)</a></li>
	";
	$data .= "</td><td nowrap class='noprint' style='background-color:#FF0000;'>";
	if($_COOKIE[psdata][level] == "Operations"){
		$data .= "<a style='background-color:#000000; color:#FFFFFF' href='?mail7=$eviction'><strong>CloseOut</strong></a>";
	}
	$data .= "</td>";
	if(1 == "1"){
		$_SESSION[letters] = $_SESSION[letters]+2;
		$data .= "<td><a target='_Blank' href='greencard.php?packet=$eviction&def=1&card=return'>$eviction-1</a>";
		if ($d['processor_notes']){
			$data .= '<br>'.$d['processor_notes'];	
		}
		$data .= '</td>'.$data2;
	}else{
		$data .= "</td><td>";
	}
	$data .= "</td>";
	$data .= "</a></td>";
	$data .= "<td";
	if ($d[rush] == 'checked'){
		$data .= " bgcolor='#FF0000'";
	}elseif($d[priority] == 'checked'){
		$data .= " bgcolor='#00FFFF'";
	}
	$data .=">".$d["affidavit_status"];
	if ($d[rush] == 'checked'){
		$data .= "<br>RUSH";
	}elseif($d[priority] == 'checked'){
		$data .= " <br>PRIORITY";
	}
	$data .="</td>";	
	$data .= "<td>".$d["mail_status"]."</td>";	
	return $data;
}



if (isset($_GET['mail5'])){
	@mysql_query("update ps_packets set process_status='SERVICE COMPLETED', mail_status='Mailed First Class and Certified Return Receipt' where packet_id = '".$_GET['mail5']."' ");
	header("Location: mailman.php?mailDate=".$_GET[mailDate]);
}
if (isset($_GET['mail4'])){
	$q4="SELECT otd FROM ps_packets WHERE packet_id='".$_GET['mail4']."'";
	$r4=@mysql_query($q4) or die (mysql_error());
	$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
	$href=washURI2($d4[otd]);
	echo "<script>window.open('".$href."', 'print')</script>";
	psActivity("mailPrint");
	ev_timeline($_GET['mail4'],$_COOKIE[psdata][name]." Printed Mail");
	@mysql_query("update ps_packets set mail_status = 'Printed Awaiting Postage' where packet_id = '".$_GET['mail4']."' ");
	echo "<script>window.location.href='mailman.php?mailDate=".$_GET[mailDate]."';</script>";
}
if (isset($_GET['done'])){
	@mysql_query("update ps_packets set process_status = 'AWAITING MAIL CONFIRMATION' where packet_id = '".$_GET['done']."' ");
	header("Location: mailman.php?mailDate=".$_GET[mailDate]);
}
if (isset($_GET['mail7'])){
	@mysql_query("update evictionPackets set process_status='SERVICE COMPLETED', mail_status='Mailed First Class and Certified Return Receipt' where eviction_id = '".$_GET['mail7']."' ");
	header("Location: mailman.php?mailDate=".$_GET[mailDate]);
}
if (isset($_GET['mail6'])){
	$q4="SELECT otd FROM evictionPackets WHERE eviction_id='".$_GET['mail6']."'";
	$r4=@mysql_query($q4) or die (mysql_error());
	$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
	$href=washURI2($d4[otd]);
	echo "<script>window.open('".$href."', 'print')</script>";
	psActivity("mailPrint");
	ev_timeline($_GET['mail6'],$_COOKIE[psdata][name]." Printed Mail");
	@mysql_query("update evictionPackets set mail_status = 'Printed Awaiting Postage' where eviction_id = '".$_GET['mail6']."' ");
	echo "<script>window.location.href='mailman.php?mailDate=".$_GET[mailDate]."';</script>";
}

include 'menu.php';
?>
<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
	a { text-decoration:none; color:#000000; }
	td { padding:5px; }
  </style> 
<form><div align="center"><font size="+2">READY TO MAIL</font><br />Update Affidavits for the date: <? if ($_GET[mailDate]){ echo $_GET[mailDate]; }else{ echo date('F jS Y');}?><br /><input name="mailDate" value="<? if ($_GET[mailDate]){ echo $_GET[mailDate]; }else{ echo date('F jS Y');}?>" /> <input type="submit" value="Set" /></div></form>

<?
$me=$_COOKIE[psdata][user_id];
if($_COOKIE[psdata][level] == "Operations"){
$q="select packet_id, mail_status from ps_packets where (process_status = 'READY TO MAIL' OR mail_status='Printed Awaiting Postage') and rush='checked' order by mail_status, packet_id";
}else{
$q="select packet_id, mail_status from ps_packets where (process_status = 'READY TO MAIL' OR mail_status='Printed Awaiting Postage') and rush='checked' and (server_id = '$me' OR server_ida = '$me' OR server_idb = '$me' OR server_idc = '$me' OR server_idd = '$me' OR server_ide = '$me' ) order by mail_status, packet_id";
}
$r=@mysql_query($q);?>

<table width="100%" border="1" style="border-collapse:collapse; padding:5px;">
<tr><td colspan='5' align='center' style='text-spacing: 5px; background-color:99AAEE; background-color:00BBAA; font-weight:bold;'>FORECLOSURES</td></tr>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ $i++;?>
		<?=getPacketData($d[packet_id])?>
    </tr>    
<? } ?>

<?
if($_COOKIE[psdata][level] == "Operations"){
$q="select packet_id, mail_status from ps_packets where (process_status = 'READY TO MAIL' OR mail_status='Printed Awaiting Postage') and rush <> 'checked' order by mail_status, packet_id";
}else{
$q="select packet_id, mail_status from ps_packets where (process_status = 'READY TO MAIL' OR mail_status='Printed Awaiting Postage') and rush <> 'checked' and (server_id = '$me' OR server_ida = '$me' OR server_idb = '$me' OR server_idc = '$me' OR server_idd = '$me' OR server_ide = '$me' ) order by mail_status, packet_id";
}
$r=@mysql_query($q);

 while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ $i++;?>
		<?=getPacketData($d[packet_id])?>
    </tr>    
<? }
//pull Evictions!
if($_COOKIE[psdata][level] == "Operations"){
$q="select eviction_id, mail_status from evictionPackets where (process_status = 'READY TO MAIL' OR mail_status='Printed Awaiting Postage') and rush='checked' order by mail_status, eviction_id";
}else{
$q="select eviction_id, mail_status from evictionPackets where (process_status = 'READY TO MAIL' OR mail_status='Printed Awaiting Postage') and rush='checked' and (server_id = '$me' OR server_ida = '$me' OR server_idb = '$me' OR server_idc = '$me' OR server_idd = '$me' OR server_ide = '$me') order by mail_status, eviction_id";
}
$r=@mysql_query($q);?>

<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ $i++;?>
		<?=getEvictionData($d[eviction_id])?>
    </tr>    
<? }
echo "<tr><td colspan='5' align='center' style='text-spacing: 5px; background-color:99AAEE; font-weight:bold;'>EVICTIONS</td></tr>";
if($_COOKIE[psdata][level] == "Operations"){
$q="select eviction_id, mail_status from evictionPackets where (process_status = 'READY TO MAIL' OR mail_status='Printed Awaiting Postage') and rush <> 'checked' order by mail_status, eviction_id";
}else{
$q="select eviction_id, mail_status from evictionPackets where (process_status = 'READY TO MAIL' OR mail_status='Printed Awaiting Postage') and rush <> 'checked' and (server_id = '$me' OR server_ida = '$me' OR server_idb = '$me' OR server_idc = '$me' OR server_idd = '$me' OR server_ide = '$me' ) order by mail_status, eviction_id";
}
$r=@mysql_query($q);

 while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ $i++;?>
		<?=getEvictionData($d[eviction_id])?>
    </tr>    
<? } ?>
</table>
<?
include 'footer.php';
?>
<script>document.title='<?=$_SESSION[letters]?> Letters <?=$_SESSION[ready]?> Queued <?=$_SESSION[printed]?> Printed';</script>
