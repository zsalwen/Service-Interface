<?
include 'common.php';
include 'menu.php';
?><?
function getDupInfo($client_file){
$r=@mysql_query("select * from ps_packets where client_file='$client_file' and process_status <> 'DUPLICATE' AND  process_status <> 'DAMAGED PDF' AND client_file <> '' ");
while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$return .= "<li><table width='100%'><tr><td width='50%'><a href='order.php?packet=$d[packet_id]&otd=1' target='_Blank'>$d[packet_id] $d[client_file] $d[process_status] $d[otd]</a></td><td>$d[processor_notes]</td></tr></table></li>";
}
return $return;
}
$q="SELECT client_file, 
 COUNT(client_file) AS NumOccurrences
FROM ps_packets WHERE process_status <> 'DUPLICATE' AND  process_status <> 'DAMAGED PDF' and process_status <> 'CANCELLED' and process_status <> 'FILE COPY'
GROUP BY client_file
HAVING ( COUNT(client_file) > 1 )";
$r=@mysql_query($q);
$i=0;?>
<table border="1" width="100%">
<?
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$i++;
	echo "<tr><td><ol>".getDupInfo($d[client_file])."</ol></tr></td>";
}
?></table><script>alert('<?=$i?> Duplicate Files')</script><?

include 'footer.php';


?>