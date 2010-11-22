<? if (!$dname){ echo "<h1>NO DEFENDANT</h1>";} ?>

<?
foreach ($_POST[remove] as $key => $value){
// this is where we build the actual history item for the affidavit
if ($_POST[served][$key] == "FIRST EFFORT"){ 
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}else{
		$source=$_POST[addressType];
		$address=$_POST[address_source][$key];
	}
	$month=monthConvert($_POST[month][$key]);
	$history="<li>First Effort: $source</li>
	$month $_POST[day][$key], $_POST[year][$key] at $_POST[hour][$key]:$_POST[minute][$key] $_POST[ampm][$key]<br>
	$address<br>
	$_POST[defendant_detail][$key]";
} 
if ($_POST[served][$key] == "SECOND EFFORT"){
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	} 
	$month=monthConvert($_POST[month][$key]);
	$history="<li>Second Effort: $source</li>
	$month $_POST[day][$key], $_POST[year][$key] at $_POST[hour][$key]:$_POST[minute][$key] $_POST[ampm][$key]<br>
	$address<br>
	$_POST[defendant_detail][$key]";
} 
if ($_POST[served][$key] == "POSTING DETAILS"){ 
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}
	$month=monthConvert($_POST[month][$key]);
	$history="<li>Posting the Property:</li>
	$month $_POST[day][$key], $_POST[year][$key] $_POST[hour][$key]:$_POST[minute][$key] $_POST[ampm][$key]<br>
	$address<br>
	$_POST[defendant_detail][$key]";
} 

if ($_POST[served][$key] == "BORROWER"){ 
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}
	$month=monthConvert($_POST[month][$key]);
	if (strtoupper($source) == "POSSIBLE PLACE OF ABODE"){
		$source="USUAL PLACE OF ABODE";
	}
	if ($_POST[mult_def]){
		$history="$dname, a BORROWER<br>
		$source<br>
		$address<br>
		DATE OF SERVICE: $month $_POST[day][$key], $_POST[year][$key] at $_POST[hour][$key]:$_POST[minute][$key] $_POST[ampm][$key]<br>";		
	}else{
		$history="$dname, BORROWER<br>
		$source<br>
		$address<br>
		DATE OF SERVICE: $month $_POST[day][$key], $_POST[year][$key] at $_POST[hour][$key]:$_POST[minute][$key] $_POST[ampm][$key]<br>";
	}
} 
if ($_POST[served][$key] == "NOT BORROWER"){
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}
	$month=monthConvert($_POST[month][$key]);
	if (strtoupper($source) == "POSSIBLE PLACE OF ABODE"){
		$source="USUAL PLACE OF ABODE";
	}
	if ($_POST[mult_def]){
		$history="SERVED RESIDENT $_POST[name], $_POST[age] YEARS OF AGE, FOR ".strtoupper($dname).", A BORROWER<br>
		$source<br>
		$address<br>
		DATE OF SERVICE: $month $_POST[day][$key], $_POST[year][$key] at $_POST[hour][$key]:$_POST[minute][$key] $_POST[ampm][$key]";		
	}else{
		$history="SERVED RESIDENT $_POST[name], $_POST[age] YEARS OF AGE, FOR ".strtoupper($dname).", BORROWER<br>
		$source<br>
		$address<br>
		DATE OF SERVICE: $month $_POST[day][$key], $_POST[year][$key] at $_POST[hour][$key]:$_POST[minute][$key] $_POST[ampm][$key]";
	}
} 

