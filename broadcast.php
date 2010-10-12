<?
if ($_COOKIE[psdata][level] == "Administrator"){
// everything in here
include 'common.php';
if ($_POST[msg] && $_POST[subject]){
$from = "Service <service@hwestauctions.com>";
$headers .= "From: $from \n";


$q="select email, name from ps_users where level <> 'DELETED'";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$headers .= "Bcc: $d[name] <$d[email]> \n"; // loop this
}


mail($from,$_POST[subject],$_POST[msg],$headers);
echo "<pre>To: ".htmlspecialchars($from)."</pre><hr>";
echo "<pre>".htmlspecialchars($headers)."</pre><hr>";
echo "<pre>Subject: $_POST[subject]</pre><hr>";
echo "<pre>Message: $_POST[msg]</pre>";
}
include 'menu.php'; ?>

<hr />
<form method="post">
<table>
	<tr>
    	<td>Subject</td>
        <td><input name="subject" size="100" value="<?=$_POST[subject]?>"></td>
    </tr>
    <tr>
    	<td>Message</td>
        <td><textarea cols="70" rows="30" name="msg"><?=$_POST[msg]?></textarea></td>
    </tr>
    <tr>
    	<td colspan="2"><input type="submit" value="Send Message to EVERYONE!!!"></td>
    </tr>
</table>    
</form>




<? } else { // end admin requirement 
	$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$_POST[password]', '$_POST[email]', NOW())";
		//@mysql_query($q1) or die(mysql_error());
?>
go away
<? } ?>