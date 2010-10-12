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

if ($_GET[jump]){
}
include 'common.php';
if ($_GET[jump]){
include 'miniwizard.jump.php';
}
include 'minimenu.php';
mysql_select_db ('core');

function alpha2desc($alpha){
	if ($alpha == 'a'){ return "FIRST DOT ATTEMPT"; }
	if ($alpha == 'b'){ return "SECOND DOT ATTEMPT"; }
	if ($alpha == 'c'){ return "POSTED DOT PROPERTY"; }
	if ($alpha == 'd'){ return "FIRST LKA ATTEMPT"; }
	if ($alpha == 'e'){ return "SECOND LKA ATTEMPT"; }
	if ($alpha == 'f'){ return "FIRST ALT ATTEMPT"; }
	if ($alpha == 'g'){ return "SECOND ALT ATTEMPT"; }
}
function photoAddress($packet,$defendant,$alpha){
	$r=@mysql_query("SELECT * from ps_packets where packet_id = '$packet'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($alpha == "a" || $alpha == "b"|| $alpha == "c"){ return $d["address$defendant"].", ".$d["state$defendant"]; }
	if ($alpha == "d" || $alpha == "e"){ return $d["address$defendant"."a"].", ".$d["state$defendant"."a"]; }
	if ($alpha == "f" || $alpha == "g"){ return $d["address$defendant"."b"].", ".$d["state$defendant"."b"]; }
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
mysql_select_db ('core');
$qqr = @mysql_query("SELECT * from ps_packets where packet_id = '$packet'");
$ddr = mysql_fetch_array($qqr, MYSQL_ASSOC);
$dname = $ddr["name$defendant"];
$daddy = $ddr["address$defendant"].', '.$ddr["city$defendant"].', '.$ddr["state$defendant"].' '.$ddr["zip$defendant"];
$vera=$defendant.'a';
$verb=$defendant.'b';
$verc=$defendant.'c';
$verd=$defendant.'d';
$vere=$defendant.'e';
if ($ddr["address$vera"]){
	$addressa=strtoupper($ddr["address$vera"].', '.$ddr["city$vera"].', '.$ddr["state$vera"].' '.$ddr["zip$vera"]);
	$daddya="<br><small>$addressa</small>";
}
if ($ddr["address$verb"]){
	$addressb=strtoupper($ddr["address$verb"].', '.$ddr["city$verb"].', '.$ddr["state$verb"].' '.$ddr["zip$verb"]);
	$daddyb="<br><small>$addressb</small>";
}
if ($ddr["address$verc"]){
	$addressc=strtoupper($ddr["address$verc"].', '.$ddr["city$verc"].', '.$ddr["state$verc"].' '.$ddr["zip$verc"]);
	$daddyc="<br><small>$addressc</small>";
}
if ($ddr["address$verd"]){
	$addressd=strtoupper($ddr["address$verd"].', '.$ddr["city$verd"].', '.$ddr["state$verd"].' '.$ddr["zip$verd"]);
	$daddyd="<br><small>$addressd</small>";
}
if ($ddr["address$vere"]){
	$addresse=strtoupper($ddr["address$vere"].', '.$ddr["city$vere"].', '.$ddr["state$vere"].' '.$ddr["zip$vere"]);
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
<!--
pic1= new Image(200,255); 
pic1.src="http://mdwestserve.com/ps/gfx/working.gif"; 
//-->
function submitLoader(){
	hideshow(document.getElementById('loading'));
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
.nav { background-image:url(gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#CCFFFF; border:solid 1px #00FF00;}
.nav2 { background-image:url(gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#FF9999; border:solid 1px #FF0000;}
.nav3 { background-image:url(gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#FFFFCC; border:solid 1px #FFFF00;}
.nav4 { background-image:url(gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:300px;  background-color:#00CCFF; border:solid 1px #00FFFF;}
.photoa, .photob, .photoc { background-image:url(gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#00FFCC; border:solid 1px #000000;}
.photod, .photoe { background-image:url(gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#FFCC99; border:solid 1px #000000;}
.photof, .photog { background-image:url(gfx/next.gif); background-repeat:no-repeat; padding-left:30px; width:500px;  background-color:#99CCFF; border:solid 1px #000000;}
</style>
<?
mysql_select_db ('core');
?>
<body bgcolor="#CCFFFF">
<title>Mini Affidavit Wizard <?=$_POST[service_type]?> &gt; <?=$_POST[served]?> &gt; <?=$_POST[parts]?></title>
<table align="center"><tr><td><form enctype="multipart/form-data" id="wizard" name="wizard" onSubmit="hideshow(document.getElementById('loading'))" method="post">
	<fieldset style="background-color:#FFFFFF;">
    	<legend style=" background-color:#FFFFCC; border:double 1px #999999; padding:5px;">
			<? if($_COOKIE[psdata][level]=="Operations"){ echo id2name($_POST[opServer])."*<br>"; }?>
            DEFENDANT: <a href="wizard.php?jump=<?=$packet?>-1">1</a><? if ($ddr[name2]){?> <a href="wizard.php?jump=<?=$packet?>-2">2</a> <? } if ($ddr[name3]){?> <a href="wizard.php?jump=<?=$packet?>-3">3</a> <? } if ($ddr[name4]){?> <a href="wizard.php?jump=<?=$packet?>-4">4</a><? } ?> <? if ($ddr[name5]){?> <a href="wizard.php?jump=<?=$packet?>-5">5</a><? } ?> <? if ($ddr[name6]){?> <a href="wizard.php?jump=<?=$packet?>-6">6</a><? } ?> 
			
			<? if ($_COOKIE[psdata][level] == 'Operations'){ ?> <a href="order.php?packet=<?=$ddr[packet_id]?>" target="_blank">(<?=id2attorney($ddr[attorneys_id]);?>)</a> - <a href="ps_instructions.<? if ($ddr[attorneys_id] == 1){ echo 'burson.';}?>php?packet=<?=$ddr[packet_id]?>" target="_blank">INSTRUCTIONS</a><? } ?><br><?=strtoupper($dname)?><br /><small><?=strtoupper($daddy)?></small><?=$daddya?><?=$daddyb?><?=$daddyc?><?=$daddyd?><?=$daddye?><? if ($_COOKIE["psdata"]["level"] == "Operations"){echo $daddypo;}?><br /><? if($i=='a'){ ?>SELECT DEFENDANT<? }elseif($i==1){ ?><? }elseif($i==4){ ?>ARE ALL DETAILS CORRECT?<? }else{ ?><? if ($i != 2 && $i!= 'a'){ echo "<strong>ENTER ".$_POST[served]." DETAILS</strong>";}?><? }?></legend><div id="loading" style="display:block; text-align:center"><img src="gfx/working.gif"><br>Watch our mouse powered servers go!</div>
<div id="navSystem" style="display:block"><? mysql_select_db ('core'); include "wizard.$i.php"; ?></div></fieldset><input type="hidden" name="MAX_FILE_SIZE" value="100000000" /></form></td></tr>
<? if($_COOKIE[psdata][level]=="Operations"){ ?>
<tr><td align="center"><form method="post" id="restart" name="restart"><select onChange='submitLoaderRestart()' name='opServer'><?=servers($_POST[opServer])?></select><input type="hidden" name="i" value="a"></form></td></tr>
<? } ?>
</table>
<?
if ($packet){
opLog($_COOKIE[psdata][name]." Wizard-$i #$packet");
}else{
opLog($_COOKIE[psdata][name]." Wizard-Jump #$_GET[jump]");
}
// include 'footer.php';?>
<script>hideshow(document.getElementById('loading'))</script>