<style>
body, input, a { font-size:12px; background-color:#0000FF; color:#FFFFFF; border:none;}
</style>
<?php
$header = date("F d Y H:i:s.")." : Starting to scrub ftp server for new files\n";
$ftp_server = "wister.worldispnetwork.com";
$ftp_user = "bursonft";
$ftp_pass = "secure";
$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
$header .= date("F d Y H:i:s.")." : Connected to $ftp_server\n";
if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
    $header .= date("F d Y H:i:s.")." : Logged in as $ftp_user@$ftp_server\n";
} else {
    $header .= date("F d Y H:i:s.")." : Failed to connect as $ftp_user\n";
}
if ($type = ftp_systype($conn_id)) {
    $header .= date("F d Y H:i:s.")." : Powered by $type\n";
} else {
    $header .= date("F d Y H:i:s.")." : Couldn't get the systype\n";
}
$header .= date("F d Y H:i:s.")." : Current directory: " . ftp_pwd($conn_id) . "\n";
$header .= date("F d Y H:i:s.")." : Searching....\n";
$contents = ftp_nlist($conn_id, ".");
$new = count($contents);
$header .= date("F d Y H:i:s.")." : Found ".($new-1)." new file(s)\n";
foreach($contents as $key => $file){
	$ext = explode('.',$file);
	$ext = $ext[1];
	if ($ext == "pdf" || $ext == "PDF"|| $ext == "Pdf"){	
	$fail=0;
	if ($file != "backup" && $file != "Filed Copies Only"){
		$print = lpwords('OTD','0',' ');		
		$number = $key+1;
		$print .= date("F d Y H:i:s.")." : Starting batch file #$number\n";
		$print .= date("F d Y H:i:s.")." : Processing $file\n";
		$buff = ftp_mdtm($conn_id, $file);
		$time = date("F d Y H:i:s.", $buff);
		$print .= date("F d Y H:i:s.")." : Sent $time\n";
		$new_path = '/opt/lampp/htdocs/portal/PS_PACKETS/'.$time."-".$file;
		if (!file_exists($new_path)){
			mkdir ($new_path,0777);
		}
		$otd = "http://mdwestserve.com/portal/PS_PACKETS/$time-$file/$file";
		if (ftp_get($conn_id, $new_path.'/'.$file, $file, FTP_BINARY)) {
			$print .= date("F d Y H:i:s.")." : Successfully downloaded $file\n";
		} else {
			$print .= date("F d Y H:i:s.")." : There was a problem downloading\n";
			$fail=1;
		}
		if (ftp_delete($conn_id, $file)) {
			$print .= date("F d Y H:i:s.")." : Starting cleanup\n";
		} else { 
			$print .= date("F d Y H:i:s.")." : Couldn't process cleanup\n";
			$fail=1;
		}
			if ($fail != 1){
			$q = "INSERT INTO ps_packets (otd, status, attorneys_id, date_received, alert_date, attorney_notes) values ('$otd', 'NEW', '1', NOW(), NOW(), '$file sent via FTP')";
			@mysql_query($q);
			$print .= date("F d Y H:i:s.")." : File added to database\n";
			$print .= date("F d Y H:i:s.")." : New Packet ID ".mysql_insert_id()." \n";
			mail('sysop@hwestauctions.com','FTP TRANSFER','FILE '.$file.' TRANSFERED FROM BURSON');
			mail('lkennebeck@logs.com','FTP TRANSFER','FILE '.$file.' TRANSFERED TO MDWESTSERVE.COM');
			$print .= date("F d Y H:i:s.")." : Client notified via E-Mail\n";
			$print .= date("F d Y H:i:s.")." : System Operators notified via E-Mail\n";
			$print .= date("F d Y H:i:s.")." : System Operators notified via System Alert\n";
			$print .= date("F d Y H:i:s.")." : Hard copy sent to to printer\n";
			$fh = fopen("offsite.log", 'w') or die("can't open file");
			$print .= lpwords('OTD','0',' ');		
			fwrite($fh, $header.$print);
			fclose($fh);
			system("lp -d LaserJet offsite.log");
			}else{
			mail('sysop@hwestauctions.com','FTP ERROR','FILE '.$file.' FAILED FROM BURSON');
			mail('lkennebeck@logs.com','FTP ERROR','FILE '.$file.' FAILED TRANSFER TO MDWESTSERVE.COM');
			$print .= date("F d Y H:i:s.")." : FTP ERROR, PACKET DISCARDED\n";
			$print .= lpwords('ERROR','0',' ');	
			$fh = fopen("offsite.log", 'w') or die("can't open file");
			fwrite($fh, $header.$print);
			fclose($fh);
			system("lp -d LaserJet offsite.log");
			}
			}else{ //transfer order forms


	$fail=0;
	if ($file != "backup" && $file != "Filed Copies Only"){
		$print = lpwords('ORDER','0',' ');		
		$number = $key+1;
		$print = date("F d Y H:i:s.")." : Starting Order batch file #$number\n";
		$print = date("F d Y H:i:s.")." : Processing Order for $file\n";
		$buff = ftp_mdtm($conn_id, $file);
		$time = date("F d Y H:i:s.", $buff);
		$print .= date("F d Y H:i:s.")." : Sent $time\n";
		$new_path = '/opt/lampp/htdocs/portal/PS_ORDERS/'.$time."-".$file;
		if (!file_exists($new_path)){
			mkdir ($new_path,0777);
		}
		if (ftp_get($conn_id, $new_path.'/'.$file, $file, FTP_BINARY)) {
			$print .= date("F d Y H:i:s.")." : Successfully downloaded orders for $file\n";
		} else {
			$print .= date("F d Y H:i:s.")." : There was a problem downloading\n";
			$fail=1;
		}
		if (ftp_delete($conn_id, $file)) {
			$print .= date("F d Y H:i:s.")." : Starting order cleanup\n";
		} else { 
			$print .= date("F d Y H:i:s.")." : Couldn't process cleanup\n";
			$fail=1;
		}
			$print .= lpwords('ORDER','0',' ');		
			$fh = fopen("offsite.log", 'w') or die("can't open file");
			fwrite($fh, $header.$print);
			fclose($fh);
			system("lp -d LaserJet offsite.log");

			
			
	}		
			
			}
	}
}
ftp_close($conn_id);  

?>
