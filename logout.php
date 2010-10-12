<?
$inTwoHours = 0;
setcookie ("psdata[user_id]", '', $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[effects]", '', $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[name]", '', $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[tos_date]", '', $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[email]", '', $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[level]", '', $inTwoHours, "/", ".mdwestserve.com");
setcookie ("psdata[debug]", '', $inTwoHours, "/", ".mdwestserve.com");
header ('Location: http://mdwestserve.com/v2/');
?>