<?
foreach ($_POST[remove] as $key => $value){
	// submit to database
	$defendant_detail=strtoupper($_POST["defendant_detail-$key"]);
	if ($_POST["served-$key"] == "INVALID"){ 
		timeline($packet,$_COOKIE[psdata][name]." Edited Invalid Address for ".$ddr["name$defendant"]);
		$type='Invalid Address';
		mail($_POST[to], $_POST[subject], $_POST[msg]);
	} 
	if ($_POST["served-$key"] == "FIRST EFFORT"){ 
		timeline($packet,$_COOKIE[psdata][name]." Edited First Effort for ".$ddr["name$defendant"]);
		$type='Attempted Service';
	} 
	if ($_POST["served-$key"] == "SECOND EFFORT"){ 
		timeline($packet,$_COOKIE[psdata][name]." Edited Second Effort for ".$ddr["name$defendant"]);
		$type='Attempted Service';
	} 
	if ($_POST["served-$key"] == "POSTING DETAILS"){ 
		timeline($packet,$_COOKIE[psdata][name]." Edited Posting Details for ".$ddr["name$defendant"]);
		$type='Posted Papers';
	} 
	if ($_POST["served-$key"] == "MAILING DETAILS"){ 
		$type='First Class C.R.R. Mailing';
	}
	if ($_POST["served-$key"] == "CERT MAILING"){ 
		$type='Mailing For Certificate of Service';
	}
	if ($_POST["served-$key"] == "LEGACY MAILING"){ 
		$type='First Class Mailing';
	} 
	if ($_POST["served-$key"] == "BORROWER"){ 
		timeline($packet,$_COOKIE[psdata][name]." Edited Delivery Details - Served Defendant for ".$ddr["name$defendant"]);
		$type='Served Defendant';
	} 
	if ($_POST["served-$key"] == "NOT BORROWER"){ 
		timeline($packet,$_COOKIE[psdata][name]." Edited Delivery Details - Substitute Service for ".$ddr["name$defendant"]);
		$type='Served Resident';
	}
	$history=addslashes(strtoupper($_POST["history-$key"]));
	if($_COOKIE[psdata][level]=="Operations"){
		$qd=@mysql_query("UPDATE ps_history SET defendant_id='$defendant', action_type='$type', action_str='$history', serverID='$_POST[opServer]', recordDate=NOW(), wizard='".$_POST["served-$key"]."', resident='".$_POST["name-$key"]."', residentDesc='$defendant_detail', address='".$_POST["serve_address-$key"]."', actionDate='".$_POST["dt-$key"]."' WHERE packet_id='$packet'") or die("Query: $qd<br>".mysql_error());
	}else{
		$qd=@mysql_query("UPDATE ps_history SET defendant_id='$defendant', action_type='$type', action_str='$history', serverID='$server', recordDate=NOW(), wizard='".$_POST["served-$key"]."', resident='".$_POST["name-$key"]."', residentDesc='$defendant_detail', address='".$_POST["serve_address-$key"]."', actionDate='".$_POST["dt-$key"]."' WHERE packet_id='$packet'") or die("Query: $qd<br>".mysql_error());
	}
	?>
	<input type="hidden" name="service_type" value="<?=$_POST["service_type-$key"]?>" />
	<input type="hidden" name="served" value="<?=$_POST["served-$key"]?>" />
<? } ?>
<? if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? } ?>
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="1" /> NEXT</div>
<div class="nav2"><input onClick="submitLoader()" type="radio" name="i" value="a" /> NEW</div>
entries edited, <a href="wizard.php">new entry</a> or <a href="home.php">finish</a>?