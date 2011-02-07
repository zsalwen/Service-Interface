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
	include 'ev_wizard.jump.php';
	die();
}
mysql_select_db ('core');

function alpha2desc($alpha){
	if ($alpha == 'a'){ return "FIRST DOT ATTEMPT"; }
	if ($alpha == 'b'){ return "SECOND DOT ATTEMPT"; }
	if ($alpha == 'c'){ return "POSTED DOT PROPERTY"; }
}
function photoAddress($packet,$defendant,$alpha){
	$r=@mysql_query("SELECT * from evictionPackets where eviction_id = '$packet'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($alpha == "a" || $alpha == "b"|| $alpha == "c"){
		if ($d["address1"]){
			return $d["address1"].", ".$d["state1"];
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
	$packet="EV".$packet;
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
	$qn="SELECT * FROM evictionHistory WHERE eviction_id = '$packet' order by defendant_id, history_id ASC";
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
$qqr = @mysql_query("SELECT * from evictionPackets where eviction_id = '$packet'");
$ddr = mysql_fetch_array($qqr, MYSQL_ASSOC);
$dname = $ddr["name$defendant"];
$daddy = $ddr["address1"].', '.$ddr["city1"].', '.$ddr["state1"].' '.$ddr["zip1"].' - <b>'.initals(id2name($ddr[server_id])).'</b>';
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
table, tr, td {padding:0px;}
.nav0 { display:none;}
.nav { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#CCFFFF; border:solid 1px #00FF00;}
.nav2 { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#FF9999; border:solid 1px #FF0000;}
.nav3 { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#FFFFCC; border:solid 1px #FFFF00;}
.nav4 { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#00CCFF; border:solid 1px #00FFFF;}
.photoa, .photob, .photoc { background-image:url(/gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#00FFCC; border:solid 1px #000000;}
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
if ($_COOKIE[psdata][level] != "Operations"){
	hardLog(' access wizard ['.$i.'] for '.$_POST[served].' by '.$_POST[service_type].' ('.$_POST[parts].')','contractor'); 
}else{
	hardLog(' access wizard ['.$i.'] for '.$_POST[served].' by '.$_POST[service_type].' ('.$_POST[parts].')','user'); 
}
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
<fieldset style="background-color:#FFFFFF;"><legend style=" background-color:#FFFFCC; border:double 1px #999999; padding:5px;">
<? if($_COOKIE[psdata][level]=="Operations" && $_POST[opServer] != ''){ echo id2name($_POST[opServer])."*<br>"; }?>
<? if ($_COOKIE[psdata][level] == 'Operations'){ ?> <a href="http://staff.mdwestserve.com/ev/order.php?packet=<?=$ddr[eviction_id]?>" target="_blank">(<?=id2attorney($ddr[attorneys_id]);?>)</a> - 
<a href="http://staff.mdwestserve.com/ev/ev_instructions.<? if($ddr[attorneys_id] == 56){ echo 'brennan.';}?>php?id=<?=$ddr[eviction_id]?>" target="_blank">INSTRUCTIONS</a> - 
<a href="http://staff.mdwestserve.com/ev/evSheet.php?id=<?=$packet?>&autoPrint=1" target="_blank">CHECKLIST</a> - 
<a href="http://staff.mdwestserve.com/ev/evictionHistoryModify.php?id=<?=$packet?>" target="_blank">MODIFY</a>
<?
include "http://service.mdwestserve.com/penalize.php?packet=$packet&svc=EV&defendant=$defendant";
} ?>
<form enctype="multipart/form-data" id="wizard" name="wizard" onSubmit="hideshow(document.getElementById('loading'))" method="post" style='display:inline;'>
<? if($_GET[mailDate]){echo "<br>Updating Mailing Affidavits for the date: ".$_GET[mailDate];} ?>
<? if($_POST[mailDate]){echo "<br>Updating Mailing Affidavits for the date: ".$_POST[mailDate];} ?><br>
<?=strtoupper($dname)?><br /><small><?=strtoupper($daddy)?></small><br />
<? if($i=='a'){ ?>SELECT DEFENDANT<? }elseif($i==1){ ?><strong><?=strtoupper($ddr[process_status])?> : <?=strtoupper($ddr[service_status])?> : <?=strtoupper($ddr[affidavit_status])?></strong><? }elseif($i==4){ ?>ARE ALL DETAILS CORRECT?<? }else{ ?><? if ($i != 2 && $i!= 'a'){ echo "<strong>ENTER ".$servedTitle." DETAILS</strong>";}?><? }?><? if ($ddr[reopenNotes] != ''){?><br>"<?=$ddr[reopenNotes]?>"<? }?></legend>
<?
//Display Server Instructions (if they exist):

 ?>
<div id="navSystem" style="display:block"><? mysql_select_db ('core'); include "ev_wizard.$i.php"; ?></div></fieldset><input type="hidden" name="MAX_FILE_SIZE" value="100000000" /><? if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? } ?>
</form></td></tr>
<tr><td>
<fieldset style="padding:0px;"><legend style="background-color:#FFFFCC;"><a onClick="hideshow(document.getElementById('timeline'))">Service Log</a><? if ($_COOKIE[psdata][level] == 'Operations'){?> | <a onClick="hideshow(document.getElementById('photos'))">Photos (<?=photoCount($ddr[eviction_id],$defendant);?>)</a> | <a onClick="hideshow(document.getElementById('notes'))">Notes</a><? } ?></legend>
<div id='timeline' style="display:none;">
<?=$ddr[timeline]?>
</div>
<? if ($_COOKIE[psdata][level] == 'Operations'){?>
<iframe name="photos" id='photos' style='display:<? if ((strtoupper($ddr[service_status]) == "PERSONAL DELIVERY")){ echo "none";}else{ echo "block";}?>;' src="ev_wizard.photo.display.php?packet=<?=$packet?>&defendant=<?=$defendant?>" height="320" width="98%"></iframe>
<iframe name="notes" id='notes' style='display:none;' src="http://staff.mdwestserve.com/notes.php?packet=<?=$packet?>" height="320" width="98%"></iframe>
<? } ?>
</fieldset>
<iframe name="preview" src="ev_wizard.preview.php?id=<?=$packet?>&def=<?=$defendant?>!" height="300" width="700"></iframe></td></tr></table>
<? if ($_COOKIE[psdata][level] == "Operations"){ ?>
</td><td valign="top">
<iframe name="modify" src="http://staff.mdwestserve.com/ev/evictionHistoryModify.php?id=<?=$packet?>&def=<?=$defendant?>" height="780" width="700"></iframe>
</td></tr></table>
<? } ?>
<?
if ($packet){
opLog($_COOKIE[psdata][name]." Wizard-$i #$packet");
}else{
opLog($_COOKIE[psdata][name]." Wizard-Jump #$_GET[jump]");
}
 include 'footer.php';?>
