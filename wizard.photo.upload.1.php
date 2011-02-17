1) Select Photograph to Upload<br />
<input size="50" name="upload" type="file" /><br />
2) Select Action / Address<br />
<? foreach(range('a','m') as $letter){ 
if (photoAddress($packet,$defendant,$letter) != ''){
?>
<div class="photo<?=$letter?>"><input onClick="submitLoader()" type="radio" name="photo" value="<?=$letter?>" /> <?=alpha2desc($letter);?> at <?=strtoupper(photoAddress($packet,$defendant,$letter))?></div>
<?
}
 } ?>
<div class="photoa"><input onClick="submitLoader()" type="radio" name="photo" value="x">FREEFORM<br>
DESCRIPTION: <input name="freeDesc" size="50" value=''><br>
ADDRESS: <select name='freeAdd'>
	<option value="1"><?=substr($ddr[address1].", ".$ddr[city1].", ".$ddr[state1],0,50)?></option>
    <? if ($ddr[address1a]){?>
	<option value="2"><?=substr($ddr[address1a].", ".$ddr[city1a].", ".$ddr[state1a],0,50)?></option>
    <? }
	if ($ddr[address1b]){?>
	<option value="3"><?=substr($ddr[address1b].", ".$ddr[city1b].", ".$ddr[state1b],0,50)?></option>
    <? }
	if ($ddr[address1c]){?>
	<option value="4"><?=substr($ddr[address1c].", ".$ddr[city1c].", ".$ddr[state1c],0,50)?></option>
    <? } 
	if ($ddr[address1d]){?>
	<option value="5"><?=substr($ddr[address1d].", ".$ddr[city1d].", ".$ddr[state1d],0,50)?></option>
    <? } 
	if ($ddr[address1e]){?>
	<option value="6"><?=substr($ddr[address1e].", ".$ddr[city1e].", ".$ddr[state1e],0,50)?></option>
    <? } ?></select></div>
<div class="nav0"><input onClick="submitLoader()" Checked type="radio" name="i" value="photo.upload.2" /> AUTO-NEXT</div>
<div class="nav2"><input onClick="submitLoader()" type="radio" name="i" value="photo.review" /> BACK</div>
<input type="hidden" name="parts" value="<?=$_POST[parts]?>" />
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />

<small>DOT = Deed of Trust | LKA = Last Known Address | ALT = Alternate Service Address</small>