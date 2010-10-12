<?
include 'common.php';
include 'lock.php';
$i=0; ?>
<table align="center">
	<tr bgcolor="<?=row_color($i,'CCFFFF','CC99CC')?>">
		<td align="center"><b>P</b>ossible <b>P</b>roblem <b>P</b>ackets</td>
	</tr>
<?
$q="SELECT DISTINCT packetID from ps_affidavits WHERE (method NOT LIKE '%return%' AND method NOT LIKE '%Return%' AND method NOT LIKE '%Filed%' AND method NOT LIKE '%filed%' AND method NOT LIKE '%copy%' AND method NOT LIKE '%Copy%') ORDER BY packetID ASC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$i++;?>
	<tr bgcolor="<?=row_color($i,'CCFFFF','CC99CC')?>">
		<td align="center"><a href="order.php?packet=<?=$d[packetID]?>" target="_blank"><?=$d[packetID]?></a></td>
	</tr>
<? } ?>
</table>