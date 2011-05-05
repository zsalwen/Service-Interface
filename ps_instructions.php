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
	$r=@mysql_query("SELECT to1 FROM envelopeImage WHERE to1 LIKE '%$search%' AND addressType='COURT' LIMIT 0,1");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	return $d[to1];
}

function id2attorneyName($id){
	$q="SELECT full_name FROM attorneys WHERE attorneys_id = '$id' LIMIT 0,1";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[full_name];
}
function fileDate($date){
	$date=strtotime($date)-86400;
	return date('n/j/y',$date); 
}
function serverList2($packet){
	$q="SELECT server_id, server_ida, server_idb, server_idc, server_idd, server_ide FROM ps_packets WHERE packet_id = '$packet' LIMIT 0,1";
	$r=@mysql_query($q) or die (mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[server_ida] != '' && $d[server_ida] != $d[server_id]){
		$list .= id2name($d[server_ida])."|";
	}
	if ($d[server_idb] != '' && $d[server_idb] != $d[server_id] && $d[server_idb] != $d[server_ida]){
		$list .= id2name($d[server_idb])."|";
	}
	if ($d[server_idc] != '' && $d[server_idc] != $d[server_id] && $d[server_idc] != $d[server_ida] && $d[server_idc] != $d[server_idb]){
		$list .= id2name($d[server_idc])."|";
	}
	if ($d[server_idd] != '' && $d[server_idd] != $d[server_id] && $d[server_idd] != $d[server_ida] && $d[server_idd] != $d[server_idb] && $d[server_idd] != $d[server_idc]){
		$list .= id2name($d[server_idd])."|";
	}
	if ($d[server_ide] != '' && $d[server_ide] != $d[server_id] && $d[server_ide] != $d[server_ida] && $d[server_ide] != $d[server_idb] && $d[server_ide] != $d[server_idc] && $d[server_ide] != $d[server_idd]){
		$list .= id2name($d[server_ide])."|";
	}
	//remove last "|"
	$list=substr($list,0,-1);
	$explode=explode('|',$list);
	$count=count($explode);
	$i=0;
	while ($i < $count){
		if($i == 0){
			$explode2 .= $explode["$i"];
		}elseif($i == ($count-1) && $count == 2){
			$explode2 .= " and ".$explode["$i"];
		}elseif ($i == ($count-1)){
			$explode2 .= ", and ".$explode["$i"];
		}else{
			$explode2 .= ", ".$explode["$i"];
		}
		$i++;
	}
	if ($count == 1 && $list != ''){
		return "$list2 is";
	}elseif($list == ''){
	}else{
		return "$list2 are";
	}
}
if ($_GET[autoSave] == 1){
	ob_start();
}
include 'common.php';
$user = $_COOKIE[psdata][user_id];
$packet = $_GET[packet];
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Service Instructions for Packet '.$packet);
$query="SELECT * FROM ps_packets WHERE packet_id = '$packet' LIMIT 0,1";
$result=@mysql_query($query) or die ("Query: $query<br>".mysql_error());
$data=mysql_fetch_array($result,MYSQL_ASSOC);
$deadline=strtotime($data[date_received]);
$received=date('n/j/y',$deadline);
$deadline=$deadline+432000;
$deadline=date('m/d/Y',$deadline);
$estFileDate=fileDate($data[estFileDate]);
$today=date('n/j/y');
$r1=mysql_query("SELECT * FROM gasRates ORDER BY id DESC LIMIT 0,1") or die (mysql_error());
$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
if ($d1[id]){
	$rate = "<br><center><div style='font-size:14px;'>[GAS PRICE: $$d1[gasPrice] | CONTRACTOR SURCHARGE: $$d1[contractor_rate] | DATE: $today]</div></center>";
}
if ($d[rush] != ''){
	$rush='<b>RUSH</b>';
}
?>
<style>
body { margin:0px; padding:0px;}
li {font-size:12px;}
</style>
<img style="position:absolute; left:0px; top:0px; width:100px; height:100px;" src="http://staff.mdwestserve.com/small.logo.gif" class="logo">
<table align="center" width="700px" style="font-variant:small-caps;" border="0">
	<tr>
    	<td valign="bottom" align="center" style="font-size:18px; font-variant:small-caps;" height="50px;">MDWestServe, Inc.<br>410-828-4568<br><?=$rush?>Service Type 'A' For Packet <?=$_GET[packet]?></td>
    </tr>
	<tr>
		<td align="center" style="font-size:18px; font-variant:small-caps;">Received: <?=$received?> || Affidavit Deadline: <?=$estFileDate?><?=$rate?></td>
	</tr>