/*if ($_POST[served][$key] == "MAILING DETAILS"){ 
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif($_POST[address_source][$key] == 'pobox'){
		if((strpos(strtoupper($ddr['pobox']),'P.O. BOX') != 'false') || (strpos(strtoupper($ddr['pobox']),'PO BOX')) != 'false'){
			$source='P.O. Box Address';
		}else{
			$source='Mailing Only Address';
		}
		$address=$_POST[pobox];
	}elseif($_POST[address_source][$key] == 'pobox2'){
		if((strpos(strtoupper($ddr['pobox2']),'P.O. BOX') != 'false') || (strpos(strtoupper($ddr['pobox2']),'PO BOX')) != 'false'){
			$source='P.O. Box Address';
		}else{
			$source='Mailing Only Address';
		}
		$address=$_POST[pobox2];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}
	$month=monthConvert($_POST[month][$key]);
	if ($_POST[opServer] != ''){
		$name=id2name($_POST[opServer]);
	}else{
		$name=$_COOKIE[psdata][name];
	}
	$history="<li>I, $name, Mailed Papers to $_POST[name] at $address '$source' by first class and certified mail, return receipt requested, on $month $_POST[day][$key], $_POST[year][$key].</li>";
}

if ($_POST[served][$key] == "CERT MAILING"){
	if($_POST[address_source][$key] == 'custom'){
		$source="KNOWN ADDRESS";
		$address=strtoupper($_POST[customAdd]);
	}elseif($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif($_POST[address_source][$key] == 'pobox'){
		if((strpos(strtoupper($ddr['pobox']),'P.O. BOX') != 'false') || (strpos(strtoupper($ddr['pobox']),'PO BOX')) != 'false'){
			$source='P.O. Box Address';
		}else{
			$source='Mailing Only Address';
		}
		$address=$_POST[pobox];
	}elseif($_POST[address_source][$key] == 'pobox2'){
		if((strpos(strtoupper($ddr['pobox2']),'P.O. BOX') != 'false') || (strpos(strtoupper($ddr['pobox2']),'PO BOX')) != 'false'){
			$source='P.O. Box Address';
		}else{
			$source='Mailing Only Address';
		}
		$address=$_POST[pobox2];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}
	$month=monthConvert($_POST[month][$key]);
	if ($_POST[opServer] != ''){
		$name=id2name($_POST[opServer]);
	}else{
		$name=$_COOKIE[psdata][name];
	}
	$history="<li>I, $name, Mailed Papers to $_POST[name] at $address '$source' by first class mail, on $month $_POST[day][$key], $_POST[year][$key].</li>";
}

if ($_POST[served][$key] == "INVALID"){ 
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}
	$month=monthConvert($_POST[month][$key]);
	if ($_POST[opServer] != ''){
		$name=id2name($_POST[opServer]);
	}else{
		$name=$_COOKIE[psdata][name];
	}
	$history="<li>I, $name, SEARCHED THE UNITED STATES POSTAL SERVICE DATABASE AND THE DEPARTMENT OF ASSESSMENTS AND TAXATION DATABASE FOR $address '$source' WITH NO RESULTS, ON $month $_POST[day][$key], $_POST[year][$key].</li>";
	$to="System Operations <sysop@hwestauctions.com>";
	$client=$_POST[client_file];
	$subject="Invalid Address For File $client (Packet $packet)";
	$msg="$name searched for $address '$source' within the united states postal service database and the department of assessments and taxation database, with no results.";
} 
if ($_POST[served][$key] == "LEGACY MAILING"){ 
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}
	if ($_POST[opServer] != ''){
		$name=id2name($_POST[opServer]);
	}else{
		$name=$_COOKIE[psdata][name];
	}
	$history="<li>I, $name, Mailed Papers to $_POST[name] at $address '$source' by first class mail.</li>";
} 
if ($_POST[served][$key] == "ADDITIONAL AFFIDAVIT"){
	if($_POST[address_source][$key] == '1a'){
		$source=$ddr[addressTypea];
		$address=$_POST[address1a];
	}elseif($_POST[address_source][$key] == '1b'){
		$source=$ddr[addressTypeb];
		$address=$_POST[address1b];
	}elseif($_POST[address_source][$key] == '1c'){
		$source=$ddr[addressTypec];
		$address=$_POST[address1c];
	}elseif($_POST[address_source][$key] == '1d'){
		$source=$ddr[addressTyped];
		$address=$_POST[address1d];
	}elseif($_POST[address_source][$key] == '1e'){
		$source=$ddr[addressTypee];
		$address=$_POST[address1e];
	}elseif ($_POST[address_source][$key] == '1'){
		$source=$ddr[addressType];
		$address=$_POST[address1];
	}
	$month=monthConvert($_POST[month][$key]);
	$history="<i style='font-weight:300;'><li>Second Effort: $source</li>
	$month $_POST[day][$key], $_POST[year][$key] at $_POST[hour][$key]:$_POST[minute][$key] $_POST[ampm][$key]<br>
	$address<br>
	Service Performed by $_POST[server_name], <b>see additional affidavit</b></i>";
}
*/


