<? 
include 'common.php';

if ($_COOKIE[psdata][level] != "Dispatch"){
		if ($_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Operations") {
		
		}else{
			$event = 'home_administrator.php';
			$email = $_COOKIE[psdata][email];
			$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
			//@mysql_query($q1) or die(mysql_error());
			header('Location: home.php');
		}
}

include 'menu.php'; ?>
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
<? if ($_GET[id]){?>
    <table border="1" style="border-collapse:collapse" align="center" width="100%">
        <tr bgcolor="#CCCCCC">
            <td align="center" colspan="3"><strong>Links</strong></td>
            <td align="center"><strong>to be served....</strong></td>
            <td align="center" width="18%"><strong>Photos</strong></td>
            <td align="center"><strong>Circuit Court</strong></td>
            <td align="center" width="40%"><strong>Service Address</strong></td>
            <td align="center"><strong>Started</strong></td>
            <td align="center"><strong>History</strong></td>
        </tr>
    <? $q1="SELECT * from ps_packets where server_id='$_GET[id]' and process_status <> 'CANCELLED'";
        $r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
		$i2=0;
        while ($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){$i2++; ?>
            <tr bgcolor="<?=row_color($i2,'#99cccc','#99ccff')?>">
                <td nowrap="nowrap"><?=$i2?>) </td>
                <td nowrap="nowrap" title="Papers to Serve" class="pcc" onclick="window.open('<?=$d1[otd]?>')">OTD</td>
                <td nowrap="nowrap" title="Packet <?=$d1[packet_id]?>" class="pcc" onclick="window.location='service.php?packet=<?=$d1[packet_id]?>'">Service Details</td>
                <td nowrap="nowrap">
                <? if ($d1[name1]){?>+ <?=$d1[name1]?> +<? }else{ } ?>
                <? if ($d1[name2]){?><?=$d1[name2]?> +<? }else{ } ?>
                <? if ($d1[name3]){?><?=$d1[name3]?> +<? }else{ } ?>
                <? if ($d1[name4]){?><?=$d1[name4]?> +<? }else{ } ?>
                </td>
                <td nowrap="nowrap">
                <? if ($d1[photo1a]){
                ?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d1['photo1a']?>&address=<?=$d1[address1]?>' target="$d[packet_id]photo1a">1A</a><? }else{ } ?>
                <? if ($d1[photo1b]){
                ?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d1['photo1b']?>&address=<?=$d1[address1]?>' target="$d[packet_id]photo1b">1B</a><? }else{ } ?>
                <? if ($d1[photo2a]){
                ?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d1['photo2a']?>&address=<?=$d1[address2]?>' target="$d[packet_id]photo2a">2A</a><? }else{ } ?>
                <? if ($d1[photo2b]){
                ?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d1['photo2b']?>&address=<?=$d1[address2]?>' target="$d[packet_id]photo2b">2B</a><? }else{ } ?>
                <? if ($d1[photo3a]){
                ?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d1['photo3a']?>&address=<?=$d1[address3]?>' target="$d[packet_id]photo3a">3A</a><? }else{ } ?>
                <? if ($d1[photo3b]){
                ?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d1['photo3b']?>&address=<?=$d1[address3]?>' target="$d[packet_id]photo3b">3B</a><? }else{ } ?>
                <? if ($d1[photo4a]){
                ?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d1['photo4a']?>&address=<?=$d1[address4]?>' target="$d[packet_id]photo4a">4A</a><? }else{ } ?>
                <? if ($d1[photo4b]){
                ?><a class="pff" style="font-size:11px" href='../process_server_add_address.php?pic2=<?=$d1['photo4b']?>&address=<?=$d1[address4]?>' target="$d[packet_id]photo4b">4B</a><? }else{ } ?></td>
                <td nowrap="nowrap"><?=$d1[circuit_court]?></td>
                <td nowrap="nowrap" title="Details for service address <?=$d1[address1]?>" class="pdd" onclick="window.location='ps_details.php?pkg=<?=$d1[packet_id]?>'"><small><?=$d1[address1] ?><? if ($d1[address1a] != ''){ echo "(a)";}?><? if ($d1[address1b] != ''){ echo "(b)";}?></small></td>
                <td nowrap="nowrap"><?=$d1[alert_date];?></td>
                <td>
                <?
                $rx = @mysql_query("SELECT packet_id FROM ps_history WHERE packet_id = '$d1[packet_id]'");
                echo mysql_num_rows($rx);
                ?>
                </td>
            </tr>
<?		}
?></table>
<? }else{ ?>
<table border="1" style="border-collapse:collapse" align="center" width="100%">
    <tr bgcolor="#CCCCCC">
    	<td align="center" colspan="3" width="7%"><strong>Links</strong></td>
        <td align="center"><strong>to be served....</strong></td>
        <td align="center" width="18%"><strong>Process Server</strong></td>
        <td align="center"><strong>Circuit Court</strong></td>
        <td align="center" width="40%"><strong>Service Address</strong></td>
        <td align="center"><strong>File Started</strong></td>
        <td align="center"><strong>History</strong></td>
    </tr>


<?
$q= "select * from ps_packets where process_status='ASSIGNED' order by server_id, date_received ";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
?>
<?
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {$i++;
?>
    <tr bgcolor="<?=row_color($i,'#99cccc','#99ccff')?>">
    	<td nowrap="nowrap"><?=$i?>) </td>
        <td nowrap="nowrap" title="Papers to Serve" class="pcc" onclick="window.open('<?=$d[otd]?>')">OTD</td>
		<td nowrap="nowrap" title="Packet <?=$d[packet_id]?>" class="pcc" onclick="window.location='service.php?packet=<?=$d[packet_id]?>'">Service Details</td>
        <td nowrap="nowrap">
        <? if ($d[name1]){?><a class="pff" title="Affidavit for <?=$d[name1]?>" target="_blank" href="affidavit.php?packet=<?=$d[packet_id]?>&def=1&server=<?=$d[server_id]?>">+ <?=$d[name1]?> +</a><? }else{ } ?>
        <? if ($d[name2]){?><a class="pff" title="Affidavit for <?=$d[name2]?>" target="_blank" href="affidavit.php?packet=<?=$d[packet_id]?>&def=2&server=<?=$d[server_id]?>"><?=$d[name2]?> +</a><? }else{ } ?>
        <? if ($d[name3]){?><a class="pff" title="Affidavit for <?=$d[name3]?>" target="_blank" href="affidavit.php?packet=<?=$d[packet_id]?>&def=3&server=<?=$d[server_id]?>"><?=$d[name3]?> +</a><? }else{ } ?>
        <? if ($d[name4]){?><a class="pff" title="Affidavit for <?=$d[name4]?>" target="_blank" href="affidavit.php?packet=<?=$d[packet_id]?>&def=4&server=<?=$d[server_id]?>"><?=$d[name4]?> +</a><? }else{ } ?>
        </td>
        <td nowrap="nowrap" align="center"><a class="pff"  title="Profile information for <?=id2name($d[server_id])?>" href="contractor_review.php?admin=<?=$d[server_id]?>"><?=id2name($d[server_id])?></a>, <a class="pff"  title="Profile information for <?=id2name($d[server_ida])?>" href="contractor_review.php?admin=<?=$d[server_ida]?>"><?=id2name($d[server_ida])?></a></td>
        <td nowrap="nowrap"><?=$d[circuit_court]?></td>
        <td nowrap="nowrap" title="Details for service address <?=$d[address1]?>" class="pdd" onclick="window.location='ps_details.php?pkg=<?=$d[packet_id]?>'"><small><?=$d[address1] ?><? if ($d[address1a] != ''){ echo "(a)";}?><? if ($d[address1b] != ''){ echo "(b)";}?></small></td>
        <td nowrap="nowrap"><?=$d[alert_date];?></td>
        <td align="center"><a class="pff" href="history.php?packet=<?=$d[packet_id]?>" target="_blank">
        <?
		$rx = @mysql_query("SELECT packet_id FROM ps_history WHERE packet_id = '$d[packet_id]'");
		echo mysql_num_rows($rx);
		?></a>
        
        
        </td>
	</tr>
<?  
}
?>


</table>
<? }
include 'footer.php';

?>