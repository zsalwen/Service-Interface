<?
// this page will use help_templates to restrict access off "staff" pages
include 'common.php';

include 'menu.php';

$q="select * from help_templates where type='PUBLIC' order by name";
$r=@mysql_query($q);
?>
<table border="1" align="center" style="border-collapse:collapse" cellpadding="2" bgcolor="#FFFFFF" width="100%">
	<tr>
    	<td align="center">Page</td>
    	<td align="center">Title</td>
    	<td align="center">Updated</td>
	</tr>
<style>
td.pcc:hover{ background-color:#CCCCCC; cursor:pointer}
</style>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){?>    
	<tr>
    	<td class="pcc" align="left" onclick="window.open('help.php?page=<?=$d[name]?>','Help File','width=500,height=700,toolbar=no,statusbar=no,location=no')"><?=$d[name]?></td>
    	<td align="left"><?=$d[title]?></td>
    	<td align="center"><?=$d[saved]?></td>
	</tr>
<? }?>    
</table>
<? include 'footer.php';
