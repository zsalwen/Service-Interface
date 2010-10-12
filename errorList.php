<?
include 'common.php';



include 'menu.php';

$r=@mysql_query("select * from ps_packets where process_status = 'ERROR'");

?>
<table>
<? while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){?>
	<tr>
    	<td>Packet <?=$d[packet_id]?></td>
	</tr>
<? } ?>
</table>





<? include 'footer.php'; ?>