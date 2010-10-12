<? include 'common.php';
function mkAlert($alertStr,$entryID,$serverID,$packetID){
	mysql_select_db('core');
	@mysql_query("INSERT INTO ps_alert (alertStr, entryID, entryTime, serverID, packetID) VALUES ('$alertStr', '$entryID', NOW(), '$serverID', '$packetID')");
}
function monthConvert($month){
	if ($month == '01'){ return 'January'; }
	if ($month == '02'){ return 'February'; }
	if ($month == '03'){ return 'March'; }
	if ($month == '04'){ return 'April'; }
	if ($month == '05'){ return 'May'; }
	if ($month == '06'){ return 'June'; }
	if ($month == '07'){ return 'July'; }
	if ($month == '08'){ return 'August'; }
	if ($month == '09'){ return 'September'; }
	if ($month == '10'){ return 'October'; }
	if ($month == '11'){ return 'November'; }
	if ($month == '12'){ return 'December'; }
}
function makeEntry($packet,$def,$add,$name,$date,$entryID){
	if ($add == 'PO'){
		$q="select name$def, pobox, pocity, postate, pozip from ps_packets where packet_id = '$packet'";
		$r=@mysql_query($q) or die ("Query $q<br>".mysql_error());
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if((strpos(strtoupper($d['pobox']),'P.O. BOX') != 'false') || (strpos(strtoupper($d['pobox']),'PO BOX')) != 'false'){			
			$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at $d[pobox], $d[pocity], $d[postate] $d[pozip] \'P.O. Box Address\' by first class mail on $date.</li>";		
		}else{
	$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at $d[pobox], $d[pocity], $d[postate] $d[pozip] \'Mailing Only Address\' by certified mail, return receipt requested, and by first class mail on $date.</li>";
		}
	}elseif($add == 'PO2'){
		$q="select name$def, pobox2, pocity2, postate2, pozip2 from ps_packets where packet_id = '$packet'";
		$r=@mysql_query($q) or die ("Query $q<br>".mysql_error());
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if((strpos(strtoupper($d['pobox']),'P.O. BOX') != 'false') || (strpos(strtoupper($d['pobox']),'PO BOX')) != 'false'){			
			$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at $d[pobox2], $d[pocity2], $d[postate2] $d[pozip2] \'P.O. Box Address\' by first class mail on $date.</li>";		
		}else{
	$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at $d[pobox2], $d[pocity2], $d[postate2] $d[pozip2] \'Mailing Only Address\' by certified mail, return receipt requested, and by first class mail on $date.</li>";
		}
	}else{
		$var=$def.$add;
		$q="select name$def, address$var, city$var, state$var, zip$var, addressType$add from ps_packets where packet_id = '$packet'";
		$r=@mysql_query($q) or die ("Query $q<br>".mysql_error());
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		$action="<li>I, $name, Mailed Papers to ".$d["name$def"]." at ".$d["address$var"].", ".$d["city$var"].", ".$d["state$var"]." ".$d["zip$var"]." \'".$d["addressType$add"]."\' by certified mail, return receipt requested, and by first class mail on $date.</li>";
	}
	$action=strtoupper($action);
	@mysql_query("INSERT into ps_history (packet_id, defendant_id, action_type, action_str, serverID, recordDate, wizard )values('".$packet."', '".$def."', 'First Class C.R.R. Mailing', '".addslashes($action)."', '".$entryID."', NOW(), 'MAILING DETAILS' )") or die (mysql_error());
	$_SESSION[querycount]++;
}
function entriesFromMatrix($packet,$name,$date,$entryID){
	$qm="SELECT * FROM mailMatrix WHERE packetID='$packet'";
	$rm=@mysql_query($qm);
	$dm=mysql_fetch_array($rm, MYSQL_ASSOC);
	$i=0;
	while ($i < 6){$i++;
		if ($dm["add$i"] != ''){
			makeEntry($packet,$i,'',$name,$date,$entryID);
		}
		foreach(range('a','e') as $letter){
			if ($dm["add$i$letter"] != ''){
				makeEntry($packet,$i,$letter,$name,$date,$entryID);
			}
		}
		$field="add".$i."PO";
		if ($dm["$field"] != ''){
			makeEntry($packet,$i,'PO',$name,$date,$entryID);
		}
		$field="add".$i."PO2";
		if ($dm["$field"] != ''){
			makeEntry($packet,$i,'PO2',$name,$date,$entryID);
		}
	}
}
function entriesFromPacket($packet,$name,$date,$entryID){
	$q1="SELECT name1, name2, name3, name4, name5, name6, address1, address1a, address1b, address1c, address1d, address1e, pobox, pobox2 FROM ps_packets WHERE packet_id='$packet'";
	$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	$i=0;
	while ($i < 6){$i++;
		if ($d["name$i"]){
			makeEntry($packet,$def,'',$name,$date,$entryID);
		}
		foreach(range('a','e') as $letter){
			if ($d["address1$letter"]){
				makeEntry($packet,$i,$letter,$name,$date,$entryID);
			}
		}
		if ($d[pobox]){
			makeEntry($packet,$i,'PO',$name,$date,$entryID);
		}
		if ($d[pobox2]){
			makeEntry($packet,$i,'PO2',$name,$date,$entryID);
		}
	}
}
function costFromMatrix($packet){
	//at a rate of $17 per defendant/address
	$qm="SELECT * FROM mailMatrix WHERE packetID='$packet'";
	$rm=@mysql_query($qm);
	$dm=mysql_fetch_array($rm, MYSQL_ASSOC);
	$i=0;
	$count=0;
	while ($i < 6){$i++;
		if ($dm["add$i"] != ''){$count++;}
		foreach(range('a','e') as $letter){
			if ($dm["add$i$letter"] != ''){$count++;}
		}
		$field="add".$i."PO";
		if ($dm["$field"] != ''){$count++;}
		$field="add".$i."PO2";
		if ($dm["$field"] != ''){$count++;}
	}
	return $count*17;
}
function costFromPacket($packet){
	//at a rate of $17 per defendant/address
	$q1="SELECT name1, name2, name3, name4, name5, name6, address1, address1a, address1b, address1c, address1d, address1e, pobox, pobox2 FROM ps_packets WHERE packet_id='$packet'";
	$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	$i=0;
	$count=0;
	while ($i < 6){$i++;
		if ($d["name$i"]){$count++;}
		foreach(range('a','e') as $letter){
			if ($d["address1$letter"]){$count++;}
		}
		if ($d[pobox]){$count++;}
		if ($d[pobox2]){$count++;}
	}
	return $count*17;
}
function datePlusOne($dateStamp){
	$deadline=strtotime($dateStamp);
	$deadline=$deadline+86400;
	while (date('w',$deadline) == 0 || date('w',$deadline) == 6){
		$deadline=$deadline+86400;
	}
	return date('Y-m-d',$deadline);
}
$packet=$_GET[packet];
if ($_GET[mailDate]){
	$mailDate=$_GET[mailDate];
}else{
	$mailDate=date('Y-m-d');
}

