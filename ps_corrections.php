<? include 'common.php';
include 'menu.php';?>
<? hardLog(' access needed corrections','user'); ?>

<br>
<br>
<br>
<table align="center" width="100%">
	<tr>
    	<td align="center"><strong>ID</strong></td>
        <td align="center"><strong>Wizard</strong></td>
        <td align="center"><strong>Reason for Reopening</strong></td>
        <? if (isset($_GET['all'])){ ?><td align="center"><strong>Servers</strong></td><? } ?>
    </tr>
<?
if (isset($_GET['server'])){
	$id=$_GET['server'];
}else{
	$id=$_COOKIE['psdata']['user_id'];
}
if (isset($_GET['all']) && $_COOKIE['psdata']['level'] == "Operations"){
$q="select * from ps_packets where (process_status = 'ASSIGNED' or process_status = 'READY') and affidavit_status='NEED CORRECTION' ORDER BY package_id, packet_id";
}elseif($_GET['server'] && $_COOKIE['psdata']['level'] == "Operations"){
$q="select * from ps_packets where (server_id = '$id' OR server_ida = '$id' OR server_idb = '$id' OR server_idc = '$id' OR server_idd = '$id' OR server_ide = '$id') and (process_status = 'ASSIGNED' or process_status = 'READY') and affidavit_status='NEED CORRECTION' ORDER BY package_id, packet_id";
}else{
$q="select * from ps_packets where (server_id = '$id' OR server_ida = '$id' OR server_idb = '$id' OR server_idc = '$id' OR server_idd = '$id' OR server_ide = '$id') and (process_status = 'ASSIGNED' or process_status = 'READY') and affidavit_status='NEED CORRECTION' ORDER BY package_id, packet_id";
}
$r=@mysql_query($q) or die("Query $q<br>".mysql_error());
$i=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
$i++;
?>
<tr>
	<td><font size="+3" style="font-weight:bold"><?=$d['package_id']?>.<?=$d['packet_id']?></font></td>
	<td><? if ($d['name1']){ ?>
            <a href="wizard.php?jump=<?=$d['packet_id']?>-1"><img src="/gfx/icon.wizard.gif" height="50" border="0" /></a>
        <? }?>
        <? if ($d['name2']){ ?>
            <a href="wizard.php?jump=<?=$d['packet_id']?>-2"><img src="/gfx/icon.wizard.gif" height="50" border="0" /></a>
        <? }?>
        <? if ($d['name3']){ ?>
            <a href="wizard.php?jump=<?=$d['packet_id']?>-3"><img src="/gfx/icon.wizard.gif" height="50" border="0" /></a>
        <? }?>
        <? if ($d['name4']){ ?>
            <a href="wizard.php?jump=<?=$d['packet_id']?>-4"><img src="/gfx/icon.wizard.gif" height="50" border="0" /></a>
        <? }?>
		<? if ($d['name5']){ ?>
            <a href="wizard.php?jump=<?=$d['packet_id']?>-5"><img src="/gfx/icon.wizard.gif" height="50" border="0" /></a>
        <? }?>
		<? if ($d['name6']){ ?>
            <a href="wizard.php?jump=<?=$d['packet_id']?>-6"><img src="/gfx/icon.wizard.gif" height="50" border="0" /></a>
        <? }?></td>
    <td><?=$d[reopenNotes]?></td>
    <? if (isset($_GET['all'])){ ?>
    	<td>
		<?=id2name($d[server_id])?>
        <? if ($d[server_ida]){ ?>
   			<br /><?=id2name($d[server_ida])?>
        <? } ?>
        <? if ($d[server_idb]){ ?>
   			<br /><?=id2name($d[server_idb])?>
        <? } ?>
        <? if ($d[server_idc]){ ?>
   			<br /><?=id2name($d[server_idc])?>
        <? } ?>
        <? if ($d[server_idd]){ ?>
   			<br /><?=id2name($d[server_idd])?>
        <? } ?>
        <? if ($d[server_ide]){ ?>
   			<br /><?=id2name($d[server_ide])?>
        <? } ?>
        </td></tr>
        <tr><td colspan="4"><hr /></td>
	<? } ?>

</tr>
<? }
	if ($i==0){
		echo "<tr><td colspan='4' align='center'><h1>No files needing corrections, please proceed to the desktop use the link in the upper-lefthand corner of this page.</h1></td></tr>";
	}
?>
</table>
<? include 'footer.php'; ?>