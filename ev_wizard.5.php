<?
// submit to database
$defendant_detail=strtoupper($_POST[defendant_detail]);
if ($_POST[served] == "INVALID"){ 
	ev_timeline($packet,$_COOKIE[psdata][name]." Entered Invalid Address");
	$type='Invalid Address';
	$sort=1;
	mail($_POST[to], $_POST[subject], $_POST[msg]);
} 
if ($_POST[served] == "FIRST EFFORT"){ 
	ev_timeline($packet,$_COOKIE[psdata][name]." Entered First Effort");
	$type='Attempted Service';
	$sort=0;
} 
if ($_POST[served] == "SECOND EFFORT"){ 
	ev_timeline($packet,$_COOKIE[psdata][name]." Entered Second Effort");
	$type='Attempted Service';
	$sort=0;
} 
if ($_POST[served] == "POSTING DETAILS"){ 
	ev_timeline($packet,$_COOKIE[psdata][name]." Entered Posting Details");
	$type='Posted Papers';
	$sort=0;
	if ($_POST[closeOut] != '0000-00-00' && $_POST[closeOut] > $dd[closeOut]){
		@mysql_query("UPDATE evictionPackets SET service_status = 'MAILING AND POSTING', closeOut='$_POST[closeOut]' where eviction_id = '$packet'");
	}else{
		@mysql_query("UPDATE evictionPackets SET service_status = 'MAILING AND POSTING' where eviction_id = '$packet'");
	}
}
if ($_POST[served] == "MAILING DETAILS"){ 
	$type='First Class C.R.R. Mailing';
	$sort=0;
	if ($_POST[closeOut] != '0000-00-00' && $_POST[closeOut] > $dd[closeOut]){
		@mysql_query("UPDATE evictionPackets SET service_status = 'MAILING AND POSTING', closeOut='$_POST[closeOut]' where eviction_id = '$packet'");
	}else{
		@mysql_query("UPDATE evictionPackets SET service_status = 'MAILING AND POSTING' where eviction_id = '$packet'");
	}
} 
if ($_POST[served] == "LEGACY MAILING"){ 
	$type='First Class Mailing';
	$sort=0;
	@mysql_query("UPDATE evictionPackets SET service_status = 'MAILING AND POSTING' where eviction_id = '$packet'");
} 
if ($_POST[served] == "BORROWER"){ 
	ev_timeline($packet,$_COOKIE[psdata][name]." Entered Delivery Details - Served Defendant");
	$type='Served Defendant';
	$sort=0;
	if ($_POST[closeOut] != '0000-00-00' && $_POST[closeOut] > $dd[closeOut]){
		@mysql_query("UPDATE evictionPackets SET service_status = 'PERSONAL DELIVERY', closeOut='$_POST[closeOut]' where eviction_id = '$packet'");
	}else{
		@mysql_query("UPDATE evictionPackets SET service_status = 'PERSONAL DELIVERY' where eviction_id = '$packet'");
	}
} 
if ($_POST[served] == "NOT BORROWER"){ 
	ev_timeline($packet,$_COOKIE[psdata][name]." Entered Delivery Details - Substitute Service");
	$type='Served Resident';
	$rd=@mysql_query("SELECT closeOut from evictionPackets where eviction_id='$packet'");
	$dd=mysql_fetch_array($rd, MYSQL_ASSOC);
	if ($_POST[closeOut] != '0000-00-00' && $_POST[closeOut] > $dd[closeOut]){
		@mysql_query("UPDATE evictionPackets SET service_status = 'PERSONAL DELIVERY', closeOut='$_POST[closeOut]' where eviction_id = '$packet'");
	}else{
		@mysql_query("UPDATE evictionPackets SET service_status = 'PERSONAL DELIVERY' where eviction_id = '$packet'");
	}
}
$history=addslashes(strtoupper(normalize_special_characters($_POST[history])));
if ($_POST[served] == "CHANGE SIGNATORY"){
	$type='CHANGED SIGNATORY';
	if ($_POST[opServer]){
		$sID=$_POST[opServer];
	}else{
		$sID=$_POST[serverID];
	}
	$re=@mysql_query("SELECT * from evictionSignatory where evictionID='$packet' and serverID='$sID'");
	$de=mysql_fetch_array($re, MYSQL_ASSOC);
	if ($_COOKIE[psdata][level] == "Operations"){
		if ($_POST[opServer]){
			$serverID=$_POST[opServer];
		}
	}else{
		$serverID=$_POST[serverID];
	}
	if (!$de){
		$qd=@mysql_query("INSERT into evictionSignatory (name, address, city, state, zip, phone, evictionID, serverID, dateEntered) VALUES ('$_POST[server_name]', '$_POST[server_add]', '$_POST[server_city]', '$_POST[server_state]', '$_POST[server_zip]', '$_POST[server_phone]', '$packet', '$sID', NOW())") or die("Query: $qd<br>".mysql_error());
	}else{
		$qd=@mysql_query("UPDATE evictionSignatory SET name='$_POST[server_name]', address='$_POST[server_add]', city='$_POST[server_city]', state='$_POST[server_state]', zip='$_POST[server_zip]', phone='$_POST[server_phone]', dateEntered=NOW() WHERE evictionID='$packet' AND serverID='$sID'");
	}
}else{
	if($_COOKIE[psdata][level]=="Operations" && $_POST[opServer]){
	$qd=@mysql_query("INSERT into evictionHistory (eviction_id, defendant_id, action_type, action_str, serverID, recordDate, wizard, resident, residentDesc, address, sort_value, actionDate ) VALUES ('$packet', '$defendant', '$type', '$history', '$_POST[opServer]', NOW(), '$_POST[served]', '$_POST[name]', '$defendant_detail', '$_POST[serve_address]', '$sort', '$_POST[dt]')") or die("Query: $qd<br>".mysql_error());
	}else{
	$qd=@mysql_query("INSERT into evictionHistory (eviction_id, defendant_id, action_type, action_str, serverID, recordDate, wizard, resident, residentDesc, address, actionDate ) VALUES ('$packet', '$defendant', '$type', '$history', '$server', NOW(), '$_POST[served]', '$_POST[name]', '$defendant_detail', '$_POST[serve_address]', '$_POST[dt]')") or die("Query: $qd<br>".mysql_error());
	}
}



?>
<? if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? } ?>
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
<input type="hidden" name="service_type" value="<?=$_POST[service_type]?>" />
<input type="hidden" name="served" value="<?=$_POST[served]?>" />
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="1" /> NEXT</div>
<div class="nav2"><input onClick="submitLoader()" type="radio" name="i" value="a" /> NEW</div>

<? if ($_POST[served] == "CHANGE SIGNATORY"){
		if (!$error){
	?>
		new signatory submitted, <a href="wizard.php">new entry</a> or <a href="home.php">finish</a>?
	<? 	}else{ ?>
		signatory updated for this file, <a href="wizard.php">new entry</a> or <a href="home.php">finish</a>?
	<?  }
}else{ ?>
	entry submitted, <a href="wizard.php">new entry</a> or <a href="home.php">finish</a>?
<? } ?>