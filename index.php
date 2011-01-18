<?
include 'functions.php';
mysql_connect();
mysql_select_db('core');
$add = $_SERVER['REMOTE_ADDR'];
if ($_POST[staffEmail] && $_POST[staffPassword]){
$email = $_POST[staffEmail];
$pass = $_POST[staffPassword];
$q1 = "SELECT * FROM ps_users WHERE email = '$email' AND password = '$pass'";
$r1 = @mysql_query ($q1) or die(mysql_error());
if ($data = mysql_fetch_array($r1, MYSQL_ASSOC)){
$inEightHours= 60 * 60 * 8 + time();
setcookie ("psdata[user_id]", $data[id], $inEightHours, "/", ".mdwestserve.com");
setcookie ("psdata[effects]", $data[effects], $inEightHours, "/", ".mdwestserve.com");
setcookie ("psdata[name]", $data[name], $inEightHours, "/", ".mdwestserve.com");
setcookie ("psdata[tos_date]", $data[tos_date], $inEightHours, "/", ".mdwestserve.com");
setcookie ("psdata[email]", $data[email], $inEightHours, "/", ".mdwestserve.com");
setcookie ("psdata[level]", $data[level], $inEightHours, "/", ".mdwestserve.com");
setcookie ("staff[user_id]", $data[id], $inEightHours, "/", "staff.mdwestserve.com");
setcookie ("staff[name]", $data[name], $inEightHours, "/", "staff.mdwestserve.com");
setcookie ("staff[email]", $data[email], $inEightHours, "/", "staff.mdwestserve.com");
error_log(date('h:iA j/n/y')." $data[name] logged in using ".$_SERVER["REMOTE_ADDR"]."\n", 3, '/logs/user.log');
header ('Location: http://service.mdwestserve.com/ps_worksheet.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<title>MDWestServe, Inc.</title>	
	<link rel="shortcut icon" href="image/favicon.ico" />
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en-gb" />
	<meta http-equiv="imagetoolbar" content="false" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />	
	<meta name="revisit-after" content="7 days" />
	<style>
.intro{
position:absolute;
left:0;
top:0;
layer-background-color:green;
background-color:green;
border:0.1px solid green;
z-index:10;
}
</style>
</head>

<body>


	<div id="container">
		<div id="navigation">
		</div>
		<div id="content">
<table width="100%"><tr><td valign="top">
			<form  method="post" id="search" name="router">
                <div id="sidebar" align="left" width=300px;>
					
<h2>MDWestServe Process Server Login</h2>
						<table>
							<tr>
								<td><li>E-Mail Address</td><td><input size="40" style="background-color:#ffccff;" name="staffEmail" /></td>
							</tr><tr>	
								<td><li>Password</li></td><td><input input size="40" style="background-color:#ffccff;"  name="staffPassword" type="password" /><input type="submit" value="GO"></td>
							</tr>
						</table>	
				</div>
            </form>
			
			</td><td valign="top" align="right">
			
			<img src="small.logo.F5F5F5.gif">
			
			</td></tr></table>
			
		</div>
		<div id="footer">
			Copyright &copy; <a href="#">MDWestServe, Inc.</a> 2009
			&nbsp;&nbsp;|&nbsp;&nbsp;
			<b>Process Server Login Only</b>
		</div>
</body>
</html>