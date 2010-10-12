<?
mysql_connect();
mysql_select_db('core');
function att2envelope($attID){
	$r=@mysql_query("SELECT envID FROM attorneys WHERE attorneys_id = '$attID'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	return $d[envID];
}
function county2envelope($county){
	$county=strtoupper($county);
	if ($county == 'BALTIMORE'){
		$search='BALTIMORE COUNTY';
	}elseif($county == 'PRINCE GEORGES'){
		$search='PRINCE GEORGE';
	}elseif($county == 'ST MARYS'){
		$search='ST. MARY';
	}elseif($county == 'QUEEN ANNES'){
		$search='QUEEN ANNE';
	}else{
		$search=$county;
	}
	$r=@mysql_query("SELECT envID FROM envelopeImage WHERE to1 LIKE '%$search%' AND addressType='COURT'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	return $d[envID];
}
function pageMaker($id,$matrix){
$r=@mysql_query("SELECT * FROM envelopeImage WHERE envID = '$id'");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
ob_start(); ?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table style="page-break-after:always; ">
	<tr>
		<td style='line-height:1px; font-size:10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=strtoupper($matrix)?></td>
	</tr>
	<tr>
		<td style="line-height:12px; font-size:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REQUEST FOR</td>
	</tr>
	<tr>
		<td style='line-height:13.5px; font-size:20px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FORECLOSURE MEDIATION</td>
	</tr>
	<tr>
		<td style="line-height:4.5px; font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=stripslashes(strtoupper($d[to1]))?></td>
	</tr>	
	<tr>
		<td style="line-height:4.5px; font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=stripslashes(strtoupper($d[to2]))?></td>
	</tr>	
	<tr>
		<td style="line-height:0px; font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=stripslashes(strtoupper($d[to3]))?></td>
	</tr>
</table>
<? 
$html = ob_get_clean();
return $html;
}
function buildFromPacket($packet){
	$r=@mysql_query("select name1, name2, name3, name4, name5, name6, address1, address1a, address1b, address1c, address1d, address1e, city1, city1a, city1b, city1c, city1d, city1e, state1, state1a, state1b, state1c, state1d, state1e, zip1, zip1a, zip1b, zip1c, zip1d, zip1e, address2, address2a, address2b, address2c, address2d, address2e, city2, city2a, city2b, city2c, city2d, city2e, state2, state2a, state2b, state2c, state2d, state2e, zip2, zip2a, zip2b, zip2c, zip2d, zip2e, address3, address3a, address3b, address3c, address3d, address3e, city3, city3a, city3b, city3c, city3d, city3e, state3, state3a, state3b, state3c, state3d, state3e, zip3, zip3a, zip3b, zip3c, zip3d, zip3e, address4, address4a, address4b, address4c, address4d, address4e, city4, city4a, city4b, city4c, city4d, city4e, state4, state4a, state4b, state4c, state4d, state4e, zip4, zip4a, zip4b, zip4c, zip4d, zip4e, address5, address5a, address5b, address5c, address5d, address5e, city5, city5a, city5b, city5c, city5d, city5e, state5, state5a, state5b, state5c, state5d, state5e, zip5, zip5a, zip5b, zip5c, zip5d, zip5e, address6, address6a, address6b, address6c, address6d, address6e, city6, city6a, city6b, city6c, city6d, city6e, state6, state6a, state6b, state6c, state6d, state6e, zip6, zip6a, zip6b, zip6c, zip6d, zip6e, pobox, pobox2, pocity, pocity2, postate, postate2, pozip, pozip2, lossMit, circuit_court, attorneys_id from ps_packets where packet_id = '$packet'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$i=0;
	$page='';
	$toCounty=county2envelope($d[circuit_court]);
	$toAttorney=att2envelope($d[attorneys_id]);
	while ($i < 6){$i++;
		if ($d["name$i"]){
			if ($d[lossMit] != 'PRELIMINARY'){
				$page .= pageMaker($toCounty,"$packet-$i");
			}
			$page .= pageMaker($toAttorney,"$packet-$i");
		}
	}
	return $page;
}

$packet=$_GET[packet];
$page=buildFromPacket($packet);
if ($_COOKIE[psdata][level] != 'Operations'){
	error_log("[".date('h:iA n/j/y')."] ".$_COOKIE[psdata][name]." Printing Envelope Stuffings For OTD$_GET[packet] \n",3,"/logs/contractor.log");
}else{
	error_log("[".date('h:iA n/j/y')."] ".$_COOKIE[psdata][name]." Printing Envelope Stuffings For OTD$_GET[packet] \n",3,"/logs/user.log");
}
require_once("/thirdParty/dompdf-0.5.1/dompdf_config.inc.php");
$old_limit = ini_set("memory_limit", "16M");
$dompdf = new DOMPDF();
$dompdf->load_html($page);
$dompdf->set_paper('letter', 'portrait');
$dompdf->render();
$dompdf->stream('envelopes-'.$_GET['packet'].".pdf");
?>