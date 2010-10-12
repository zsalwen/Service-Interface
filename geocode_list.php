<? include 'common.php';
if ($_COOKIE[psdata][level] != "SysOp" && $_COOKIE[psdata][level] != "Operations"){
	header('Location: home.php');
}
include 'menu.php';
$q="SELECT * from ps_packets";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
?>
<style>
td.prf{text-decoration:none; cursor:pointer; }
td.prf:hover{text-decoration:none; cursor:pointer; color:#FF0000; background-color:#99CCFF; }
</style>
<table width="1000px" style="border-collapse:collapse;" border="1">
	<tr bgcolor="#99CC99">
    	<td align="center"><strong>Addresses</strong></td>
        <td align="center"><strong>Latitudes</strong></td>
        <td align="center"><strong>Longitudes</strong></td>
        <td align="center" nowrap="nowrap"><strong>Names</strong></td>
        <td align="center"><strong>Server</strong></td>
        <td align="center"><strong>Geocode</strong></td>
    </tr>
<?
$b=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){$b++;
?>
	<tr bgcolor="<?= row_color($b,'#66CC66','#99CC99') ?>">
    	<td><? if ($d[address1]){ echo "$d[address1], $d[city1], $d[state1] $d[zip1]<br>"; }else{ }?><? if ($d[address2]){ echo "$d[address2], $d[city2], $d[state2] $d[zip2]<br>"; }else{ }?><? if ($d[address3]){ echo "$d[address3], $d[city3], $d[state3] $d[zip3]<br>"; }else{ }?><? if ($d[address4]){ echo "$d[address4], $d[city4], $d[state4] $d[zip4]<br>"; }else{ }?></td>
        <td><? if ($d[lat1]){ echo "$d[lat1]<br>"; }else{ }?><? if ($d[lat2]){ echo "$d[lat2]<br>"; }else{ }?><? if ($d[lat3]){ echo "$d[lat3]<br>"; }else{ }?><? if ($d[lat4]){ echo "$d[lat4]<br>"; }else{ }?></td>
        <td><? if ($d[lng1]){ echo "$d[lng1]<br>"; }else{ }?><? if ($d[lng2]){ echo "$d[lng2]<br>"; }else{ }?><? if ($d[lng3]){ echo "$d[lng3]<br>"; }else{ }?><? if ($d[lng4]){ echo "$d[lng4]<br>"; }else{ }?></td>
        <td><? if ($d[name1]){ echo "$d[name1]<br>"; }else{ }?><? if ($d[name2]){ echo "$d[name2]<br>"; }else{ }?><? if ($d[name3]){ echo "$d[name3]<br>"; }else{ }?><? if ($d[name4]){ echo "$d[name4]<br>"; }else{ }?></td>
        <td><?=id2name($d[server_id])?></td>
        <td class="prf" onclick="window.open('ps_geocode.php?id=<?=$d[packet_id]?>','edit2','width=200,height=100,toolbar=no,location=no')" title="<?=$d[packet_id]?>">Geocode</td>
	</tr>
<? 
} ?>
</table>
<? include 'footer.php'; ?>