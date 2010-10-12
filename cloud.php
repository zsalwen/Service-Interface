<? 
include 'common.php';
include 'lock.php';

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
	return $c;
}
function countFilesZ($zip){
	$r=@mysql_query("SELECT zip1 from ps_packets WHERE zip1='$zip'");
	$c=mysql_num_rows($r);
	return $c;
}
include 'menu.php';
$q="SELECT DISTINCT circuit_court from ps_packets";
$r=@mysql_query($q) or die(mysql_error());
?>
<fieldset style="border:double 5px #00FF00; padding:10px;">
<legend>Activity by County</legend>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ ?>
	<font style="font-size:<?=countFiles($d[circuit_court])-100;?>px"><?=$d[circuit_court]?></font> 
<? } ?>
</fieldset>
<?
$q="SELECT DISTINCT zip1 from ps_packets";
$r=@mysql_query($q) or die(mysql_error());
?>
<fieldset style="border:double 5px #00FF00; padding:10px;">
<legend>Activity by Zip Code</legend>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ ?>
	<font style="font-size:<?=countFilesZ($d[zip1])+10;?>px" label="<?=countFilesZ($d[zip1])+10;?>"><?=$d[zip1]?></font> 
<? } ?>
</fieldset>


<?
$q="SELECT DISTINCT circuit_court from ps_packets";
$r=@mysql_query($q) or die(mysql_error());
?>
<fieldset style="border:double 5px #00FF00; padding:10px;">
<legend>Margin by County</legend>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ ?>
    <? $contractor=contractorRate($d[circuit_court]);?>
      <? $client=clientRate($d[circuit_court]);?>
	<font style="font-size:<?=number_format(($client-$contractor),2)-20;?>px"><?=$d[circuit_court]?></font> 
<? } ?>
</fieldset>


<?
function serverCount($id){
	$r=@mysql_query("SELECT packet_id from ps_packets where server_id='$id' OR server_ida='$id' OR server_idb='$id'");
	$c=mysql_num_rows($r);
	return $c;
}
$q="SELECT DISTINCT server_id from ps_packets";
$r=@mysql_query($q) or die(mysql_error());
?>
<fieldset style="border:double 5px #00FF00; padding:10px;">
<legend>Server Activity</legend>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ ?>
      <? $files=serverCount($d[server_id])-100;?>
	<font style="font-size:<?=$files?>px"><?=id2name($d[server_id])?></font> 
<? } ?>
</fieldset>



<? include 'footer.php';?>
