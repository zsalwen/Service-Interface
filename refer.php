<?
include 'common.php'; 
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Referring a Friend');
$user_id=$_COOKIE[psdata][user_id];
if ($_POST[name] && $_POST[email]){
$q1 = "INSERT INTO ps_refer ( 
							name,
							email,
							send_id,
							send_time
							) VALUES (
							'$_POST[name]',
							'$_POST[email]',
							'$_POST[user_id]',
							NOW()
							)";
@mysql_query($q1) or die("Query: $q1<br>".mysql_error());

$q= "select name from ps_users where id = '".$_COOKIE[psdata][user_id]."'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC);

$from = "Service <service@hwestauctions.com>";
$to  = "$_POST[name] <$_POST[email]>";
$subject = "New Referral:  $_POST[name]";
$headers .= "From: $from \n";
$headers .= "Cc: $from \n";
		
		
$msg = "Dear $_POST[name],

$d[name] referred your information to us at the Harvey West Auctioneers Process Serving Network.  If you have any interest in learning more about process serving, or signing up for a free account, you can find all the necessary tools at www.hwestauctions.com.  If you have any questions, please feel free to contact our office at 410-828-4568." ;
//		$body .= "MySQL Query: ".$q1."...success!";
mail($to,$subject,$msg,$headers);

$thanks = "<center><h2>Thank you for referring $_POST[name]!</center></h2>";

}
	include 'menu.php';
?>
<style>
input{background-color:#ccffff; font-weight:bold;}
</style>
<br />
<br />
<br />
<br />

<table align="center" width="75%" border="1">
<form method="post">
<input type="hidden" name="user_id" value="<?=$_COOKIE[psdata][user_id]?>" />
	<tr>
    	<td bgcolor="#ffff99" align="center" valign="middle"><font size="+3"><b>Refer a Friend!</b></font></td>
    </tr>
	<tr>
    	<td bgcolor="#99cccc" style="border-bottom:hidden" align="center"><b>Name:</b> <input name="name" size="60" /></td>
	</tr>
	<tr>
    	<td bgcolor="#99cccc" align="center"><b>Email:</b> <input name="email" size="60" /></td>
	</tr>
    <tr>
    	<td align="center" bgcolor="#ffff99"><input type="submit" name="submit" value="Send Referral" /></td>
    </tr>
</form>
</table>
<?	echo $thanks;
include 'footer.php'; ?>