<?php
require("../common/pop3.php");
// let's keep a time monitor
$starttime = microtime();
$startarray = explode(" ", $starttime);
$starttime = $startarray[1] + $startarray[0];
// set up our connection
$pop3=new pop3_class;
$pop3->hostname="mail.hwestauctions.com";
$pop3->port=110;                                                      
$pop3->tls=0;
$user="backoffice@hwestauctions.com";
$password="zerohour";
$pop3->realm="";
$pop3->workstation="";
$apop=0;
$pop3->authentication_mechanism="USER";
$pop3->debug=0;
$pop3->html_debug=0;
$pop3->join_continuation_header_lines=1;
// connecting to the mail server
if(($error=$pop3->Open())=="")
{
echo "<PRE>Connected to the POP3 server &quot;".$pop3->hostname."&quot;.</PRE>\n";
if(($error=$pop3->Login($user,$password,$apop))=="")
{
echo "<PRE>User &quot;$user&quot; logged in.</PRE>\n";
if(($error=$pop3->Statistics($messages,$size))=="")
{
echo "<PRE>There are $messages messages in the mail box with a total of $size bytes.</PRE>\n";
function clean($str){							
	$str = htmlspecialchars($str);
	$str = str_replace('&quot;','',$str);
	$str = str_replace('&lt;','',$str);
	$str = str_replace('&gt;','',$str);
	$srt = trim($str);
	return $str;
}		
// let's set some variables							
$i=0;	
$dup=0;
$err=0;
// ok let's get the messages
while ($i < $messages){							
// let's clear some variables in the loop							
$subject="";
$date="";
$uid="";
$from="";
$i++;
//echo "<hr>";
$command = $pop3->RetrieveMessage($i,$headers,$body,-1);
if(($error=$command)=="")
	{
		$line = 0;
		$count = count($headers);
		while ($line < $count){
			$line++;
			// unique ID
			$search   = 'X-UIDL';
			$pos = strpos($headers[$line], $search);
			if ($pos === false) {
			} else {
				$uid = clean($headers[$line]);
				$uid = explode(':',$uid);
				$uid = $uid[1];
			}
			// Sender
			$search   = 'From';
			$pos = strpos($headers[$line], $search);
			if ($pos === false) {
			} else {
				$from = clean($headers[$line]);
				$from = explode('m:',$from);
				$from = $from[1];
			}
			// Sender
			$search   = 'FROM';
			$pos = strpos($headers[$line], $search);
			if ($pos === false) {
			} else {
				$from = clean($headers[$line]);
				$from = explode('M:',$from);
				$from = $from[1];
			}
			// Message Subject
			$search   = 'Subject';
			$pos = strpos($headers[$line], $search);
			if ($pos === false) {
			} else {
				$subject = clean($headers[$line]);
				$subject = explode('t:',$subject);
				$subject = $subject[1];
				$subject =  substr($subject, 1, 200);

			}
			// Message Subject
			$search   = 'SUBJECT';
			$pos = strpos($headers[$line], $search);
			if ($pos === false) {
			} else {
				$subject = clean($headers[$line]);
				$subject = explode('T:',$subject);
				$subject = $subject[1];
				$subject =  substr($subject, 1, 200);
			}
			// Date Sent
			$search   = 'Date';
			$pos = strpos($headers[$line], $search);
			if ($pos === false) {
			} else {
				$date = clean($headers[$line]);
				$date = explode('e:',$date);
				$date = $date[1];
			}
			// Date Sent
			$search   = 'DATE';
			$pos = strpos($headers[$line], $search);
			if ($pos === false) {
			} else {
				$date = clean($headers[$line]);
				$date = explode('E:',$date);
				$date = $date[1];
			}
		}
		$mail .= "From: $from\n";
		$mail .= "Date: $date\n";
		$mail .= "Subject: $subject\n\n";
		
		$msg = str_replace('<div>','',$body[1]);
		$msg = str_replace('</div>','\n',$msg);
		$msg = str_replace('<li>','',$msg);
		$mail .= str_replace('</li>','\n',$msg);
		$mail .= "\n END OF MESSAGE \n\n";
		

			
	}
$command = $pop3->DeleteMessage($i);
	}
//echo "<hr>";
}

// disconnect
if($error=="" && ($error=$pop3->Close())==""){
echo "<PRE>Disconnected from the POP3 server &quot;".$pop3->hostname."&quot;.</PRE>\n";
}
}
}

	//echo $mail;
	$fh = fopen("mailServer.tmp", 'w') or die("can't open file");
	fwrite($fh, $mail);
	fclose($fh);
	system("lp -d LaserJet mailServer.tmp");
?>