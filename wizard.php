<?

if (!$_POST['i']){
$i='a';
}else{
$i=$_POST['i'];
}

$server = $_COOKIE[psdata][user_id];
$part = explode('-',$_POST[parts]);
$packet = $part[0];
$defendant = $part[1];
$defName = $parts;
if (!$defName){
$lock=1; // unlocked
}else{	
$lock=2; // locked 
}

include 'common.php';
if ($_GET[jump]){
	include 'wizard.jump.php';
	die();
}
//include 'menu.php';
mysql_select_db ('core');

function alpha2desc($alpha){
	if ($alpha == 'a'){ return "FIRST DOT ATTEMPT"; }
	if ($alpha == 'b'){ return "SECOND DOT ATTEMPT"; }
	if ($alpha == 'c'){ return "POSTED DOT PROPERTY"; }
	if ($alpha == 'd'){ return "FIRST LKA ATTEMPT"; }
	if ($alpha == 'e'){ return "SECOND LKA ATTEMPT"; }
	if ($alpha == 'f'){ return "FIRST ALT ATTEMPT"; }
	if ($alpha == 'g'){ return "SECOND ALT ATTEMPT"; }
	if ($alpha == 'h'){ return "FIRST ALT ATTEMPT"; }
	if ($alpha == 'i'){ return "SECOND ALT ATTEMPT"; }
	if ($alpha == 'j'){ return "FIRST ALT ATTEMPT"; }
	if ($alpha == 'k'){ return "SECOND ALT ATTEMPT"; }
	if ($alpha == 'l'){ return "FIRST ALT ATTEMPT"; }
	if ($alpha == 'm'){ return "SECOND ALT ATTEMPT"; }
}
function alpha2add($alpha){
	if ($alpha == 'a' || $alpha == 'b' || $alpha == 'c'){ return 1; }
	if ($alpha == 'd' || $alpha == 'e'){ return 2; }
	if ($alpha == 'f' || $alpha == 'g'){ return 3; }
	if ($alpha == 'i' || $alpha == 'h'){ return 4; }
	if ($alpha == 'j' || $alpha == 'k'){ return 5; }
	if ($alpha == 'l' || $alpha == 'm'){ return 6; }
}
function photoAddress($packet,$defendant,$alpha){
	$r=@mysql_query("SELECT * from ps_packets where packet_id = '$packet'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($alpha == "a" || $alpha == "b"|| $alpha == "c"){
		if ($d["address$defendant"]){
			return $d["address$defendant"].", ".$d["state$defendant"];
		}
	}
	if ($alpha == "d" || $alpha == "e"){
		if ($d["address$defendant"."a"]){
			return $d["address$defendant"."a"].", ".$d["state$defendant"."a"];
		}
	}
	if ($alpha == "f" || $alpha == "g"){
		if ($d["address$defendant"."b"]){
			return $d["address$defendant"."b"].", ".$d["state$defendant"."b"];
		}
	}
	if ($alpha == "h" || $alpha == "i"){
		if ($d["address$defendant"."c"]){
			return $d["address$defendant"."c"].", ".$d["state$defendant"."c"];
		}
	}
	if ($alpha == "j" || $alpha == "k"){
		if ($d["address$defendant"."d"]){
			return $d["address$defendant"."d"].", ".$d["state$defendant"."d"];
		}
	}
	if ($alpha == "l" || $alpha == "m"){
		if ($d["address$defendant"."e"]){
			return $d["address$defendant"."e"].", ".$d["state$defendant"."e"];
		}
	}
}

function servers($current){
	$q= "select * from ps_users where level='Gold Member' OR level = 'Operations' order by level DESC, name ";
	$r=@mysql_query($q);
	if ($current){
	$option .= "<option value='$current'>*Operations Recording ".strtoupper(id2name($_COOKIE[psdata][user_id]))." as ".strtoupper(id2name($current))."</option>";
	}else{
	$option .= "<option value='$current'>+++ NO SERVER SELECTED FOR RECORDING +++</option>";
	}
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {
	   		$option .= "<option value='$d[id]' style='font-style:italic'>Switch to $d[name]</option>";
	} 
	return $option;
}

