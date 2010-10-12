<?
include 'common.php';
if ($_POST[workRequestMax]){
@mysql_query("UPDATE ps_users set workRequestDate=NOW(), workRequestDone='$_POST[workRequestDone]', workRequestMax='$_POST[workRequestMax]' where id='".$_COOKIE['psdata']['user_id']."'");
}
include 'menu.php';
?>
<center>
<?


if ($_COOKIE[psdata][level] == "Operations"){

$r=@mysql_query("select id from ps_users");while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){ echo workStatus($d[id]); }


}else{
echo workStatus($_COOKIE['psdata']['user_id']);
?>
<hr>

<div style="font-size:24px">Work Request for <?=date('Y-m-d')?></div>
<table>
<form method="post">
	<tr>
    	<td>Days untill oldest files will be completed.</td>
        <td><input name="workRequestDone"></td>
    </tr>
	<tr>
    	<td>Maximum number of new files accepted today.</td>
        <td><input name="workRequestMax"></td>
    </tr>
    <tr>
    	<td colspan="2" align="center"><input type="submit" value="Notify Dispatch of Update"</td>
       </tr>
</form>
</table>
<? }?>
</center>

<?
include 'footer.php';
?>