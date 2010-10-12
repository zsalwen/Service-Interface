<?
//test
include "common.php"; 
$server=$_COOKIE['psdata']['user_id'];
?>
<table>
	<tr>
		<td colspan="3">
		<h3>RECENT ACTIVITY FOR <?=id2name($server)?></h3>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><?=date('Y-m-d H:i:j')?></td>
		<td>Current System Time</td>
	</tr>
<?
$r1=@mysql_query("SELECT * from ps_alert WHERE (serverID='$server' OR serverID='ALL' OR entryID='$server') ORDER BY entryTime DESC");
$i=0;
while ($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){
	if (isServer($server,$d1[packet_id]) || ($d1[packetID] == "") || ($d1[packetID] == "ALL")){$i++;
		if ($d1[entryID]){
			if ($d1[alertStr] == 'NEED CORRECTION'){
				$r2=@mysql_query("SELECT reopenNotes FROM ps_packets WHERE packet_id='$d1[packetID]'");
				$d2=mysql_fetch_array($r2, MYSQL_ASSOC);
				$action="ACTION ".$d1[alertStr]." BY ".id2name($d1[entryID]).' - '.strtoupper($d2[reopenNotes]);
			}else{
				$action="ACTION ".$d1[alertStr]." BY ".id2name($d1[entryID]);
			}
		}else{
			if ($d1[alertStr] == 'NEED CORRECTION'){
				$r2=@mysql_query("SELECT reopenNotes FROM ps_packets WHERE packet_id='$d1[packetID]'");
				$d2=mysql_fetch_array($r2, MYSQL_ASSOC);
				$action="ACTION: ".$d1[alertStr].' - '.strtoupper($d2[reopenNotes]);
			}else{
				$action="ACTION ".$d1[alertStr];
			}
		}
	?>
		<tr bgcolor='<?=row_color($i,'ffcccc','ffffcc')?>'>
			<td>
				<?=$d[packet_id]?>
			</td>
			<td>
				<?=$d1[alertStr]?>
			</td>
			<td>
				<?=$d1[entryTime]?>
			</td>
		</tr>
	<? } ?>
<? } ?>
</table>