if($_POST[ampm][$key] == 'PM'){
	$hour=$_POST[hour][$key]+12;
}else{
	$hour=$_POST[hour][$key];
}
$dt="$_POST[year][$key]-$_POST[month][$key]-$_POST[day][$key] $hour:$_POST[minute][$key]:00";
?>
<strong>AFFIDAVIT ENTRY FOR <?=$_POST[service_type][$key];?> <?=$_POST[served][$key];?></strong><br />
<div style="background-color:#FFFF00;"><?=stripslashes(strtoupper($history))?><? if ($_POST[defendant_detail][$key] != ''){echo "<br />RESIDENT DESCRIPTION: ".strtoupper($_POST[defendant_detail][$key]);}?></div>

<? $closeOut=$_POST[year][$key].'-'.$_POST[month][$key].'-'.$_POST[day][$key]; ?>
<input type="hidden" name="closeOut[<?=$key?>]" value="<?=$closeOut?>">
<input type="hidden" name="address_source[<?=$key?>]" value="<?=$_POST[address_source][$key]?>">
<input type="hidden" name="date[<?=$key?>]" value="<?=$_POST['date']?>">
<input type="hidden" name="time[<?=$key?>]" value="<?=$_POST['time']?>">
<input type="hidden" name="dt[<?=$key?>]" value="<?=$dt?>">
<input type="hidden" name="address[<?=$key?>]" value="<?=$_POST[address]?>">
<input type="hidden" name="city[<?=$key?>]" value="<?=$_POST[city]?>">
<input type="hidden" name="state[<?=$key?>]" value="<?=$_POST[state]?>">
<input type="hidden" name="zip[<?=$key?>]" value="<?=$_POST[zip]?>">
<input type="hidden" name="serve_address[<?=$key?>]" value="<?=$address?>" />
<input type="hidden" name="defendant_detail[<?=$key?>]" value="<?=$_POST[defendant_detail][$key]?>">
<input type="hidden" name="name[<?=$key?>]" value="<?=$_POST[name]?>">
<input type="hidden" name="age[<?=$key?>]" value="<?=$_POST[age]?>">
<input type="hidden" name="property_detail[<?=$key?>]" value="<?=$_POST[property_detail]?>" />
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<input type="hidden" name="history[<?=$key?>]" value="<?=$history?>" />
<input type="hidden" name="service_type[<?=$key?>]" value="<?=$_POST[service_type]?>" />
<input type="hidden" name="served[<?=$key?>]" value="<?=$_POST[served][$key]?>" />
<? 
}
if ($_POST[served][$key] == 'INVALID'){?>
<!--------------
<input type="hidden" name="to" value="<?=$to?>" />
<input type="hidden" name="subject" value="<?=strtoupper($subject)?>" />
<input type="hidden" name="msg" value="<?=strtoupper($msg)?>" />
------------------->
<? } ?>
<hr />
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="3" /> EDIT</div>
<div class="nav3"><input onClick="submitLoader()" type="radio" name="i" value="5" /> SAVE</div>
<div class="nav2"><input onClick="submitLoader()" type="radio" name="i" value="1" /> RESTART</div>
<? if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? } ?>
