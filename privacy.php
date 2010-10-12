<?
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Reviewing Privacy Notice');
include 'menu.php';?>
<table bgcolor="#B4CDE2" width="800px" align="center">
    <tr>
    	<td><?=getTemplate('PRIVACY');?></td>
    </tr>
</table>    
<?
include 'footer.php';
?>