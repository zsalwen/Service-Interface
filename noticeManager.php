<?
include 'common.php';
include 'menu.php';
mysql_connect();
mysql_select_db('core');
ob_start();
$i=0;
if ($_GET[sendDate]){
	$date=$_GET[sendDate];
}else{
	$date=date('Y-m-d');
}
?>
<style>
table {border-style:solid 1px; border-collapse:collapse;}
</style>
<table align="center" frame='border' rules='all'>
	<form>
	<tr bgcolor="<?echo row_color($i,'#FFFFFF','#cccccc'); ?>">
		<td colspan='5' align='center'><span style="font-size:16px; font-weight: bold;">SEND NOTICES FOR THE DATE:</span><br /><input name="sendDate" size=10 value="<?=$date?>" /> <input type="submit" value="Set" /></td>
	</tr>
	</form>
	<tr>
		<td>File #</td>
		<td>Address</td>
		<td>Attorney</td>
		<td>Print Envelope</td>
		<td>Print Notice</td>
	</tr>
<?
$q="SELECT * FROM occNotices WHERE sendDate='0000-00-00'";
$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$i++;
	echo "<tr bgcolor='".row_color($i,'#FFFFFF','#cccccc')."'>";
	echo "<td>$d[clientFile]</td>";
	echo "<td>".strtoupper("$d[address], $d[city], $d[state], $d[zip]")."</td>";
	echo "<td>".id2attorney($d[attorneysID])."</td>";
	echo "<td><a href='http://mdwestserve.com/ps/greencard.php?name=Occupant&line1=".strtoupper($d[address])."&line2=".$d[clientFile]."&csz=".strtoupper($d[city].", ".$d[state]." ".$d[zip])."&card=envelope' target='_blank'>Envelope</a></td>";
	echo "<td><a href='http://mdwestserve.com/ps/occupant.php?id=".$d[occID]."&sendDate=".$date."' target='_blank'>Notice</a></td>";
	echo "</tr>";
}
echo "</table>";
$buffer = ob_get_clean();
echo $buffer;
?>