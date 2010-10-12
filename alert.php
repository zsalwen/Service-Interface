<?
/*
$qa="SELECT * from ps_packets";
$ra=@mysql_query($qa) or die(mysql_error());
while ($da=mysql_fetch_array($ra, MYSQL_ASSOC)){
	@mysql_query("UPDATE ps_packets set alert_date='$da[date_received]' where packet_id = '$da[packet_id]'");
}


$alert = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-3,date('Y')));


$qa="SELECT * from ps_packets where alert_date < '$alert' AND process_status = 'ASSIGNED'";
$ra=@mysql_query($qa) or die(mysql_error());
while ($da=mysql_fetch_array($ra, MYSQL_ASSOC)){
 $list .= "( $da[address1] )";
}

if ($list && $_COOKIE[psdata][level] == "Dispatch"){
?>

<s cript>alert('The following files are past deadline. <?=$list?>')</s cript>
<? }?>
*/
?>