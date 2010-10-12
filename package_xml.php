<?php
session_start();
include 'functions.php';
echo db_connect('delta.mdwestserve.com','intranet','root','zerohour');
// ok silently we will geo-code all files that have not been done at this point

function getmassLnL($address){
$address = str_replace(' ','+',$address);
$key = "ABQIAAAA2ArF_EF7s8gt5SlN-66dGRSDwiOJjXtIz2bb2tX6zkVuu1lXuxQ_mZTPk-otfXUittH4129cC1VyvQ";
   $curl = curl_init();
   curl_setopt ($curl, CURLOPT_URL, "http://maps.google.com/maps/geo?q=$address&output=csv&key=$key");
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   $result = curl_exec ($curl);
   curl_close ($curl);
   $data = explode(',',$result);
   return $data;
}

	$q = "SELECT * FROM ps_packets where lat1 = ''";
	$r = @mysql_query ($q) or die(mysql_error());
	while ($d = mysql_fetch_array($r, MYSQL_ASSOC)){
		$pkg=1;
		while ($pkg < 5){
			$makeLnL = $d["address$pkg"].", ".$d["city$pkg"].", ".$d["state$pkg"]." ".$d["zip$pkg"];
			$lnl = getmassLnL($makeLnL);
			$q2 = "UPDATE ps_packets set lat$pkg='$lnl[2]', lng$pkg='$lnl[3]' where packet_id ='$d[packet_id]'";
			$r2 = @mysql_query ($q2) or die(mysql_error());
			$pkg++;
		}
	}




header("Content-type: text/xml");
$open = "&lt;font size=4&gt;";
$close = "&lt;/font&gt;";
$break = "&lt;br&gt;";
$stronga = "&lt;strong&gt;";
$strongb = "&lt;/strong&gt;";
$pubtoday = date('m/d/Y');
$package = $_GET[package];
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";

$xml .= "<markers>";


function markerSet($package,$set){
	$q1 = "SELECT * FROM ps_packets where lat$set > '0' AND package_id = '$package' AND process_status <> 'CANCELLED'";
	$r1 = @mysql_query ($q1) or die($q1);
	while($data = mysql_fetch_array($r1, MYSQL_ASSOC)){
// internal map only
//$link = "&lt;a href=index.php?page=details&amp;id=$data[schedule_id]&gt;Click For Details&lt;/a&gt;";
//$xml .= "<marker lat='$data[lat]' lng='$data[lng]' html='$stronga $data[sale_date] $strongb $break $data[address1] $break $data[city], $data[state] $break $link' />";

// public map
$xml .= '<marker lat=\''.$data["lat$set"].'\' lng=\''.$data["lng$set"].'\' html=\''.$open.' '.$stronga.' '.$strongb.' '.htmlentities($data["address$set"]).' '.$break.' '.$data["city$set"].', '.$data["state$set"].' '.$break.' '.$data["name$set"].' '.$close.'\' />';

	}
return $xml;
}// end function
$i=0;
while ($i < 4){
$i++;
$xml .= markerSet($_GET[package],$i);
}
$xml .= "</markers>";

echo $xml;
?>


