<?
	if ($_COOKIE[psdata][level] != "Dispatch" && $_COOKIE[psdata][level] != "SysOp"){
		header('Location: home.php');
	}
$id = $_COOKIE[psdata][user_id];

// start functions
function db_connect($host,$database,$user,$password){
	$step1 = @mysql_connect ();
	$step2 = mysql_select_db ($database);
	return mysql_error();
}
function getPageTitle($template){
	$q="select title from help_templates where name='$template' order by id desc";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return stripslashes($d[title]);
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
function color(){
	$color[0] = "00";
	$color[1] = "33";
	$color[2] = "66";
	$color[3] = "99";
	$color[4] = "cc";
	$color[5] = "ff";
	$a = rand(2,5);
	$b = rand(1,5);
	$c = rand(1,5);
	$color = $color[$a].$color[$b].$color[$c];
	return $color;
}
// end functions
db_connect('delta.mdwestserve.com','intranet','root','zerohour');



if ($_GET[change]){
$q="select level from help_templates where id = '$_GET[change]'";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
if ($d[level] == "PRIVATE"){ $new = "PUBLIC"; } else { $new = "PRIVATE"; } 
@mysql_query("update help_templates set level = '$new' where id = '$_GET[change]' ");
}

include 'menu.php';


if ($_GET[id]){
?>
    
        <?
        if ($_POST[whiteboard]){
            $whiteboard = addslashes($_POST[whiteboard]);
            $q = "update help_templates set template='$whiteboard', title = '$_POST[title]', updated_by='$id', saved=NOW() WHERE id = '$_GET[id]'";		
            $r = @mysql_query ($q) or die(mysql_error());
            $saved = 1;
        }
        $q = "SELECT * FROM help_templates WHERE id = '$_GET[id]'";		
        $r = @mysql_query ($q) or die(mysql_error());
        $d = mysql_fetch_array($r, MYSQL_ASSOC);
        ?>
		<? if ($_GET[id] && !$saved ){?>
        <script language="JavaScript" type="text/javascript" src="../common/ps_wysiwyg.js"></script>
        <div style="background-color:#FFFFFF; border:double;">
            <form method="post">
            <center>
            Title: <input name="title" size="50" value="<?=$d[title]?>" /> (<?=$d[name]?>)
            <textarea id="whiteboard" rows="30" cols="100" name="whiteboard"><?=stripslashes($d[template])?></textarea>
             <script language="JavaScript">
              generate_wysiwyg('whiteboard');
            </script> <br>
            <input style="font-size:24px; color:#006666;" name="submit" type="submit" value="Save Template"></center>
            </form></div>
        <? } else { echo "<script>window.location='help_cms.php'</script>";}?>
    
<?
} else {
$q="select * from help_templates order by name";
$r=@mysql_query($q);
?>
<table border="1" align="center" style="border-collapse:collapse" cellpadding="2" bgcolor="#FFFFFF" width="100%">
	<tr>
    	<td align="center">Page</td>
    	<td align="center">Title</td>
        <td>Availability</td>
    	<td align="center">Updated</td>
	</tr>
<style>
td.pcc:hover{ background-color:#CCCCCC; cursor:pointer}
</style>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){?>    
	<tr>
    	<td class="pcc" align="left" onclick="window.location='?id=<?=$d[id]?>'"><?=$d[name]?></td>
    	<td align="left"><?=$d[title]?></td>
    	<td align="left" onclick="window.location='?change=<?=$d[id]?>'"><?=$d[level]?></td>
    	<td align="center"><?=$d[saved]?></td>
        <td align="center"><? if ($d[template] == 'Documentation In Progress'){?><small>Needs Documentation</small><? }else{ } ?></td>
	</tr>
<? }?>    
</table>
<? }
include 'footer.php';
?>
<script>hideshow(document.getElementById('sysop'))</script>