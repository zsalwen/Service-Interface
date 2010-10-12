<? include 'common.php';

if (($_COOKIE[psdata][level] != "SysOp") && ($_COOKIE[psdata][level] != "Operations")){
	$event = 'browser.php';
	$email = $_COOKIE[psdata][email];
	$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
	//@mysql_query($q1) or die(mysql_error());
	header('Location: home.php');
}

if ($_POST[submit] == "Update"){
$q1="UPDATE browsers SET
							description='$_POST[description]',
							status='$_POST[status]'
							where agent = '$_POST[agent]'";
$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
header('Location: browser.php');}
include 'menu.php'; 
?>
<meta http-equiv="refresh" content="60" />

<?
if ($_GET[agent]){
$q="SELECT * from browsers where agent = '$_GET[agent]'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC);	
?>
<center>
<div style="width:100%; height:70px; overflow:auto;">
<table align="center" width="100%">
<form method="post">
<input type="hidden" name="user_id" value="<?=$_COOKIE[psdata][user_id]?>" />
<input type="hidden" name="agent" value="<?=$d[agent]?>" />
    <tr>
        <td align="center"><select name="status"><option>Unstable</option><option><?=$d[status]?></option><option>New</option><option>Allow</option><option>Block</option></select><input name="description" value="<?=$d[description]?>" size="35" /><input type="submit" name="submit" value="Update" /><br /><?=$d[agent]?></td>
    </tr>
</form>
</table>
</div>
</center>
<?
$height = 540;
}else{
$height = 610;
?>
<? } ?>
<center>
<div style="width:100%; height:<?=$height?>; overflow:auto;">
<table width="100%" border="1" style="font-size:12px;">
<?

function status_color($status){
	if ($status == "New"){ return "#ffff00"; }
	if ($status == "Allow"){ return "#00ff00"; }
	if ($status == "Block"){ return "#ff0000"; }
}
$q2="SELECT * from browsers where hits > '0' order by hits DESC, agent";
$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
$i=0;
while ($d2=mysql_fetch_array($r2, MYSQL_ASSOC)) {$i++;
?>
    <tr bgcolor="<?=status_color($d2[status])?>">
    	<td onclick='window.location.href="browser.php?agent=<?=htmlspecialchars($d2[agent])?>"' align="left"><strong><?=$d2[status]?> <?=$d2[description]?> <?=$d2[last_access]?></strong><br /><?=$d2[hits]?> hits using <?=$d2[agent]?></td>
    </tr>
<?
}
?>
</table>
</div>
</center>
<? include 'footer.php'; ?>