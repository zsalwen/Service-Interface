<?
function db_connect($host,$database,$user,$password){ 
	$step1 = @mysql_connect ();
	$step2 = mysql_select_db ($database);
	return mysql_error();
}
db_connect('delta.mdwestserve.com','intranet','root','zerohour');
$q="SELECT state1a, state2a, state3a, state4a, packet_id from ps_packets";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$i=0;
	if ($d[state1a] != 'MD' && $d[state1a] != ''){ $i++; }
	if ($d[state1] != 'MD' && $d[state1] != ''){ $i++; }
	if ($d[state2a] != 'MD' && $d[state2a] != ''){ $i++; }
	if ($d[state2] != 'MD' && $d[state2] != ''){ $i++; }
	if ($d[state3a] != 'MD' && $d[state3a] != ''){ $i++; }
	if ($d[state3] != 'MD' && $d[state3] != ''){ $i++; }
	if ($d[state4a] != 'MD' && $d[state4a] != ''){ $i++; }
	if ($d[state4] != 'MD' && $d[state4] != ''){ $i++; }
	$cost=$i * 20;
	$q1="UPDATE ps_packets SET outofstate_cost='$cost' where packet_id='$d[packet_id]'";
	$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
}
?>