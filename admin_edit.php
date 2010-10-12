<?
include 'common.php';

if ($_COOKIE[psdata][level] !="Administrator"){
header('Location: home.php');
}


if ($_POST[submit]){
$action = addslashes($_POST[action]);
$q1="UPDATE ps_history SET action_str = '$action' where history_id = '$_POST[history_id]'";
$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
header('Location: admin_edit.php?packet='.$packet.'&def='.$def.'');
}
if ($_POST[packet]){
$packet = $_POST[packet];
}else{
$packet = $_GET[packet];
}
if ($_POST[def]){
$def = $_POST[def];
}else{
$def = $_GET[def];
}
$q="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' ORDER by history_id ASC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
?>
<table width="100%" align="center">
	<tr>
    	<td align="center">Edit History</td>
    </tr>
</table>
<?
$i=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){$i++;
?>
<table width="100%" align="center">
<form method="post">
<input type="hidden" name="def" value="<?=$def?>">
<input type="hidden" name="history_id" value="<?=$d[history_id]?>">
	<tr>
    	<td align="center"><textarea rows="4" cols="50" name="action"><?=stripslashes($d[action_str])?></textarea></td>
    </tr>
	<tr>
    	<td align="center"><input type="submit" name="submit" value="Update"></td>
    </tr>
</form>
</table>
<?
}
?>