<?
include_once 'functions.php';
@mysql_connect ();
mysql_select_db ('core');
// start output buffering
	$subtract='0';

function EVdefCount($eviction_id){
	$c=0;
	$r=@mysql_query("SELECT DISTINCT defendant_id from evictionHistory WHERE eviction_id='$eviction_id' ORDER BY defendant_id DESC LIMIT 0,1");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[defendant_id];
}
?>
<style>
.dim {
   /* the filter attribute is recognized in
   Internet Explorer and should be a percentage */
   filter: Alpha(opacity=40);
   /* the -moz-opacity attribute is recognized by 
   Gecko browsers and should be a decimal */
   -moz-opacity: .40;
   /* opacity is the proposed CSS3 method, supported
   in recent Gecko browsers */
   opacity: .40;
}
.dimmer {
   /* the filter attribute is recognized in
   Internet Explorer and should be a percentage */
   filter: Alpha(opacity=25);
   /* the -moz-opacity attribute is recognized by 
   Gecko browsers and should be a decimal */
   -moz-opacity: .25;
   /* opacity is the proposed CSS3 method, supported
   in recent Gecko browsers */
   opacity: .25;
}
td { font-variant:small-caps; font-size:12px;}
td.a {font-size:14px;}
td.b {font-size:24px;}
table { page-break-after:always;}
p {border-style:solid; border-width:thick; border-collapse:collapse;}
</style>
<?
function EVmakeAffidavit($p,$defendant,$level,$user_id){
	$packet = $p;
	$def = 0;
	$defs = EVdefCount($packet);
	if (strpos($defendant,"!")){
		$overRide=1;
	}
	while ($def < $defs){$def++;
	$q1='';
	$r1='';
	$d1='';
	$q2='';
	$r2='';
	$d2='';
	$q3='';
	$r3='';
	$d3='';
	$q4='';
	$r4='';
	$d4='';
	$sign_by='';
	$attempts = '';
	$iID = '';
	$attemptsa = '';
	$iIDa = '';
	$attemptsb = '';
	$iIDb = '';
	$attemptsc = '';
	$iIDc = '';
	$attemptsd = '';
	$iIDd = '';
	$attemptse = '';
	$iIDe = '';
	$posting = '';
	$iiID = '';
	$delivery = '';
	$deliveryID = '';
	$resident = '';
	$residentDesc = '';
	$serveAddress = '';
	$nondef='';
	$mailing = '';
	$crr='';
	$iiiID = '';
	$first='';
	// get main information
	if ($overRide == '1'){
		$q1="SELECT * FROM evictionPackets WHERE eviction_id='$packet'";
	}else{
		$q1="SELECT * FROM evictionPackets WHERE eviction_id='$packet' AND affidavit_status='SERVICE CONFIRMED'";
	}
	$r1=@mysql_query($q1) or die(mysql_error());
	$d1=mysql_fetch_array($r1, MYSQL_ASSOC);
	if ($d1[amendedAff] == "checked"){
		$amended="Amended ";
	}else{
		$amended="";
	}
	if ($def != 1 && strtoupper($d1["onAffidavit$def"]) != 'CHECKED'){
		$party=strtoupper($d1["name$def"]);
	}else{
		$party="ALL OCCUPANTS";
	}
	if ($d1[altDocs] != ''){
		$altDocs=$d1[altDocs];
	}else{
		$altDocs="MOTION FOR JUDGMENT AWARDING POSSESSION";
	}
	$court = $d1[circuit_court];
	if (!preg_match("/CITY|D.C./", $court)){
		$court = str_replace('PRINCE GEORGES','PRINCE GEORGE\'S',$court);
		$court = str_replace('QUEEN ANNES','QUEEN ANNE\'S',$court);
		$court = str_replace('ST MARYS','ST MARY\'S',$court);
		$court = ucwords(strtolower($court))." County";
	} else {
		$court = ucwords(strtolower($court));
	}
	// get plaintiff information
	mysql_select_db ('ccdb');
	$q2="SELECT * from attorneys where attorneys_id = '$d1[attorneys_id]'";
	$r2=@mysql_query($q2) or die(mysql_error());
	$d2=mysql_fetch_array($r2, MYSQL_ASSOC);
	if ($d1[altPlaintiff] != ''){
		$plaintiff = str_replace('-','<br>',$d1[altPlaintiff]);
	}else{
		$plaintiff = str_replace('-','<br>',$d2[ps_plaintiff]);
	}
	mysql_select_db ('core');
	// get service history
	$q4="SELECT * from evictionHistory where eviction_id = '$packet' AND defendant_id = '$def' and (wizard='FIRST EFFORT' or wizard='INVALID') and onAffidavit='checked' order by sort_value desc";
	$r4=@mysql_query($q4) or die(mysql_error());
	while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
		if ($d4[serverID] == $d1[server_id]){
			$attempts .= $d4[action_str];
			$iID = $d4[serverID];
		}
	}

	$q4="SELECT * from evictionHistory where eviction_id = '$packet' AND defendant_id = '$def' and wizard='SECOND EFFORT' and onAffidavit='checked' order by sort_value";
	$r4=@mysql_query($q4) or die(mysql_error());
	while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
		if ($d4[serverID]==$d1[server_id]){
			$attempts .= $d4[action_str];
			$iID = $d4[serverID];
		}
	}

	$q4="SELECT * from evictionHistory where eviction_id = '$packet' AND defendant_id = '$def' and action_type = 'Posted Papers' and onAffidavit='checked'";
	$r4=@mysql_query($q4) or die(mysql_error());
	$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
	$posting = $d4[action_str];
	$iiID = $d4[serverID];

	$q4="SELECT * from evictionHistory where eviction_id = '$packet' AND defendant_id = '$def' and action_type = 'First Class C.R.R. Mailing' and onAffidavit='checked'";
	$r4=@mysql_query($q4) or die(mysql_error());
	while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
		$mailing .= $d4[action_str];
		$crr=$d4[action_type];
		$iiiID = $d4[serverID];
		if ($resMail == ''){
			$resMail = strtoupper($d4[resident]);
		}
	}
	if ($mailing == ''){
		$q4="SELECT * from evictionHistory where eviction_id = '$packet' AND defendant_id = '$def' and action_type = 'First Class Mailing' and onAffidavit='checked'";
		$r4=@mysql_query($q4) or die(mysql_error());
		while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
			$mailing .= $d4[action_str];
			$iiiID = $d4[serverID];
			$first = $d4[action_type];
			if ($resMail == ''){
				$resMail = strtoupper($d4[resident]);
			}
		}
	}

	$q4="SELECT * from evictionHistory where eviction_id = '$packet' AND defendant_id = '$def' and action_type = 'Served Defendant' and onAffidavit='checked'";
	$r4=@mysql_query($q4) or die(mysql_error());
	$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
	$delivery = $d4[action_str];
	$deliveryID = $d4[serverID];
	$serveAddress = $d4[address];
	if ($delivery == ''){
		$q4="SELECT * from evictionHistory where eviction_id = '$packet' AND defendant_id = '$def' and action_type = 'Served Resident' and onAffidavit='checked'";
		$r4=@mysql_query($q4) or die(mysql_error());
		$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
		$delivery = $d4[action_str];
		$deliveryID = $d4[serverID];
		$resident = $d4[resident];
		$residentDesc = $d4[residentDesc];
		$serveAddress = $d4[address];
		$nondef='1';
	}
	// new settings
	if ($delivery != ''){
		$type = 'pd';
	}else{
		$type = 'non';
	}
	// hard code
	$header="<td colspan='2' align='center' style='font-size:24px; font-variant:small-caps;'>State of Maryland</td></tr>
		<tr><td colspan='2' align='center' style='font-size:20px;'>Circuit Court for ".$court."</td></tr>
		<tr></tr>
		<tr><td class='a'>".$plaintiff."<br><small>_____________________<br /><em>Substitute Trustees<br>Plaintiff</em></small><br /><br />v.<br /><br />";
			if ($d1[onAffidavit1]=='checked'){$header .= strtoupper($d1['name1']).'<br>';}
			if ($d1['name2'] && $d1[onAffidavit2]=='checked'){$header .= strtoupper($d1['name2']).'<br>';}
			if ($d1['name3'] && $d1[onAffidavit3]=='checked'){$header .= strtoupper($d1['name3']).'<br>';}
			if ($d1['name4'] && $d1[onAffidavit4]=='checked'){$header .= strtoupper($d1['name4']).'<br>';}
			if ($d1['name5'] && $d1[onAffidavit5]=='checked'){$header .= strtoupper($d1['name5']).'<br>';}
			if ($d1['name6'] && $d1[onAffidavit6]=='checked'){$header .= strtoupper($d1['name6']).'<br>';}
			$header .=strtoupper($d1['address1']).'<br>';
			$header .=strtoupper($d1['city1']).', '.strtoupper($d1['state1']).' '.$d1['zip1'].'<br>';
			$header .= "<small>_____________________<br /><em>Defendant</em></small></td>
				<td align='right' valign='top' style='padding-left:200px; width:200px' nowrap='nowrap'><div style='font-size:24px; border:solid 1px #666666; text-align:center;'>Case Number<br />".str_replace(0,'&Oslash;',$d1[case_no])."</div>";

	if ($type == "non"){
		$article = "14-102 (d) (3) (A) (ii)";
		$result = "MAILING AND POSTING";
		if ($attempts != ''){
				$history = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve $party, by personal delivery:<br>I, [SERVERNAME], made the following efforts:</u></div>
				".$attempts;
			}elseif($attemptsa != ''){
				$history = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve $party, by personal delivery:<br>I, [SERVERNAME], made the following efforts:</u></div>
				".$attemptsa;
				$iID=$iIDa;
			}
			$history2 = "<div style='font-weight:300'><u>Include the date of the posting and a description of the location of the posting on the property:<br>I, [SERVERNAME], posted the property in the following manner:</u></div>".$posting;
		if ($mailing == ''){
			$history3 = "<div class='dim' style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and certified mail, return receipt requested, and the address:</u>
				<center><font size='36 px'>AWAITING MAILING<br>DO NOT FILE</font></center></div>";
			$noMail = 1;
		}else{
			if ($crr != ''){
				$history3 = "<div style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and certified mail, return receipt requested, and the address:</u></div>
				".$mailing;
			}elseif(($iiID == $d1[server_id]) || ($first != '' && $crr == '')){
				$history3 = "<div style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and the address:</u></div>
				".$mailing;
			}
		}
			//$history4 = "<u>If available, the original certified mail return receipt shall be attached to the affidavit.</u><div style='height:50px; width:550px; border:double 4px; color:#666'>Affix original certified mail return receipt here.</div>";
	}
	if ($type == "pd"){
		$article = "14-102 (d) (3) (A) (i)";
		$result = "PERSONAL DELIVERY";
	}
	// ok let's really have some fun with this 
	$history = attorneyCustomLang($d1[attorneys_id],$history);
	$history1 = attorneyCustomLang($d1[attorneys_id],$history1);
	$history2 = attorneyCustomLang($d1[attorneys_id],$history2);
	$history3 = attorneyCustomLang($d1[attorneys_id],$history3);
	$history4 = attorneyCustomLang($d1[attorneys_id],$history4);
	$delivery = attorneyCustomLang($d1[attorneys_id],$delivery);
	if ($type == "non"){
	//begin output buffering
	ob_start();
	//1st server, or servera if non-Burson
	//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	if ($iID){
	?>
		<table width="80%" align="center" bgcolor="#FFFFFF" <? if ((strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED") && ($overRide != '1')){echo "class='dimmer'";}?>>
	 <? 
	$r5=@mysql_query("SELECT * from evictionSignatory where serverID='$iID' AND evictionID='$packet'");
	$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
	$serverName=$d5[name];
	$serverID=$iID;
	$serverAdd=$d5[address];
	$serverCity=$d5[city];
	$serverState=$d5[state];
	$serverZip=$d5[zip];
	$serverPhone=$d5[phone];
	if (!$d5){
	$q3="SELECT * from ps_users where id = '$iID'";
	$r3=@mysql_query($q3) or die(mysql_error());
	$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
	$serverName=$d3[name];
	$serverAdd=$d3[address];
	$serverCity=$d3[city];
	$serverState=$d3[state];
	$serverZip=$d3[zip];
	$serverPhone=$d3[phone];
	}
	$cord="EV".$d1[eviction_id]."-".$def."-".$serverID."%";
	 echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=300&height=40'><center>File Number: ".$d1[client_file]."<br>[PAGE]</center></td></tr>"; ?>
		<tr>
			<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top"><?=$amended?>Affidavit of Attempted Delivery<? if ($iID==$iiID){ echo " and Posting";} ?></td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
		</tr>
		<tr>
			<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the <?=$altDocs?> and all other papers filed with it (the "Papers") in the above-captioned case, I, <?=$serverName?>, do hereby affirm that the contents of the following affidavit are true and correct, based on my personal knowledge:<br></td>
		</tr>
		<tr>
			<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes(str_replace('[SERVERNAME]',$serverName,$history))?></td>
		</tr>
	<?
	if ($iID == $iiID){
	}else{
	?>        
		<tr>
			<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this <?=strtolower($amended)?>Affidavit are true and correct, to the best of my knowledge, information and belief<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?>, and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?>, and that I served the <?=$altDocs?> and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
		</tr>
		<tr>
			<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
		</tr>
		<tr>
			<td valign="top" style="font-size:14px">____________________________________<br />+Notary Public+<br /><br /><br />SEAL</td>
			<td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?><br><?=$_SERVER[REMOTE_ADDR]?></td> 
		</tr>
	</table>
	<? }
	 }
	$pageI["$def"] = ob_get_clean();
	ob_start();
	 //Multiple servers' attempts end here
	if($posting){
	if ($iID==$iiID){
	}else{
	?>
		<table width="80%" align="center" bgcolor="#FFFFFF" <? if ((strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED") && ($overRide != '1')){echo "class='dimmer'";}?>>
	<?
	$r5=@mysql_query("SELECT * from evictionSignatory where serverID='$iiID' AND evictionID='$packet'");
	$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
	$serverName=$d5[name];
	$serverID=$iiID;
	$serverAdd=$d5[address];
	$serverCity=$d5[city];
	$serverState=$d5[state];
	$serverZip=$d5[zip];
	$serverPhone=$d5[phone];
	if (!$d5){
	$q3="SELECT * from ps_users where id = '$iiID'";
	$r3=@mysql_query($q3) or die(mysql_error());
	$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
	$serverName=$d3[name];
	$serverAdd=$d3[address];
	$serverCity=$d3[city];
	$serverState=$d3[state];
	$serverZip=$d3[zip];
	$serverPhone=$d3[phone];
	}
	$cord="EV".$d1[eviction_id]."-".$def."-".$serverID."%";
	?> 
		<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=300&height=40'><center>File Number: ".$d1[client_file]."<br>[PAGE]</center></td></tr>"; ?>
		<tr>
			<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top"><?=$amended?>Affidavit of Posting</td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
		</tr>
		<tr>
			<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the <?=$altDocs?> and all other papers filed with it (the "Papers") in the above-captioned case, I, <?=$serverName?>, do hereby affirm that the contents of the following affidavit are true and correct, based on my personal knowledge:<br></td>
		</tr>
		<? } ?>
		<tr>
			<td colspan="2" style="font-weight:bold; padding-left:20px"><?=stripslashes(str_replace('[SERVERNAME]',$serverName,$history2))?></td>
		</tr>       
		<tr>
			<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this <?=strtolower($amended)?>Affidavit are true and correct, to the best of my knowledge, information and belief.<br></td>
		</tr>
		<tr>
			<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
		</tr>
		<tr>
			<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
			<td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?><br><?=$_SERVER[REMOTE_ADDR]?></td> 
		</tr>
	</table>
	<? }
	 $pageII["$def"] = ob_get_clean();
	 $postingID = $iiID;
	 ob_start();
	  if($iiiID){ ?>
		<table width="80%" align="center" bgcolor="#FFFFFF" <? if ((strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED") && ($overRide != '1')){echo "class='dimmer'";}?>>
	<?
	$r5=@mysql_query("SELECT * from evictionSignatory where serverID='$iiiID' AND evictionID='$packet'");
	$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
	$serverName=$d5[name];
	$serverID=$iiiID;
	$serverAdd=$d5[address];
	$serverCity=$d5[city];
	$serverState=$d5[state];
	$serverZip=$d5[zip];
	$serverPhone=$d5[phone];
	if (!$d5){
	$q3="SELECT * from ps_users where id = '$iiiID'";
	$r3=@mysql_query($q3) or die(mysql_error());
	$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
	$serverName=$d3[name];
	$serverAdd=$d3[address];
	$serverCity=$d3[city];
	$serverState=$d3[state];
	$serverZip=$d3[zip];
	$serverPhone=$d3[phone];
	}
	if ($resMail != ''){
		$name=$resMail;
	}elseif((strtoupper($d1["onAffidavit$def"]) != "CHECKED") && ($def != 1) && ($d1[attorneys_id] == 3)){
		$name=strtoupper($d1["name$def"]);
	}else{
		$name=explode(' AT ',stripslashes($history3));
		$name=explode('MAILED PAPERS TO ',$name[0]);
		$name=trim($name[1]);
		if ($name == ''){
			$name="ALL OCCUPANTS";
		}
	}
	$cord="EV".$d1[eviction_id]."-".$def."-".$serverID."%";
	 echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=300&height=40'><center>File Number: ".$d1[client_file]."<br>[PAGE]</center></td></tr>"; ?>
		<tr>
			<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top"><?=$amended?>Affidavit of Mailing</td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
		</tr>
		<tr>
			<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the <?=$altDocs?> and all other papers filed with it (the "Papers") in the above-captioned case, I, <?=$serverName?>, do hereby affirm that the contents of the following affidavit are true and correct, based on my personal knowledge:<br></td>
		</tr>
		<tr>
			<td colspan="2" style="font-weight:bold; padding-left:20px"><?=stripslashes($history3)?></td>
		</tr>      
		<tr <? if($noMail == 1){ echo 'class="dim"';}?>>
			<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this <?=strtolower($amended)?>Affidavit are true and correct, to the best of my knowledge, information and belief.  And that I mailed the above papers under section 14-102 (d) (3) (A) (ii) to <?=$name?>.<br></td>
		</tr>
		<tr <? if($noMail == 1){ echo 'class="dim"';}?>>
			<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
		</tr>
		<tr <? if($noMail == 1){ echo 'class="dim"';}?>>
			<td valign="top" style="font-size:14px">____________________________________<br />+Notary Public+<br /><br /><br />SEAL</td>
			<td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?><br><?=$_SERVER[REMOTE_ADDR]?></td> 
		</tr>
		<tr>
			<td colspan="2" style="padding-left:20px"><?=stripslashes($history4)?></td>
		</tr>
	</table>
	<? }
	 $pageIII["$def"] = ob_get_clean();
	//------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------
	}elseif($type == "pd"){ 
	ob_start();
	?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if ((strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED") && ($overRide != '1')){echo "class='dimmer'";}?>>
	<?
	$r5=@mysql_query("SELECT * from evictionSignatory where serverID='$deliveryID' AND evictionID='$packet'");
	$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
	$serverName=$d5[name];
	$serverID=$deliveryID;
	$serverAdd=$d5[address];
	$serverCity=$d5[city];
	$serverState=$d5[state];
	$serverZip=$d5[zip];
	$serverPhone=$d5[phone];
	if (!$d5){
	$q3="SELECT * from ps_users where id = '$deliveryID'";
	$r3=@mysql_query($q3) or die(mysql_error());
	$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
	$serverName=$d3[name];
	$serverAdd=$d3[address];
	$serverCity=$d3[city];
	$serverState=$d3[state];
	$serverZip=$d3[zip];
	$serverPhone=$d3[phone];
	}
	$cord="EV".$d1[eviction_id]."-".$def."-".$serverID."%";
	?> 
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=300&height=40'><center>File Number: ".$d1[client_file]."<br>[PAGE]</center></td></tr>"; ?>
		<tr>
			<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top"><?=$amended?>Affidavit of Personal Delivery</td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
		</tr>
		<tr>
			<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the <?=$altDocs?> and all other papers filed with it (the "Papers") in the above-captioned case, I, <?=$serverName?>, do hereby affirm that the contents of the following affidavit are true and correct, based on my personal knowledge:<br></td>
		</tr>
	<? if ($residentDesc){
		$desc=strtoupper(str_replace('CO-A BORROWER IN THE ABOVE-REFERENCED CASE', 'A BORROWER IN THE ABOVE-REFERENCED CASE', str_replace('BORROWER','A BORROWER IN THE ABOVE-REFERENCED CASE', attorneyCustomLang($d1[attorneys_id],strtoupper($residentDesc)))));
	}?>
		<tr>
			<td colspan="2" style="font-weight:bold; font-size:14px; padding-left:20px; padding-top:20px; padding-bottom:20px; line-height:2;"><?=stripslashes($delivery)?></td>
		</tr>       
		<tr>
			<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of <? if ($type == 'non'){ ?>section (i) of <? }?>this <?=strtolower($amended)?>Affidavit are true and correct, to the best of my knowledge, information and belief<? if ($type == 'pd' && $nondef == '1'){?>,  and that I served the <?=$altDocs?> and other papers to <? if ($resident){ echo strtoupper($resident);}else{ echo '[PERSON SERVED]';}?>, <? if ($residentDesc){echo $desc;}else{ echo '[RELATION TO DEFENDANT]';}?><? if ($serveAddress){ echo ', at '.$serveAddress;}?><? }elseif($type == 'pd' && $nondef != '1'){?>, and that I served the <?=$altDocs?> and other papers to <?=strtoupper($d1["name$def"])?><? if ($serveAddress){ echo ', at '.$serveAddress;}?><? } ?>.<br><br /></td>
		</tr>
		<tr>
			<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
		</tr>
		<tr>
			<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
			<td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?><br><?=$_SERVER[REMOTE_ADDR]?></td> 
		</tr>
	</table>
	<? 
	$pagePD["$def"] = ob_get_clean();
	$PDID["$def"]=$deliveryID;
	$PDADD["$def"]=$serveAddress;
	}
}
	//count pages and construct table of contents
	$count=0;
	$totalPages=0;
	while($count < $defs){$count++;
		if ($pageI != ''){
			$totalPages++;
		}
		if ($pageII != ''){
			//if posting server also made attempt(s), do nothing
			if ($iID==$iiID){
			}else{
			//otherwise increase counter
				$totalPages++;
			}
		}
		if ($pageIII != ''){
			$totalPages++;
		}
		if ($pagePD != ''){
			$totalPages++;
		}
	}
	$count=0;
	$currentCounter=0;
	if (strpos($defendant,"!")){
		$explode=explode('!',$defendant);
		$currentDef=$explode[0];
	}else{
		$currentDef=$defendant;
	}
	//echo first set of pages
	while($count < $defs){$count++;
		if ($pageI["$count"] != ''){
			$currentCounter++;
			if (($count==$currentDef || $currentDef=="ALL") && ($level=='Operations' || $iID==$user_id) && ($currentDef != "MAIL")){
				echo str_replace("[PAGE]","Set 1 (Affidavit $currentCounter of $totalPages)",$pageI["$count"]);
			}else{
				//echo "<script>alert('No Display Page I  count: [$count] currentDef: [$currentDef] iID: [$iID] level: [$level]')</script>";
			}
		}
		if ($pageII["$count"] != ''){
			//if posting server also made attempt(s), do nothing
			if ($iID==$iiID){
			}else{
			//otherwise increase counter
				$currentCounter++;
			}
			if (($count==$currentDef || $currentDef=="ALL") && ($level=='Operations' || $iiID==$user_id) && ($currentDef != "MAIL")){
				echo str_replace("[PAGE]","Set 1 (Affidavit $currentCounter of $totalPages)",$pageII["$count"]);
			}else{
				//echo "<script>alert('No Display Page II count: [$count] currentDef: [$currentDef] iiID: [$iiID] level: [$level]')</script>";
			}
		}
		if ($pageIII["$count"] != ''){
			$currentCounter++;
			if (($count==$currentDef || $currentDef=="ALL" || $currentDef=="MAIL") && $level=='Operations'){
				echo str_replace("[PAGE]","Set 1 (Affidavit $currentCounter of $totalPages)",$pageIII["$count"]);
			}else{
				//echo "<script>alert('No Display Page III count: [$count] currentDef: [$currentDef] level: [$level]')</script>";
			}
		}
		if ($pagePD["$count"] != ''){
			$currentCounter++;
			if (($count==$currentDef || $currentDef=="ALL") && ($level=='Operations' || $PDID["$count"]==$user_id) && ($currentDef != "MAIL")){
				echo str_replace("[PAGE]","Set 1 (Affidavit $currentCounter of $totalPages)",$pagePD["$count"]);
			}
		}
	}
	$count=0;
	$currentCounter=0;
	//echo second set of pages
	while($count < $defs){$count++;
		if ($pageI["$count"] != ''){
			$currentCounter++;
			if (($count==$currentDef || $currentDef=="ALL") && ($level=='Operations' || $iID==$user_id) && ($currentDef != "MAIL")){
				echo str_replace("[PAGE]","Set 2 (Affidavit $currentCounter of $totalPages)",$pageI["$count"]);
			}
		}
		if ($pageII["$count"] != ''){
			//if posting server also made attempt(s), do nothing
			if ($iID==$iiID){
			}else{
			//otherwise increase counter
				$currentCounter++;
			}
			if (($count==$currentDef || $currentDef=="ALL") && ($level=='Operations' || $iiID==$user_id) && ($currentDef != "MAIL")){
				echo str_replace("[PAGE]","Set 2 (Affidavit $currentCounter of $totalPages)",$pageII["$count"]);
			}
		}
		if ($pageIII["$count"] != ''){
			$currentCounter++;
			if (($count==$currentDef || $currentDef=="ALL" || $currentDef=="MAIL") && $level=='Operations'){
				echo str_replace("[PAGE]","Set 2 (Affidavit $currentCounter of $totalPages)",$pageIII["$count"]);
			}
		}
		if ($pagePD["$count"] != ''){
			$currentCounter++;
			if (($count==$currentDef || $currentDef=="ALL") && ($level=='Operations' || $PDID["$count"]==$user_id) && ($currentDef != "MAIL")){
				echo str_replace("[PAGE]","Set 2 (Affidavit $currentCounter of $totalPages)",$pagePD["$count"]);
			}
		}
	}
}
if ($_GET[level]){
	$level=$_GET[level];
}else{
	$level=$_COOKIE[psdata][level];
}
if ($_GET[user_id]){
	$user_id=$_GET[user_id];
}else{
	$user_id=$_COOKIE[psdata][user_id];
}
//execute affidavit code depending on inputs
if ($_GET[server]){
	$serveID=$_GET[server];
	if ($_GET[start]){
		$start=$_GET[start];
		if ($_GET[stop]){
			$stop=$_GET[stop];
			if ($stop < $start){
				echo "<br><br><br><center><h1 style='color:#FF0000; font-size:48px;'>THAT RANGE OF AFFIDAVITS CANNOT BE DISPLAYED.</h1></center>";
			}
			$q10="SELECT eviction_id FROM evictionPackets where server_id='$serveID' AND eviction_id >= '$start' AND eviction_id <= '$stop' AND process_status <> 'CANCELLED' AND affidavit_status='SERVICE CONFIRMED' AND filing_status <> 'PREP TO FILE' AND filing_status <> 'FILED WITH COURT' AND filing_status <> 'FILED WITH COURT - FBS' AND filing_status <> 'SEND TO CLIENT' AND affidavit_status2 <> 'AWAITING MAILING'";
		}else{
			$q10="SELECT eviction_id FROM evictionPackets where server_id='$serveID' AND eviction_id >= '$start' AND process_status <> 'CANCELLED' AND affidavit_status='SERVICE CONFIRMED' AND filing_status <> 'FILED WITH COURT' AND filing_status <> 'PREP TO FILE' AND filing_status <> 'FILED WITH COURT - FBS' AND filing_status <> 'SEND TO CLIENT' AND affidavit_status2 <> 'AWAITING MAILING'";
		}
	}else{
		$q10="SELECT eviction_id FROM evictionPackets where server_id='$serveID' AND process_status <> 'CANCELLED' AND affidavit_status='SERVICE CONFIRMED' AND filing_status <> 'FILED WITH COURT' AND filing_status <> 'PREP TO FILE' AND filing_status <> 'FILED WITH COURT - FBS' AND filing_status <> 'SEND TO CLIENT' AND affidavit_status2 <> 'AWAITING MAILING'";
	}
	$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
	while ($d10=mysql_fetch_array($r10, MYSQL_ASSOC)){
	//echo $d10[eviction_id].'<br>';
	$packet=$d10[eviction_id];
	EVmakeAffidavit($packet,"ALL",$level,$user_id);
	}
}elseif($_GET[id] && $_GET[mail]){
	if (strpos($_GET[def],"!")){
		EVmakeAffidavit($_GET[id],"MAIL!",$level,$user_id);
	}else{
		EVmakeAffidavit($_GET[id],"MAIL",$level,$user_id);
	}
}elseif ($_GET[id] && $_GET[def]){
	EVmakeAffidavit($_GET[id],$_GET[def],$level,$user_id);
}elseif($_GET[id] && !$_GET[def]){
	if (strpos($_GET[all],"!")){
		EVmakeAffidavit($_GET[id],"ALL!",$level,$user_id);
	}else{
		EVmakeAffidavit($_GET[id],"ALL",$level,$user_id);
	}
}
if ($_GET['autoPrint'] == 1){
echo "<script>
if (window.self) window.print();
self.close();
</script>";
}
?>