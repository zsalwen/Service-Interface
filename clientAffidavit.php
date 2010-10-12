<?
include 'functions.php';
db_connect('192.168.1.101','core','root','zerohour');

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
td { font-variant:small-caps; }
</style>
<?
if ($_GET[packet]){
$packet = $_GET[packet];
$def = $_GET[def];
}
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
if ($d1[altPlaintiff] != ''  && $d1[attorneys_id] != '1'){
	$plaintiff = str_replace('-','<br>',$d1[altPlaintiff]);
}else{
	$plaintiff = str_replace('-','<br>',$d2[ps_plaintiff]);
}
	$article = "14-204(b)(2)";
	$result = "MAILING AND POSTING";
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
?>





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
    	<td><?=$plaintiff;?><br><small>_____________________<br /><em>Plaintiff</em></small><br /><br />v.<br /><br /><?
		
		
		echo strtoupper($d1["name1"])."<br>";
		if ($d1["name2"]){ echo strtoupper($d1["name2"])."<br>";}
		if ($d1["name3"]){ echo strtoupper($d1["name3"])."<br>";}
		if ($d1["name4"]){ echo strtoupper($d1["name4"])."<br>";}
		echo strtoupper($d1["address1"])."<br>";
		echo strtoupper($d1["city1"]).', '.strtoupper($d1["state1"]).' '.$d1["zip1"]."<br>";
		?><small>_____________________<br /><em>Defendant</em></small></td>
        	<td align="right" valign="top" style="padding-left:200px; width:200px" nowrap="nowrap">Case No. <?=$d1[case_no]?><br />File No. <?=$d1[client_file]?><br />Logic No. <?=$d1[packet_id]?>-<?=$def?></td>
</tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Service</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?><br /><br /><br /></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br><br /><br /></td>
    </tr>
    <tr>
    	<td colspan="2" height="50px" style="font-weight:bold; padding-left:20px;">Mailed First Class to <?=strtoupper($d1["name$def"])?> at <?=strtoupper($d1["address$def"])?>, <?=strtoupper($d1["city$def"])?>, <?=strtoupper($d1["state$def"])?> <?=strtoupper($d1["zip$def"])?> on _________________________.<br /><br /><br /></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of section (ii) of this affidavit are true and correct.  And that I mailed the above papers under section 14-204(b)(2) to <?=strtoupper($d1["name$def"])?> at <?=strtoupper($d1["address$def"])?>, <?=strtoupper($d1["city$def"])?>, <?=strtoupper($d1["state$def"])?> <?=strtoupper($d1["zip$def"])?>.<br><br /><br /><br /></td>
    </tr>
    <tr>
    	<td colspan="2">I, _________________________, certify that I am over eighteen years old and not a party to this action.<br /><br /><br /><br /></td>
    </tr>
    <tr>
    	<td valign="top">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top">________________________<u>DATE:</u>________<br />Sign<br /><br />______________________________________<br />Print</td> 
	</tr>
</table>	
<? 
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
