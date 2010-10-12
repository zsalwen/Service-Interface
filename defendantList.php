<? include 'common.php'; ?>
<table align="center">
	<tr>
    	<td width="30%">Packet #</td>
        <td width="70%">Defendant(s)</td>
    </tr>
<?
$q="SELECT * from ps_packets";
$r=@mysql_query($q) or die(mysql_error());
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){?>
	<tr>
    	<td><?=$d[packet_id]?></td>
        <td><?=$d[name1]?><? if ($d[name2]){ echo ', '.$d[name2];}?><? if ($d[name3]){ echo ', '.$d[name3];}?><? if ($d[name4]){ echo ', '.$d[name4];}?></td>
    </tr>
<? }?>
</table>