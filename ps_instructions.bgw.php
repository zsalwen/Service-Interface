<?
function county2envelope2($county){
	$county=strtoupper($county);
	if ($county == 'BALTIMORE'){
		$search='BALTIMORE COUNTY';
	}elseif($county == 'PRINCE GEORGES'){
		$search='PRINCE GEORGE';
	}elseif($county == 'ST MARYS'){
		$search='ST MARY';
	}elseif($county == 'QUEEN ANNES'){
		$search='QUEEN ANNE';
	}else{
		$search=$county;
	}
	$r=@mysql_query("SELECT to1 FROM envelopeImage WHERE to1 LIKE '%$search%' AND addressType='COURT'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	return $d[to1];
}
function fileDate($date){
	$date=strtotime($date)-86400;
	return date('n/j/y',$date); 
}
if ($_GET[autoSave] == 1){
	ob_start();
}
include 'common.php';
$user = $_COOKIE[psdata][user_id];
$packet = $_GET[packet];
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Service Instructions for Packet '.$packet);
$query="SELECT * FROM ps_packets WHERE packet_id = '$packet'";
$result=@mysql_query($query);
$data=mysql_fetch_array($result,MYSQL_ASSOC);
$deadline=strtotime($data[date_received]);
$received=date('n/j/y',$deadline);
$deadline=$deadline+432000;
$deadline=date('m/d/Y',$deadline);
$estFileDate=fileDate($data[estFileDate]);
?>
<style>
body { margin:0px; padding:0px;}
li {font-size:12px;}
</style>
<img style="position:absolute; left:0px; top:0px; width:100px; height:100px;" src="http://service.mdwestserve.com/smallLogo.jpg" class="logo">
<table align="center" width="700px" style="font-variant:small-caps;" border="0">
	<tr>
    	<td valign="bottom" align="center" style="font-size:18px; font-variant:small-caps;" height="50px;">MDWestServe, Inc.<br>410-828-4568<br>Service Type 'D' For Packet <?=$_GET[packet]?></td>
    </tr>
	<tr>
		<td align="center" style="font-size:18px; font-variant:small-caps;">Received: <?=$received?> || Affidavit Deadline: <?=$estFileDate?></td>
	</tr>
<?
$i=0;
while ($i < 6){$i++;
	if ($data["name$i"]){
		$name=ucwords($data["name$i"]);
		$add1 = $data["address$i"].' '.$data["city$i"].', '.$data["state$i"].' '.$data["zip$i"];
?>
	<tr>
		<td><strong><?=$name?>:</strong>
<?
$i2=0;
foreach(range('e','a') as $letter){
	$vr=$i.$letter;
	if ($data["address$vr"]){$i2++; ?>
	<li><?=id2name($data["server_id$letter"])?> is to make 2 service attempts on <?=$name?> at <?=$data["address$vr"].' '.$data["city$vr"].', '.$data["state$vr"].' '.$data["zip$vr"]?>.</li>
<? } 
		}
	if ($i2 == 0 && $data[avoidDOT] == ''){?>
	<li><?=id2name($data[server_id])?> is to make 2 service attempts on <?=$name?> at <?=$add1?>.<br />
<?  }elseif($data[avoidDOT] == 'checked'){ ?>
	<li><?=id2name($data[server_id])?> is <b>NOT</b> to attempt service on <?=$name?> at <?=$add1?>.<br />
<?	}else{
		echo "<li>";
	} ?>
	After all other attempts have proven unsuccessful, if <?=id2name($data[server_id])?> is unable to serve <?=$name?>:<br />
	<?=id2name($data[server_id])?> is to post <?=$add1?>.<?if ($data[avoidDOT] == 'checked'){ echo "  <b>PLEASE DO NOT MAKE ANY ATTEMPTS AT THIS ADDRESS, SIMPLY POST DOCUMENTS. IF YOU ENCOUNTER A PARTY OF SUITABLE DISCRETION, DO NOT DELIVER PAPERS, BUT CONTACT OUR OFFICE INSTEAD. ALSO, CONTACT OUR OFFICE UNLESS YOU ARE ABSOLUTELY SURE YOU ARE AUTHORIZED TO PROCEED WITH POSTING.</b>";} ?></li>
<? }
	}
 ?>
		</td>
	</tr>
	<? if ($data[lossMit] != '' && $data[lossMit] != 'N/A - OLD L' && $data[packet_id] >= 12435){ 
		//if file is a final or preliminary, instruct to include envelope for attorney
		$lossMit="Per Maryland law HB472, please include one of the provided white, preprinted #10 envelopes addressed to BIERMAN, GEESING & WARD, LLC";
		if ($data[lossMit] == 'FINAL'){
			//if file is a final, also instruct to include envelope for court
			$toCounty=county2envelope2($data[circuit_court]);
			$lossMit .= " and another white, preprinted #10 envelope addressed to ".$toCounty;
		}
		$lossMit .= " with each defendant's service documents.";
	?>
	<tr>
		<td style='border: 1px solid;' align='center'><?=strtoupper($lossMit);?></td>
	</tr>
	<? } ?>
	<tr>
		<td align='center'><?=strtoupper($data[server_notes]);?></td>
	</tr>
<tr><td>
<table style="border:solid 1px; font-size: 12px;" border=1 width="700px" align="center">
	<tr>
    	<td colspan="5" align="center"><b>Service Type 'D':</b></td>
    </tr>
    <tr>
    	<td colspan="5" align="center"><div style="width:550px; text-align:justify;"><div style="border:ridge 3px; font-size: 16px; width: 400px; align:justify;"><strong style="text-decoration:underline;">ALL SERVICE MUST TAKE INTO ACCOUNT:</strong><br>'Two good faith attempts on separate days' - MD Rule 14-209(b)</div>
		<li>You cannot make two attempts at the same property on the same day.</li>
        <li><b>Posting</b> must be done <b>after</b> <u>all attempts</u> have been completed.</li>
        <li>Attempts are to be performed in order listed on service instructions.</li>
		<li><b>Make one attempt either before 8 AM or after 6 PM, and another attempt between 9AM and 5PM.  Please avoid attempts between 8AM-9AM & 5PM-6PM.  "Good Faith" efforts must be made at different times of day.</b></li>
        <li>Photographs are required for <b>posting</b>s as well as <b>attempt</b>s.</li>
		<li>If the address is a business, appears vacant, or the defendants are not known at the address, do not make a second attempt, but instead notify the office as soon as possible, and we will determine how to proceed.</li>
		<li>Personal delivery can only be achieved in the following manner:
<pre>	1.  Direct Delivery to the defendants themselves.<br>
-OR-	2.  Substitute Delivery to someone <b>over the age of 18</b> who resides with
	the defendant in question <i>at the address being served</i>.</pre>
		<b>All personal delivery affidavits <b>REQUIRE</b> a physical description of the individual served.</b></li>
		<li><b>Delivery to MDWestServe of all service affidavits for this file must be accomplished by <?=$estFileDate?></b></li></div></td>
    </tr>
</table>
</tr></td></table>
<?
if ($_GET['autoPrint'] == 1){
echo "<script>
if (window.self) window.print();
self.close();
</script>";
}
if ($_GET['autoSave'] == 1){
	$contents=ob_get_clean();
	require_once("/thirdParty/dompdf-0.5.1/dompdf_config.inc.php");
	$html = stripslashes($contents);
	$old_limit = ini_set("memory_limit", "50M");
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	echo $html;  
	$dompdf->set_paper('letter', 'portrait');
	$dompdf->render();
	//echo "2!";
	$unique = '/data/service/unknown/Service Instructions For Packet '.$data['packet_id'].'.PDF';
	//echo "1!";
	file_put_contents($unique, $dompdf->output()); //save to disk
	echo "<script>window.open('instructionSave.php?packet=".$data['packet_id']."');</script>";
	echo "<script>self.close();</script>";
}else{
	if (!$_GET[noField]){
		include "http://service.mdwestserve.com/fieldSheet.php?packet=".$data['packet_id']."&pageBreak=1";
	}
}
mysql_close();
?>