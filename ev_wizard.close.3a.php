<?
//first we need to generate all mailing entries if file is M&P.

if ($ddr[service_status] == "MAILING AND POSTING"){
	if ($_GET[mailDate]){
		$mailDate=$_GET[mailDate];
		$actionDate=$_GET[mailDate]." 00:00:00";
	}elseif($_POST[mailDate]){
		$mailDate=$_POST[mailDate];
		$actionDate=$_GET[mailDate]." 00:00:00";
	}else{
		$mailDate=$date=date('Y-m-d');
		$actionDate=date('Y-m-d')." 00:00:00";
	}
	ev_timeline($packet,$_COOKIE[psdata][name]." Confirmed Mail Sent");

	psActivity("mailSent");
	if ($_POST[opServer] != ''){
		$entryID=$_POST[opServer];
	}else{
		$entryID=$_COOKIE[psdata][user_id];
	}
	
	@mysql_query("update evictionPackets set closeOut = '$mailDate', gcStatus='MAILED', mail_status = 'Mailed First Class and Certified Return Receipt', process_status='READY TO MAIL', affidavit_status='SERVICE CONFIRMED', photoStatus='PHOTO CONFIRMED' where eviction_id = '".$packet."' ");
	mkAlert('SERVICE CONFIRMED',$entryID,'ALL',$packet);
	$_SESSION[querycount]++;
	
	$q="select * from evictionPackets where eviction_id = '".$packet."'";
	$r=@mysql_query($q) or die ("Query $q<br>".mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$co=explode('-',$mailDate);
	$month=monthConvert($co[1]);
	$closeOut=$month.' '.$co[2].', '.$co[0];
	$date=$closeOut;
	if (!$date){
		$date=$mailDate;
	}
	if ($_POST[opServer] != ''){
		$name=id2name($_POST[opServer]);
	}else{
		$name=$_COOKIE[psdata][name];
	}
	
	if ($d[name1]){
		if ($d[address1]){
			$action="<li>I, $name, Mailed Papers to All Occupants at $d[address1], $d[city1], $d[state1] $d[zip1] \'Residential Property Subject to Mortgage or Deed of Trust\' by certified mail, return receipt requested, and by first class mail on $date.</li>";	
			$action=strtoupper($action);
			@mysql_query("INSERT into evictionHistory (eviction_id, defendant_id, action_type, action_str, serverID, recordDate, wizard, actionDate, resident)values('".$packet."', '1', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS', '$actionDate', 'ALL OCCUPANTS' )");$_SESSION[querycount]++; 
		}
	}	
	$i=1;
	while ($i < 6){$i++;
		if ($d["name$i"] && (strtoupper($d["onAffidavit$i"]) != 'CHECKED')){
			$action="<li>I, $name, Mailed Papers to ".$d["name$i"]." at $d[address1], $d[city1], $d[state1] $d[zip1] \'Residential Property Subject to Mortgage or Deed of Trust\' by certified mail, return receipt requested, and by first class mail on $date.</li>";	
			$action=strtoupper($action);
			@mysql_query("INSERT into evictionHistory (eviction_id, defendant_id, action_type, action_str, serverID, recordDate, wizard, actionDate, resident )values('".$packet."', '$i', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS', '$actionDate', '".strtoupper($d["name$i"])."' )");$_SESSION[querycount]++; 
		}
	}
	$href="http://service.mdwestserve.com/evictionAff.php?id=$packet&mail=1&autoPrint=1";
	echo "<script>window.open('".$href."', 'Mailing Affidavits')</script>";
}

// make links to affidavits
$file1 = "http://mdwestserve.com/ps/liveAffidavit.php?eviction=$packet&def=1";
$file2 = "http://mdwestserve.com/ps/liveAffidavit.php?eviction=$packet&def=2"; 
$file3 = "http://mdwestserve.com/ps/liveAffidavit.php?eviction=$packet&def=3";
$file4 = "http://mdwestserve.com/ps/liveAffidavit.php?eviction=$packet&def=4";
// generate all invoices
?>
<!-------------
<table>
<tr><td><iframe frameborder="0" src="http://staff.mdwestserve.com/ev/ev_write_invoice.php?id=<?=$packet?>" width="600" height="30"></iframe></td></tr>
</table>
-------------------->
<?

// email client invoice
$to = "MDWestServe Archive <mdwestserve@gmail.com>";
$subject = "Service Completed for Eviction $packet ($ddr[client_file])";
$headers  = "MIME-Version: 1.0 \n";
$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
$headers .= "From: Service Complete <service.complete@mdwestserve.com> \n";

$attR = @mysql_query("select ps_to_alt from attorneys where attorneys_id = '$ddr[attorneys_id]'");
$attD = mysql_fetch_array($attR, MYSQL_BOTH);
$c=0;
$cc = explode(',',$attD[ps_to_alt]);
$ccC = count($cc);
while ($c < $ccC){
$headers .= "Cc: ".$cc[$c]."\n";
$c++;
}
$fname = id2attorney($ddr["attorneys_id"]).'/'.$filename;
if ($ddr[service_status] == "MAILING AND POSTING"){
	$qp="SELECT * from evictionHistory WHERE eviction_id='$packet' AND (wizard='POSTING DETAILS')";
	$rp=@mysql_query($qp) or die ("Query: $qp<br>".mysql_error());
	while ($dp=mysql_fetch_array($rp,MYSQL_ASSOC)){
		$posting=explode('</LI>',$dp[action_str]);
		$posting=explode('<BR>',$posting[1]);
		$posting=trim($posting[0]);
		if ($pDate < $posting){
			$pDate=$posting;
		}
	}
	$addendum="<br>Posting for this file was performed on $pDate.";
}else{
	$addendum='';
}
if ($ddr[closeOut] != '0000-00-00'){
	$co=explode('-',$ddr[closeOut]);
	$month=monthConvert($co[1]);
	$closeOut=$month.' '.$co[2].', '.$co[0];
	$body ="<strong>Thank you for selecting MDWestServe as Your Process Service Provider.</strong><br>
Service for eviction $packet (<strong>$ddr[client_file]</strong>) was completed on $closeOut, via $ddr[service_status].";
}else{
	$q10a="SELECT action_str, action_type from evictionHistory WHERE eviction_id='$packet' AND (wizard='BORROWER' OR wizard='NOT BORROWER')";
	$r10a=@mysql_query($q10a) or die(mysql_error());
	//also Invalid Address entries
	$q10b="SELECT action_str, action_type from evictionHistory WHERE eviction_id='$packet' AND (wizard='INVALID')";
	$r10b=@mysql_query($q10b) or die(mysql_error());
	$serviceDate='';
	$serviceDates='';
	while ($d10a=mysql_fetch_array($r10a, MYSQL_ASSOC)){
		$serviceDate=explode('DATE OF SERVICE',$d10a[action_str]);
		$serviceDates .= $d10a[action_type].' - '.$serviceDate[1];
	}
	while ($d10b=mysql_fetch_array($r10b, MYSQL_ASSOC)){
		$dateStr=explode('WITH NO RESULTS, ON ',$d10b[action_str]);
		$serviceDate=str_replace('.</LI>','',$dateStr[1]);
		if ($serviceDates == ''){
			$serviceDates = $d10b[action_type].' - '.$serviceDate;
		}else{
			$serviceDates .= '<br>'.$d10b[action_type].' - '.$serviceDate;
		}
	}
	if ($serviceDates != ''){
		$body ="<strong>Thank you for selecting MDWestServe as Your Process Service Provider.</strong><br>
Service for eviction $packet (<strong>$ddr[client_file]</strong>) is complete, via $ddr[service_status].  
As this document predates our latest system of affidavit entry, there is no standardized method of telling on which date service was completed.  
To better facilitate the coordinating of auctions and post-service processing, we have included a list of all service actions and the dates on which they occurred:<br><br>$serviceDates";
	}else{
		$body ="<strong>Thank you for selecting MDWestServe as Your Process Service Provider.</strong><br>
Service for eviction $packet (<strong>$ddr[client_file]</strong>) is complete, via $ddr[service_status].";
	}
}
$body .= "$addendum<br><br><br><br>".$_COOKIE[psdata][name]."<br>MDWestServe<br>Harvey West Auctioneers<br>".time()."<br>".md5(time());
$headers .= "Cc: MDWestServe Archive <mdwestserve@gmail.com> \n";
mail($to,$subject,$body,$headers);
psActivity("serviceConfirmed");
ev_timeline($packet,$_COOKIE[psdata][name]." Confirmed Service for ".$closeOut);

if ($ddr[service_status] == "MAILING AND POSTING"){
	
}else{
		if ($_POST[opServer] != ''){
		$entryID=$_POST[opServer];
	}else{
		$entryID=$_COOKIE[psdata][user_id];
	}
	
	mkAlert('SERVICE CONFIRMED',$entryID,'ALL',$packet);
	$q10="UPDATE evictionPackets SET process_status='SERVICE COMPLETED', affidavit_status='SERVICE CONFIRMED', photoStatus='PHOTO CONFIRMED' WHERE eviction_id = '$packet'";
	$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
}
?>
Affidavit confirmed.<br />
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="a" /> NEXT FILE</div>
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">