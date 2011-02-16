<?
/*$uri = $ddr["photo".$defendant.$_POST['old']];
$newField = "photo".$defendant.$_POST['new'];
$oldField = "photo".$defendant.$_POST['old'];
@mysql_query("UPDATE ps_packets set $newField = '$uri' where packet_id = '$packet'");
@mysql_query("UPDATE ps_packets set $oldField = '' where packet_id = '$packet' ");*/
function alpha2ID($alpha){
	if ($alpha == 'a'){ return "1";}
	if ($alpha == 'b'){ return "1"; }
	if ($alpha == 'c'){ return "1"; }
	if ($alpha == 'd'){ return "2"; }
	if ($alpha == 'e'){ return "2"; }
	if ($alpha == 'f'){ return "3"; }
	if ($alpha == 'g'){ return "3"; }
	if ($alpha == 'h'){ return "4"; }
	if ($alpha == 'i'){ return "4"; }
	if ($alpha == 'j'){ return "5"; }
	if ($alpha == 'k'){ return "5"; }
	if ($alpha == 'l'){ return "6"; }
	if ($alpha == 'm'){ return "6"; }
}
$addressID=alpha2ID($_POST["new"]);
$description=alpha2desc($_POST["new"]);
@mysql_query("UPDATE ps_photos SET description='$description', addressID='$addressID' WHERE photoID='$_POST[photo]'");
?>
Move Completed...<br>
<div class="nav2"><input onClick="submitLoader()" type="radio" name="i" value="photo.review" /> NEXT</div>

<input type="hidden" name="parts" value="<?=$_POST[parts]?>" />
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />





