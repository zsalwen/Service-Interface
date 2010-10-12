<? include 'functions.php';
mysql_connect();
mysql_select_db('core');
include 'browser.sec.php';
$add = $_SERVER['REMOTE_ADDR'];
if (($_POST[email] && $_POST[password]) || ($_GET[email] && $_GET[password]) ){
	if ($_POST[email]){ $email = $_POST[email]; }else{ $email = $_GET[email];}
	if ($_POST[password]){ $pass = $_POST[password];}else{$pass = $_GET[password]; }
	$q1 = "SELECT * FROM ps_users WHERE email = '$email' AND password = '$pass' AND level <> 'DELETED'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	if ($data = mysql_fetch_array($r1, MYSQL_ASSOC)){
    $ip = getenv(REMOTE_ADDR);
$raw = getPage('http://dnstools.com/?arin=on&portNum=80&target='.$ip.'&submit=Get+Info','anarchy.org','300','');
$cut = explode('<b>IP Whois Results:</b>',$raw);
$cut = explode('<script type="text/javascript">',$cut[1]);
$clean = addslashes($cut[0]);

			$md5 = md5($data[id]);

		if ($data[email_status] != "VERIFIED"){ 
			header('Location: next.php?id='.$data[id]);
		}
			$inTwoHours= 60 * 60 * 2 + time();
			setcookie ("psdata[user_id]", $data[id], $inTwoHours, "/", "service.mdwestserve.com");
			setcookie ("psdata[effects]", $data[effects], $inTwoHours, "/", "service.mdwestserve.com");
			setcookie ("psdata[name]", $data[name], $inTwoHours, "/", "service.mdwestserve.com");
			setcookie ("psdata[tos_date]", $data[tos_date], $inTwoHours, "/", "service.mdwestserve.com");
			setcookie ("psdata[email]", $data[email], $inTwoHours, "/", "service.mdwestserve.com");
			setcookie ("psdata[level]", $data[level], $inTwoHours, "/", "service.mdwestserve.com");
error_log(date('h:iA j/n/y')." $data[name] logged in using ".$_SERVER["REMOTE_ADDR"]."\n", 3, '/logs/user.log');
			header ('Location: server.php');
	
	} else {
		$error = "Invalid Username / Password";
		$event = "bad password: $pass";
				
	}
} elseif ($_POST[submit]){
		$error = "Please Enter your E-Mail Address *AND* Password";
header ('Location: http://mdwestserve.com/application.php?msg=invalid login');
} else{
header ('Location: http://mdwestserve.com/application.php?msg=missing credentials');
}

?>