<?php
function owner2attorney($uid){
	if ($uid = "1003"){ return 1; }
}
if ($handle = opendir('/service')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            // start move
			//echo "Found: <strong>$file</strong><br>";
			$time = fileatime('/service/'.$file);
			$owner = fileowner('/service/'.$file);
			$new_path = '/opt/lampp/htdocs/portal/PS_PACKETS/'.$time."-".$file;
			if (!file_exists($new_path)){
				mkdir ($new_path,0777);
			}
			$otd = "http://mdwestserve.com/portal/PS_PACKETS/$time-$file/$file";
			//echo 'Link to:'.$otd.'<br>';
			$q = "INSERT INTO ps_packets (otd, status, attorneys_id, date_received, alert_date, attorney_notes) values ('$otd', 'NEW', '".owner2attorney($owner)."', NOW(), NOW(), '$file sent via FTP')";
			@mysql_query($q);
			//$userinfo = posix_getpwuid($owner);
			//print_r($userinfo);
			rename("/service/$file", $new_path."/$file");
			//echo "<br><strong>FTP Service Transfer Complete</strong><hr>";
			mail('sysop@hwestauctions.com','FTP TRANSFER','NEW FILE TRANSFERED FROM FTP SERVER');
        }
    }
    closedir($handle);
}
?>
