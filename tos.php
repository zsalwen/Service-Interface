<?
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Terms of Service');
?>
<table bgcolor="#B4CDE2" width="100%" align="center">
	<tr bgcolor="#FFFFCC">
    	<td style="font-size:24px;" align="center">PS-CORE Terms of Service</td>
        <td style="font-size:24px;" align="center">Updated on <? $date=getTemplateDate('TOS'); echo $date[1];?></td>
	</tr>
    <tr>
    	<td colspan="2"><?=getTemplate('TOS');?></td>
    </tr>
</table>    
<?
include 'footer.php';
?>