<?
//first we need to generate all mailing entries if file is M&P.

if ($ddr[service_status] == "MAILING AND POSTING" && ($_GET[mailDate] || $_POST[mailDate])){
	if ($_GET[mailDate]){
		$mailDate=$_GET[mailDate];
	}else{
		$mailDate=$_POST[mailDate];
	}
	timeline($packet,$_COOKIE[psdata][name]." Confirmed Mail Sent");

	psActivity("mailSent");

	
	@mysql_query("update ps_packets set closeOut = '$mailDate', gcStatus='MAILED', mail_status = 'Mailed First Class and Certified Return Receipt', process_status='READY TO MAIL', affidavit_status='SERVICE CONFIRMED', affidavit_status2='AWAITING OUT-OF-STATE', photoStatus='PHOTO CONFIRMED' where packet_id = '".$packet."' ");
	$_SESSION[querycount]++;
	
	$q="select * from ps_packets where packet_id = '".$packet."'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($_GET['mailDate']){
		$explode=explode('-',$_GET['mailDate']);
		$month=monthConvert($explode[1]);
		$date=$month.' '.$explode[2].', '.$explode[0];
	}else{
		$date=date('F d, Y');
	}
	$name=id2name($_COOKIE['psdata']['user_id']);
	$iC=0;
	while ($iC < 6){$iC++;
		if ($d["name$iC"]){
			if ($d["address$iC"]){
				$action="<li>I, $name, Mailed Papers to ".$d["name$iC"]." at ".$d["address$iC"].", ".$d["city$iC"].", ".$d["state$iC"]." ".$d["zip$iC"]." \'$d[addressType]\' by certified mail, return receipt requested, and by first class mail on $date.</li>";	
				$action=strtoupper($action);
				@mysql_query("INSERT into ps_history (packet_id, defendant_id, action_type, action_str, serverID, recordDate, wizard )values('".$packet."', '".$iC."', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS' )");$_SESSION[querycount]++; 
			}
			foreach(range('a','e') as $letter){
				if ($d["address$iC$letter"]){
					$action="<li>I, $name, Mailed Papers to ".$d["name$iC$letter"]." at ".$d["address$iC$letter"].", ".$d["city$iC$letter"].", ".$d["state$iC$letter"]." ".$d["zip$iC$letter"]." \'$d[addressTypea]\' by certified mail, return receipt requested, and by first class mail on $date.</li>";	
					$action=strtoupper($action);
					@mysql_query("INSERT into ps_history (packet_id, defendant_id, action_type, action_str, serverID, recordDate, wizard )values('".$packet."', '".$iC."', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS' )");$_SESSION[querycount]++; 
				}
			}
					if ($d[pobox]){
						if((strpos(strtoupper($d['pobox']),'P.O. BOX') != 'false') || (strpos(strtoupper($d['pobox']),'PO BOX')) != 'false'){			
						$action="<li>I, $name, Mailed Papers to ".$d["name$iC"]." at $d[pobox], $d[pocity], $d[postate] $d[pozip] \'P.O. Box Address\' by first class mail on $date.</li>";		
				
						}else{
				$action="<li>I, $name, Mailed Papers to ".$d["name$iC"]." at $d[pobox], $d[pocity], $d[postate] $d[pozip] \'Mailing Only Address\' by certified mail, return receipt requested, and by first class mail on $date.</li>";

						}
				$action=strtoupper($action);
				@mysql_query("INSERT into ps_history (packet_id, defendant_id, action_type, action_str, serverID, recordDate, wizard )values('".$packet."', '".$iC."', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS' )");$_SESSION[querycount]++; 
			}
			if ($d[pobox2]){
						if((strpos(strtoupper($d['pobox2']),'P.O. BOX') != 'false') || (strpos(strtoupper($d['pobox2']),'PO BOX')) != 'false'){			$action="<li>I, $name, Mailed Papers to ".$d["name$iC"]." at $d[pobox2], $d[pocity2], $d[postate2] $d[pozip2] \'P.O. Box Address\' by first class mail on $date.</li>";				
		
						}else{
				$action="<li>I, $name, Mailed Papers to ".$d["name$iC"]." at $d[pobox2], $d[pocity2], $d[postate2] $d[pozip2] \'Mailing Only Address\' by certified mail, return receipt requested, and by first class mail on $date.</li>";
						}
				$action=strtoupper($action);
				@mysql_query("INSERT into ps_history (packet_id, defendant_id, action_type, action_str, serverID, recordDate, wizard )values('".$packet."', '".$iC."', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS' )");$_SESSION[querycount]++; 
			}
		}	
	}
	$href="http://service.mdwestserve.com/obAffidavit.php?packet=$packet&mail=1&autoPrint=1";
	echo "<script>window.open('".$href."', 'Mailing Affidavits')</script>";
}

