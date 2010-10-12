<?
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Mailbox');
if ($_POST[subject] && $_POST[message]){
$message = addslashes($_POST[message]);
$subject = addslashes($_POST[subject]);
$user_id = $_COOKIE[psdata][user_id];
$from2 = id2name($user_id);
$to2 = id2name($_POST[to]);
@mysql_query("insert into ps_mailbox (from_id, to_id, message, subject, send_date) values ('$user_id', '$_POST[to]', '$message', '$subject', NOW()) ");
$response = "Sending message.......<br>Subject: $_POST[subject]<br>$_POST[message]<br>.......your message has been sent.";
$q="SELECT notifications, email FROM ps_users WHERE id = '$_POST[to]'";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[notifications] == "OPT-IN"){
	$to = "$d[email]";
	$subject = "You Have Received a Private Message";
	$msg = "Dear $to2, <br>
	$from2 has sent a message to your private inbox.<br>
	To view your messages, please follow this link: http://mdwestserve.com/ps/mailbox.php";
	smtpMail($to,$subject,$msg);
	}
}?>
<script type="text/javascript" language="javascript" src="mailbox.js"></script>
<script type="text/javascript">
function pwin(tarea,width,height) {
myfloater=window.open('','Page_Title','scrollbars=yes,toolbar=no,resizable=yes,status=no,width='+width+',height='+height+',top='+((screen.availHeight/2)-(height/2))+',left='+((screen.availWidth/2)-(width/2))+',directores=no');
myfloater.document.open();
myfloater.document.write('<pre>'+tarea+'</pre>');
myfloater.document.close();
myfloater.focus();
myfloater.window.print();
myfloater.window.close();
}

function init() {
sndReq('msg_new','');
}
window.onload = init;
</script>

<body>
<? include 'menu.php';
function mouseover2($a,$b){ return "onmouseover=\"style.backgroundColor='#$a';\" onmouseout=\"style.backgroundColor='#$b';\"  bgcolor=\"#$b\" align='center'";}?>
<style> 
textarea {background-color:#FFFFCC; border-color:#000000; color:#000000; font-weight:bold}
input {background-color:#FFFFCC; color:#000000; font-weight:bold}
select {background-color:#FFFFCC; color:#000000; font-weight:bold}
strong {cursor:pointer;}
</style>
<center>
<? if($_COOKIE[psdata][level] == "Operations"){ ?>
		<a onClick="sndReq('form_send_user','')">Send User Message</a> | 
<? } ?>
		<a onClick="sndReq('form_send_staff','')">Send Message</a> |
    	<a onClick="sndReq('msg_new','')">New Messages</a> |
    	<a onClick="sndReq('msg_saved','')">Saved Messages</a> |
    	<a onClick="sndReq('msg_sent','')">Sent Messages</a></center>

<table align="center" border="0"><tr><td><div align="justify" id="workspace" style="width:780px; height:420px; overflow:auto; background-color:#B4CDE2; color:#000000; font:Lucida Console, Monaco5, monospace; font-size:16px; padding:10px;"><?=$response?></div></td></tr></table>
<? include 'footer.php';?>