<?
include 'common.php';
include 'lock.php';
include 'menu.php';
if (isset($_POST[closeOut])){
	@mysql_query("UPDATE ps_packets SET closeOut='$_POST[closeOut]' where packet_id='$_POST[packet_id]'");
}
?>
<form method="post">
<table align="center">
	<tr>
        <td>Packet #: <input name="packet_id" /></td>
    	<td>CloseOut: <input name="closeOut" /></td>
        <td><input type="submit" /></td>
    </tr>
</table>
</form>

<table align="center" width="100%" border="1" style="border-collapse:collapse">
<? 
$q="SELECT * from ps_packets where (closeOut='' or closeOut='0000-00-00') AND process_status <> 'CANCELLED' AND process_status <> 'DAMAGED PDF' AND process_status <> 'DUPLICATE' order by packet_id ASC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){$i++;
?>
	<tr>
    	<td><small><?=$d[packet_id]?> - <?=id2attorney($d[attorneys_id])?></small></td>
        <td><?=$d[date_received]?></td>
        <td><small><?=$d[service_status]?></small></td>
        <td><? if ($d[server_id]){ echo id2name($d[server_id]);}?><? if ($d[server_ida]){ echo ', '.id2name($d[server_ida]);}?><? if ($d[server_idb]){ echo ', '.id2name($d[server_idb]);}?><? if ($d[server_idc]){ echo ', '.id2name($d[server_idc]);}?><? if ($d[server_idd]){ echo ', '.id2name($d[server_idd]);}?><? if ($d[server_ide]){ echo ', '.id2name($d[server_ide]);}?></td>
	</tr>
<? } ?>
<div style="background-color:#00FF00; font-weight:900; color:#0000FF; height:20px" align="center"><?=$i?> Files Needing Closeout</div>
</table>
<table align="center" width="100%" border="1" style="border-collapse:collapse">
<? 
$q="SELECT * from ps_packets where closeOut <> '' and closeOut <> '0000-00-00' AND process_status <> 'CANCELLED' AND process_status <> 'DAMAGED PDF' AND process_status <> 'DUPLICATE' order by packet_id ASC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i2=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){$i2++;
?>
	<tr>
    	<td><small><a href="order.php?packet=<?=$d[packet_id]?>" target="_blank"><?=$d[packet_id]?></a> - <?=id2attorney($d[attorneys_id])?></small></td>
        <td><?=$d[closeOut]?></td>
        <td><?=$d[date_received]?></td>
        <td><small><?=$d[service_status]?></small></td>
        <td><? if ($d[server_id]){ echo id2name($d[server_id]);}?><? if ($d[server_ida]){ echo ', '.id2name($d[server_ida]);}?><? if ($d[server_idb]){ echo ', '.id2name($d[server_idb]);}?><? if ($d[server_idc]){ echo ', '.id2name($d[server_idc]);}?><? if ($d[server_idd]){ echo ', '.id2name($d[server_idd]);}?><? if ($d[server_ide]){ echo ', '.id2name($d[server_ide]);}?></td>
        <td><? if ($d[name1]){?><a href="wizard.php?jump=<?=$d[packet_id]?>-1">[1]</a><? } ?>
        	<? if ($d[name2]){?><a href="wizard.php?jump=<?=$d[packet_id]?>-2">[2]</a><? } ?>
            <? if ($d[name3]){?><a href="wizard.php?jump=<?=$d[packet_id]?>-3">[3]</a><? } ?>
            <? if ($d[name4]){?><a href="wizard.php?jump=<?=$d[packet_id]?>-4">[4]</a><? } ?>
            <? if ($d[name5]){?><a href="wizard.php?jump=<?=$d[packet_id]?>-5">[5]</a><? } ?>
            <? if ($d[name6]){?><a href="wizard.php?jump=<?=$d[packet_id]?>-6">[6]</a><? } ?>
        </td>
	</tr>
<? } ?>
<div style="font-size:48px; background-color:#00FF00; font-weight:900; color:#0000FF; height:100px" align="center"><?=$i2?> Closed Out Files</div>
</table>
<? include 'footer.php'; ?>