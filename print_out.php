<?
include 'functions.php';
db_connect('delta.mdwestserve.com','intranet','root','zerohour');
$user=$_COOKIE[psdata][user_id];
$packet = $_GET[packet];
$def = $_GET[def];
// get main information
$q1="SELECT * FROM ps_packets WHERE packet_id='$packet'";
$r1=@mysql_query($q1) or die(mysql_error());
$d1=mysql_fetch_array($r1, MYSQL_ASSOC);
$q2="SELECT * FROM ps_packages WHERE id='$d1[package_id]'";
$r2=@mysql_query($q2) or die(mysql_error());
$d2=mysql_fetch_array($r2, MYSQL_ASSOC);
if ($d1[server_id] != $user){
	if ($_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Operations" || $_COOKIE[psdata][level] == "Dispatch" || $_COOKIE[psdata][level] == "Administrator"){
	}else{
	header('Location: home.php');
	}
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
$assign=explode(' ',$d2[assign_date]);
$assign2=explode('-',$assign[0]);
?>
<style>body { margin:0px; padding:0px;}</style>
<table width="80%" align="center" height="100%">
	<tr>
    	<td align="center" style="font-size:24px; font-variant:small-caps;"><img src="http://mdwestserve.com/templates/logo3.jpg"></td>
    </tr>
	<tr>
    	<td align="center" style="font-size:20px;">Circuit Court for <?=$court?></td>
    </tr>
    <tr>
    	<td align="center" style="font-weight:bold; font-size:20px;" valign="top"><u>HWA Service Notes for <?=id2name($d1[server_id]);?> (Assigned <?=$assign2[1]?>/<?=$assign2[2]?>/<?=$assign2[0]?>)</u><br><br></td>
    </tr>
    <tr>
    	<td style="font-size:18px">Defendant 1: <?=$d1[name1]?></td>
    </tr>
	<tr>
    	<td style="font-size:18px">Address: <?=$d1[address1]?>, <?=$d1[city1]?>, <?=$d1[state1]?> <?=$d1[zip1]?><br><br></td>
    </tr>
<?	if ($d1[name2]){ ?>
        <tr>
    	<td style="font-size:18px">Defendant 2: <?=$d1[name2]?></td>
    </tr>
	<tr>
    	<td style="font-size:18px">Address: <?=$d1[address2]?>, <?=$d1[city2]?>, <?=$d1[state2]?> <?=$d1[zip2]?><br><br></td>
    </tr>
<?    } 
	if ($d1[name3]){ ?>
        <tr>
    	<td style="font-size:18px">Defendant 3: <?=$d1[name3]?></td>
    </tr>
	<tr>
    	<td style="font-size:18px">Address: <?=$d1[address3]?>, <?=$d1[city3]?>, <?=$d1[state3]?> <?=$d1[zip3]?><br><br></td>
    </tr>
<?    } 
	if ($d1[name4]){ ?>
        <tr>
    	<td style="font-size:18px">Defendant 4: <?=$d1[name4]?></td>
    </tr>
	<tr>
    	<td style="font-size:18px">Address: <?=$d1[address4]?>, <?=$d1[city4]?>, <?=$d1[state4]?> <?=$d1[zip4]?></td>
    </tr>
<?    } ?>
	<tr>
    	<td valign="bottom">Special Instructions: <div style="border:solid; font-size:18px; height:300px"><?=$d1[attorney_notes]?></div></td>
    </tr>
</table>	
