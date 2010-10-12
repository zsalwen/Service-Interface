<?
include 'common.php';
include 'menu.php';
?>
<form method="post">
<table align="center">
	<tr>
    	<td>History: <input name="history" /> Server ID: <input name="server" /> <input type="submit" name="submit" value="Submit" /></td>
    </tr>
</table>
</form>
<? if (isset($_POST[history])){
	$q="SELECT * from ps_history where history_id='$_POST[history]'";
	$r=@mysql_query($q) or die(mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$id=id2name($d[serverID]);
	echo "<table align='center'><tr><td>$d[history_id] Before: $id($d[serverID])<br>$d[action_str]</td></tr></table>";
	$action=strtoupper(addslashes($d[action_str]));
	if ($_POST[server] != ''){
		$serverID=$_POST[server];
	}else{
		$serverID=$d[serverID];
	}
	$q1="UPDATE ps_history SET action_str='$action', serverID='$serverID' where history_id='$d[history_id]'";
	$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
	$q2="SELECT * from ps_history where history_id='$_POST[history]'";
	$r2=@mysql_query($q2) or die(mysql_error());
	$d2=mysql_fetch_array($r2, MYSQL_ASSOC);
	$id2=id2name($d2[serverID]);
	echo "<table align='center'><tr><td>$d2[history_id] After: $id2($d2[serverID])<br>$d2[action_str]</td></tr></table>";

}
include 'footer.php'; ?>