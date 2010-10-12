<? 
include 'common.php';
include 'menu.php';
logAction($_COOKIE['psdata']['user_id'], $_SERVER['PHP_SELF'], 'Reading Online Documents');

?><script type="text/javascript">
function init() {
hideshow(document.getElementById('docs'));
}
window.onload = init;
</script>
<style>
a { color:#000000; text-decoration:none; font-size:12px;}
</style>
<table border="1" cellpadding="5" style="border-collapse:collapse; border:solid 2px;" width="880px">
<?
$i=0;
$q= "select * from ps_news WHERE is_approved = 'checked' ORDER by topic ASC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {

if ($d[icon_url] == "Web Site"){
$icon = '<img src="http://portal.hwestauctions.com/ps/gfx/web.png" height="30" style="float:left"  border="0">' ;
}

if ($d[icon_url] == "PDF File"){
$icon = '<img src="http://portal.hwestauctions.com/ps/gfx/pdf.png" height="30" style="float:left"  border="0">' ;
}

if ($d[icon_url] == "Image File"){
$icon = '<img src="http://portal.hwestauctions.com/images/icon_picture.gif" style="float:left" height="25" border="0">' ;
}

if ($d[icon_url] != "Web Site" && $d[icon_url] != "PDF File" && $d[icon_url] != "Image File" || !$d[icon_url] ){
$icon = "<center>no image to display</center>" ;
}
?>
	<tr>
    	<td bgcolor="#ffffff"><?=$icon ?></td>
    	<td align="left">
            	<a href="<?=$d[news_url] ?>" target="_blank">
					<strong><?=$d[topic] ?></strong>
                </a>
            
        </td>
    
    	<td align="justify" bgcolor="#FFFFFF" style="font-size:14px"><?=$d[description] ?></td>
        
        
<?  if ($_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Administrator" || $_COOKIE[psdata][level] == "Operations" || $_COOKIE[psdata][user_id] == $d['user_id']) { ?>    
        <td><a target="_blank" href="news_edit.php?id=<?=$d['id']?>"><strong>Edit</strong></a></td>
        <? } ?>        
        
        
	</tr>
<?		
 $i++;
} ?>
	<tr>
    	<td colspan="4" bgcolor="#CCFFCC" style="color:#000000; border:solid" align="center"><a style="font-size:18px" href="post.php">New Document</a></td> 
	</tr>

</table>
<? include 'footer.php';?>