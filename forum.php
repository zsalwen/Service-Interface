<?
function mouseover2($a,$b){ return "onmouseover=\"style.backgroundColor='#$a';\" onmouseout=\"style.backgroundColor='#$b';\"  bgcolor=\"#$b\" align='center'";}
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Forum');
include 'menu.php';
?>
<script type="text/javascript" language="javascript" src="forum.js"></script>
<script type="text/javascript">
function init() {
sndReq('main_tree','');
hideshow(document.getElementById('forum'));
}
window.onload = init;
</script>
<style>
small.pss:hover{color:#FF0000; cursor:pointer; font-weight:bold;}
.btn{background-color:#CC99FF; font-size:9px; padding:0px; margin:0px; border:solid 1px;}
.btn:hover{background-color:#CC99CC; font-size:9px; padding:0px; margin:0px; border:solid 1px;}
</style>
<?
function topic($topic_id){
	$q="select * from ps_forum_topics where topic_id = '$topic_id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return stripslashes($d[topic]);
}


	$q="select * from ps_forum_messages order by message_id DESC limit 0,4";
	$r=@mysql_query($q);
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$recent_messages .= '<div style="border:solid 1px; padding:2px; background-color:#ffffcc" onClick="sndReq(\'main_post\',\''.$d[topic_id].'\');">'.stripslashes($d[message]).'</div><div align="right"><small>'.id2name($d[post_by]).' about '.topic($d[topic_id]).'</small></div>';
	}


?>
<table border="1" width="800px" style="border-collapse:collapse" cellpadding="0" align="center">
	<tr>
    	<td rowspan="2" valign="top"><div align="center" style="font-size:22px; background-color:#CCCCFF; font-variant:small-caps">Message Board Topics</div><div id="tree" style="height:435px; width:337px; overflow:auto"></div></td>
        <td><div id="read" style="height:300px; width:550px; padding-left:5px; padding-right:5px; background-color:#CCCCFF; overflow:auto"><?=$recent_messages;?></div></td>
    </tr>
    <tr>
    	<td bgcolor="#FFFFCC"><div id="post" style="height:150px; width:550px; padding:5px"></div></td>
    </tr>
</table>
<?
if ($_GET[topic]){ ?>
<script>sndReq('main_read','<?=$_GET[topic];?>')</script>
<? }
include 'footer.php';?>