<?
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Member List');
include 'menu.php';

$q="SELECT *, DATE_FORMAT(signup,'%b %D %Y at %r') as signup, DATE_FORMAT(last_login,'%b %D %Y at %r') as login  FROM ps_users WHERE contract = 'YES' and level = 'Gold Member' ORDER BY online_now DESC";
$r=@mysql_query($q);
?>
<table width="100%" border="1" style="border-collapse:collapse; font-size:14px;">
	<tr bgcolor="#FFFFCC">
    	<td colspan="2" align="center">Independent Contractor</td>
        <td align="center">Signup Date</td>
        <td align="center">Last Login</td>
	</tr>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ 
	if ($d[ip_address] == $_SERVER['REMOTE_ADDR']){
		$bg = "bgcolor=#CCFF66";
	}else{
		$bg = "";
	}
?>
	<tr <?=$bg?>>
    	<td width="10px"><?=image($d[img],'','50');?></td>
        <td style="font-size:20px"><a href="profile.php?id=<?=$d[id]?>"><? if($d[profile_name]){ echo $d[profile_name];}else{ echo $d[name]; }?></a></td>
        <td><? if ($d[signup]){ echo $d[signup];}else{?> ...from the start. <? }?></td>
        <td><?=$d[login]?></td>
	</tr>

<? }?>

</table>
<?
include 'footer.php';
?>