// make links to affidavits
$file1 = "http://mdwestserve.com/ps/liveAffidavit.php?packet=$packet&def=1";
$file2 = "http://mdwestserve.com/ps/liveAffidavit.php?packet=$packet&def=2"; 
$file3 = "http://mdwestserve.com/ps/liveAffidavit.php?packet=$packet&def=3";
$file4 = "http://mdwestserve.com/ps/liveAffidavit.php?packet=$packet&def=4";
// generate all invoices
?>
<!--------------commenting out invoice generation
<table>
<tr><td><iframe frameborder="0" src="http://mdwestserve.com/ps/ps_write_invoice.php?id=<?=$packet?>" width="600" height="30"></iframe></td></tr>
</table>
--------------->
<?

// email client
$to = "MDWestServe Archive <mdwestserve@gmail.com>";
$subject = "Service Completed for Packet $packet ($ddr[client_file])";
$headers  = "MIME-Version: 1.0 \n";
$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
$headers .= "From: ".$_COOKIE[psdata][name]." <".$_COOKIE[psdata][email]."> \n";


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
//get most recent closeOut (which has just been updated at top of page)
$qCO="SELECT closeOut FROM ps_packets WHERE packet_id='$packet'";
$rCO=@mysql_query($qCO) or die("Query: $qCO<br>".mysql_error());
$dCO=mysql_fetch_array($rCO,MYSQL_ASSOC);
if ($dCO[closeOut] != '0000-00-00'){
	$co=explode('-',$dCO[closeOut]);
	$month=monthConvert($co[1]);
	$closeOut=$month.' '.$co[2].', '.$co[0];
	$body ="<strong>Thank you for selecting MDWestServe as Your Process Service Provider.</strong><br>
Service for packet $packet (<strong>$ddr[client_file]</strong>) was completed on $closeOut, via $ddr[service_status].";
}else{
	$q10a="SELECT action_str, action_type from ps_history WHERE packet_id='$packet' AND (wizard='BORROWER' OR wizard='NOT BORROWER')";
	$r10a=@mysql_query($q10a) or die(mysql_error());
	//also Invalid Address entries
	$q10b="SELECT action_str, action_type from ps_history WHERE packet_id='$packet' AND (wizard='INVALID')";
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
Service for packet $packet (<strong>$ddr[client_file]</strong>) is complete, via $ddr[service_status].
As this document predates our latest system of affidavit entry, there is no standardized method of telling on which date service was completed.  
To better facilitate the coordinating of auctions and post-service processing, we have included a list of all service actions and the dates on which they occurred:<br><br>$serviceDates";
	}else{
		$body ="<strong>Thank you for selecting MDWestServe as Your Process Service Provider.</strong><br>
Service for packet $packet (<strong>$ddr[client_file]</strong>) is complete, via $ddr[service_status].";
	}
}
$body .= "<br><br><br><br>".$_COOKIE[psdata][name]."<br>MDWestServe, Inc.<br>(410) 828-4568<br>service@mdwestserve.com<br>".time()."<br>".md5(time());
$headers .= "Cc: MDWestServe Archive <mdwestserve@gmail.com> \n";
mail($to,$subject,$body,$headers);
psActivity("serviceConfirmed");
timeline($packet,$_COOKIE[psdata][name]." Confirmed Service");

if ($ddr[service_status] == "MAILING AND POSTING"){
}else{
	$q10="UPDATE ps_packets SET process_status='SERVICE COMPLETED', affidavit_status='SERVICE CONFIRMED', affidavit_status2='AWAITING OUT-OF-STATE', photoStatus='PHOTO CONFIRMED' WHERE packet_id = '$packet'";
	$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
}

?>
Affidavit confirmed.<br />
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="a" /> NEXT FILE</div>
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
