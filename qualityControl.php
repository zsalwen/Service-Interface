<?
include 'common.php';
hardLog('Quality Control Report','user');
include 'lock.php';
opLog($_COOKIE[psdata][name]." Loaded Quality Control");
if ($_GET[mailDate]){

	$mailDate=$_GET[mailDate];
}else{
	$mailDate=date('Y-m-d');
}
//include 'menu.php';
$i=0;
?>
<style>
a { color:#000000; text-decoration:none }
td { color:#000000 }
.M2 { background-color:#FF6633; color:#666666}
.I { background-color:#FF66CC; color:#FFFFFF}
.P { background-color:#00CC00; color:#FFFFFF}
.M { background-color:#CCCC00; color:#FFFFFF}
.M23 { background-color:#FF4477; color:#666666}
.I3 { background-color:#6688CC; color:#CCCCCC}
.P3 { background-color:#99FF00; color:#CCCCCC}
.M3 { background-color:#CCCC00; color:#CCCCCC}
td { border-bottom:solid 1px; border-right:dotted 1px; font-size:12px;}
</style>
<table><tr><td>
<form><div align="center">Update Affidavits for the date: <? if ($_GET[mailDate]){ echo $_GET[mailDate]; }else{ echo date('Y-m-d');}?><br /><input name="mailDate" size=10 value="<? if ($_GET[mailDate]){ echo $_GET[mailDate]; }else{ echo date('Y-m-d');}?>" /> <input type="submit" value="Set" /></div></form>
</td></tr><tr><td valign="top">
<table width="100%" style="border-collapse:collapse;" border="1">
    <tr bgcolor="#FFCC66">
    	<td>Received</td>
    	<td>Packet Number</td>
        <td>Order Link</td>
        <td>Primary Server</td>
		<td>Client</td>
        <td>Service Status</td>
        <td>Affidavit Status</td>
        <td>Affidavit Corrections</td>
        <td>Op. Notes</td>
        <td>Ext. Notes</td>
        </tr>

<?
$qc="SELECT DISTINCT packet_id, attorneys_id, service_status, affidavit_status, filing_status, server_id, server_ida, server_idb, server_idc, server_idd, server_ide, processor_notes, reopenNotes, extended_notes, date_received, client_file, rush, priority FROM ps_packets WHERE process_status = 'ASSIGNED' AND (request_close = 'YES' OR request_closea = 'YES' OR request_closeb = 'YES' OR request_closec = 'YES' OR request_closed = 'YES' OR request_closee = 'YES') order by date_received";
$rc=@mysql_query($qc) or die(mysql_error());

while ($dc=mysql_fetch_array($rc, MYSQL_ASSOC)){ $i++;?>
	
    <tr class="<?=substr($dc[service_status],0,1)?>">
    	<td nowrap="nowrap"><?=$dc[date_received]?><br><?=$dc[client_file]?></td>
        <td><a class="x<?=$dc[attorneys_id]?>" href="http://mdwestserve.com/ps/wizard.php?jump=<?=$dc[packet_id]?>-1&mailDate=<?=$mailDate?>" target="_blank">Load <?=$dc[packet_id]?></a></td>
                <td><a href="http://mdwestserve.com/ps/order.php?packet=<?=$dc[packet_id]?>" target="_blank">Load Order</a></td>
                <td><?=id2name($dc[server_id])?> <?=id2name($dc[server_ida])?> <?=id2name($dc[server_idb])?> <?=id2name($dc[server_idc])?> <?=id2name($dc[server_idd])?> <?=id2name($dc[server_ide])?></td>
		<td <? if ($dc[rush] == 'checked'){echo "bgcolor='#FF0000'";}elseif($dc[priority] == 'checked'){echo "bgcolor='#00FFFF'";} ?>><?=id2attorney($dc[attorneys_id])?><? if ($dc[rush] == 'checked'){echo "<br><b>RUSH</b>";} ?><? if ($dc[priority] == 'checked'){echo "<br><b>PRIORITY</b>";} ?></td>
        <td><?=$dc[service_status]?></td>
        <td><?=$dc[affidavit_status]?></td>
        <td><?=stripslashes($dc[reopenNotes])?></td>
        <td><?=stripslashes($dc[processor_notes])?></td>
        <td><?=stripslashes($dc[extended_notes])?></td>
</tr>
<? } 
//pull evictions
$qc="SELECT DISTINCT eviction_id, attorneys_id, service_status, affidavit_status, filing_status, server_id, server_ida, server_idb, server_idc, server_idd, server_ide, processor_notes, reopenNotes, extended_notes, date_received, client_file, rush, priority FROM evictionPackets WHERE process_status = 'ASSIGNED' AND (request_close = 'YES' OR request_closea = 'YES' OR request_closeb = 'YES' OR request_closec = 'YES' OR request_closed = 'YES' OR request_closee = 'YES') order by date_received";
$rc=@mysql_query($qc) or die(mysql_error());

while ($dc=mysql_fetch_array($rc, MYSQL_ASSOC)){ $i++;?>
	
    <tr class="<?=substr($dc[service_status],0,1)?>3">
    	<td nowrap="nowrap"><?=$dc[date_received]?><br><?=$dc[client_file]?></td>
        <td><a class="x<?=$dc[attorneys_id]?>" href="http://service.mdwestserve.com/ev_wizard.php?jump=<?=$dc[eviction_id]?>-1&mailDate=<?=$mailDate?>" target="_blank">Load <?=$dc[eviction_id]?></a></td>
                <td><a href="http://staff.mdwestserve.com/ev/order.php?packet=<?=$dc[eviction_id]?>" target="_blank">Load Order</a></td>
                <td><?=id2name($dc[server_id])?> <?=id2name($dc[server_ida])?> <?=id2name($dc[server_idb])?> <?=id2name($dc[server_idc])?> <?=id2name($dc[server_idd])?> <?=id2name($dc[server_ide])?></td>
		<td <? if ($dc[rush] == 'checked'){echo "bgcolor='#FF0000'";}elseif($dc[priority] == 'checked'){echo "bgcolor='#00FFFF'";} ?>><?=id2attorney($dc[attorneys_id])?><? if ($dc[rush] == 'checked'){echo "<br><b>RUSH</b>";} ?><? if ($dc[priority] == 'checked'){echo "<br><b>PRIORITY</b>";} ?></td>
        <td><?=$dc[service_status]?></td>
        <td><?=$dc[affidavit_status]?></td>
        <td><?=stripslashes($dc[reopenNotes])?></td>
        <td><?=stripslashes($dc[processor_notes])?></td>
        <td><?=stripslashes($dc[extended_notes])?></td>
</tr>
<? } ?>
<h1 align="center">There are <?=$i?> Cases to Review for Close - <a href="multChecklist.php?autoPrint=1" target="_blank">Print All Checklists</a></h1>
<? $final1 = $i;?>
</table>

</td></tr>
</td></tr></table>
<script>document.title='Quality Control: <?=$final1?> Close';</script>
<?
//include 'footer.php';
?>
<meta http-equiv="refresh" content="60" />
<? mysql_close();?>