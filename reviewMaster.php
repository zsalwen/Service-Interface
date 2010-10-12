<?
include 'common.php';
include 'lock.php';
opLog($_COOKIE[psdata][name]." Loaded Quality Control");

$i=0;
?>
<style>
body{ padding:0px; margn:0px}
a { color:#000000; text-decoration:none }
td { color:#000000 }
.M2 { background-color:#FF6633; color:#666666}
.I { background-color:#FF66CC; color:#FFFFFF}
.P { background-color:#00CC00; color:#FFFFFF}
.M { background-color:#CCCC00; color:#FFFFFF}
td { border-bottom:solid 1px; border-right:dotted 1px; font-size:18px;}
</style>
<div>Confirm Service</div>

<?
$qc="SELECT DISTINCT packet_id, attorneys_id, service_status, affidavit_status, filing_status, server_id, server_ida, server_idb, server_idc, server_idd, server_ide, processor_notes, reopenNotes, extended_notes, date_received FROM ps_packets WHERE process_status = 'ASSIGNED' AND (request_close = 'YES' OR request_closea = 'YES' OR request_closeb = 'YES' OR request_closec = 'YES' OR request_closed = 'YES' OR request_closee = 'YES') order by date_received";
$rc=@mysql_query($qc) or die(mysql_error());

while ($dc=mysql_fetch_array($rc, MYSQL_ASSOC)){ $i++;?>
	<table width="100%" style="border-collapse:collapse;" border="1">

    <tr class="<?=substr($dc[service_status],0,1)?>">
    	
        <td style='border-top:solid 4px;'><?=$dc[packet_id]?>: <a class="x<?=$dc[attorneys_id]?>" href="http://mdwestserve.com/ps/wizard.php?jump=<?=$dc[packet_id]?>-1" target="_blank">Wizard</a> or <a href="http://mdwestserve.com/ps/order.php?packet=<?=$dc[packet_id]?>" target="_blank">Order</a></td>
        <td style='border-top:solid 4px;' colspan='2'><?=id2name($dc[server_id])?> <?=id2name($dc[server_ida])?> <?=id2name($dc[server_idb])?> <?=id2name($dc[server_idc])?> <?=id2name($dc[server_idd])?> <?=id2name($dc[server_ide])?></td>
	</tr>
	<tr class="<?=substr($dc[service_status],0,1)?>">
        <td><?=id2attorney($dc[attorneys_id])?></td>
		<td><?=$dc[service_status]?></td>
        <td><?=$dc[affidavit_status]?></td>
	</tr>
		<tr class="<?=substr($dc[service_status],0,1)?>">
        <td><?=stripslashes($dc[reopenNotes])?></td>
        <td><?=stripslashes($dc[processor_notes])?></td>
        <td><?=stripslashes($dc[extended_notes])?></td>
</tr></table><br><br>

<? } ?>
<? $final1 = $i;?>
<div>Confirm mailing</div>

<? $i=0;?>


<?
mysql_select_db ('core');
$qd="SELECT DISTINCT packet_id, attorneys_id, service_status, affidavit_status, filing_status, server_id, server_ida, server_idb, server_idc, server_idd, server_ide, processor_notes, reopenNotes,extended_notes, date_received FROM ps_packets WHERE process_status = 'AWAITING AFFIDAVIT CONFIRMATION' OR process_status = 'AWAITING MAIL CONFIRMATION' order by date_received";
$rd=@mysql_query($qd) or die(mysql_error());
while ($dd=mysql_fetch_array($rd, MYSQL_ASSOC)){ $i++;?>
   <table width="100%" style="border-collapse:collapse;" border="1"> <tr class="<?=substr($dd[service_status],0,1)?>">
    	
        <td style='border-top:solid 4px;'><?=$dd[packet_id]?>: <a class="x<?=$dd[attorneys_id]?>" href="http://mdwestserve.com/ps/wizard.php?jump=<?=$dd[packet_id]?>-1" target="_blank">Wizard</a> or <a href="http://mdwestserve.com/ps/order.php?packet=<?=$dd[packet_id]?>" target="_blank">Order</a></td>
        <td style='border-top:solid 4px;' colspan='2'><?=id2name($dd[server_id])?> <?=id2name($dd[server_ida])?> <?=id2name($dd[server_idb])?> <?=id2name($dd[server_idd])?> <?=id2name($dd[server_idd])?> <?=id2name($dd[server_ide])?></td>
	</tr>
	<tr class="<?=substr($dd[service_status],0,1)?>">
        <td><?=id2attorney($dd[attorneys_id])?></td>
		<td><?=$dd[service_status]?></td>
        <td><?=$dd[affidavit_status]?></td>
	</tr>
		<tr class="<?=substr($dd[service_status],0,1)?>">
        <td><?=stripslashes($dd[reopenNotes])?></td>
        <td><?=stripslashes($dd[processor_notes])?></td>
        <td><?=stripslashes($dd[extended_notes])?></td>
</tr></table>
<? }?>


<script>document.title='<?=$final1?> Close <?=$i?> Mail';</script>
<meta http-equiv="refresh" content="120" />
