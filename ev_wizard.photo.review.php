<?
?>
<table border="1"><tr>
<?
$qP="SELECT * FROM ps_photos WHERE packetID='EV$packet' AND defendantID='$defendant' ORDER by addressID ASC";
$rP=@mysql_query($qP) or die ("Query: $qP<br>".mysql_error());
while ($dP=mysql_fetch_array($rP,MYSQL_ASSOC)){
	$letter=getLetter($dP[localPath]);
	if ($dP[description] != ''){
		$description=strtoupper($dP[description]);
	}else{
		$description=alpha2desc($letter);
	}
	if ($dP[addressID] != ''){
		$letter=num2add($dP[addressID]);
		$address=strtoupper($ddr["address$defendant$letter"].", ".$ddr["state$defendant$letter"])
	}else{
		$address=strtoupper($ddr["address$defendant"].", ".$ddr["state$defendant"]);
	}
	$newPic = str_replace('ps/','',$dP[browserAddress]);
	echo "<td><input type='radio' name='photo' value='$dP[photoID]'></td><td>$description<br>$address<br><a href='$newPic' target='_Blank'><img width='200' height='125' src='$newPic' /></a></td>";	
}
?>
</tr></table>
<div class="nav3"><input onClick="submitLoader()" type="radio" name="i" value="photo.move.1" /> CHANGE ADDRESS FOR SELECTED</div>
<div class="nav3"><input onClick="submitLoader()" type="radio" name="i" value="photo.remove" /> REMOVE SELECTED PHOTOGRAPH</div>
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="photo.upload.1" /> UPLOAD MORE PHOTOGRAPHS</div>
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="1" /> BACK</div>
<input type="hidden" name="parts" value="<?=$_POST[parts]?>" />
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />

<small>DOT = Deed of Trust | LKA = Last Known Address | ALT = Alternate Service Address</small>
