<?
include 'common.php';
include 'lock.php';
include 'menu.php';
?>
<style>
.new{ background-color:#00FF00;}
.found {background-color:#FF0000;}
</style>
<?
$q="select * from ps_packets where status='NEW' and attorneys_id='1'";
$r=@mysql_query($q);
while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
$bb = explode('.', $d[attorney_notes]);
$subq="select packet_id from ps_packets where client_file='$bb[0]'";
$subr=@mysql_query ($subq);
$subd=mysql_fetch_array($subr, MYSQL_ASSOC);
if ($subd[packet_id]){
echo "<li class='found'>$d[packet_id] recorded as file number $bb[0] !ALERT! DUPLICATE OF PACKET $subd[packet_id]</li>";
} else{
echo "<li class='new'>$d[packet_id] recorded as file number $bb[0]</li>";
}
@mysql_query("update ps_packets set client_file = '$bb[0]' where packet_id='$d[packet_id]'");
}
include 'footer.php';
?>