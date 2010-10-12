<? include 'common.php';
$id = $_COOKIE[psdata][user_id];
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing PS Home Page');
	include 'menu.php';
?>
<style>
td.psc { color:#FFFFFF; background-color: #6699cc;}
td.psc:hover { color:#000000; background-color: #666699; cursor:pointer; font-size:16px;}
</style>
<table width="100%">
    <tr bgcolor="#666699">
    	<td width="50%" class="psc" colspan="2" align="center"><a href="ps_worksheet.php"><strong>Spreadsheet View</strong></a></td>
        <td class="psc" colspan="2" align="center" onclick="window.frames['ps_frame'].location='ps_map.php?id=<?=$id?>'"><strong>Map View</strong></td>
</table>
<iframe name="ps_frame" width="100%" marginheight="0" frameborder="0" marginwidth="0" height="540px" style="overflow:auto">
</iframe>
<? include 'footer.php'; ?>