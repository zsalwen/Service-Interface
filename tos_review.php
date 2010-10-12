<?
include 'security.php';
include 'functions.php';
mysql_connect();
mysql_select_db('core');
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Reviewing Terms of Service');
$templateDate=getTemplateDate('TOS');
if ($_GET[tos] == "Y"){
	$id = $_COOKIE[psdata][user_id];
	setcookie ("psdata[tos_date]", $templateDate[0]);
	@mysql_query("UPDATE ps_users SET tos_date = '$templateDate[0]' WHERE id = '$id'") or die(mysql_error());
	header('Location: http://mdwestserve.com/updated.html'); 
}

if ($_GET[tos] == "N"){
	header('Location: http://www.openoffice.org');
}


include 'menu.php';



?>
<table bgcolor="#99CCFF">
	<tr>
    	<td width="50%">PS-CORE Terms of Service</td>
        <td width="50%"><?=$templateDate[1];?></td>
	</tr>
    <tr>
    	<td colspan="2"><?=getTemplate('TOS');?></td>
    </tr>
	<tr style="font-size:30px">
    	<td width="50%" align="center"><a href="?tos=Y">I AGREE</a></td>
        <td width="50%" align="center"><a href="?tos=N">I DISAGREE</a></td>
	</tr>
</table>    
<?
include 'footer.php';
?>
