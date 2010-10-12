<? include 'common.php'; 
function changelog($core,$version,$bug,$fix,$status){
	if($core && $version && $bug && $fix && $status == "Resolved"){
	$q="SELECT changelog FROM version_control where core='$core' AND core_version ='$version'";
	$r=@mysql_query($q) or die(mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$changelog = "<div>Issue: $bug<br>Action: $fix</div>".$d[changelog];
	@mysql_query("UPDATE version_control SET changelog='".addslashes($changelog)."' where core='$core' AND core_version ='$version'") or die(mysql_error());
	}
}
function getCVer($core){
	$q="SELECT * FROM version_control where core='$core' order by core_version DESC";
	$r=@mysql_query($q);
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$option .= "<option value='$d[core_version]'>$d[codename] ($d[core_version])</option>";
	}
	return $option;
}
if ($_COOKIE[psdata][level] != "SysOp" && $_COOKIE[psdata][level] != "Operations"){
	$event = 'view_feedback.php';
	$email = $_COOKIE[psdata][email];
	$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
	//@mysql_query($q1) or die(mysql_error());
	header('Location: home.php');
}

if ($_POST[submit]){
$q1="UPDATE ps_feedback SET
							description='$_POST[description]',
							core_version='$_POST[core_version]',
							fix='$_POST[fix]',
							status='$_POST[status]',
							priority='$_POST[priority]',
							programmer='$_POST[programmer]'
							where id = '$_GET[bug]'";
$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
changelog('PS-CORE',$_POST[core_version],addslashes($_POST[description]),addslashes($_POST[fix]), $_POST[status]);
$prog = id2name($_POST[programmer]);
$msg = "$prog has updated your posted feedback:\n
		Your original description:\n
		$_POST[description]\n
		The programmer has made these notes on your posting:\n
		$_POST[fix]\n
		As of now, the status of your feedback is: $_POST[status].";
$subj = "$prog has updated the feedback item you submitted!";

$q2 = "INSERT into ps_mailbox (from_id, to_id, subject, message, send_date) values ('$_POST[programmer]', '$_POST[user]', '$subj', '$msg', NOW())";
$r2 = @mysql_query($q2) or die("Query: $q2<br>".mysql_error());
header('Location: view_feedback.php');
}

include 'menu.php';
$top = 0;
if ($_GET[bug]){
$id = $_GET[bug];
$top = 1;
$q="SELECT * from ps_feedback where id = '$id'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC);
?>
<style>
img.sll{ text-decoration:none; border-style:none; }
</style>
<table width="900px" align="center" bgcolor="#CCCC99">
<form method="post">
<input type="hidden" name="user_id" value="<?=$_COOKIE[psdata][user_id]?>" />
<input type="hidden" name="user" value="<?=$d[user_id]?>"  />
    	<td width="70%">
            <table bgcolor="#CCCC99" width="100%">
                <tr>
                	<td align="center" colspan="2"><?=$d[agent]?></td>
                </tr>
                <tr>
                	<td colspan="2" align="center"><?=$d[referer]?></td>
                </tr>
                <tr>
                    <td width="10%">Bug: </td>
                    <td><textarea name="description" cols="60" rows="4"><?=$d[description]?></textarea></td>
                </tr>
                <tr>
                    <td>Fix: </td>
	                <td><textarea name="fix" cols="60" rows="3"><?=$d[fix]?></textarea></td>
                </tr>
            </table>
        </td>
        <td width="30%">
			<span style="float:right; height:70px"><strong><a href="view_feedback.php"><img title="Close Without Updating" class="sll" src="http://mdwestserve.com/ps/gfx/closeit.gif" /></a></strong></span>
            <table bgcolor="#CCCC99" width="100%" height="100%">
                <tr>
                    <td align="left">User: </td>
                    <td align="right"><?=id2name($d[user_id])?></td>
                </tr>
                <tr>
                    <td align="left">Programmer: </td>
                    <td align="right"><select name="programmer"><? if ($d[programmer]) { ?><option value="<?=$d[programmer]?>"><?=id2name($d[programmer])?></option><? } else { } ?><option value="1">Patrick McGuire</option><option value="2">Zach Salwen</option></select></td>
                </tr>
                <tr>
                	<td align="left">Priority Level: </td>
	                <td align="right"><select name="priority"><option><?=$d[priority]?></option><option value="1">1- Design</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9 - Crash</option></select></td>
                </tr>
                <tr>
                	<td align="left">Status: </td>
	                <td align="right"><select name="status"><option><?=$d[status]?></option><option>New</option><option>In Progress</option><option>Resolved</option></select></td>
                </tr>
                <tr>
                	<td align="left">Update in Core: </td>
	                <td align="right"><select name="core_version"><?=getCVer('PS-CORE')?></select></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td bgcolor="#333333" colspan="2" align="center"><input type="submit" name="submit" value="Update" /></td>
    </tr>
</table>

<?
}else{
?>
<table align="center" bgcolor="#333333" width="900px">
	<tr>
    	<td align="center"><font color="#FFFFFF" size="+1">Please select an item to view.</font></td>
    </tr>
</table>

<? 
} 
?>
<table width="100%" align="center">
    <tr bgcolor="#CCFFCC">
    	<td align="center"></td>
    	<td align="center">Priority</td>
        <td align="center">Status</td>
        <td align="center">Reporter</td>
        <td align="center">Date Entered</td>
        <td align="center" width="10%">Programmer</td>
        <td align="center">Last Updated On</td>
    </tr>
<?
$q2="SELECT * from ps_feedback where status <> 'Resolved' order by priority DESC";
$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
$i=0;
while ($d2=mysql_fetch_array($r2, MYSQL_ASSOC)) {$i++;
$color2 = row_color($i,'#CCCC99','#CCFFCC');
if ($_GET[bug] == $d2[id]){ $color="#00FF00";} else { $color=$color2;}
?>
<style>
td.pcc:hover{ background-color:#CCFFFF; color:#FF0000; cursor:pointer; }
</style>    
	<tr bgcolor="<?=$color?>">
    	<td class="pcc" align="center" rowspan="4" onclick="window.location.href='view_feedback.php?bug=<?=$d2[id]?>'"><strong><?=$i?>)</strong> Edit</td>
    	<td align="center"><?=$d2[priority]?></td>
        <td align="center"><?=$d2[status]?></td>
        <td align="center"><?=id2name($d2[user_id])?></td>
        <td align="center"><?=$d2[entry_date]?></td>
        <td align="center" width="15%"><?=id2name($d2[programmer])?></td>
        <td align="center"><?=$d2[updated]?></td>
    </tr>
    <tr>
    	<td bgcolor="<?=$color?>" colspan="7" align="center"><? if (strlen($d2[description]) > 250){ echo substr($d2[description],0,250) ?>...<? ; } else { echo $d2[description];} ?></td>
    </tr>
    <tr>
    	<td bgcolor="<?=$color?>" colspan="7" align="center"><?=$d2[referer];?></td>
    </tr>
    <tr>
    	<td bgcolor="<?=$color?>" colspan="7" align="center"><?=$d2[agent];?></td>
    </tr>
<? } ?>
</form>
</table>
<? include 'footer.php'; ?>
</table>

<script>hideshow(document.getElementById('sysop'))</script>