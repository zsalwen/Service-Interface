<? include 'common.php';
function topicList(){
	$q="select * from ps_forum_topics order by start_on DESC";
	$r=@mysql_query($q);
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$html .= '<div style="border-bottom:solid 1px;" onClick="sndReq(\'main_read\',\''.$d[topic_id].'\');">&nbsp;'.substr(stripslashes($d[topic]),0,45).'...</div>';
	}
	return $html;
}
function messageList($topic_id){
	$user = $_COOKIE[psdata][user_id];
	$q="select *,DATE_FORMAT(post_on, '%c/%d/%Y %r') as post_on_f from ps_forum_messages where topic_id = '$topic_id' order by message_id";
	$r=@mysql_query($q);
//	$i=0;
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
/*	
	$i++;
		if($d[post_by] == $user){
		$delete = '<input type="hidden" id="message" value="'.$d[message_id].'" />
				<input type="hidden" id="topic" value="Delete Message" />
				<input type="submit" class="btn" value="Delete">';
//		'<b><small class="pss" onClick="sndReq(\'main_delete\',\''.$topic_id.'\');">click to DELETE</small><small> - </small></b>';
		}
*/
	$html .= '<div><div style="border:solid 1px; padding:2px; background-color:#ffffcc" onClick="sndReq(\'main_post\',\''.$topic_id.'\');">'.stripslashes($d[message]).'</div><div align="right"><small>'.id2name($d[post_by]).' on '.$d[post_on_f].'</small></div></div>';
//		$delete = '';
	}
	return $html;
}

function messageTopic($topic_id){
	$user = $_COOKIE[psdata][user_id];
	$q="select *,DATE_FORMAT(start_on, '%c/%d/%Y %r') as start_on_f from ps_forum_topics where topic_id = '$topic_id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
/*
	if($d[start_by] == $user){
		$delete2 = '<input type="submit" class="btn" value="Delete Topic">';
//		'<b><small class="pss" onClick="sndReq(\'main_delete\',\''.$topic_id.'\');">click to DELETE</small><small> - </small></b>';
		}
*/
	return '<div style="border:solid 1px; font-size:20; text-align:center; background-color:#ccFFCC;">'.stripslashes($d[topic]).'</div><div align="right"><small>Started by '.id2name($d[start_by]).' on '.$d[start_on_f].'</small></div>';
//	$delete2 = '';
}
function messageTopicSmall($topic_id){
	$q="select * from ps_forum_topics where topic_id = '$topic_id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return stripslashes($d[topic]);
}

switch($_REQUEST['action']) {

    case 'main_tree':
	$div = "tree";
	// code
	$html = $div.'|';
	$html .= topicList();
	echo $html;	 
      break;


    case 'main_read':
	$div = "read";
	// code
	$html = $div.'|';
	$html .= messageTopic($_REQUEST[id]);
	$html .= messageList($_REQUEST[id]);
	$open = 1;
	if ($open){
	$html .= '<br><div align="right"><div align="right" style="background-color:#99ffff; width:130px; border:solid 1px; padding:2px; cursor:pointer;" onClick="sndReq(\'main_post\',\''.$_REQUEST[id].'\');">Post Reply Message</div></span>';
	}
	echo $html;	 
      break;
	  
	  
    case 'main_post':
	$div = "post";
	// code
	$html = $div.'|';
	$html .= '<small>Reply to: '.messageTopicSmall($_REQUEST['id']).'</small><form action="javascript:get(document.getElementById(\'myform\'));" name="myform" id="myform">
<textarea id="message" cols="50" rows="6"></textarea>
<input type="hidden" id="topic" value="'.$_REQUEST['id'].'" />
<input type="button" name="button" value="Post" 
   onclick="javascript:get(this.parentNode);">
</form>
<span name="response" id="response"></span>
';
	echo $html;	 
      break;


    case 'alt_post':
	$div = "post";
	// code
	$html = $div.'|';
	$html .= '<small>New Topic:</small><form action="javascript:get(document.getElementById(\'myform\'));" name="myform" id="myform">
<input id="topic" size="50" maxlength="80" />
<input type="hidden" id="message" />
<input type="hidden" name="message_id" value="'.$_REQUEST['id'].'" />
<input type="button" name="button" value="Start" 
   onclick="javascript:get(this.parentNode);">
</form>
<span name="response" id="response"></span>
';
	echo $html;	 
      break;


}

?>