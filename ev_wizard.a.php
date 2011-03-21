<?
// ok so here we will select the defendant 
if ($_COOKIE[psdata][level] == "Operations"){
	$q1="select eviction_id, name1, name2, name3, name4, name5, name6 from evictionPackets ORDER BY eviction_id DESC";
}else{
	$q1="select eviction_id, name1, name2, name3, name4, name5, name6 from evictionPackets where ((server_id = '$server') or (server_ida = '$server') or (server_idb = '$server') or (server_idc = '$server') or (server_idd = '$server') or (server_ide = '$server')) ORDER BY eviction_id DESC";
}
$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
$option = "<option>Select from 'In Progress' affidavits.</option>";
while ($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){
					$option .= "<OPTGROUP LABEL='Packet $d1[eviction_id] - $d1[address1]'>";
					$option .= "<option value='$d1[eviction_id]-1'>$d1[name1]</option>";
if ($d1[name2]){	$option .= "<option value='$d1[eviction_id]-2'>$d1[name2]</option>"; }
if ($d1[name3]){	$option .= "<option value='$d1[eviction_id]-3'>$d1[name3]</option>"; }
if ($d1[name4]){	$option .= "<option value='$d1[eviction_id]-4'>$d1[name4]</option>"; }
if ($d1[name5]){	$option .= "<option value='$d1[eviction_id]-4'>$d1[name5]</option>"; }
if ($d1[name6]){	$option .= "<option value='$d1[eviction_id]-4'>$d1[name6]</option>"; }
					$option .= "</OPTGROUP>";
}
?>
<input type="hidden" name="i" value="1" />
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<select name="parts" onchange="submitLoader()"><?=$option?></select>
<? if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? } ?>