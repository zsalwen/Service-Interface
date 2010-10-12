<?
include 'common.php';
include 'lock.php';
include 'menu.php';
?>
<form name="last" id="last"><input name="last4" id="last4" /><input type="submit" /></form>
<script>document.last.last4.focus()</script>
<?
if ($_GET[last4]){
$number=0;
while($number++ < 6){
foreach(range('a','e') as $letter){ 
if ($letter == 'a'){
$field = "article".$number;
$r=@mysql_query("select * from ps_packets where $field LIKE '%$_GET[last4]%'");
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
if ($d[packet_id]){
	echo "<h1><a href='affidavitUpload.php?packet=$d[packet_id]&def=$number'>$d[packet_id]-$number$letter</a></h1><h3>$d[$field]</h3>";
}}
$field = "article".$number.$letter;
$r=@mysql_query("select * from ps_packets where $field LIKE '%$_GET[last4]%'");
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
if ($d[packet_id]){
	echo "<h1><a href='affidavitUpload.php?packet=$d[packet_id]&def=$number'>$d[packet_id]-$number$letter</a></h1><h3>$d[$field]</h3>";
}}
}else{
$field = "article".$number.$letter;
$r=@mysql_query("select * from ps_packets where $field LIKE '%$_GET[last4]%'");
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
if ($d[packet_id]){
	echo "<h1><a href='affidavitUpload.php?packet=$d[packet_id]&def=$number'>$d[packet_id]-$number$letter</a></h1><h3>$d[$field]</h3>";
}}
}


}}
}


include 'footer.php';
?>