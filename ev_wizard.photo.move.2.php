<?
$uri = $ddr["photo".$defendant.$_POST['old']];
$newField = "photo".$defendant.$_POST['new'];
$oldField = "photo".$defendant.$_POST['old'];
@mysql_query("UPDATE evictionPackets set $newField = '$uri' where eviction_id = '$packet'");
@mysql_query("UPDATE evictionPackets set $oldField = '' where eviction_id = '$packet' ");
?>
Move Completed...<br>
<div class="nav2"><input onClick="submitLoader()" type="radio" name="i" value="photo.review" /> NEXT</div>

<input type="hidden" name="parts" value="<?=$_POST[parts]?>" />
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />





