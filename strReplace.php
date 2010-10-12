<?
include 'common.php';
include 'lock.php';
$i=0;
?>
<center><h1>Affidavit Language Replacement</h1></center>
<table align="center">
	<tr bgcolor="<?=row_color($i,'CCFFFF','CC99CC')?>">
		<td align="center">#</td>
		<td align="center">Search Term</td>
		<td align="center">Replacement Term</td>
		<td align="center">Attorney</td>
	<tr>
<?
$q="SELECT repID, attorneys_id, str_search, str_replace FROM ps_str_replace ORDER BY attorneys_id ASC";
$r=@mysql_query($q) or die (mysql_error());
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$i++;?>
	<tr bgcolor="<?=row_color($i,'CCFFFF','CC99CC')?>">
		<td align="center">
			<?=$d[repID]?>
		</td>
		<td align="center">
			<?=$d[str_search]?>
		</td>
		<td align="center">
			<?=$d[str_replace]?>
		</td>
		<td align="center">
			<?=id2attorney($d[attorneys_id])?>
		</td>
	<tr>
<? } ?>
</table>