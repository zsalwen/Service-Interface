<? include 'functions.php';
db_connect('delta.mdwestserve.com','intranet','root','zerohour');?>
<script language="javascript" type="text/javascript"><!--
function automation() {
  window.opener.location.href = window.opener.location.href;
  //window.open('write_update.php','update','width=1,height=1,toolbar=no,location=no')
  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
  window.close();
}
// -->
</script>
<?
if ($_POST[submit]){
$q= "select * from ps_users WHERE email = '$_POST[email]'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC);
$from = "Service <service@hwestauctions.com>";
$to  = "$d[name] <$_POST[email]>";
$subject = "Lost Password:  $d[name]";
$headers .= "From: $from \n";
$msg = "Dear $d[name],
Your password is $d[password].  If you have any questions, please feel free to contact our office at 410-828-4568." ;
mail($to,$subject,$msg,$headers);
echo "<script>automation();</script>";
}
?>
<table align="center">
<form method="post">
<tr>
<td>Email Address: </td>
<td><input name="email" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input name="submit" type="submit" value="E-Mail My Password To Me" /></td>
</tr>
</form>
</table>
