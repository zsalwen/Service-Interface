<?
// this file will create the connection to joomla based upon email address
mysql_connect();
mysql_select_db('core');
if ($_GET[joomla] && $_GET[email]){
@mysql_query("update ps_users set joomla='$_GET[joomla]' where email='$_GET[email]'");
$q1 = "SELECT * FROM ps_users WHERE joomla = '".$_GET[joomla]."'";		
$r1 = @mysql_query ($q1);
if ($data = mysql_fetch_array($r1, MYSQL_ASSOC)){
$inTwoHours= 60 * 60 * 60 * 2 + time();
setcookie ("psdata[user_id]", $data[id], $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[effects]", $data[effects], $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[name]", $data[name], $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[tos_date]", $data[tos_date], $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[email]", $data[email], $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[level]", $data[level], $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[debug]", date('h:iA n/j/y')." $data[name] #$data[id] logged in using ".$_SERVER["REMOTE_ADDR"], $inTwoHours, "/", ".mdwestserve.com");
header('Location: http://mdwestserve.com/v2/?connect=success');
}else{
header('Location: http://mdwestserve.com/v2/?connect=failed');
}
}else{
header('Location: http://mdwestserve.com/v2/?connect=missing');
}
?>




