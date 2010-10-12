<?
include 'common.php';


include 'lock.php';
opLog($_COOKIE[psdata][name]." Loaded Dispath Master #$_GET[packet]");


?>

<table width="100%" style="display:none;" id="addresses"><tr><td>

<FIELDSET>
<LEGEND class="a" ACCESSKEY=C><a href="http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=<?=$d[address1]?>&city=<?=$d[city1]?>&state=<?=$d[state1]?>&miles=5" target="_Blank">Mortgage / Deed of Trust</a><input type="checkbox" checked><br><?=id2name($d[server_id]);?></LEGEND>
<table>
<tr>
<td><input id="address" name="address" size="30" value="<?=$d[address1]?>" /></td>
</tr>
<tr>
<td><input size="20" name="city" value="<?=$d[city1]?>" /><input size="2" name="state" value="<?=$d[state1]?>" /><input size="4" name="zip" value="<?=$d[zip1]?>" /></td>
</tr>
</table>    
</FIELDSET>
</td><td>
<FIELDSET>
<LEGEND class="a" ACCESSKEY=C><a href="http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=<?=str_replace('#','',$d[address1a])?>&city=<?=$d[city1a]?>&state=<?=$d[state1a]?>&miles=5" target="_Blank">Possible Place of Abode</a> <input type="checkbox"><br><?=id2name($d[server_ida]);?></LEGEND>
<table>
<tr>
<td><input name="addressa" size="30" value="<?=$d[address1a]?>" /></td>
</tr>
<tr>
<td><input name="citya" size="20" value="<?=$d[city1a]?>" /><input size="2" name="statea" value="<?=$d[state1a]?>" /><input size="4" name="zipa" value="<?=$d[zip1a]?>" /></td>
</tr>
</table>    
</FIELDSET>
</td><td>
<FIELDSET>
<LEGEND class="a" ACCESSKEY=C><a href="http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=<?=$d[address1b]?>&city=<?=$d[city1b]?>&state=<?=$d[state1b]?>&miles=5" target="_Blank">Possible Place of Abode</a> <input type="checkbox"><br><?=id2name($d[server_idb]);?></LEGEND>
<table>
<tr>
<td><input name="addressb" size="30" value="<?=$d[address1b]?>" /></td>
</tr>
<tr>
<td><input name="cityb" size="20" value="<?=$d[city1b]?>" /><input size="2" name="stateb" value="<?=$d[state1b]?>" /><input size="4" name="zipb" value="<?=$d[zip1b]?>" /></td>
</tr>
</table>    
</FIELDSET>
</td></tr>

<tr><td>
<FIELDSET>
<LEGEND class="a" ACCESSKEY=C><a href="http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=<?=$d[address1c]?>&city=<?=$d[city1c]?>&state=<?=$d[state1c]?>&miles=5" target="_Blank">Possible Place of Abode</a> <input type="checkbox"><br><?=id2name($d[server_idc]);?></LEGEND>
<table>
<tr>
<td><input name="addressc" value="<?=$d[address1c]?>" size="30" /></td>
</tr>
<tr>
<td><input name="cityc" size="20" value="<?=$d[city1c]?>" /><input size="2" name="statec" value="<?=$d[state1c]?>" /><input size="4" name="zipc" value="<?=$d[zip1c]?>" /></td>
</tr>
</table>    
</FIELDSET>
</td><td>
<FIELDSET>
<LEGEND class="a" ACCESSKEY=C><a href="http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=<?=$d[address1d]?>&city=<?=$d[city1d]?>&state=<?=$d[state1d]?>&miles=5" target="_Blank">Possible Place of Abode</a> <input type="checkbox"><br><?=id2name($d[server_idd]);?></LEGEND>
<table>
<tr>
<td><input name="addressd" size="30" value="<?=$d[address1d]?>" /></td>
</tr>
<tr>
<td><input name="cityd" size="20" value="<?=$d[city1d]?>" /><input size="2" name="stated" value="<?=$d[state1d]?>" /><input size="4" name="zipd" value="<?=$d[zip1d]?>" /></td>
</tr>
</table>    
</FIELDSET>
</td><td>
<FIELDSET>
<LEGEND class="a" ACCESSKEY=C><a href="http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=<?=$d[address1e]?>&city=<?=$d[city1e]?>&state=<?=$d[state1e]?>&miles=5" target="_Blank">Possible Place of Abode</a> <input type="checkbox"><br><?=id2name($d[server_ide]);?></LEGEND>
<table>
<tr>
<td><input name="addresse" size="30" value="<?=$d[address1e]?>" /></td>
</tr>
<tr>
<td><input name="citye" size="20" value="<?=$d[city1e]?>" /><input size="2" name="statee" value="<?=$d[state1e]?>" /><input size="4" name="zipe" value="<?=$d[zip1e]?>" /></td>
</tr>
</table>    
</FIELDSET>
</td></tr>
</table>

