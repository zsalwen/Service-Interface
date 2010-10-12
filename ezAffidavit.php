<?
// first thing we need to do is build a list of affidavits needed
@mysql_connect();
mysql_select_db('core');
$packet = $_GET['packet'];
if ($packet){
$r = @mysql_query("select * from ps_packets where packet_id = '$packet'");
$d = mysql_fetch_array($r,MYSQL_ASSOC);


$r2 = @mysql_query("select * from ps_history where packet_id = '$packet'");

$r3= @mysql_query("select distinct defendant_id from ps_history where packet_id = '$packet'");
$defendants = mysql_num_rows($r3);
$r4= @mysql_query("select distinct serverID from ps_history where packet_id = '$packet'");
$i=0;
$server=array();
while($d4=mysql_fetch_array($r4,MYSQL_ASSOC)){
$i++;
$server[$i] = $d4[serverID];
}
$servers = count($server);
?>
<style>
.dim {
   filter: Alpha(opacity=40);
   -moz-opacity: .40;
   opacity: .40;
}
.dimmer {
   filter: Alpha(opacity=25);
   -moz-opacity: .25;
   opacity: .25;
}
@media print {
  .noprint { display: none; }
}
</style>
<div class="noprint" style='border:solid;'>
Case Overview:<br />
Overall Status: <?=$d[service_status]?><br>
Number of Defendants: <?=$defendants?><br>
Number of Servers: <?=$servers?><br>
<hr>
History:<br>
<?
while ($d2 = mysql_fetch_array($r2,MYSQL_ASSOC)){
echo $d2[action_type]." - ".$d2[serverID]."<br>";
}
?>

</div>

<?
// ok here we do all the includes
$counter1=0;
while ($counter1 < $servers){
$counter1++;
include 'ezAffidavit.server.php';
}







} else {?>

Link Expired.

<? }?>