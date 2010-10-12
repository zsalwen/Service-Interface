<?
if (isset($_POST[overRideType]) && ($_POST[overRideType] == 'PD')){?>
	<input type="hidden" name="i" value="close.3">
<? }elseif(isset($_POST[overRideType]) && ($_POST[overRideType] == 'MandP')){ ?>
	<input type="hidden" name="i" value="close.5">
<? } ?>
<input type="hidden" name="overRide" value="1" />
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
<?
echo "<script>onLoad='submitLoader()'</script>";
?>