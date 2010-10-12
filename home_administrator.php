<? 
include 'common.php';
if ($_GET[update]){
$q="UPDATE ps_packets SET process_status='AWAITING AFFIDAVIT CONFIRMATION' where packet_id = '$_GET[update]'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
header('Location: home_administrator.php');
}

if ($_COOKIE[psdata][level] != "Administrator"){
		if ($_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Operations") {
		
		}else{
			$event = 'home_administrator.php';
			$email = $_COOKIE[psdata][email];
			$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
			//@mysql_query($q1) or die(mysql_error());
			header('Location: home.php');
		}
}

include 'menu.php';



?>
<table border="1" style="border-collapse:collapse" align="center" width="100%">

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
$q= "select * from ps_packets order by process_status";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
?>
    <tr>
    	<td colspan="12" class="pstd" align="center"><strong><?=$status?> Files</strong></td>
    </tr>
<?
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {$i++;
$q2="SELECT history_id from ps_history where packet_id = '$d[packet_id]'";
$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
$d2=mysql_num_rows($r2);
?>
    <tr bgcolor="<?=row_color($i,'#99cccc','#99ccff')?>">
    	<td nowrap="nowrap"><a class="pff" href="<?=$d[otd]?>" target="_blank"><?=$d[packet_id]?>) PDF</a></td>
		<td nowrap="nowrap" title="Package <?=$d[packet_id]?>" class="pcc" onclick="window.location='service.php?packet=<?=$d[packet_id]?>'">Service</td>
        <td nowrap="nowrap">
        <? if ($d[name1]){?><a class="pff" title="Affidavit for <?=$d[name1]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=1&server=<?=$d[server_id]?>')">| <?=$d[name1]?> | </a><? }else{ } ?>
        <? if ($d[name2]){?><a class="pff" title="Affidavit for <?=$d[name2]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=2&server=<?=$d[server_id]?>')"><?=$d[name2]?> | </a><? }else{ } ?>
        <? if ($d[name3]){?><a class="pff" title="Affidavit for <?=$d[name3]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=3&server=<?=$d[server_id]?>')"><?=$d[name3]?> | </a><? }else{ } ?>
        <? if ($d[name4]){?><a class="pff" title="Affidavit for <?=$d[name4]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=4&server=<?=$d[server_id]?>')"><?=$d[name4]?> | </a><? }else{ } ?>
        </td>
        <td nowrap="nowrap">
		<? if ($d[photo1a]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo1a']?>&address=<?=$d[address1]?>' target="$d[packet_id]photo1a">1A</a><? }else{ } ?>
        <? if ($d[photo1b]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo1b']?>&address=<?=$d[address1]?>' target="$d[packet_id]photo1b">1B</a><? }else{ } ?>
        <? if ($d[photo1c]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo1c']?>&address=<?=$d[address1a]?>' target="$d[packet_id]photo1c">1C</a><? }else{ } ?>
        <? if ($d[photo2a]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo2a']?>&address=<?=$d[address2]?>' target="$d[packet_id]photo2a">2A</a><? }else{ } ?>
        <? if ($d[photo2b]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo2b']?>&address=<?=$d[address2]?>' target="$d[packet_id]photo2b">2B</a><? }else{ } ?>
        <? if ($d[photo2c]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo2c']?>&address=<?=$d[address2a]?>' target="$d[packet_id]photo2c">2C</a><? }else{ } ?>
        <? if ($d[photo3a]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo3a']?>&address=<?=$d[address3]?>' target="$d[packet_id]photo3a">3A</a><? }else{ } ?>
        <? if ($d[photo3b]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo3b']?>&address=<?=$d[address3]?>' target="$d[packet_id]photo3b">3B</a><? }else{ } ?>
        <? if ($d[photo3c]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo3c']?>&address=<?=$d[address3a]?>' target="$d[packet_id]photo3c">3C</a><? }else{ } ?>
        <? if ($d[photo4a]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo4a']?>&address=<?=$d[address4]?>' target="$d[packet_id]photo4a">4A</a><? }else{ } ?>
		<? if ($d[photo4b]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo4b']?>&address=<?=$d[address4]?>' target="$d[packet_id]photo4b">4B</a><? }else{ } ?>
		<? if ($d[photo4c]){
		?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d['photo4c']?>&address=<?=$d[address4a]?>' target="$d[packet_id]photo4c">4C</a><? }else{ } ?></td>
        <td nowrap="nowrap" align="center"><a class="pff"  title="Profile information for <?=id2name($d[server_id])?>" href="contractor_review.php?admin=<?=$d[server_id]?>"><?=id2name($d[server_id])?></a>($<?=$d[contractor_rate] ?>)</td>
        <td nowrap="nowrap" align="center"><a class="pff"  title="Profile information for <?=id2name($d[server_ida])?>" href="contractor_review.php?admin=<?=$d[server_ida]?>"><?=id2name($d[server_ida])?></a>($<?=$d[contractor_ratea] ?>)</td>
        <td nowrap="nowrap"><?=id2attorney($d[attorneys_id])?> ($<?=$d[client_rate];?>/<?=$d[client_ratea];?>)</td>
        <td nowrap="nowrap"><?=$d[client_file] ?> - <?=$d[case_no] ?></td>
        <td nowrap="nowrap"><?=$d[circuit_court]?></td>
        <td nowrap="nowrap" title="Details for service address <?=$d[address1]?>" class="pdd" onclick="window.location='ps_details.php?pkg=<?=$d[packet_id]?>'"><small><?=$d[address1] ?></small> (<small><?=$d[state1] ?>/<?=$d[state1a] ?></small>)</td>
        <td nowrap="nowrap"><? if ($d[process_status] == 'ASSIGNED'){echo "<a title='Click to mark file AWAITING AFFIDAVIT CONFIRMATION' class='pff' href='home_administrator.php?update=$d[packet_id]'>$d[process_status]</a>"; }else{echo $d[process_status]; }?></td>
        <td nowrap="nowrap" title="history items for packet <?=$d[packet_id]?>"><?=$d2?></td>
	</tr>
<?  
}
?>


</table>
<?
include 'footer.php';
?>