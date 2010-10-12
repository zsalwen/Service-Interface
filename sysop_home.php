<? include 'common.php';
if ($_GET[update]){
$q="UPDATE ps_packets SET process_status='AWAITING AFFIDAVIT CONFIRMATION' where packet_id = '$_GET[update]'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
header('Location: home_administrator.php');
}

if ($_COOKIE[psdata][level] != "SysOp"){
	$event = 'sysop_home.php';
	$email = $_COOKIE[psdata][email];
	$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
	//@mysql_query($q1) or die(mysql_error());
	header('Location: home.php');
}

	include 'menu.php';
?>
<table border="1" style="border-collapse:collapse" align="center" width="100%">
    <tr bgcolor="#CCCCCC">
    	<td align="center" colspan="3" width="7%"><small>Links</small></td>
        <td align="center"><small>Affidavits</small></td>
    	<td align="center"><small>Photos</small></td>
        <td align="center"><small>Server</small></td>
        <td align="center"><small>Client</small></td>
        <td align="center"><small>File #</small></td>
        <td align="center"><small>County</small></td>
        <td align="center"><small>Address</small></td>
        <td align="center"><small>Status</small></td>
        <td align="center"><small>Started</small></td>
    </tr>

<style>
.pstd{background-color:#333333; color:#CCCCCC;}
.mem{font-size:11px; font-variant:small-caps; font-weight:bold;}
td.pcc:hover{ background-color:#333333; color:#FF0000; cursor:pointer;}
td.pdd:hover{ background-color:#CCFFCC; color:#000000; cursor:pointer;}
a.pff{color:#000000; text-decoration:none;}
a.pff:link{color:#000000; text-decoration:none;}
a.pff:visited{color:#000000; text-decoration:none;}
a.pff:hover{ color:#990000; cursor:pointer; text-decoration:none;}
</style>
<?
$q= "select * from ps_packets order by process_status, server_id DESC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {$i++;
?>
    <tr bgcolor="<?=row_color($i,'#99cccc','#99ccff')?>">
    	<td nowrap="nowrap" title="Order to Docket for file <?=$d[client_file]?>" class="pcc" style="border-right:hidden;" onclick="window.open('<?=$d[otd]?>')"><font size="-2">OTD</font></td>
		<td nowrap="nowrap" title="Packet <?=$d[packet_id]?>" class="pcc" style="border-right:hidden;" onclick="window.location='service.php?packet=<?=$d[packet_id]?>'"><font size="-2">Service</font></td>
        <td nowrap="nowrap" class="pcc" onclick="window.open('print_out.php?packet=<?=$d[packet_id]?>')"><font size="-2">Info</font></td>
        <td nowrap="nowrap">
        <? if ($d[name1]){?><a class="pff" title="Affidavit for <?=$d[name1]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=1')">|<font size='-2'><?=$d[name1]?></font>|</a><? }else{ }?>
        <? if ($d[name2]){?><a class="pff" title="Affidavit for <?=$d[name2]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=2')"><font size='-2'><?=$d[name2]?></font>|</a><? }else{ }?>
        <? if ($d[name3]){?><a class="pff" title="Affidavit for <?=$d[name3]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=3')"><font size='-2'><?=$d[name3]?></font>|</a><? }else{ }?>
        <? if ($d[name4]){?><a class="pff" title="Affidavit for <?=$d[name4]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=4')"><font size='-2'><?=$d[name4]?></font>|</a><? }else{ }?>
        </td>
        <td nowrap="nowrap">
		<? if ($d[photo1a]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo1a']?>&address=<?=$d[address1]?>' target="$d[packet_id]photo1a">1A</a><? }else{ } ?>
        <? if ($d[photo1b]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo1b']?>&address=<?=$d[address1]?>' target="$d[packet_id]photo1b">1B</a><? }else{ } ?>
        <? if ($d[photo2a]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo2a']?>&address=<?=$d[address2]?>' target="$d[packet_id]photo2a">2A</a><? }else{ } ?>
        <? if ($d[photo2b]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo2b']?>&address=<?=$d[address2]?>' target="$d[packet_id]photo2b">2B</a><? }else{ } ?>
        <? if ($d[photo3a]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo3a']?>&address=<?=$d[address3]?>' target="$d[packet_id]photo3a">3A</a><? }else{ } ?>
        <? if ($d[photo3b]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo3b']?>&address=<?=$d[address3]?>' target="$d[packet_id]photo3b">3B</a><? }else{ } ?>
        <? if ($d[photo4a]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo4a']?>&address=<?=$d[address4]?>' target="$d[packet_id]photo4a">4A</a><? }else{ } ?>
		<? if ($d[photo4b]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo4b']?>&address=<?=$d[address4]?>' target="$d[packet_id]photo4b">4B</a><? }else{ } ?></td>
        <td nowrap="nowrap" align="center" class="pcc" title="Profile for <?=id2name($d[server_id])?>" onclick="window.location='contractor_review.php?admin=<?=$d[server_id]?>'"><font size='-2'><?=ucwords(strtolower(id2name($d[server_id])))?></font></td>
        <td nowrap="nowrap" align="center"><small><?=id2attorney($d[attorneys_id])?></small></td>
        <td nowrap="nowrap"><small><?=$d[client_file] ?></small></td>
        <td nowrap="nowrap"><font size='-2'><?=$d[circuit_court]?></font></td>
        <td nowrap="nowrap" class="pdd" title="Details for service address <?=$d[address1]?>" onclick="window.location='ps_details.php?pkg=<?=$d[packet_id]?>'"><small><?=$d[address1] ?></small></td>
        <td nowrap="nowrap"><? if($d[process_status] == 'AWAITING AFFIDAVIT CONFIRMATION'){echo "<font size='-2'>CONFIRM AFFIDAVIT</font>";}elseif($d[process_status] == 'AWAITING PHOTO CONFIRMATION'){echo "<font size='-2'>CONFIRM PHOTO</font>";}else{echo "<font size='-2'>".$d[process_status]."</font>"; }?></td>
        <? $received=explode(' ',$d[date_received]);?>
        <td nowrap="nowrap"><small><?=$received[0]?></small></td>
	</tr>
<?  
}
?>
<tr>
	<td colspan="12" bgcolor="#333333" align="center"><strong style="color:#FFFFFF"><?=$i?> files in the system</strong></td>
</tr>

</table>
<? include 'footer.php'; ?>