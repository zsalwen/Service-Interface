<?
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Affidavit Manager');

function getPacketData($packet){
	$q="select * from ps_packets where packet_id = '$packet'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[name1]){$defs++;}
	if ($d[name2]){$defs++;}
	if ($d[name3]){$defs++;}
	if ($d[name4]){$defs++;}
	$data .= "<td nowrap>$d[case_no]</td>";	
	if ($_GET['server'] == "operations"){
		if ($d[server_ida]){
			$ida=", ".id2name($d[server_ida]);
		}
		if ($d[server_idb]){
			$idb=", ".id2name($d[server_idb]);
		}
		$data .= "<td nowrap>".id2name($d[server_id]).$ida.$idb."</td>";	
	}
	$data .= "<td nowrap>$d[affidavit_status]</td>";	
	if ($_GET['server'] == "operations"){
		$q1="SELECT affidavitID from ps_affidavits where packetID = '$packet'";
		$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
		$d1=mysql_num_rows($r1);
		if ($d1 > 0 && $d1 != $defs){
			$data .="<td nowrap bgcolor='#FFCCFF' align='center'>$d1/$defs</td>";
		}elseif($d1 > 0 && $d1 == $defs){
			$data .="<td nowrap bgcolor='#CCFFCC' align='center'>$d1/$defs</td>";
		}else{
			$data .="<td nowrap align='center'>$d1</td>";
		}
	}
	$data .= "<td nowrap><a title='Mark Affidavits Faxed and Mailed for case $d[case_no]' href='?returned=$packet'>Returned</a>";
	if ($_GET['server'] == "operations"){
		$data .= "| <a title='Mark Affidavits Received for case $d[case_no]' href='?received=$packet&server=operations'>Received</a> | <a title='Mark Affidavits Filed and Mailed for case $d[case_no]' href='?filed=$packet&server=operations'>Filed and Mailed</a>";
	}
	$data .= "</td><td nowrap> |";	
	return $data;
}


if (isset($_GET['returned'])){
	@mysql_query("update ps_packets set affidavit_status='RETURNED' where packet_id = '".$_GET['returned']."' ");
	header('Location: affidavitManager.php');
}
if (isset($_GET['received'])){
	@mysql_query("update ps_packets set affidavit_status='RECEIVED' where packet_id = '".$_GET['received']."' ");
	header('Location: affidavitManager.php?server='.$_GET['server']);
}
if (isset($_GET['filed'])){
	@mysql_query("update ps_packets set affidavit_status='FILED AND MAILED' where packet_id = '".$_GET['filed']."' ");
	header('Location: affidavitManager.php?server='.$_GET['server']);
}


include 'menu.php';
?>
<div style="border:dashed 2px #FFFFFF">
<h1 align="center">Affidavit Manager</h1>
Instructions:<br>
This is a list of all confirmed affidavits to be printed and returned<br>
</div>
<?
$i='';

if (isset($_GET['server'])){
	if ($_GET['server'] == "operations"){	
	$q="select * from ps_packets order by packet_id DESC";
	}else{
	$server = $_GET['server'];
	$q="select * from ps_packets where (affidavit_status='SERVICE CONFIRMED' or affidavit_status='RETURNED') AND (server_id = '$server' OR server_ida = '$server' OR server_idb = '$server') order by packet_id DESC";
	}
}else{
	$server = $_COOKIE['psdata']['user_id'];
	$q="select * from ps_packets where (affidavit_status='SERVICE CONFIRMED' or affidavit_status='RETURNED' or process_status='READY TO MAIL') AND (server_id = '$server' OR server_ida = '$server' OR server_idb = '$server') order by packet_id DESC";
}

$r=@mysql_query($q);
?>

<table width="100%" border="1" style="border-collapse:collapse">
	<tr bgcolor="#CCCCCC" align="center">
    	<td>Case&nbsp;Number</td>
        <? if ($_GET['server'] == "operations"){ ?>
        <td>Servers</td>
        <? } ?>
        <td>Affidavit Status</td>
        <? if ($_GET['server'] == "operations"){ ?>
        <td>Affs/Defs</td>
        <? } ?>
        <td>Mark Affidavit</td>
        <td>Affidavit Links</td>
     </tr>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ $i++;
		if ($_GET['server'] == "operations"){
			$html="&server=".$d[server_id]; 
		}
?>
	<tr>
		<?=getPacketData($d[packet_id])?> 
		<? if ($d[name1]){ ?><a title="View Affidavit for <?=$d[name1]?>" href='affidavit.php?packet=<?=$d[packet_id]?>&def=1<?=$html?>' target='_Blank'><?=$d[name1]?></a> <? } ?>
		<? if ($d[name2]){ ?>| <a title="View Affidavit for <?=$d[name2]?>" href='affidavit.php?packet=<?=$d[packet_id]?>&def=2<?=$html?>' target='_Blank'><?=$d[name2]?></a> <? } ?>
		<? if ($d[name3]){ ?>| <a title="View Affidavit for <?=$d[name3]?>" href='affidavit.php?packet=<?=$d[packet_id]?>&def=3<?=$html?>' target='_Blank'><?=$d[name3]?></a> <? } ?>
		<? if ($d[name4]){ ?>| <a title="View Affidavit for <?=$d[name4]?>" href='affidavit.php?packet=<?=$d[packet_id]?>&def=4<?=$html?>' target='_Blank'><?=$d[name4]?></a><? } ?>|
        <? if ($_GET['server'] == 'operations'){ echo '<a href="affidavitUpload.php?packet='.$d[packet_id].'">Upload</a> |';  }?></td>
    </tr>    
<? } ?>
</table>
<?
include 'footer.php';
?>