<?
include 'common.php';
$user_id=$_COOKIE[userdata][user_id];



if (!$_COOKIE[psdata][level]){
	header('Location: login.php');
}

if (($_COOKIE[psdata][level] != 'Administrator') && ($_COOKIE[psdata][level] != 'SysOp') && ($_COOKIE[psdata][level] != 'Operations')){
	$event = 'mg_news.php';
	$email = $_COOKIE[psdata][email];
	$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
	//@mysql_query($q1) or die(mysql_error());
	header('Location: ps_main.php');
}
if ($_GET[delete]){
@mysql_query("DELETE FROM ps_news where id = '$_GET[delete]'");
header('Location: mg_news.php');
}
include 'menu.php';
?>
<div style="width:100%; height:585px; overflow:auto">
<table align="center" style="border-collapse:collapse" border="1" bordercolor="#000000" width="100%">
	<tr bgcolor="#336633" style="color:#FFFFFF">
    	<td align="center">Review</td>
        <td align="center" width="200">User</td>
        <td align="center">Posted On</td>
        <td align="center">IP Address</td>
        <td align="center" width="350">Topic</td>
        <td align="center">Approved?</td>        
	</tr> 
<?
$q= "select * from ps_news where is_approved !=  'checked' ORDER by news_date ASC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {

$q1= "select name from ps_users where id = $d[user_id]";
$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
$d1=mysql_fetch_array($r1, MYSQL_ASSOC);

?>    
    <tr bgcolor="#66FF66">
	    <td align="center" bgcolor="#336633">
        <a onclick="window.open('news_edit.php?id=<?=$d['id']?>','Edit News Item','width=825,height=230,toolbar=no,statusbar=no,location=no')"><strong style="color:#CCCCCC">Edit</strong></a> <a href="?delete=<?=$d['id']?>"><strong>Delete</strong></a></td>
        <td align="center" width="200"><? if($d[user_id]){echo $d1[name];}else{ echo "<i>empty</i>";} ?></td>
        <td align="center"><? if($d[news_date]){echo $d[news_date];}else{ echo "<i>empty</i>";} ?></td>
        <td align="center"><? if($d[ip_add]){echo $d[ip_add];}else{ echo "<i>empty</i>";} ?></td>
        <td align="center" width="350"><? if($d[topic]){echo $d[topic];}else{ echo "<i>empty</i>";} ?></td>
        <td align="center"><? if($d[is_approved]){echo "YES";}else{ echo "NO";} ?></td>
    </tr>
    <? 
 $i++;
} ?>
</table>

<?
if ($i == 0){
echo "<center><h2 style=\"color:#FF0000\">No News Items To Review</h2></center>";
} ?>
</div>
</center>
<? include 'footer.php'; ?>