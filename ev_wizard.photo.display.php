<?
include 'common.php';
mysql_connect();
mysql_select_db('core');
function alpha2desc($alpha){
	if ($alpha == 'a'){ return "FIRST DOT ATTEMPT"; }
	if ($alpha == 'b'){ return "SECOND DOT ATTEMPT"; }
	if ($alpha == 'c'){ return "POSTED DOT PROPERTY"; }
}
function photoAddress($packet,$defendant,$alpha){
	$r=@mysql_query("SELECT * from evictionPackets where eviction_id = '$packet'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($alpha == "a" || $alpha == "b"|| $alpha == "c"){
		if ($d["address$defendant"]){
			return $d["address$defendant"].", ".$d["state$defendant"];
		}
	}
}?>
<style>
legend{background-color:#FFFFCC;}
div{text-align:center;}
fieldset, legend, div, table {padding:0px;}
</style>
<?
$packet=$_GET[packet];
$def=$_GET[defendant];
$q="SELECT name1, name2, name3, name4, name5, name6 FROM evictionPackets WHERE eviction_id='$packet'";
$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$html=trim(getPage("http://data.mdwestserve.com/findPhotos.php?packet=EV$packet&def=$def", 'MDWS Find Photos', '5', ''));
echo "<table align='center' valign='top'><tr>";
if ($d["name$def"]){
	echo "<td valign='top'><fieldset><legend>".strtoupper($d["name$def"])."</legend>";
	echo $html;
	echo "</fieldset></td>";
}

echo "</tr></table>";
?>