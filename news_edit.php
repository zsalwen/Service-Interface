<? include 'common.php'; ?>


<script language="javascript" type="text/javascript"><!--
function automation() {
  window.opener.location.href = window.opener.location.href;
  //window.open('write_update.php','update','width=1,height=1,toolbar=no,location=no')
  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
  window.close();
}
// -->
self.moveTo((screen.width-500),0);

</script>

<?
if ($_POST[submit] ){
$q1 = "UPDATE ps_news SET 
								icon_url='$_POST[icon_url]',
								topic='$_POST[topic]',
								news_url='$_POST[news_url]',
								description='$_POST[description]',
								is_approved='$_POST[is_approved]'
									WHERE id = '$_POST[id]'";



	
	$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
	echo "<script>automation();</script>";	
}


$q= "select * from ps_news where id = '$_GET[id]'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC);

?>

<table align="center" width="800" border="1" style="border-collapse:collapse" bordercolor="#CCCCCC" bgcolor="#CCCCCC">
<form method="post">
<input type="hidden" name="id" value="<?=$_GET[id]?>" />
	<tr>
    	<td colspan="3" width="800" bgcolor="#336699" style="color:#FFFFFF" align="center" valign="bottom"><font size="+3">Edit News Item</font></td>
	</tr>
    <tr>
    	<td rowspan="5" align="center" width="400">
        <strong>Description:</strong><br>
        <textarea name="description" cols="45" rows="5"><?=$d[description]?></textarea>
		</td>
	</tr>
    <tr>        
    	<td bgcolor="#336699" width="100" style="color:#CCCCCC"><strong>Icon URL: </strong></td>
        <td bgcolor="#336699" width="300" style="color:#CCCCCC">
        <select name="icon_url"><option><?=$d[icon_url]?></option><option>Web Site</option><option>PDF File</option><option>Image File</option></select>
        </td>
	</tr>        
	<tr>        
        <td width="100"><strong>Topic: </strong></td>
        <td bgcolor="#336699" width="300" style="color:#CCCCCC">
        <input name="topic" maxlength="255" size="50" value="<? if ($_POST[topic]){ echo $_POST[topic];}else{echo $d[topic];}?>" />
        </td>
	</tr>
	<tr>
        <td bgcolor="#336699" width="100" style="color:#CCCCCC"><strong>News URL: </strong></td>
        <td bgcolor="#336699" width="300" style="color:#CCCCCC">
		<input name="news_url" size="50" value="<? if ($_POST[news_url]){ echo $_POST[news_url];}else{echo $d[news_url] ;}?>" />
        </td>
	</tr>
<? if ($_COOKIE[psdata][level] == "SysOp"){?>

 
    <tr>
    	<td width="200"><strong>Approve Posting?</strong></td>
        <td width="200"><input <? if ($d[is_approved]){ echo "checked" ;}?> type="checkbox" name="is_approved" value="checked"  /></td>
    </tr>
<? } ?>
    <tr>
    	<td colspan="3" align="center"><input type="submit" name="submit" value="Update News Item" /></td>
    </tr>     
</form>
</table>
<? include 'footer.php';?>
</body>