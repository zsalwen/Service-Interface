<?
//first we need to generate all mailing entries if file is M&P.
function makeEntry($packet,$def,$add,$name,$date,$entryID,$product){
	if ($add == 'PO'){
		$q="select name$def, pobox, pocity, postate, pozip from ps_packets where packet_id = '$packet'";
		$r=@mysql_query($q) or die ("Query $q<br>".mysql_error());
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if((strpos(strtoupper($d['pobox']),'P.O. BOX') !== false) || (strpos(strtoupper($d['pobox']),'PO BOX')) !== false){			
			$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at $d[pobox], $d[pocity], $d[postate] $d[pozip] \'P.O. Box Address\' by first class mail on $date.</li>";		
		}else{
	$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at $d[pobox], $d[pocity], $d[postate] $d[pozip] \'Mailing Only Address\' by certified mail, return receipt requested, and by first class mail on $date.</li>";
		}
	}elseif($add == 'PO2'){
		$q="select name$def, pobox2, pocity2, postate2, pozip2 from ps_packets where packet_id = '$packet'";
		$r=@mysql_query($q) or die ("Query $q<br>".mysql_error());
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if((strpos(strtoupper($d['pobox']),'P.O. BOX') !== false) || (strpos(strtoupper($d['pobox']),'PO BOX')) !== false){			
			$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at $d[pobox2], $d[pocity2], $d[postate2] $d[pozip2] \'P.O. Box Address\' by first class mail on $date.</li>";		
		}else{
	$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at $d[pobox2], $d[pocity2], $d[postate2] $d[pozip2] \'Mailing Only Address\' by certified mail, return receipt requested, and by first class mail on $date.</li>";
		}
	}else{
		$var=$def.$add;
		if ($product == 'EV'){
			$q="select name$def, address$var, city$var, state$var, zip$var from evictionPackets where eviction_id = '$packet'";
		}else{
			$q="select name$def, address$var, city$var, state$var, zip$var, addressType$add from ps_packets where packet_id = '$packet'";
		}
		$r=@mysql_query($q) or die ("Query $q<br>".mysql_error());
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if (($def == 1) && ($product == 'EV')){
			$name2="ALL OCCUPANTS";
		}else{
			$name2=$d["name$def"];
		}
		$action="<li>I, $name, Mailed Papers to $name2 at ".$d["address$var"].", ".$d["city$var"].", ".$d["state$var"]." ".$d["zip$var"]." \'".$d["addressType$add"]."\' by certified mail, return receipt requested, and by first class mail on $date.</li>";
	}
	$action=strtoupper($action);
	$actionDate=$mailDate." 00:00:00";
	if ($product == 'EV'){
		@mysql_query("INSERT into evictionHistory (eviction_id, defendant_id, action_type, action_str, serverID, recordDate, wizard, actionDate )values('".$packet."', '".$def."', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS', '$actionDate')") or die (mysql_error());
	}else{
		@mysql_query("INSERT into ps_history (packet_id, defendant_id, action_type, action_str, serverID, recordDate, wizard, actionDate )values('".$packet."', '".$def."', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS', '$actionDate')") or die (mysql_error());
	}
	$_SESSION[querycount]++;
}
function entriesFromMatrix($packet,$name,$date,$entryID,$mailDate,$product){
	$qm="SELECT * FROM mailMatrix WHERE packetID='$packet' AND product='$product'";
	$rm=@mysql_query($qm);
	$dm=mysql_fetch_array($rm, MYSQL_ASSOC);
	$i=0;
	while ($i < 6){$i++;
		if ($dm["add$i"] != ''){
			makeEntry($packet,$i,'',$name,$date,$entryID,$product);
		}
		foreach(range('a','e') as $letter){
			if ($dm["add$i$letter"] != ''){
				makeEntry($packet,$i,$letter,$name,$date,$entryID,$product);
			}
		}
		$field="add".$i."PO";
		if ($dm["$field"] != ''){
			makeEntry($packet,$i,'PO',$name,$date,$entryID,$product);
		}
		$field="add".$i."PO2";
		if ($dm["$field"] != ''){
			makeEntry($packet,$i,'PO2',$name,$date,$entryID,$product);
		}
	}
}
function entriesFromEviction($packet,$name,$date,$entryID){
	$q1="SELECT name1, name2, name3, name4, name5, name6, onAffidavit1, onAffidavit2, onAffidavit3, onAffidavit4, onAffidavit5, onAffidavit6, address1, attorneys_id FROM evictionPackets WHERE eviction_id='$packet'";
	$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	if ($d1[name1]){
		makeEntry($packet,1,'',$name,$date,$entryID,"EV");
	}
	$i=1;
	while ($i < 6){$i++;
		if ($d["name$i"] && (strtoupper($d["onAffidavit$i"]) != 'CHECKED') && ($d[attorneys_id] == 3)){
			makeEntry($packet,$i,'',$name,$date,$entryID,$mailDate,"EV");
		}
	}
}
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
	$qm="SELECT packetID FROM mailMatrix WHERE packetID='$packet' AND product='EV'";
	$rm=@mysql_query($qm);
	$dm=mysql_fetch_array($rm, MYSQL_ASSOC);
	if ($dm[packetID] != ''){
		entriesFromMatrix($packet,$name,$date,$entryID,$mailDate,'EV');
	}else{
		entriesFromEviction($packet,$name,$date,$entryID,$mailDate);
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