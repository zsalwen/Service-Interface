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
function id2name($id){
	$q="SELECT name FROM ps_users WHERE id = '$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
return $d[name];
}
// end functions
db_connect('delta.mdwestserve.com','intranet','root','zerohour');


$q="select name from help_templates where level='PUBLIC' order by RAND()";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
$page = $d[name];
$update = getTemplateDate($page);
$title = getTemplateTitle($page);
?>
<div style="padding:10px">
<div style="font:Arial, Helvetica, sans-serif; font-size:24px;" align="center">Do you know about <em><?=$title;?></em> ?</div>
<hr>
<?=getTemplate($page);?>
</div>