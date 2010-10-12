<? 
include 'common.php';
function contractorRate($county){
	$q="SELECT contractor_rate from ps_packets where circuit_court='$county' and contractor_rate <> ''";
	$r=@mysql_query($q) or die("Query: contractorRate<br>".mysql_error());
	$i=0;
	$total=0;
	while($d=mysql_fetch_array($r, MYSQL_ASSOC)){$i++;
		$total=$total+$d[contractor_rate];
	}
	if ($i > 0){
		$final=number_format(($total/$i), 2);
		return $final;
	}else{
		return number_format(0,2);
	}
}
function clientRate($county){
	$q="SELECT client_rate from ps_packets where circuit_court='$county' and client_rate <> ''";
	$r=@mysql_query($q) or die("Query: clientRate<br>".mysql_error());
	$i=0;
	$total=0;
	while($d=mysql_fetch_array($r, MYSQL_ASSOC)){$i++;
		$total=$total+$d[client_rate];
	}
	if ($i > 0){
		$final=number_format(($total/$i), 2);
		return $final;
	}else{
		return number_format(0,2);
	}
}
function countFiles($court){
	$r=@mysql_query("SELECT circuit_court from ps_packets WHERE circuit_court='$court'");
	$c=mysql_num_rows($r);
	if($c > 1){
		return $c." FILES";
	}else{
		return $c." FILE";
	}
}
include 'menu.php';
$q="SELECT DISTINCT circuit_court from ps_packets ORDER BY circuit_court";
$r=@mysql_query($q) or die(mysql_error());
?>
<table align="center" border="1">
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ ?>
	<tr>
    	<td style="padding:5px"><?=$d[circuit_court]?> CIRCUIT COURT</td>
        <td style="padding:5px"><?=countFiles($d[circuit_court]);?></td>
        <td style="padding:5px">$<?=$contractor=contractorRate($d[circuit_court]);?> <small>Contractor Average</small></td>
        <td style="padding:5px">$<?=$client=clientRate($d[circuit_court]);?> <small>Client Average</small></td>
        <td style="padding:5px">$<?=number_format(($client-$contractor),2);?> <small>Margin</small></td>
    </tr>
<? } ?>
</table>
<? include 'footer.php';?>
