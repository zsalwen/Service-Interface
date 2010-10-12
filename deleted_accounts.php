<? include 'common.php'; 
	include 'menu.php';
?>
<center>
<div style="width: 100%; height:590px; overflow:auto">
<table bgcolor="#CCCCFF" width="100%">
	<tr>
    	<td colspan=""></td>
    </tr>
	<tr>
    	<td width="6%"><b>Undelete</b></td>
        <td align="center"><b>Profile Name / Name / Company</b></td>
        <td align="center"><b>Signup Date</b></td>
        <td align="center"><b>Profile Updated</b></td>
        <td align="center"><b>Last Login</b></td>
        <td align="center"><b>Manager Review Notes</b></td>
    </tr>
<?
$q="SELECT * FROM ps_users where level = 'DELETED'";
$r=mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
while($d=mysql_fetch_array($r, MYSQL_ASSOC)){$i++;
?>
	<tr bgcolor="<?=row_color($i,'#ffcccc','#ccccff')?>">
		<td>
        <a href="ps_review.php?admin=<?=$d[id] ?>">Undelete</a></td>
        <td align="center"><? if ($d[profile_name]){echo "$d[profile_name], ";}else{} if ($d[name]){echo "$d[name]";}else{} if ($d[company]){ echo ", $d[company]";}else{}?></td>
        <td align="center"><?=$d[signup]?></td>
        <td align="center"><?=$d[p_update]?></td>
        <td align="center"><?=$d[last_login]?></td>
        <td align="center"><?=$d[manager_review]?></td>
	</tr>

<? } ?>
</table>
</div>
</center>
<? include 'footer.php'; ?>