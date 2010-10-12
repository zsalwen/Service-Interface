<?
if ($_COOKIE[psdata][level] != "Operations"){
		$event = 'Security Lock';
		$email = $_COOKIE[psdata][email];
		$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
		//@mysql_query($q1) or die(mysql_error());
		header('Location: desktop.php');
}
?>