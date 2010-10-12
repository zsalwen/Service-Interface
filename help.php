<? 
// start functions
function db_connect($host,$database,$user,$password){
	$step1 = @mysql_connect ();
	$step2 = mysql_select_db ($database);
	return mysql_error();
}
function getTemplate($template){
	$q="select template from help_templates where name='$template' order by id desc";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return stripslashes($d[template]);
}
function getTemplateTitle($template){
	$q="select title from help_templates where name='$template' order by id desc";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return stripslashes($d[title]);
}
function getTemplateDate($template){ // version history ?
$q="select *, DATE_FORMAT(saved, '%W, %M %D at %r') as saved_f from help_templates where name='$template' order by id desc";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
$date[0] = $d[saved];
$date[1] = $d[saved_f];
return $date;
}
function smtpMail($t,$subject,$html){
	//error_reporting(E_ALL); 
	define('DISPLAY_XPM4_ERRORS', false); 
	require_once '/opt/lampp/htdocs/smtp/SMTP.php';
	$f = 'service@hwestauctions.com';
	$user = 'pmcguire@hwestauctions.com';
	$p = 'patrick';
	$m = 'From: '.$f."\r\n".
		 'To: '.$t."\r\n".
		 'Subject: '.$subject."\r\n".
		 'Content-Type: text/html'."\r\n\r\n".
		 '<body>'.$html.'</body>';
	$c = fsockopen('mail.hwestauctions.com', 25, $errno, $errstr, 20) or die($errstr);
	if (!SMTP::recv($c, 220)) die(print_r($_RESULT));
	if (!SMTP::ehlo($c, 'delta.mdwestserve.com')) SMTP::helo($c, 'delta.mdwestserve.com') or die(print_r($_RESULT));
	if (!SMTP::auth($c, $user, $p, 'login')) SMTP::auth($c, $user, $p, 'plain') or die(print_r($_RESULT));
	SMTP::from($c, $f) or die(print_r($_RESULT));
	SMTP::to($c, $t) or die(print_r($_RESULT));
	SMTP::data($c, $m) or die(print_r($_RESULT));
	SMTP::quit($c);
	@fclose($c);
}
function id2name($id){
	$q="SELECT name FROM ps_users WHERE id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
return $d[name];
}
function logAction($userid, $page, $action){
	$q="INSERT into ps_log(user_id, page, action, log_stamp) values ('$userid', '$page', '$action', NOW())";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());

}
// end functions
db_connect('delta.mdwestserve.com','intranet','root','zerohour');
if ($_GET[page]){
	$page = $_GET[page];
}else{
	$page = $_GET[request];
}

logAction($_COOKIE['psdata']['user_id'], $_SERVER['PHP_SELF'], 'Requesting Help for '.$page);
$id = $_COOKIE[psdata][user_id];
$id2 = id2name($id);

if ($_GET[request]){ // we can keep this at the top
	$a = $_GET[request];
	$b = "Documentation In Progress";
	@mysql_query("INSERT INTO help_templates (name, template, requested_by, saved) values ('$a', '$b', $id, NOW() )") or die(mysql_error());
	$to = "sysop@hwestauctions.com";
	$subject = "Help File Requested : $a";
	$html = "User $id2 has requested the help file for $a";
	smtpMail($to,$subject,$html);
	header('Location: help.php?page='.$a);
}
$update = getTemplateDate($page);
$title = getTemplateTitle($page);
?>
<script src="common.js" type="text/javascript"></script>
<script>//workspace(400,500);</script>
<div>
<div  onclick="self.close();" style="font:Arial, Helvetica, sans-serif; font-size:24px;" align="right">HWA Help : <? if ($title){ echo $title;}else{ echo "No Topic";}?></div>
<hr>
<? if (getTemplate($page)){ echo getTemplate($page); }else{?><center><a href='?request=<?=$page?>'>Help us help YOU!<br>Click HERE to Request Help File</a></center><? } ?>
<hr>
	
<div style="font-size:12px" align="center">Help file for <? if ($title){ echo $title;}else{ echo $page;}?> <? if ($update[0]){ echo "last updated ".$update[0];}else{ echo "has not been requested";}?><br>&copy; Harvey West Auctioneers</div><center><a onClick="self.close();">CLICK-2-CLOSE</a></center>
</div>