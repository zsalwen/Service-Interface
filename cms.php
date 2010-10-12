<?

	if (($_COOKIE[psdata][level] != "Administrator") && ($_COOKIE[psdata][level] != "Operations")){
		header('Location: home.php');
	}

include 'common.php';
include 'menu.php';




if ($_GET[create]){ // we can keep this at the top
	$a = $_GET[create];
	$b = "Blank Template";
	$c = $_COOKIE[psdata][user_id];
	@mysql_query("INSERT INTO ps_templates (name, template, user_id, saved) values ('$a', '$b', '$c', NOW() )");
}
if ($_GET[id]){
?>
<table align="center">
	<tr>
    	<td valign="top" align="center">
    <div style="background-color:#FFFFFF; border:double;">
        <?
        if ($_POST[whiteboard]){
            $whiteboard = addslashes($_POST[whiteboard]);
			$user = $_COOKIE[psdata][user_id];
            $q = "update ps_templates set template='$whiteboard', user_id = '$user', saved=NOW() WHERE id = '$_GET[id]'";		
            $r = @mysql_query ($q) or die(mysql_error());
            $saved = 1;
        }
        $q = "SELECT * FROM ps_templates WHERE id = '$_GET[id]'";		
        $r = @mysql_query ($q) or die(mysql_error());
        $d = mysql_fetch_array($r, MYSQL_ASSOC);
        ?>
        <script language="JavaScript" type="text/javascript" src="../common/ps_wysiwyg.js"></script>
        <? if ($_GET[edit] && !$saved ){?>
            <form method="post">
            <center>
            <textarea id="whiteboard" rows="30" cols="100" name="whiteboard"><?=stripslashes($d[template])?></textarea>
             <script language="JavaScript">
              generate_wysiwyg('whiteboard');
            </script> <br>
            <input style="font-size:24px; color:#006666;" name="submit" type="submit" value="Save Template"></center>
            </form>
        <? }else{?>
            <div align="right">
            <form><input type="hidden" name="page" value="templates"><input type="hidden" name="id" value="<?=$_GET[id]?>"><input name="edit" value="Edit Template" style="font-size:24px; color:#006666;" type="submit"><br />
<a href="cms.php">BACK</a></form></div>
            <div style="text-align:justify"><?=stripslashes($d[template])?></div>
        <? } ?>
    </div>
		</td>
    </tr>
</table>
<?
} else {






?>
<table border="1" align="center" style="border-collapse:collapse" cellpadding="2" bgcolor="#FFFFFF">
	<tr>
    	<td align="center">Template</td>
    	<td align="center">Version Tracking</td>
	</tr>
	<tr bgcolor="#FFFF00">
    	<td align="left">Terms of Service</td>
    	<td align="left"><?=getTemplates('TOS')?></td>
	</tr>
	<tr bgcolor="#FFFF00">
    	<td align="left">Privacy Statement</td>
    	<td align="left"><? if (getTemplate('PRIVACY')){ echo getTemplates('PRIVACY'); }else{?><a href='?page=templates&create=PRIVACY'>Create Blank Template</a><? } ?></td>
	</tr>
	<tr bgcolor="#FFFF00">
    	<td align="left">Browser Platform - New</td>
    	<td align="left"><? if (getTemplate('BPN')){ echo getTemplates('BPN'); }else{?><a href='?page=templates&create=BPN'>Create Blank Template</a><? } ?></td>
	</tr>
	<tr bgcolor="#FFFF00">
    	<td align="left">Browser Platform - Blocked</td>
    	<td align="left"><? if (getTemplate('BPB')){ echo getTemplates('BPB'); }else{?><a href='?page=templates&create=BPB'>Create Blank Template</a><? } ?></td>
	</tr>
</table>
<? }?>
<? include 'footer.php';?>