<?
$i=0;
while ($i < 6){$i++;
	if ($data["name$i"]){
		$ver=$i."a";
		$verb=$i."b";
		$verc=$i."c";
		$verd=$i."d";
		$vere=$i."e";
		$name=ucwords($data["name$i"]);
		$add1ex=$data["address$vere"].' '.$data["city$vere"].', '.$data["state$vere"].' '.$data["zip$vere"];
		$add1dx=$data["address$verd"].' '.$data["city$verd"].', '.$data["state$verd"].' '.$data["zip$verd"];
		$add1cx=$data["address$verc"].' '.$data["city$verc"].', '.$data["state$verc"].' '.$data["zip$verc"];
		$add1bx=$data["address$verb"].' '.$data["city$verb"].', '.$data["state$verb"].' '.$data["zip$verb"];
		$add1ax=$data["address$ver"].' '.$data["city$ver"].', '.$data["state$ver"].' '.$data["zip$ver"];
		$add1x = $data["address$i"].' '.$data["city$i"].', '.$data["state$i"].' '.$data["zip$i"];
?>
<tr>
<td>
<strong><?=$name?>:</strong>
<? if ($data[server_ida]){ ?>
	<? if ($data[server_idb]){ ?>
		<ol><li>
		<? if ($data[server_ide]){ ?>
			<?=id2name($data[server_ide])?> is to make 1 service attempt on <?=$name?> at <?=$add1ex?>.</li><li>
		<? } ?>
		<? if ($data[server_idd]){ ?>
			<?=id2name($data[server_idd])?> is to make 1 service attempt on <?=$name?> at <?=$add1dx?>.</li><li>
		<? } ?>
		<? if ($data[server_idc]){ ?>
			<?=id2name($data[server_idc])?> is to make 1 service attempt on <?=$name?> at <?=$add1cx?>.</li><li>
		<? } ?>
		<?=id2name($data[server_idb])?> is to make 1 service attempt on <?=$name?> at <?=$add1bx?>.</li><li>
		<?=id2name($data[server_ida])?> is to make 1 service attempt on <?=$name?> at <?=$add1ax?>.</li><li> 
		After all other attempts have proven unsuccessful, 
		If <?=serverList2($data[packet_id])?> unable to serve <?=$name?>:<br />
		<?=id2name($data[server_id])?> is to post <?=$add1x?>.<?if ($data[avoidDOT] == 'checked'){ echo "  <b>PLEASE DO NOT MAKE ANY ATTEMPTS AT THIS ADDRESS, SIMPLY POST DOCUMENTS. IF YOU ENCOUNTER A PARTY OF SUITABLE DISCRETION, DO NOT DELIVER PAPERS, BUT CONTACT OUR OFFICE INSTEAD. ALSO, CONTACT OUR OFFICE UNLESS YOU ARE ABSOLUTELY SURE YOU ARE AUTHORIZED TO PROCEED WITH POSTING.</b>";} ?></li>
	<? }elseif($data[address1b]){ ?>
		<ol><li><?=id2name($data[server_ida])?> is to make 1 service attempt on <?=$name?> at <?=$add1bx?>.</li><li>
		<?=id2name($data[server_id])?> is to make 1 service attempt on <?=$name?> at <?=$add1ax?>.</li><li> 
		After all other attempts have proven unsuccessful, 
		If <?=serverList2($data[packet_id])?> unable to serve <?=$name?>:<br />
		<?=id2name($data[server_id])?> is to post <?=$add1x?>.<?if ($data[avoidDOT] == 'checked'){ echo "  <b>PLEASE DO NOT MAKE ANY ATTEMPTS AT THIS ADDRESS, SIMPLY POST DOCUMENTS. IF YOU ENCOUNTER A PARTY OF SUITABLE DISCRETION, DO NOT DELIVER PAPERS, BUT CONTACT OUR OFFICE INSTEAD. ALSO, CONTACT OUR OFFICE UNLESS YOU ARE ABSOLUTELY SURE YOU ARE AUTHORIZED TO PROCEED WITH POSTING.</b>";} ?></li>
	<? }else{?>
<ol><li><?=id2name($data[server_ida])?> is to make 2 service attempts on <?=$name?> at <?=$add1ax?> on different days.</li><li> 
After all other attempts have proven unsuccessful, 
If <?=id2name($data[server_ida])?> is unable to serve <?=$name?>:<br />
<?=id2name($data[server_id])?> is to post <?=$add1x?>.<?if ($data[avoidDOT] == 'checked'){ echo "  <b>PLEASE DO NOT MAKE ANY ATTEMPTS AT THIS ADDRESS, SIMPLY POST DOCUMENTS. IF YOU ENCOUNTER A PARTY OF SUITABLE DISCRETION, DO NOT DELIVER PAPERS, BUT CONTACT OUR OFFICE INSTEAD. ALSO, CONTACT OUR OFFICE UNLESS YOU ARE ABSOLUTELY SURE YOU ARE AUTHORIZED TO PROCEED WITH POSTING.</b>";} ?></li>
<?		}
 }elseif($data[address1a]){?>
	<? if ($data[address1b]){?>
<ol><li><?=id2name($data[server_id])?> is to make 1 service attempt on <?=$name?> at <?=$add1bx?>.</li><li>
<?=id2name($data[server_id])?> is to make 1 service attempt on <?=$name?> at <?=$add1ax?>.</li><li>
After all other attempts have proven unsuccessful, 
If <?=id2name($data[server_id])?> is unable to serve <?=$name?>:<br />
<?=id2name($data[server_id])?> is to post <?=$add1x?>.<?if ($data[avoidDOT] == 'checked'){ echo "  <b>PLEASE DO NOT MAKE ANY ATTEMPTS AT THIS ADDRESS, SIMPLY POST DOCUMENTS. IF YOU ENCOUNTER A PARTY OF SUITABLE DISCRETION, DO NOT DELIVER PAPERS, BUT CONTACT OUR OFFICE INSTEAD. ALSO, CONTACT OUR OFFICE UNLESS YOU ARE ABSOLUTELY SURE YOU ARE AUTHORIZED TO PROCEED WITH POSTING.</b>";} ?></li>        	
	<? }else{?>
<ol><li><?=id2name($data[server_id])?> is to make 2 service attempts on <?=$name?> at <?=$add1ax?> on different days.</li><li>
After all other attempts have proven unsuccessful, 
If <?=id2name($data[server_id])?> is unable to serve <?=$name?>:<br />
<?=id2name($data[server_id])?> is to post <?=$add1x?>.<?if ($data[avoidDOT] == 'checked'){ echo "  <b>PLEASE DO NOT MAKE ANY ATTEMPTS AT THIS ADDRESS, SIMPLY POST DOCUMENTS. IF YOU ENCOUNTER A PARTY OF SUITABLE DISCRETION, DO NOT DELIVER PAPERS, BUT CONTACT OUR OFFICE INSTEAD. ALSO, CONTACT OUR OFFICE UNLESS YOU ARE ABSOLUTELY SURE YOU ARE AUTHORIZED TO PROCEED WITH POSTING.</b>";} ?></li>
<? }
 }else{?>
<ol><li><?=id2name($data[server_id])?> is to make 2 service attempts on <?=$name?> at <?=$add1x?> on different days.</li><li>
After all other attempts have proven unsuccessful, 
If <?=id2name($data[server_id])?> is unable to serve <?=$name?>:<br />
<?=id2name($data[server_id])?> is to post <?=$add1x?>.</li></ol>
<? }?>
</ol></ol></td></tr>
<? 	
	}
}
if ($data[lossMit] != '' && $data[lossMit] != 'N/A - OLD L' && $data[packet_id] >= 12435){ 
	//if file is a final or preliminary, instruct to include available envelope stuffings
	$toAttorney=id2attorneyName($data[attorneys_id]);
		$lossMit="Per Maryland law HB472, please include one of the provided WHITE, preprinted #10 envelopes addressed to '$toAttorney'";
		if ($data[lossMit] == 'FINAL'){
			//if file is a final, also instruct to include envelope for court
			$toCounty=county2envelope2($data[circuit_court]);
			$lossMit .= ", and another WHITE, preprinted #10 envelope addressed to '".$toCounty."'";
		}
		$lossMit .= " with each defendant's service documents.";
?>
<tr>
	<td style='border: 1px solid;' align='center'><?=strtoupper($lossMit);?></td>
</tr>
<? } 
if ($data[server_idb] != '' || $data[address1b] != ''){
	$timedInstruct = "<li>Since only one attempt will be made at each address, ensure that they are still made at different times of day <b>(see below)</b></li>";
}else{
	$timedInstruct = "<li>You cannot make two attempts at the same property within the same 24 hour period.</li>";
}
?>
		<tr>
			<td align='center'><?=strtoupper($data[server_notes]);?></td>
		</tr>
