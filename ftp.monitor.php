<style>
body, input, a { font-size:12px; background-color:#0000FF; color:#FFFFFF; border:none;}
</style>
<meta http-equiv="refresh" content="30" />
<?php
$header = date("F d Y H:i:s.")." : Scan Started<hr>";
$ftp_server = "wister.worldispnetwork.com";
$ftp_user = "bursonft";
$ftp_pass = "secure";
$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
$header .= date("F d Y H:i:s.")." : Connected to $ftp_server<hr>";
if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
    $header .= date("F d Y H:i:s.")." : Logged in as $ftp_user@$ftp_server<hr>";
} else {
    $header .= date("F d Y H:i:s.")." : Failed to connect as $ftp_user<hr>";
}
if ($type = ftp_systype($conn_id)) {
    $header .= date("F d Y H:i:s.")." : Powered by $type<hr>";
} else {
    $header .= date("F d Y H:i:s.")." : Couldn't get the systype<hr>";
}
$header .= date("F d Y H:i:s.")." : Current directory: " . ftp_pwd($conn_id) . "<hr>";
$header .= date("F d Y H:i:s.")." : Searching....<hr>";
$contents = ftp_nlist($conn_id, ".");
$new = count($contents);
$header .= date("F d Y H:i:s.")." : Found ".($new-1)." new file(s)<hr>";
foreach($contents as $key => $file){
	if ($file != "backup"){
		$number = $key+1;
		$header .= date("F d Y H:i:s.")." : Starting batch file #$number<hr>";
		$header .= date("F d Y H:i:s.")." : Processing $file<hr>";
		$buff = ftp_mdtm($conn_id, $file);
		$time = date("F d Y H:i:s.", $buff);
		$header .= date("F d Y H:i:s.")." : Sent $time<hr>Rescan in 30 seconds.";
		/*
		$new_path = '/opt/lampp/htdocs/portal/PS_PACKETS/'.$time."-".$file;
		if (!file_exists($new_path)){
			mkdir ($new_path,0777);
		}
		$otd = "http://mdwestserve.com/portal/PS_PACKETS/$time-$file/$file";
		if (ftp_get($conn_id, $new_path.'/'.$file, $file, FTP_BINARY)) {
			$print .= date("F d Y H:i:s.")." : Successfully downloaded $file<hr>";
		} else {
			$print .= date("F d Y H:i:s.")." : There was a problem downloading<hr>";
		}
		if (ftp_chdir($conn_id, "backup")) {
			$print .= date("F d Y H:i:s.")." : Starting backup<hr>";
		} else { 
			$print .= date("F d Y H:i:s.")." : Couldn't change directory to backup<hr>";
		}
		if (ftp_rename($conn_id, '/'.$file, $file)) {
		 $print .= date("F d Y H:i:s.")." : Successfully backed up $file<hr>";
		 } else {
		 $print .= date("F d Y H:i:s.")." : There was a problem while backing up $file<hr>";
		}
		if (ftp_chdir($conn_id, "/")) {
			$print .= date("F d Y H:i:s.")." : Ending backup<hr>";
		} else { 
			$print .= date("F d Y H:i:s.")." : Couldn't change directory to root<hr>";
		}
		*/
		
	}
}
ftp_close($conn_id);  
echo $header;
?>
