<? include 'common.php';

function notifyNewPost($topic_id){
	$user = $_COOKIE[psdata][user_id];
	$id2name = id2name($user);
	$q="SELECT DISTINCT post_by from ps_forum_messages where topic_id = '$topic_id' and post_by <> '$user'";
	$r=@mysql_query($q) or die(mysql_error());
	while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		$q1="SELECT DISTINCT start_by from ps_forum_topics where topic_id = '$topic_id'";
		$r1=@mysql_query($q1) or die(mysql_error());
		$d1=mysql_fetch_array($r1, MYSQL_ASSOC);
		if ($d1[start_by] != $d[post_by] && $d[post_by] != '$user'){
			//notify
			$message = "$id2name sent a response to a topic you posted on!\n";
			$subject = "$id2name has responded to your posted forum topic!";
			@mysql_query("insert into ps_mailbox (from_id, to_id, message, subject, send_date) values ('$user', '$d[post_by]', '$message', '$subject', NOW()) ");
			$from2 = id2name($user);
			$to2 = id2name($d1[post_by]);
			$q2="SELECT notifications, email FROM ps_users WHERE id = '$d1[post_by]'";
			$r2=@mysql_query($q2);
			$d2=mysql_fetch_array($r2, MYSQL_ASSOC);
			if ($d2[notifications] == "OPT-IN"){
					$to = "$d2[email]";
					$subject = "You Have Received a Private Message";
					$msg = "Dear $to2, <br>
					$from2 has sent a message to your private inbox.<br>
					To view your messages, please follow this link: http://mdwestserve.com/ps/mailbox.php";
					smtpMail($to,$subject,$msg);
				}
			}else{
			//do nothing
			}
		}
}

if ($_POST[message] && $_POST[topic]){ 
$user = $_COOKIE[psdata][user_id];
$id2name = id2name($user);
$topic = $_POST[topic];
$messages = addslashes($_POST[messages]);
$q="insert into ps_forum_messages (topic_id, post_by, post_on, message) values ( '$topic', '$user', NOW(), '$message' )";
@mysql_query($q);
$q1="Select start_by, topic from ps_forum_topics where topic_id = $topic";
$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
$d1=mysql_fetch_array($r1, MYSQL_ASSOC);
if ($user != $d1[start_by]){
$message2 = "$id2name sent this response to your topic: $d1[topic] \n";
$message2 .= $message;
$subject = "$id2name has responded to your posted forum topic!";
@mysql_query("insert into ps_mailbox (from_id, to_id, message, subject, send_date) values ('$user', '$d1[start_by]', '$message2', '$subject', NOW()) ");
$from4 = id2name($user);
$to4 = id2name($d1[start_by]);
$q3="SELECT notifications, email FROM ps_users WHERE id = '$d1[start_by]'";
$r3=@mysql_query($q3);
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
if ($d3[notifications] == "OPT-IN"){
		$to3 = "$d3[email]";
		$subject3 = "You Have Received a Private Message";
		$msg3 = "Dear $to4, <br>
		$from4 has sent a message to your private inbox.<br>
		To view your messages, please follow this link: http://mdwestserve.com/ps/mailbox.php";
		smtpMail($to3,$subject3,$msg3);
	}

}
notifyNewPost($topic);
?>
<span onMouseMove="sndReq('main_read','<?=$_POST[topic]?>');">
Reply posted successfully, it shall display within a moment.
</span>
<? }?>

<? if (!$_POST[message] && $_POST[topic]){ 
$topic = addslashes($_POST[topic]);
$user = $_COOKIE[psdata][user_id];
$q="insert into ps_forum_topics (topic, start_by, start_on) values ( '$topic', '$user', NOW() )";
@mysql_query($q);
?>
<span on onMouseOut="sndReq('main_tree','');">
<?=stripslashes($_POST[topic])?> successfully created.... it shall appear within a few seconds.
</span>
<? }  ?>