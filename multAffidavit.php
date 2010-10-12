<?
include 'functions.php';
@mysql_connect ();
mysql_select_db ('core');
// start output buffering
//ob_start();

function defCount($packet_id){
	$c=0;
	$r=@mysql_query("SELECT name1, name2, name3, name4, name5, name6 from ps_packets WHERE packet_id='$packet_id'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[name1]){$c++;}
	if ($d[name2]){$c++;}
	if ($d[name3]){$c++;}
	if ($d[name4]){$c++;}
	if ($d[name5]){$c++;}
	if ($d[name6]){$c++;}
	return $c;
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
table { page-break-after:always;}
</style>
<?
if ($_GET[server]){
	$serveID=$_GET[server];
	$def = 0;
}elseif ($_GET[packet]){
	$packet = $_GET[packet];
	$def = 0;
}
if ($_GET[server]){
if ($_GET[start]){
	$start=$_GET[start];
	if ($_GET[stop]){
		$stop=$_GET[stop];
		if ($stop < $start){
			echo "<br><br><br><center><h1 style='color:#FF0000; font-size:48px;'>THAT RANGE OF AFFIDAVITS CANNOT BE DISPLAYED.</h1></center>";
		}
		$q10="SELECT packet_id FROM ps_packets where (server_id='$serveID' OR server_ida='$serveID' OR server_idb='$serveID' OR server_idc='$serveID' OR server_idd='$serveID' OR server_ide='$serveID') AND packet_id >= '$start' AND packet_id <= '$stop' AND process_status <> 'CANCELLED' AND affidavit_status='SERVICE CONFIRMED' AND filing_status <> 'FILED WITH COURT' AND filing_status <> 'FILED WITH COURT - FBS'";
	}else{
		$q10="SELECT packet_id FROM ps_packets where (server_id='$serveID' OR server_ida='$serveID' OR server_idb='$serveID' OR server_idc='$serveID' OR server_idd='$serveID' OR server_ide='$serveID') AND packet_id >= '$start' AND process_status <> 'CANCELLED' AND affidavit_status='SERVICE CONFIRMED' AND filing_status <> 'FILED WITH COURT' AND filing_status <> 'FILED WITH COURT - FBS'";
	}
}else{
	$q10="SELECT packet_id FROM ps_packets where (server_id='$serveID' OR server_ida='$serveID' OR server_idb='$serveID' OR server_idc='$serveID' OR server_idd='$serveID' OR server_ide='$serveID') AND process_status <> 'CANCELLED' AND affidavit_status='SERVICE CONFIRMED' AND filing_status <> 'FILED WITH COURT' AND filing_status <> 'FILED WITH COURT - FBS'";
}
$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
while ($d10=mysql_fetch_array($r10, MYSQL_ASSOC)){
//echo $d10[packet_id].'<br>';
$packet=$d10[packet_id];
$def = 0;
$style1="style='background-color:#FFFFFF'";
$style2="style='background-color:#FFFFFF'";
$style3="style='background-color:#FFFFFF'";
$style4="style='background-color:#FFFFFF'";
$style5="style='background-color:#FFFFFF'";
$style6="style='background-color:#FFFFFF'";
while ($def < defCount($packet)){$def++;
if ($def==1){
	$style=$style1;
}elseif($def==2){
	$style=$style2;
}elseif($def==3){
	$style=$style3;
}elseif($def==4){
	$style=$style4;
}elseif($def==5){
	$style=$style5;
}elseif($def==6){
	$style=$style6;
}
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
$noMail='';
$result='';
$history='';
$historya='';
$historyb='';
$historyc='';
$historyd='';
$historye='';
?>
<div <? echo "$style";?>>
<?
// get main information
$q1="SELECT * FROM ps_packets WHERE packet_id='$packet'";
$r1=@mysql_query($q1) or die(mysql_error());
$d1=mysql_fetch_array($r1, MYSQL_ASSOC);
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
if ($d1[altPlaintiff] != ''  && $d1[attorneys_id] != '1'){
	$plaintiff = str_replace('-','<br>',$d1[altPlaintiff]);
}else{
	$plaintiff = str_replace('-','<br>',$d2[ps_plaintiff]);
}
mysql_select_db ('core');
// get service history
$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and (wizard='FIRST EFFORT' or wizard='INVALID') order by sort_value desc";
$r4=@mysql_query($q4) or die(mysql_error());
while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
	if ($d4[serverID] == $d1[server_id]){
		$attempts .= $d4[action_str];
		$iID = $d4[serverID];
	}elseif($d1[server_ida] && $d4[serverID] == $d1[server_ida]){
		$attemptsa .= $d4[action_str];
		$iIDa = $d4[serverID];
	}elseif($d1[server_idb] && $d4[serverID] == $d1[server_idb]){
		$attemptsb .= $d4[action_str];
		$iIDb = $d4[serverID];
	}elseif($d1[server_idc] && $d4[serverID] == $d1[server_idc]){
		$attemptsc .= $d4[action_str];
		$iIDc = $d4[serverID];
	}elseif($d1[server_idd] && $d4[serverID] == $d1[server_idd]){
		$attemptsd .= $d4[action_str];
		$iIDd = $d4[serverID];
	}elseif($d1[server_ide] && $d4[serverID] == $d1[server_ide]){
		$attemptse .= $d4[action_str];
		$iIDe = $d4[serverID];
	}
}
$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and wizard='SECOND EFFORT' order by sort_value";
$r4=@mysql_query($q4) or die(mysql_error());
while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
	if ($d4[serverID]==$d1[server_id]){
		$attempts .= $d4[action_str];
		$iID = $d4[serverID];
	}elseif($d1[server_ida] && $d4[serverID]==$d1[server_ida]){
		$attemptsa .= $d4[action_str];
		$iIDa = $d4[serverID];
	}elseif($d1[server_idb] && $d4[serverID]==$d1[server_idb]){
		$attemptsb .= $d4[action_str];
		$iIDb = $d4[serverID];
	}elseif($d1[server_idc] && $d4[serverID]==$d1[server_idc]){
		$attemptsc .= $d4[action_str];
		$iIDc = $d4[serverID];
	}elseif($d1[server_idd] && $d4[serverID]==$d1[server_idd]){
		$attemptsd .= $d4[action_str];
		$iIDd = $d4[serverID];
	}elseif($d1[server_ide] && $d4[serverID]==$d1[server_ide]){
		$attemptse .= $d4[action_str];
		$iIDe = $d4[serverID];
	}
}
$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'Posted Papers'";
$r4=@mysql_query($q4) or die(mysql_error());
$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
$posting = $d4[action_str];
$iiID = $d4[serverID];
$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'First Class C.R.R. Mailing'";
$r4=@mysql_query($q4) or die(mysql_error());
while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
	$mailing .= $d4[action_str];
	$crr=$d4[action_type];
	$iiiID = $d4[serverID];
}
if ($mailing == ''){
	$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'First Class Mailing'";
	$r4=@mysql_query($q4) or die(mysql_error());
	while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
		$mailing .= $d4[action_str];
		$iiiID = $d4[serverID];
		$first = $d4[action_type];
	}
}
$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'Served Defendant'";
$r4=@mysql_query($q4) or die(mysql_error());
$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
$delivery = $d4[action_str];
$deliveryID = $d4[serverID];
$serveAddress = $d4[address];
if ($delivery == ''){
	$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'Served Resident'";
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
    <tr><td>".$plaintiff."<br><small>_____________________<br /><em>Plaintiff</em></small><br /><br />v.<br /><br />";
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
$totalPages=0;
$currentPageCounter=0;
if ($type == "non"){
	$article = "14-209(b)";
	$result = "MAILING AND POSTING";
	if ($iIDe){
		$historye = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptse;
		$totalPages++;
		$currentPageCounter++;
		$currentPagee=$currentPageCounter;
	}
	if ($iIDd){
		$historyd = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptsd;
		$totalPages++;
		$currentPageCounter++;
		$currentPaged=$currentPageCounter;
	}
	if ($iIDc){
		$historyc = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptsc;
		$totalPages++;
		$currentPageCounter++;
		$currentPagec=$currentPageCounter;
	}
	if ($iIDb){
		$historyb = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptsb;
		$totalPages++;
		$currentPageCounter++;
		$currentPageb=$currentPageCounter;
	}
	if ($iIDa){
		$historya = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptsa;
		$totalPages++;
		$currentPageCounter++;
		$currentPagea=$currentPageCounter;
	}
	if ($attempts != ''){
			$history = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attempts;
			$totalPages++;
			$currentPageCounter++;
			$currentPage=$currentPageCounter;
		}elseif($attemptsa != ''){
			$history = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attemptsa;
			$iID=$iIDa;
		}
		$history2 = "<div style='font-weight:300'><u>Include the date of the posting and a description of the location of the posting on the property:</u></div>".$posting;
		if ($iID==$iiID){
		$currentPage2=$currentPageCounter;
		}else{
		$totalPages++;
		$currentPageCounter++;
		$currentPage2=$currentPageCounter;
		}
	if ($mailing == ''){
		$history3 = "<div class='dim' style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and certified mail, return receipt requested, and the name and address of the addressee:</u>
			<center><font size='36 px'>AWAITING MAILING<br>DO NOT FILE</font></center></div>";
		$noMail = 1;
		$totalPages++;
		$currentPageCounter++;
		$currentPage3=$currentPageCounter;
	}else{
		if (($iiID == $d1[server_id]) || ($first != '' && $crr == '')){
			$history3 = "<div style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and the name and address of the addressee:</u></div>
			".$mailing;
			$totalPages++;
			$currentPageCounter++;
			$currentPage3=$currentPageCounter;
		}else{
			$history3 = "<div style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and certified mail, return receipt requested, and the name and address of the addressee:</u></div>
			".$mailing;
			$totalPages++;
			$currentPageCounter++;
			$currentPage3=$currentPageCounter;
		}
	}
		$history4 = "<u>If available, the original certified mail return receipt shall be attached to the affidavit.</u><div style='height:50px; width:550px; border:double 4px; color:#666'>Affix original certified mail return receipt here.</div>";
}
if ($type == "pd"){
	$article = "14-209(a)";
	$result = "PERSONAL DELIVERY";
	$totalPages=1;
	$currentPagePD=1;
}
// ok let's really have some fun with this 
$history = attorneyCustomLang($d1[attorneys_id],$history);
$history1 = attorneyCustomLang($d1[attorneys_id],$history1);
$history2 = attorneyCustomLang($d1[attorneys_id],$history2);
$history3 = attorneyCustomLang($d1[attorneys_id],$history3);
$history4 = attorneyCustomLang($d1[attorneys_id],$history4);
$delivery = attorneyCustomLang($d1[attorneys_id],$delivery);
if ($type == "non"){
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
if ($iIDe){
	$hiID=$iIDe;
}elseif($iIDd){
	$hiID=$iIDd;
}elseif($iIDc){
	$hiID=$iIDc;
}elseif($iIDb){
	$hiID=$iIDb;
}elseif($iIDa){
	$hiID=$iIDa;
}elseif($iID){
	$hiID=$iID;
}

$r5=@mysql_query("SELECT * from ps_signatory where serverID='$hiID' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$hiID;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$hiID'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
ob_start();
if ($_COOKIE[psdata][user_id] == $hiID || $_COOKIE[psdata][level] == 'Operations' ){ ?>
<table width="80%" align="center" bgcolor="#FFFFFF" id="page1" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
 <? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery<? if ($iID && !$iIDa && !$iIDb && !$iIDc && !$iIDd && !$iIDe){ echo " and Posting";}?></td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
<? }
//Multiple servers' attemps begin here
//6th server
if ($iIDe && ($iIDe == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){ ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historye)?></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPagee; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
}
//5th server
if ($iIDd && ($iIDd == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	if ($iIDe){
?>
<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iIDd' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$iIDd;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$iIDd'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";

	echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historyd)?></td>
    </tr>    
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPaged; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
}
//4th server
if ($iIDc && ($iIDc == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	if ($iIDd || $iIDe){?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iIDc' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$iIDc;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$iIDc'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";

	echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historyc)?></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPagec; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
}
//3rd server
if ($iIDb && ($iIDb == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	if ($iIDc || $iIDd || $iIDe){?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iIDb' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$iIDb;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$iIDb'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";

	echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historyb)?></td>
    </tr>    
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPageb; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
}
//2nd server
if ($iIDa && ($iIDa == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	if ($iIDb || $iIDc || $iIDd || $iIDe){?>
<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iIDa' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$iIDa;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$iIDa'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";

	echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historya)?></td>
    </tr>      
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverSstate?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPagea; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
}
//1st server, or servera if non-Burson
if ($iID != $iIDa && ($iID == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	if ($iIDa || $iIDb || $iIDc || $iIDd || $iIDe){?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iID' AND packetID='$packet'");
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
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
 echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery<? if ($iID==$iiID){ echo " and Posting";} ?></td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($history)?></td>
    </tr>
<?
if ($iID == $iiID){
}else{
?>        
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPage; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? }
}
//Multiple servers' attempts end here
if($history2 && ($iiID == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){ 
if ($iID==$iiID){
}else{

?><table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iiID' AND packetID='$packet'");
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
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?> 
<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Posting</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px"><?=stripslashes($history2)?></td>
    </tr>
       
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPage2; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? }
if($history3 && $_COOKIE[psdata][level] == 'Operations'){ ?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iiiID' AND packetID='$packet'");
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
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?>  
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Mailing</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px"><?=stripslashes($history3)?></td>
    </tr>      
	<tr <? if($noMail == 1){ echo 'class="dim"';}?>>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct.  And that I mailed the above papers under section 14-209(b) to <?=strtoupper($d1["name$def"])?>.<br></td>
    </tr>
    <tr <? if($noMail == 1){ echo 'class="dim"';}?>>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
    <tr <? if($noMail == 1){ echo 'class="dim"';}?>>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
<? } ?>
<? if($history4 && $_COOKIE[psdata][level] == 'Operations'){ ?>
    <tr>
    	<td colspan="2" style="padding-left:20px"><?=stripslashes($history4)?></td>
    </tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPage3; ?> of <?=$totalPages?></td>
	</tr>
</table>	
<? } ?>
<? 
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
}elseif($type == "pd"){ ?>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$deliveryID' AND packetID='$packet'");
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
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?> 
<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Personal Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
<? if ($residentDesc){
	$desc=strtoupper(str_replace('CO-A BORROWER IN THE ABOVE-REFERENCED CASE', 'A BORROWER IN THE ABOVE-REFERENCED CASE', str_replace('BORROWER','A BORROWER IN THE ABOVE-REFERENCED CASE', attorneyCustomLang($d1[attorneys_id],strtoupper($residentDesc)))));
}?>
    <tr>
    	<td colspan="2" style="font-weight:bold; font-size:14px; padding-left:20px; padding-top:20px; padding-bottom:20px; line-height:2;"><?=stripslashes($delivery)?><?  if ($type == 'pd' && $d1[attorneys_id] != "1" && $nondef == '1' && $residentDesc != ''){ echo "<br />RESIDENT DESCRIPTION: ".$desc;}?></td>
    </tr>
       
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of <? if ($type == 'non'){ ?>section (i) of <? }?>this affidavit are true and correct<? if ($type == 'pd' && $d1[attorneys_id] == "1" && $nondef == '1'){?>,  and that I served the order to docket and other papers to <? if ($resident){ echo strtoupper($resident);}else{ echo '[PERSON SERVED]';}?>, <? if ($residentDesc){echo $desc;}else{ echo '[RELATION TO DEFENDANT]';}?><? if ($serveAddress){ echo ', at '.$serveAddress;}?><? }elseif($type == 'pd' && $d1[attorneys_id] == "1" && $nondef != '1'){?>, and that I served the order to docket and other papers to <?=strtoupper($d1["name$def"])?><? if ($serveAddress){ echo ', at '.$serveAddress;}?><? } ?>.<br><br /></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPagePD; ?> of <?=$totalPages?></td>
	</tr>
</table>

<? } ?>
</div>
<? }


 $buf = ob_get_clean();

  echo $buf;
 
  echo memory_get_usage()."\n";

}
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
}else{
$style="style='background-color:#FFFFFF'";
while ($def < defCount($packet)){$def++;
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
?>
<div <? echo "$style";?>>
<?
// get main information
$q1="SELECT * FROM ps_packets WHERE packet_id='$packet' AND affidavit_status='SERVICE CONFIRMED'";
$r1=@mysql_query($q1) or die(mysql_error());
$d1=mysql_fetch_array($r1, MYSQL_ASSOC);
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
if ($d1[altPlaintiff] != ''  && $d1[attorneys_id] != '1'){
	$plaintiff = str_replace('-','<br>',$d1[altPlaintiff]);
}else{
	$plaintiff = str_replace('-','<br>',$d2[ps_plaintiff]);
}
mysql_select_db ('core');
// get service history
$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and (wizard='FIRST EFFORT' or wizard='INVALID') order by sort_value desc";
$r4=@mysql_query($q4) or die(mysql_error());
while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
	if ($d4[serverID] == $d1[server_id]){
		$attempts .= $d4[action_str];
		$iID = $d4[serverID];
	}elseif($d1[server_ida] && $d4[serverID] == $d1[server_ida]){
		$attemptsa .= $d4[action_str];
		$iIDa = $d4[serverID];
	}elseif($d1[server_idb] && $d4[serverID] == $d1[server_idb]){
		$attemptsb .= $d4[action_str];
		$iIDb = $d4[serverID];
	}elseif($d1[server_idc] && $d4[serverID] == $d1[server_idc]){
		$attemptsc .= $d4[action_str];
		$iIDc = $d4[serverID];
	}elseif($d1[server_idd] && $d4[serverID] == $d1[server_idd]){
		$attemptsd .= $d4[action_str];
		$iIDd = $d4[serverID];
	}elseif($d1[server_ide] && $d4[serverID] == $d1[server_ide]){
		$attemptse .= $d4[action_str];
		$iIDe = $d4[serverID];
	}
}

$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and wizard='SECOND EFFORT' order by sort_value";
$r4=@mysql_query($q4) or die(mysql_error());
while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
	if ($d4[serverID]==$d1[server_id]){
		$attempts .= $d4[action_str];
		$iID = $d4[serverID];
	}elseif($d1[server_ida] && $d4[serverID]==$d1[server_ida]){
		$attemptsa .= $d4[action_str];
		$iIDa = $d4[serverID];
	}elseif($d1[server_idb] && $d4[serverID]==$d1[server_idb]){
		$attemptsb .= $d4[action_str];
		$iIDb = $d4[serverID];
	}elseif($d1[server_idc] && $d4[serverID]==$d1[server_idc]){
		$attemptsc .= $d4[action_str];
		$iIDc = $d4[serverID];
	}elseif($d1[server_idd] && $d4[serverID]==$d1[server_idd]){
		$attemptsd .= $d4[action_str];
		$iIDd = $d4[serverID];
	}elseif($d1[server_ide] && $d4[serverID]==$d1[server_ide]){
		$attemptse .= $d4[action_str];
		$iIDe = $d4[serverID];
	}
}

$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'Posted Papers'";
$r4=@mysql_query($q4) or die(mysql_error());
$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
$posting = $d4[action_str];
$iiID = $d4[serverID];

$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'First Class C.R.R. Mailing'";
$r4=@mysql_query($q4) or die(mysql_error());
while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
	$mailing .= $d4[action_str];
	$crr=$d4[action_type];
	$iiiID = $d4[serverID];
}
if ($mailing == ''){
	$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'First Class Mailing'";
	$r4=@mysql_query($q4) or die(mysql_error());
	while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
		$mailing .= $d4[action_str];
		$iiiID = $d4[serverID];
		$first = $d4[action_type];
	}
}

$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'Served Defendant'";
$r4=@mysql_query($q4) or die(mysql_error());
$d4=mysql_fetch_array($r4, MYSQL_ASSOC);
$delivery = $d4[action_str];
$deliveryID = $d4[serverID];
$serveAddress = $d4[address];
if ($delivery == ''){
	$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and action_type = 'Served Resident'";
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
    <tr><td>".$plaintiff."<br><small>_____________________<br /><em>Plaintiff</em></small><br /><br />v.<br /><br />";
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
$totalPages=0;
$currentPageCounter=0;
if ($type == "non"){
	$article = "14-209(b)";
	$result = "MAILING AND POSTING";
	if ($iIDe){
		$historye = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptse;
		$totalPages++;
		$currentPageCounter++;
		$currentPagee=$currentPageCounter;
	}
	if ($iIDd){
		$historyd = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptsd;
		$totalPages++;
		$currentPageCounter++;
		$currentPaged=$currentPageCounter;
	}
	if ($iIDc){
		$historyc = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptsc;
		$totalPages++;
		$currentPageCounter++;
		$currentPagec=$currentPageCounter;
	}
	if ($iIDb){
		$historyb = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptsb;
		$totalPages++;
		$currentPageCounter++;
		$currentPageb=$currentPageCounter;
	}
	if ($iIDa){
		$historya = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
				".$attemptsa;
		$totalPages++;
		$currentPageCounter++;
		$currentPagea=$currentPageCounter;
	}
	if ($attempts != ''){
			$history = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attempts;
			$totalPages++;
			$currentPageCounter++;
			$currentPage=$currentPageCounter;
		}elseif($attemptsa != ''){
			$history = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attemptsa;
			$iID=$iIDa;
		}
		$history2 = "<div style='font-weight:300'><u>Include the date of the posting and a description of the location of the posting on the property:</u></div>".$posting;
		if ($iID==$iiID){
		$currentPage2=$currentPageCounter;
		}else{
		$totalPages++;
		$currentPageCounter++;
		$currentPage2=$currentPageCounter;
		}
	if ($mailing == ''){
		$history3 = "<div class='dim' style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and certified mail, return receipt requested, and the name and address of the addressee:</u>
			<center><font size='36 px'>AWAITING MAILING<br>DO NOT FILE</font></center></div>";
		$noMail = 1;
		$totalPages++;
		$currentPageCounter++;
		$currentPage3=$currentPageCounter;
	}else{
		if (($iiID == $d1[server_id]) || ($first != '' && $crr == '')){
			$history3 = "<div style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and the name and address of the addressee:</u></div>
			".$mailing;
			$totalPages++;
			$currentPageCounter++;
			$currentPage3=$currentPageCounter;
		}else{
			$history3 = "<div style='font-weight:300'><u>State the date on which the required papers were mailed by first-class and certified mail, return receipt requested, and the name and address of the addressee:</u></div>
			".$mailing;
			$totalPages++;
			$currentPageCounter++;
			$currentPage3=$currentPageCounter;
		}
	}
		$history4 = "<u>If available, the original certified mail return receipt shall be attached to the affidavit.</u><div style='height:50px; width:550px; border:double 4px; color:#666'>Affix original certified mail return receipt here.</div>";
}
if ($type == "pd"){
	$article = "14-209(a)";
	$result = "PERSONAL DELIVERY";
	$totalPages=1;
	$currentPagePD=1;
}
// ok let's really have some fun with this 
$history = attorneyCustomLang($d1[attorneys_id],$history);
$history1 = attorneyCustomLang($d1[attorneys_id],$history1);
$history2 = attorneyCustomLang($d1[attorneys_id],$history2);
$history3 = attorneyCustomLang($d1[attorneys_id],$history3);
$history4 = attorneyCustomLang($d1[attorneys_id],$history4);
$delivery = attorneyCustomLang($d1[attorneys_id],$delivery);
if ($type == "non"){
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
if ($iIDe){
	$hiID=$iIDe;
}elseif($iIDd){
	$hiID=$iIDd;
}elseif($iIDc){
	$hiID=$iIDc;
}elseif($iIDb){
	$hiID=$iIDb;
}elseif($iIDa){
	$hiID=$iIDa;
}elseif($iID){
	$hiID=$iID;
}

$r5=@mysql_query("SELECT * from ps_signatory where serverID='$hiID' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$hiID;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$hiID'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";


ob_start();

if ($_COOKIE[psdata][user_id] == $hiID || $_COOKIE[psdata][level] == 'Operations' ){ 
?>    
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery<? if ($iID && !$iIDa && !$iIDb && !$iIDc && !$iIDd && !$iIDe){ echo " and Posting";}?></td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
<? }
//Multiple servers' attemps begin here
//6th server
if ($iIDe && ($iIDe == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	$historye = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attemptse;
?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historye)?></td>
    </tr>   
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPagee; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
}?>

<?

//5th server
if ($iIDd && ($iIDd == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	$historyd = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attemptsd;
 if ($iIDe){
?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iIDd' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$iIDd;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$iIDd'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?>        
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historyd)?></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPaged; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
} ?>


<?
//4th server
if ($iIDc && ($iIDc == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	$historyc = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attemptsc;
if ($iIDd || $iIDe){?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iIDc' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$iIDc;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$iIDc'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?>
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historyc)?></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPagec; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
} ?>



<?
//3rd server
if ($iIDb && ($iIDb == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	$historyb = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attemptsb;
if ($iIDc || $iIDd || $iIDe){?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iIDb' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$iIDb;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$iIDb'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?>   
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historyb)?></td>
    </tr>     
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPageb; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
}?>


<?
//2nd server
if ($iIDa && ($iIDa == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
	$historya = "<div style='font-weight:300'><u>Describe with particularity the good faith efforts to serve the mortgagor or grantor, ".$d1["name$def"].",  by personal delivery:</u></div>
			".$attemptsa;
if ($iIDb || $iIDc || $iIDd || $iIDe){?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iIDa' AND packetID='$packet'");
$d5=mysql_fetch_array($r5, MYSQL_ASSOC);
$serverName=$d5[name];
$serverID=$iIDa;
$serverAdd=$d5[address];
$serverCity=$d5[city];
$serverState=$d5[state];
$serverZip=$d5[zip];
$serverPhone=$d5[phone];
if (!$d5){
$q3="SELECT * from ps_users where id = '$iIDa'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
$serverName=$d3[name];
$serverAdd=$d3[address];
$serverCity=$d3[city];
$serverState=$d3[state];
$serverZip=$d3[zip];
$serverPhone=$d3[phone];
}
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?>  
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($historya)?></td>
    </tr>      
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />+Notary Public+<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverSstate?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPagea; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? 
} 
//1st server, or servera if non-Burson
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
if ($iID != $iIDa && ($iID == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){
if ($iIDa || $iIDb || $iIDc || $iIDd || $iIDe){?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
 <? 
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iID' AND packetID='$packet'");
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
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
 echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Attempted Delivery<? if ($iID==$iiID){ echo " and Posting";} ?></td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($history)?></td>
    </tr>
<?
if ($iID == $iiID){
}else{
?>        
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct<? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?><? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served the Order to Docket and all other papers filed with it to [PERSON SERVED]<? }?>.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action<? if ($type != 'non' && $d1[attorneys_id] == "1"){ ?> and that I served [PERSON SERVED], [RELATION TO DEFENDANT]<? }?><? if ($type == 'non' && $d1[attorneys_id] == "1"){ ?> and that I did attempt service as set forth above<? }?>.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />+Notary Public+<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPage; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? }?>

<? }
//Multiple servers' attempts end here
if($history2 && ($iiID == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][level] == 'Operations')){ 
if ($iID==$iiID){
}else{
?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iiID' AND packetID='$packet'");
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
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?> 
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Posting</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <? } ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px"><?=stripslashes($history2)?></td>
    </tr>       
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct.<br></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPage2; ?> of <?=$totalPages?></td>
	</tr>
    </table>
<? } ?>


<? if($history3 && $_COOKIE[psdata][level] == 'Operations'){ ?>
	<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$iiiID' AND packetID='$packet'");
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
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?>  
	<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Mailing</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px"><?=stripslashes($history3)?></td>
    </tr>      
	<tr <? if($noMail == 1){ echo 'class="dim"';}?>>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct.  And that I mailed the above papers under section 14-209(b) to <?=strtoupper($d1["name$def"])?>.<br></td>
    </tr>
    <tr <? if($noMail == 1){ echo 'class="dim"';}?>>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
    <tr <? if($noMail == 1){ echo 'class="dim"';}?>>
    	<td valign="top" style="font-size:14px">____________________________________<br />+Notary Public+<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
<? } ?>
<? if($history4 && $_COOKIE[psdata][level] == 'Operations'){ ?>
    <tr>
    	<td colspan="2" style="padding-left:20px"><?=stripslashes($history4)?></td>
    </tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPage3; ?> of <?=$totalPages?></td>
	</tr>
</table>	
<? } ?>
<? 
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
}elseif($type == "pd"){ ?>









<table width="80%" align="center" bgcolor="#FFFFFF" <? if (strtoupper($d1[affidavit_status]) != "SERVICE CONFIRMED"){echo "class='dimmer'";}?>>
<?
$r5=@mysql_query("SELECT * from ps_signatory where serverID='$deliveryID' AND packetID='$packet'");
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
$cord=$d1[packet_id]."-".$def."-".$serverID."%";
?> 
<? echo "<tr>".$header."<IMG SRC='barcode.php?barcode=".$cord."&width=250&height=40'><center>File Number: ".$d1[client_file]."</center></td></tr>"; ?>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Personal Delivery</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
<? if ($residentDesc){
	$desc=strtoupper(str_replace('CO-A BORROWER IN THE ABOVE-REFERENCED CASE', 'A BORROWER IN THE ABOVE-REFERENCED CASE', str_replace('BORROWER','A BORROWER IN THE ABOVE-REFERENCED CASE', attorneyCustomLang($d1[attorneys_id],strtoupper($residentDesc)))));
}?>
    <tr>
    	<td colspan="2" style="font-weight:bold; font-size:14px; padding-left:20px; padding-top:20px; padding-bottom:20px; line-height:2;"><?=stripslashes($delivery)?><?  if ($type == 'pd' && $d1[attorneys_id] != "1" && $nondef == '1' && $residentDesc != ''){ echo "<br />RESIDENT DESCRIPTION: ".$desc;}?></td>
    </tr>       
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of <? if ($type == 'non'){ ?>section (i) of <? }?>this affidavit are true and correct<? if ($type == 'pd' && $d1[attorneys_id] == "1" && $nondef == '1'){?>,  and that I served the order to docket and other papers to <? if ($resident){ echo strtoupper($resident);}else{ echo '[PERSON SERVED]';}?>, <? if ($residentDesc){echo $desc;}else{ echo '[RELATION TO DEFENDANT]';}?><? if ($serveAddress){ echo ', at '.$serveAddress;}?><? }elseif($type == 'pd' && $d1[attorneys_id] == "1" && $nondef != '1'){?>, and that I served the order to docket and other papers to <?=strtoupper($d1["name$def"])?><? if ($serveAddress){ echo ', at '.$serveAddress;}?><? } ?>.<br><br /></td>
    </tr>
    <tr>
    	<td colspan="2">I, <?=$serverName?>, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
    <tr>
    	<td valign="top" style="font-size:14px">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top" style="font-size:14px">________________________<u>DATE:</u>________<br /><?=$serverName?><br /><?=$serverAdd?><br /><?=$serverCity?>, <?=$serverState?> <?=$serverZip?><br /><?=$serverPhone?></td> 
	</tr>
	<tr>
		<td colspan="2" align="center">Page <? echo $currentPagePD; ?> of <?=$totalPages?></td>
	</tr>
</table>
<? } ?>
</div>
<? }
} 
// end output buffering
 $buf = ob_get_clean();

  echo $buf;
 
/*
$contents = ob_get_contents();


require_once("/var/www/dompdf-0.5.1/dompdf_config.inc.php");



 $html = stripslashes($contents);
  
  $old_limit = ini_set("memory_limit", "50M");
  
  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $dompdf->set_paper('letter', 'portrait');
  $dompdf->render();
  $key = md5(time());
  $unique = '/var/www/dataFiles/tmp/'.$key.'.PDF';
  $load = 'http://mdwestserve.com/tmp/'.$key.'.PDF';
  file_put_contents($unique, $dompdf->output()); //save to disk
 <script>window.location.href='<?=$load?>'</script>
*/
  ?>
  
<script type="text/javascript">
var browser=navigator.appName;

if (browser == 'Microsoft Internet Explorer'){
alert('Unable to load in IE, we will now take you to why...');
location.href='http://www.google.com/search?hl=en&q=ie7+css+page+break+bug';
}
</script>