function mkmonth($keep){
	//if (!$keep){$keep = date('M');}
	$opt = "<option selected value='$keep'>$keep</option>";
	$opt .= "<option value='01'>1</option>";
	$opt .= "<option value='02'>2</option>";
	$opt .= "<option value='03'>3</option>";
	$opt .= "<option value='04'>4</option>";
	$opt .= "<option value='05'>5</option>";
	$opt .= "<option value='06'>6</option>";
	$opt .= "<option value='07'>7</option>";
	$opt .= "<option value='08'>8</option>";
	$opt .= "<option value='09'>9</option>";
	$opt .= "<option value='10'>10</option>";
	$opt .= "<option value='11'>11</option>";
	$opt .= "<option value='12'>12</option>";
	return $opt;
}
function mkday($keep){
	$opt = "<option selected value='$keep'>$keep</option>";
	$opt .= "<option value='01'>1</option>";
	$opt .= "<option value='02'>2</option>";
	$opt .= "<option value='03'>3</option>";
	$opt .= "<option value='04'>4</option>";
	$opt .= "<option value='05'>5</option>";
	$opt .= "<option value='06'>6</option>";
	$opt .= "<option value='07'>7</option>";
	$opt .= "<option value='08'>8</option>";
	$opt .= "<option value='09'>9</option>";
	$opt .= "<option value='10'>10</option>";
	$opt .= "<option value='11'>11</option>";
	$opt .= "<option value='12'>12</option>";
	$opt .= "<option value='13'>13</option>";
	$opt .= "<option value='14'>14</option>";
	$opt .= "<option value='15'>15</option>";
	$opt .= "<option value='16'>16</option>";
	$opt .= "<option value='17'>17</option>";
	$opt .= "<option value='18'>18</option>";
	$opt .= "<option value='19'>19</option>";
	$opt .= "<option value='20'>20</option>";
	$opt .= "<option value='21'>21</option>";
	$opt .= "<option value='22'>22</option>";
	$opt .= "<option value='23'>23</option>";
	$opt .= "<option value='24'>24</option>";
	$opt .= "<option value='25'>25</option>";
	$opt .= "<option value='26'>26</option>";
	$opt .= "<option value='27'>27</option>";
	$opt .= "<option value='28'>28</option>";
	$opt .= "<option value='29'>29</option>";
	$opt .= "<option value='30'>30</option>";
	$opt .= "<option value='31'>31</option>";
	return $opt;
}
function mkminute($keep){
	$opt = "<option selected value='$keep'>$keep</option>";
	$opt .= "<option value='00'>00</option>";
	$opt .= "<option value='01'>01</option>";
	$opt .= "<option value='02'>02</option>";
	$opt .= "<option value='03'>03</option>";
	$opt .= "<option value='04'>04</option>";
	$opt .= "<option value='05'>05</option>";
	$opt .= "<option value='06'>06</option>";
	$opt .= "<option value='07'>07</option>";
	$opt .= "<option value='08'>08</option>";
	$opt .= "<option value='09'>09</option>";
	$opt .= "<option value='10'>10</option>";
	$opt .= "<option value='11'>11</option>";
	$opt .= "<option value='12'>12</option>";
	$opt .= "<option value='13'>13</option>";
	$opt .= "<option value='14'>14</option>";
	$opt .= "<option value='15'>15</option>";
	$opt .= "<option value='16'>16</option>";
	$opt .= "<option value='17'>17</option>";
	$opt .= "<option value='18'>18</option>";
	$opt .= "<option value='19'>19</option>";
	$opt .= "<option value='20'>20</option>";
	$opt .= "<option value='21'>21</option>";
	$opt .= "<option value='22'>22</option>";
	$opt .= "<option value='23'>23</option>";
	$opt .= "<option value='24'>24</option>";
	$opt .= "<option value='25'>25</option>";
	$opt .= "<option value='26'>26</option>";
	$opt .= "<option value='27'>27</option>";
	$opt .= "<option value='28'>28</option>";
	$opt .= "<option value='29'>29</option>";
	$opt .= "<option value='30'>30</option>";
	$opt .= "<option value='31'>31</option>";
	$opt .= "<option value='32'>32</option>";
	$opt .= "<option value='33'>33</option>";
	$opt .= "<option value='34'>34</option>";
	$opt .= "<option value='35'>35</option>";
	$opt .= "<option value='36'>36</option>";
	$opt .= "<option value='37'>37</option>";
	$opt .= "<option value='38'>38</option>";
	$opt .= "<option value='39'>39</option>";
	$opt .= "<option value='40'>40</option>";
	$opt .= "<option value='41'>41</option>";
	$opt .= "<option value='42'>42</option>";
	$opt .= "<option value='43'>43</option>";
	$opt .= "<option value='44'>44</option>";
	$opt .= "<option value='45'>45</option>";
	$opt .= "<option value='46'>46</option>";
	$opt .= "<option value='47'>47</option>";
	$opt .= "<option value='48'>48</option>";
	$opt .= "<option value='49'>49</option>";
	$opt .= "<option value='50'>50</option>";
	$opt .= "<option value='51'>51</option>";
	$opt .= "<option value='52'>52</option>";
	$opt .= "<option value='53'>53</option>";
	$opt .= "<option value='54'>54</option>";
	$opt .= "<option value='55'>55</option>";
	$opt .= "<option value='56'>56</option>";
	$opt .= "<option value='57'>57</option>";
	$opt .= "<option value='58'>58</option>";
	$opt .= "<option value='59'>59</option>";
	return $opt;
}
function mkyear($keep){
	$opt = "<option selected value='$keep'>$keep</option>";
	$curYear=date('Y');
	//dynamically start range 3 years before current year.
	$year=$curYear-3;
	while ($year <= $curYear){
		$opt .= "<option value='$year'>$year</option>";
		$year++;
	}
	return $opt;
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
function mkAlert($alertStr,$entryID,$serverID,$packetID){
	mysql_select_db('core');
	@mysql_query("INSERT INTO ps_alert (alertStr, entryID, entryTime, serverID, packetID) VALUES ('$alertStr', '$entryID', NOW(), '$serverID', '$packetID')");
}
function serverFiled($county, $server){
	if ($county == 'ALLEGANY'){
		return 1;
	}elseif ($county == 'CALVERT'){
		return 1;
	}elseif ($county == 'CAROLINE'){
		return 1;
	}elseif ($county == 'CHARLES'){
		return 1;
	}elseif ($county == 'DORCHESTER'){
		return 1;
	}elseif ($county == 'FREDERICK'){
		return 1;
	}elseif ($county == 'GARRETT'){
		return 1;
	}elseif ($county == 'ST MARYS'){
		return 1;
	}elseif ($county == 'SOMERSET'){
		return 1;
	}elseif ($county == 'TALBOT'){
		return 1;
	}elseif ($county == 'WASHINGTON'){
		return 1;
	}elseif ($county == 'PRINCE GEORGES' && $server == '267'){
		return 1;
	}
}
function photoCount($packet,$defendant){
	$count=0;
	if ($defendant == 'ALL'){
		$q="SELECT * FROM ps_photos WHERE packetID='$packet'";
	}else{
		$q="SELECT * FROM ps_photos WHERE packetID='$packet' AND defendantID='$defendant'";
	}
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$count++;	}
	return $count;
}
function historyList($packet,$attorneys_id){
	$qn="SELECT * FROM ps_history WHERE packet_id = '$packet' order by defendant_id, history_id ASC";
	$rn=@mysql_query($qn) or die ("Query: $qn<br>".mysql_error());
	$counter=0;
	while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){$counter++;
		$action_str=str_replace('<LI>','',strtoupper($dn[action_str]));
		$action_str=str_replace('</LI>','',$action_str);
			$list .=  "<li>#$dn[history_id] : ".id2server($dn[serverID]).' '.$dn[wizard].'<br>'.stripslashes(attorneyCustomLang($attorneys_id,$action_str));
			if ($dn[wizard] == 'BORROWER' || $dn[wizard] == 'NOT BORROWER'){
				$list .=  '<br>'.attorneyCustomLang($attorneys_id,$dn[residentDesc]);
			}
			$list .= "</li>";
	}
	return $list;
}
function explodeDesc($str){
	$desc=explode('<BR>',$str);
	$count=count($desc)-1;
	return $desc["$count"];
}
function explodeAge($str){
	$age=explode(' YEARS OF AGE,',$str);
	$age=explode(', ',$age[0]);
	$count=count($age)-1;
	return trim($age["$count"]);
}
function getAddressType($address){
	$return='';
	$r = @mysql_query("SELECT addressType, addressTypea, addressTypeb, addressTypec, addressTyped, addressTypee, address1, city1, state1, zip1, address1a, city1a, state1a, zip1a, address1b, city1b, state1b, zip1b, address1c, city1c, state1c, zip1c, address1d, city1d, state1d, zip1d, address1e, city1e, state1e, zip1e from ps_packets where packet_id = '$packet' LIMIT 0,1");
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[address1] != ''){
		$add=$d[address1].', '.$d[city1].', '.$d[state1].' '.$d[zip1];
		if ($address == $add){
			$return=$d[addressType];
		}
	}
	foreach (range('a','e') as $letter){
		if ($d["address1$letter"] != ''){
			$add=$d["address1$letter"].', '.$d["city1$letter"].', '.$d["state1$letter"].' '.$d["zip1$letter"];
			if ($address == $add){
				$return=$d["addressType$letter"];
			}
		}
	}
	if ($return == ''){
		$return='KNOWN ADDRESS';
	}
	return $return;
}
function getLetter($str){
	$str=str_replace('/data/service/photos/','',$str);
	$str=str_replace('-','.',$str);
	//if file is in packet folder
	if (strpos($str,'/') !== false){
		$explode=explode('.',$str);
		$letter=$explode[1];
	}else{
		$explode=explode('.',$str);
		$letter=$explode[2];
	}
	return $letter;
}
function getPhoto($photoID){
	$r=@mysql_query("SELECT * from ps_photos WHERE photoID='$photoID' LIMIT 0,1");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[localPath];
}
mysql_select_db ('core');
$qqr = @mysql_query("SELECT * from ps_packets where packet_id = '$packet'");
$ddr = mysql_fetch_array($qqr, MYSQL_ASSOC);
if ($defendant != 'ALL'){
	$dname = $ddr["name$defendant"];
}else{
	$dname = "ALL DEFENDANTS";
	$defendant=1;
	$all=1;
}
$daddy = $ddr["address$defendant"].', '.$ddr["city$defendant"].', '.$ddr["state$defendant"].' '.$ddr["zip$defendant"].' - <b>'.initals(id2name($ddr[server_id])).'</b>';
$vera=$defendant.'a';
$verb=$defendant.'b';
$verc=$defendant.'c';
$verd=$defendant.'d';
$vere=$defendant.'e';
if ($ddr["address$vera"]){
	$addressa=strtoupper($ddr["address$vera"].', '.$ddr["city$vera"].', '.$ddr["state$vera"].' '.$ddr["zip$vera"]).' - <b>'.initals(id2name($ddr[server_ida])).'</b>';
	$daddya="<br><small>$addressa</small>";
}
if ($ddr["address$verb"]){
	$addressb=strtoupper($ddr["address$verb"].', '.$ddr["city$verb"].', '.$ddr["state$verb"].' '.$ddr["zip$verb"]).' - <b>'.initals(id2name($ddr[server_idb])).'</b>';
	$daddyb="<br><small>$addressb</small>";
}
if ($ddr["address$verc"]){
	$addressc=strtoupper($ddr["address$verc"].', '.$ddr["city$verc"].', '.$ddr["state$verc"].' '.$ddr["zip$verc"]).' - <b>'.initals(id2name($ddr[server_idc])).'</b>';
	$daddyc="<br><small>$addressc</small>";
}
if ($ddr["address$verd"]){
	$addressd=strtoupper($ddr["address$verd"].', '.$ddr["city$verd"].', '.$ddr["state$verd"].' '.$ddr["zip$verd"]).' - <b>'.initals(id2name($ddr[server_idd])).'</b>';
	$daddyd="<br><small>$addressd</small>";
}
if ($ddr["address$vere"]){
	$addresse=strtoupper($ddr["address$vere"].', '.$ddr["city$vere"].', '.$ddr["state$vere"].' '.$ddr["zip$vere"]).' - <b>'.initals(id2name($ddr[server_ide])).'</b>';
	$daddye="<br><small>$addresse</small>";
}
if ($ddr["pobox"]){
	$addresspo=strtoupper($ddr["pobox"].', '.$ddr["pocity"].', '.$ddr["postate"].' '.$ddr["pozip"]);
	$daddypo="<br><small>$addresspo</small>";
}
$info = "<div>Packet: $packet</div>";
$info .= "<div>Defendant: $dname</div>";
$info .= "<div>Address: $daddy</div>";
if ($_POST[opServer]){
$info .= "<div>Updated By: ".id2name($server)." for ".id2name($_POST[opServer])."</div>";
}else{
$info .= "<div>Entered By: ".id2name($server)."</div>";
}
?>
<SCRIPT language="JavaScript">
function hideshow(which){
	if (!document.getElementById)
		return
	if (which.style.display=="block")
		which.style.display="none"
	else
		which.style.display="block"
}
function submitLoader(){
	//hideshow(document.getElementById('loading'));
	//hideshow(document.getElementById('navSystem'));
	document.wizard.submit();
}
function submitLoaderRestart(){
	hideshow(document.getElementById('loading'));
	document.restart.submit();
}
</script>
<style>
.nav0 { display:none;}
.nav { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#CCFFFF; border:solid 1px #00FF00;}
.nav2 { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#FF9999; border:solid 1px #FF0000;}
.nav3 { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#FFFFCC; border:solid 1px #FFFF00;}
.nav4 { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#00CCFF; border:solid 1px #00FFFF;}
.photoa, .photob, .photoc { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#00FFCC; border:solid 1px #000000;}
.photod, .photoe { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#FFCC99; border:solid 1px #000000;}
.photof, .photog { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#99CCFF; border:solid 1px #000000;}
.photoh, .photoi { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#CC99FF; border:solid 1px #000000;}
.photoj, .photok { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#FFFF99; border:solid 1px #000000;}
.photol, .photom { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#993333; border:solid 1px #000000;}
</style>
<?
mysql_select_db ('core');
?>
<body bgcolor="#CCFFFF" style="padding:0px;">
<? 
if ($_GET[mailDate]){
	$mailDate=$_GET[mailDate];
}elseif($_POST[mailDate]){
	$mailDate=$_POST[mailDate];
}
hardLog(' ['.$i.'] '.$_POST[served].' '.$_POST[service_type].' '.$_POST[parts],'contractor'); 
@mysql_query("insert into explorer (date,date_time,user,packet,uri) values (NOW(),NOW(),'".$_COOKIE[psdata][name]."','$_POST[parts]','$i $_POST[service_type]')") or die(mysql_error());
if (is_array($_POST[served])){
	$servedTitle='EDITING';
}else{
	$servedTitle=$_POST[served];
}
?>
<title>Affidavit Wizard <?=$_POST[service_type]?> &gt; <?=$servedTitle?> &gt; <?=$_POST[parts]?></title>
<? if ($_COOKIE[psdata][level] === "Operations"){ ?>
<table align="center" style="padding:0px;"><tr><td valign="top">
<? } ?>
<table align="center" style="padding:0px;"><tr><td>
<fieldset style="background-color:#FFFFFF;"><legend style=" background-color:#FFFFCC; border:double 1px #999999; padding:0px;">
<? if ($all == 1){ $defendant='ALL';}?>
DEFENDANT: <a href="wizard.php?jump=<?=$packet?>-1<? if ($mailDate){ echo "&mailDate=".$mailDate;} ?>"><?if ($defendant == '1'){ echo "<b>1</b>";}else{ echo "1";}?></a>
<? if ($ddr[name2]){?> <a href="wizard.php?jump=<?=$packet?>-2<? if ($mailDate){ echo "&mailDate=".$mailDate;} ?>"><?if ($defendant == '2'){ echo "<b>2</b>";}else{ echo "2";}?></a> <? } ?>
<? if ($ddr[name3]){?> <a href="wizard.php?jump=<?=$packet?>-3<? if ($mailDate){ echo "&mailDate=".$mailDate;} ?>"><?if ($defendant == '3'){ echo "<b>3</b>";}else{ echo "3";}?></a> <? } ?>
<? if ($ddr[name4]){?> <a href="wizard.php?jump=<?=$packet?>-4<? if ($mailDate){ echo "&mailDate=".$mailDate;} ?>"><?if ($defendant == '4'){ echo "<b>4</b>";}else{ echo "4";}?></a><? } ?>
<? if ($ddr[name5]){?> <a href="wizard.php?jump=<?=$packet?>-5<? if ($mailDate){ echo "&mailDate=".$mailDate;} ?>"><?if ($defendant == '5'){ echo "<b>5</b>";}else{ echo "5";}?></a><? } ?>
<? if ($ddr[name6]){?> <a href="wizard.php?jump=<?=$packet?>-6<? if ($mailDate){ echo "&mailDate=".$mailDate;} ?>"><?if ($defendant == '6'){ echo "<b>6</b>";}else{ echo "6";}?></a><? } ?>
<? if ($_COOKIE[psdata][level] == 'Operations'){ ?> <a href="http://staff.mdwestserve.com/otd/order.php?packet=<?=$ddr[packet_id]?>" target="_blank">(<?=id2attorney($ddr[attorneys_id]);?>)</a> - 
<a href="customInstructions.php?packet=<?=$ddr[packet_id]?>" target="_blank">INSTRUCTIONS</a> - 
<a href="http://staff.mdwestserve.com/otd/serviceSheet.php?packet=<?=$packet?>&autoPrint=1" target="_blank">CHECKLIST</a> - 
<a href="http://staff.mdwestserve.com/otd/historyModify.php?packet=<?=$packet?>" target="_blank">MODIFY</a>
<? 
include "http://service.mdwestserve.com/penalize.php?packet=$packet&svc=OTD&defendant=$defendant";
} ?>
<form enctype="multipart/form-data" id="wizard" name="wizard" onSubmit="hideshow(document.getElementById('loading'))" method="post" style='display:inline;'>
<? if($_GET[mailDate]){echo "<br>Updating Mailing Affidavits for the date: ".$_GET[mailDate];} ?>
<? if($_POST[mailDate]){echo "<br>Updating Mailing Affidavits for the date: ".$_POST[mailDate];} ?><br>
<?=strtoupper($dname)?><br /><small><?=strtoupper($daddy)?></small><?=$daddya?><?=$daddyb?><?=$daddyc?><?=$daddyd?><?=$daddye?><? if ($_COOKIE["psdata"]["level"] == "Operations"){echo $daddypo;}?><br />
<? if($i=='a'){ ?>SELECT DEFENDANT<? }elseif($i==1){ ?><strong><?=strtoupper($ddr[process_status])?> : <?=strtoupper($ddr[service_status])?> : <?=strtoupper($ddr[affidavit_status])?></strong><? }elseif($i==4){ ?>ARE ALL DETAILS CORRECT?<? }else{ ?><? if ($i != 2 && $i!= 'a'){ echo "<strong>ENTER ".$servedTitle." DETAILS</strong>";}?><? }?><? if ($ddr[reopenNotes] != ''){?><br>"<?=$ddr[reopenNotes]?>"<? }?></legend>
<?//Display Server Instructions (if they exist):?>
<div id="navSystem" style="display:block"><? mysql_select_db ('core'); include "wizard.$i.php"; ?></div></fieldset>
<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
<? if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? }
$photoCount=photoCount($ddr[packet_id],$defendant); ?>
</form></td></tr>
<tr><td>
<fieldset style="padding:0px;"><legend style="background-color:#FFFFCC;"><a onClick="hideshow(document.getElementById('timeline'))">Service Log</a><? if ($_COOKIE[psdata][level] == 'Operations'){?> | <a onClick="hideshow(document.getElementById('photos'))">Photos (<?=$photoCount;?>)</a> | <a onClick="hideshow(document.getElementById('notes'))">Notes</a><? } ?></legend>
<div id='timeline' style="display:none;">
<?=$ddr[timeline]?>
</div>
<? if ($_COOKIE[psdata][level] === 'Operations'){?>
<iframe name="photos" id='photos' style='display:<? if ($photoCount > 0){ echo "block";}else{ echo "none";}?>;' src="wizard.photo.display.php?packet=<?=$packet?>&defendant=<?=$defendant?>" height="320" width="98%"></iframe>
<iframe name="notes" id='notes' style='display:none;' src="http://staff.mdwestserve.com/notes.php?packet=<?=$packet?>" height="320" width="98%"></iframe>
<? } ?>
</fieldset>
<iframe name="preview" src="wizard.preview.php?packet=<?=$packet?>&def=<?=$defendant?>!" height="300" width="700"></iframe></td></tr></table>
<? if ($_COOKIE[psdata][level] == "Operations"){ ?>
</td><td valign="top">
<iframe name="modify" src="http://staff.mdwestserve.com/otd/historyModify.php?packet=<?=$packet?>&def=<?=$defendant?>" height="780" width="700"></iframe>
</td></tr></table>
<? } ?>
<?
if ($packet){
opLog($_COOKIE[psdata][name]." Wizard-$i #$packet");
}else{
opLog($_COOKIE[psdata][name]." Wizard-Jump #$_GET[jump]");
}
 include 'footer.php';?>
