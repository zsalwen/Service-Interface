<? include 'common.php';
function getMark($file){
$split=explode('http://mdwestserve.com/ps/photographs//',$file);
$img= "http://mdwestserve.com/ps/photographs//small.".$split[1];
return $img;
} 
include 'menu.php'; ?>
<style>
a.pff{color:#000000; text-decoration:none;}
a.pff:link{color:#000000; text-decoration:none;}
a.pff:visited{color:#000000; text-decoration:none;}
a.pff:hover{ color:#990000; cursor:pointer; text-decoration:none;}
</style>
<table width="100%">
	<tr>
    	<td align="center" nowrap="nowrap">File</td>
        <td align="center" nowrap="nowrap">Photo 1a</td>
        <td align="center" nowrap="nowrap">Photo 1b</td>
        <td align="center" nowrap="nowrap">Photo 2a</td>
        <td align="center" nowrap="nowrap">Photo 2b</td>
        <td align="center" nowrap="nowrap">Photo 3a</td>
        <td align="center" nowrap="nowrap">Photo 3b</td>
        <td align="center" nowrap="nowrap">Photo 4a</td>
        <td align="center" nowrap="nowrap">Photo 4b</td>
    </tr>
<? $q="SELECT * from ps_packets WHERE photo1a <> '' order by date_received DESC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
?>
<tr>
	<td><small><a class="pff" title="click for details" href="ps_details.php?pkg=<?=$d[packet_id]?>"><?=$d[client_file] ?></a></small></td>
    <td align="center"><?=$d[name1]?><br /><strong>First Attempt</strong><img src="<?=getMark($d[photo1a])?>" /></td>
    <? if ($d[photo1b]){?><td align="center"><?=$d[name1]?><br /><strong>Second Attempt</strong><img src="<?=getMark($d[photo1b])?>" /></td>
	<? }else{ echo "<td align='center' valign='middle'>NONE</td>";} ?>
    <? if ($d[photo2a]){?><td align="center"><?=$d[name2]?><br /><strong>First Attempt</strong><img src="<?=getMark($d[photo2a])?>" /></td>
	<? }else{ echo "<td align='center' valign='middle'>NONE</td>";} ?>
    <? if ($d[photo2b]){?><td align="center"><?=$d[name2]?><br /><strong>Second Attempt</strong><img src="<?=getMark($d[photo2b])?>" /></td>
	<? }else{ echo "<td align='center' valign='middle'>NONE</td>";} ?>
    <? if ($d[photo3a]){?><td align="center"><?=$d[name3]?><br /><strong>First Attempt</strong><img src="<?=getMark($d[photo3a])?>" /></td>
	<? }else{ echo "<td align='center' valign='middle'>NONE</td>";} ?>
    <? if ($d[photo3b]){?><td align="center"><?=$d[name3]?><br /><strong>Second Attempt</strong><img src="<?=getMark($d[photo3b])?>" /></td>
	<? }else{ echo "<td align='center' valign='middle'>NONE</td>";} ?>
    <? if ($d[photo4a]){?><td align="center"><?=$d[name4]?><br /><strong>First Attempt</strong><img src="<?=getMark($d[photo4a])?>" /></td>
	<? }else{ echo "<td align='center' valign='middle'>NONE</td>";} ?>
    <? if ($d[photo4b]){?><td align="center"><?=$d[name4]?><br /><strong>Second Attempt</strong><img src="<?=getMark($d[photo4b])?>" /></td>
	<? }else{ echo "<td align='center' valign='middle'>NONE</td>";} ?>

</tr>
<? } ?>



</table>
<? include 'footer.php'; ?>