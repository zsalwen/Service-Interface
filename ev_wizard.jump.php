<body onLoad="document.form1.submit()">
<? if ($_GET[photojump]){?>
<form method="post" name="form1" id="form1" action="ev_wizard.php" target="_self"><input type="hidden" name="i" value="photo.upload.1" /><input type="hidden" name="parts" value="<?=$_GET[jump]?>" /><input type="hidden" name="opServer" value="<?=$_GET[server]?>" />
<? }else{ ?>
<form method="post" name="form1" id="form1" action="ev_wizard.php" target="_self"><input type="hidden" name="i" value="1" /><input type="hidden" name="parts" value="<?=$_GET[jump]?>" /><input type="hidden" name="opServer" value="<?=$_GET[server]?>" />
<? } ?>
<? if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? } ?></form>