</table>
<table style="border:solid 1px; font-size: 12px;" border=1 width="700px" align="center">
	<tr>
    	<td colspan="5" align="center"><b>Service Type 'A':</b></td>
    </tr>
    <tr>
    	<td colspan="5" align="center"><div style="width:650px; text-align:left;"><div style="border:ridge 3px; font-size: 16px;"><b style="text-decoration:underline;">ALL SERVICE MUST TAKE INTO ACCOUNT:</b><br>'Two good faith attempts on separate days' - MD Rule 14-209(b)</div>
        <li><b>Posting</b> must be done <b>after</b> <u>all attempts</u> have been completed.</li>
        <li>Attempts are to be performed in order listed on service instructions.</li>
		<?=$timedInstruct?>
		<li><b>Make one attempt either before 8 AM or after 6 PM, and another attempt between 9AM and 5PM.  Please avoid attempts between 8AM-9AM & 5PM-6PM.  "Good Faith" efforts must be made at different times of day, meaning that one attempt should be made <b>before</b> noon, and another afterwards, and they must be at least 24 hours apart.</b></li>
        <li>Photographs are required for <b>posting</b>s as well as for <b>attempt</b>s.</li>
		<li>Personal delivery can only be achieved in the following manner:
<pre>	1.  Direct Delivery to the defendants themselves.<br>
-OR-	2.  Substitute Delivery to someone <b>over the age of 18</b> who resides with
	the defendant in question <i>at the address being served</i>.</pre>
		<b>All personal delivery affidavits <b>REQUIRE</b> a physical description of the individual served.</b></li>
		<li><b>Delivery to MDWestServe of all service affidavits for this file must be accomplished by <?=$estFileDate?></b></li></div></td>
    </tr>
</table>
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