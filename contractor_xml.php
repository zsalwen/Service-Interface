<?php
session_start();
include 'functions.php';
echo db_connect('delta.mdwestserve.com','intranet','root','zerohour');
header("Content-type: text/xml");
$open = "&lt;font size=4&gt;";
$close = "&lt;/font&gt;";
$break = "&lt;br&gt;";
$stronga = "&lt;strong&gt;";
$strongb = "&lt;/strong&gt;";
$pubtoday = date('m/d/Y');
$today = date('Y-m-d');
function cleanXML($data){
$data = str_replace('\'','',$data);
$data = htmlentities($data);
return $data;
}

$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

$xml .= "<markers>";

	$q1 = "SELECT * FROM ps_users where lat > '0' and level <> 'DELETED' and contract = 'YES' and (level = 'Green Member' or level = 'Gold Member' or level = 'Platinum Member')";
	$r1 = @mysql_query ($q1) or die($q1);
	while($data = mysql_fetch_array($r1, MYSQL_ASSOC)){
// internal map only
//$link = "&lt;a href=index.php?page=details&amp;id=$data[schedule_id]&gt;Click For Details&lt;/a&gt;";
//$xml .= "<marker lat='$data[lat]' lng='$data[lng]' html='$stronga $data[sale_date] $strongb $break $data[address1] $break $data[city], $data[state] $break $link' />";

// public map


$xml .= "<marker lat='$data[lat]' lng='$data[lng]' html='$open $stronga ".$data[name]." $break ".htmlentities($data[address])." $break ".$data[city].", ".$data[state]." $break Level: ".cleanXML($data[level])." $break Company: ".cleanXML($data[company])." $break Drivers: ".$data[drivers]." $break Years exp: ".$data[experence]." $close' />";

	}

$xml .= "</markers>";

echo $xml;
?>