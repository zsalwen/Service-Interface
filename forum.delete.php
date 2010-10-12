<? include 'common.php';
function topic2id($topic){
	$q="Select topic_id from ps_forum_topics where topic = $topic";
	$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[topic_id];
}

if ($_POST[message] && $_POST[topic]){ 
$user = $_COOKIE[psdata][user_id];
$topic = $_POST[topic];
$messages = addslashes($_POST[messages]);
$topic_id = topic2id($topic);
//delete message
$q5="DELETE FROM ps_forum_messages where message = '$message' and topic_id = '$topic_id' and post_by = '$user'";
$r5=@mysql_query($q5) or die("Query: $q5<br>".mysql_error());
?>
<span onMouseMove="sndReq('main_read','<?=$_POST[topic]?>');">
Topic Deleted.
</span>
<? }?>

<? if (!$_POST[message] && $_POST[topic]){ 
$user = $_COOKIE[psdata][user_id];
$topic = $_POST[topic];
$topic_id = topic2id($topic);
//check to see if topic has any postings
	$q1="Select * from ps_forum_messages where topic_id = $topic";
	$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
	$d1=mysql_fetch_array($r, MYSQL_ASSOC);
	//if no postings, delete topic
	if (!$d1) {
	$topic = addslashes($_POST[topic]);
	$user = $_COOKIE[psdata][user_id];
	$topic_id = topic2id($_POST[topic]);
	$q6="DELETE FROM ps_forum_topics where topic_id = '$topic_id'";
	$r6=@mysql_query($q6) or die("Query: $q6<br>".mysql_error());
	?>
	<span on onMouseOut="sndReq('main_tree','');">
	Topic deleted.
	</span>
	<? }else{ ?>
	<span on onMouseOut="sndReq('main_tree','');">
	Cannot Delete: Topic has postings!
	</span>
<? 	}
} ?>
