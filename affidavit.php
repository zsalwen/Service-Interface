<?
include 'functions.php';
db_connect('delta.mdwestserve.com','intranet','root','zerohour');
header ('Location: newAffidavit.php?packet='.$_GET[packet].'&def='.$_GET[def]);
$packet = $_GET[packet];
$def = $_GET[def];
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
$q2="SELECT * from attorneys where attorneys_id = '$d1[attorneys_id]'";
$r2=@mysql_query($q2) or die(mysql_error());
$d2=mysql_fetch_array($r2, MYSQL_ASSOC);
$plaintiff = str_replace('-','<br>',$d2[ps_plaintiff]);							
// get process server's information
if ($d1[server_id] == $_COOKIE[psdata][user_id]){
	$server_id = $d1[server_id];
}elseif($d1[server_ida] == $_COOKIE[psdata][user_id]){
	$server_id = $d1[server_ida];
}elseif(isset($_GET['server'])){
	$server_id = $_GET['server'];
}else{	
	$server_id = $_COOKIE[psdata][user_id];
}	

$q3="SELECT * from ps_users where id = '$server_id'";
$r3=@mysql_query($q3) or die(mysql_error());
$d3=mysql_fetch_array($r3, MYSQL_ASSOC);
if (isset($_GET['alt_name'])){
	$sign_by = $_GET['alt_name'];
	}else{
	$sign_by = $d3[name];
	}
// get service history
$q4="SELECT * from ps_history where packet_id = '$packet' AND defendant_id = '$def' and serverID = '$server_id' order by action_str";
$r4=@mysql_query($q4) or die(mysql_error());
while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
 $history .= "<div>$d4[action_str]</div><br>";
}
?>
<style>
body { margin:0px; padding:0px;}
    @media print {
      .noprint { display: none; }
    }
</style>
<div class="noprint" align="center">
<form method="get">
<input type="hidden" name="packet" value="<?=$_GET[packet]?>" />
<input type="hidden" name="def" value="<?=$_GET[def]?>" />
<? if ($_GET['server']){ ?>
<input type="hidden" name="server" value="<?=$_GET[server]?>" />
<? } ?>
Enter Substitue Process Server Name: <input name="alt_name" /> <input type="submit" name="submit" value="Submit" />
</form>
</div>
<table width="80%" align="center">
	<tr>
    	<td colspan="2" align="center" style="font-size:24px; font-variant:small-caps;">State of Maryland</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-size:20px;">Circuit Court for <?=$court?></td>
    </tr>
    <tr>
    </tr>
    <tr>
    	<td><?=$plaintiff;?><br><small>_____________________<br /><em>Plaintiff</em></small><br /><br />v.<br /><br /><?=strtoupper($d1["name$def"]);?><br /><small>_____________________<br /><em>Defendant</em></small></td>
        	<td align="right" valign="top">Case No. <?=$d1[case_no]?> </td>
</tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="50px" valign="top">Affidavit of Service</td>
    </tr>
    <tr>
    	<td colspan="2" align="left">I,  <?=strtoupper($sign_by)?>, certify that on <?=date('m/d/Y @ g:i A')?> pursuant to Maryland Rule 2-121(a) and Maryland Real Property Article 7-105.1.<br><br>That I served a copy of the Order to Docket and all other papers filed with it (the "Papers")  in the above-captioned case by:<br><br></td>
    </tr>
    <tr>
    	<td colspan="2" style="font-weight:bold"><?=stripslashes($history)?></td>
    </tr>
    <tr>
    	<td colspan="2">I further certify that I am over eighteen years old and not a party to this action.<br /><br /></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of this affidavit are true and correct.<br /><br /><br><br><br></td>
    </tr>
    <tr>
    	<td valign="top">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top">____________________________________<br /><?=str_replace(' ', '&nbsp;', strtoupper($sign_by));?><br /><?=strtoupper($d3[address])?><br /><?=strtoupper($d3[city])?>, <?=strtoupper($d3[state])?> <?=$d3[zip]?><br /><?=$d3[phone]?></td> 
	</tr>
</table>	
