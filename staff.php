<?
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Staff List');
include 'menu.php';

$q="SELECT *, DATE_FORMAT(signup,'%a, %b %D %Y at %r') as signup, DATE_FORMAT(last_login,'%a, %b %D %Y at %r') as login  FROM ps_users WHERE level = 'Administrator' or level = 'Manager' or level = 'Data Entry' or level = 'SysOp' or level = 'Dispatch' or level = 'Photo Specialist' or level = 'Operations' ORDER BY last_login DESC";
$r=@mysql_query($q);
?>
<div style="overflow:auto; width:900px; height:590px">
<table align="center" border="1" style="border-collapse:collapse; font-size:14px;" bgcolor="#FFFFFF">
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ ?>

	<tr>
    	<td width="10px"><?=image($d[img],'','100');?></td>
        <td style="font-size:20px"><? if($d[profile_name]){ echo $d[profile_name];}else{ echo $d[name]; }?>-<?=$d[user_id]?><br><?=$d[level]?><br><?=$d[login]?></td>
	</tr>

<? }?>

</table>
</div>
<?
include 'footer.php';
?>