psActivity("mailSent");
if ($_POST[opServer] != ''){
	$entryID=$_POST[opServer];
}else{
	$entryID=$_COOKIE[psdata][user_id];
}
@mysql_query("update ps_packets set closeOut = '$mailDate', gcStatus='MAILED', mail_status = 'Mailed First Class and Certified Return Receipt', process_status='READY TO MAIL', affidavit_status='SERVICE CONFIRMED', photoStatus='PHOTO CONFIRMED' where packet_id = '$packet' ");
mkAlert('SERVICE CONFIRMED',$entryID,'ALL',$packet);
$_SESSION[querycount]++;

$q="select * from ps_packets where packet_id = '$packet'";
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
?>
<script>
function confirmation() {
	var answer = confirm("Entries already exist for this file.  Make them again?")
	if (answer){
		window.location = "http://service.mdwestserve.com/matrixEntries.php?packet=<?=$packet?>&confirm=1&mailDate=<?=$mailDate?>&autoClose=1";
	}
	else{
		alert("ABORTED");
		self.close();
	}
}
</script>
<?
$qh="SELECT * FROM ps_history WHERE wizard='MAILING DETAILS' AND packet_id='$packet' LIMIT 0, 1";
$rh=@mysql_query($qh) or die ("Query: $qh<br>".mysql_error());
$dh=mysql_fetch_array($rh, MYSQL_ASSOC);

if ($dh[packet_id] && !$_GET[confirm]){
	echo "<script>confirmation()</script>";
}else{
	$qm="SELECT packetID FROM mailMatrix WHERE packetID='$packet'";
	$rm=@mysql_query($qm) or die ("Query: $qm<br>".mysql_error());
	$dm=mysql_fetch_array($rm, MYSQL_ASSOC);
	if ($dm[packetID] != ''){
		entriesFromMatrix($packet,$name,$date,$entryID);
		$cost=costFromMatrix($packet);
	}else{
		entriesFromPacket($packet,$name,$date,$entryID);
		$cost=costFromPacket($packet);
	}
	//if $_GET[mailCost] is present, file is "MAIL ONLY", set estFileDate=$mailDate+1 day
	if ($_GET[mailCost]){
		$deadline=datePlusOne($mailDate);
		@mysql_query("UPDATE ps_packets SET bill420='$cost', estFileDate='$deadline' WHERE packet_id='$packet'");
		timeline($packet,$_COOKIE[psdata][name]." Set mailMatrix, made affidavit entries, and determined mailing cost of $".$cost);
		//pop up affidavit, redirect to quality control checklist
		echo "<script>window.open('http://service.mdwestserve.com/obAffidavit.php?packet=$packet&mail=1&autoPrint=1',  'affidavit',   'width=1000, height=800'); </script>";
		echo "<script>window.location='http://staff.mdwestserve.com/otd/serviceSheet.php?packet=$packet&autoPrint=1'</script>";
	}elseif ($_GET[autoClose] == 1){
		timeline($packet,$_COOKIE[psdata][name]." Set mailMatrix and made affidavit entries");
		echo "<script>self.close();</script>";
	}
}
?>