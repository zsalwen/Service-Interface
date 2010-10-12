<?
/*
$agent = $_SERVER['HTTP_USER_AGENT'];
$q="SELECT * FROM browsers WHERE agent = '$agent'";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
if (!$d[agent]){
	$q1="INSERT into browsers (agent, last_access, hits) values ('$_SERVER[HTTP_USER_AGENT]', NOW(), '1')";
	$r1=@mysql_query($q1);
	//generate email
	$from = "SysOp <sysop@hwestauctions.com>";
	$to  = "SysOp <sysop@hwestauctions.com>";
	$subject = "$agent : FIRST APPEARANCE";
	$headers .= "From: $from \n";
	$msg = "New Browser submitted. \n
	Description: $agent";
	mail($from,$subject,$msg,$headers);	
}
$hits = ($d[hits] + 1);
$q2="UPDATE browsers SET last_access=NOW(), hits='$hits' where agent = '$agent'";
$r2=@mysql_query($q2) or die(mysql_error());

if (!function_exists('getPage')) {

function getPage($url, $referer, $timeout, $header){
    if(!isset($timeout))
        $timeout=30;
    $curl = curl_init();
    if(strstr($referer,"://")){
        curl_setopt ($curl, CURLOPT_REFERER, $referer);
    }
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
    curl_setopt ($curl, CURLOPT_HEADER, (int)$header);
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}

}

if (getenv(HTTP_X_FORWARDED_FOR)) {							
    $ip = getenv(HTTP_X_FORWARDED_FOR); 
} else { 
    $ip = getenv(REMOTE_ADDR); 
}	
	$raw = getPage('http://dnstools.com/?arin=on&portNum=80&target='.$ip.'&submit=Get+Info','anarchy.org','300','');
	$cut = explode('<b>IP Whois Results:</b>',$raw);
	$cut = explode('<script type="text/javascript">',$cut[1]);
	$clean = addslashes($cut[0]);

$q="SELECT * FROM knownip WHERE ip = '$ip'";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
if (!$d[ip]){
	$q1="INSERT into knownip (ip, lastSeen, hits, whois) values ('$ip', NOW(), '1', '$clean')";
	$r1=@mysql_query($q1);
	//generate email
	$from = "SysOp <sysop@hwestauctions.com>";
	$to  = "SysOp <sysop@hwestauctions.com>";
	$subject = "$ip : FIRST APPEARANCE";
	$headers  = "MIME-Version: 1.0 \n";
	$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
	$headers .= "From: $from \n";
	$msg = "New IP submitted.<hr>
	SeCuRiTy HaS RiPPeD WHoIS INFo YeT aGaiN:<hr>$clean<hr>";
	mail($from,$subject,$msg,$headers);	
}else{
	$hits = ($d[hits] + 1);
	$q2="UPDATE knownip SET lastSeen=NOW(), hits='$hits', whois='$clean' where ip = '$ip'";
	$r2=@mysql_query($q2) or die(mysql_error());
}
*/
?>