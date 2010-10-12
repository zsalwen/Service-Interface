<?
include 'common.php';
include 'menu.php';
$q="SELECT DISTINCT circuit_court from ps_packets where server_id <> ''";
$r=@mysql_query($q) or die(mysql_error());?>
<table align="center" width="60%" style="border-collapse:collapse" border="1">
<? while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$i=0;
	$q1="SELECT DISTINCT server_id from ps_packets where circuit_court = '$d[circuit_court]' and server_id <> ''";
	$r1=@mysql_query($q1) or die(mysql_error());
	while ($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){$i++;
?>
	<tr <? if ($i == 1){ echo 'bgcolor="#CCCCFF"';}?>>
        <td><?=$d[circuit_court]?></td>
    	<td><?=id2name($d1[server_id])?> (<?=$d1[server_id]?>)</td>
    </tr>
<?	}
	$q3="SELECT DISTINCT server_ida from ps_packets where circuit_court = '$d[circuit_court]' and server_ida <> ''";
	$r3=@mysql_query($q3) or die(mysql_error());
	while ($d3=mysql_fetch_array($r3, MYSQL_ASSOC)){?>
		<tr>
        	<td><?=$d[circuit_court]?></td>
    		<td><?=id2name($d3[server_ida])?> (<?=$d3[server_ida]?>)</td>
	    </tr>
<?	}
	$q5="SELECT DISTINCT server_idb from ps_packets where circuit_court = '$d[circuit_court]' and server_idb <> ''";
	$r5=@mysql_query($q5) or die(mysql_error());
	while ($d5=mysql_fetch_array($r5, MYSQL_ASSOC)){
?>
	<tr>
        <td><?=$d[circuit_court]?></td>
    	<td><?=id2name($d5[server_idb])?> (<?=$d5[server_idb]?>)</td>
    </tr>
<?	}
}
?>

</table>
<? include 'footer.php' ?>