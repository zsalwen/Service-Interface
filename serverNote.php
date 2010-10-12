<?
include "common.php";
include "menu.php";
$entryID=$_COOKIE[psdata][user_id];
	if ($_POST[submit] && $_POST[serverID] && $_POST[alertStr]){
		@mysql_query("INSERT INTO ps_alert (alertStr, entryID, entryTime, serverID, packetID) VALUES ('$_POST[alertStr]','$entryID',NOW(),'$_POST[serverID]')") or die(mysql_error());
	}
?>
<table align="center">
	<tr>
		<td align="center">
			<h1>SEND SERVER NOTE:</h1><br>
			<form><select name="serverID"><? if (!$_POST[serverID]){ ?><option value="">Select Server </option><? }else{ ?><option value="<?=$_POST[serverID]?>"><?=id2name($_POST[serverID]);?> (Server)</option><? } ?>
<?
$q7= "select * from ps_users where contract = 'YES' order by id ASC";
$r7=@mysql_query($q7) or die("Query: $q7<br>".mysql_error());
while ($d7=mysql_fetch_array($r7, MYSQL_ASSOC)) {
?>
<option value="<?=$d7[id]?>"><? if ($d7[company]){echo $d7[company].', '.$d7[name] ;}else{echo $d7[name] ;}?></option>
<?        } ?>
<option value=""></option>
</select><br />
			PACKET NUMBER (IF APPLICABLE): <input name="packetID" size="4"><br>
			<input name="alertStr" value="ENTER NOTE TEXT HERE" onClick="value=''" size="40"> <input type="submit">
		</td> 
	</tr>
</table>