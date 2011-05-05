<?
function getFolder($otd){
	$path=explode("/",$otd);
	$count=(count($path)-2);
	$folder=$path["$count"];
	return $folder;
}
function digit2Str($digit){
	if ($digit == 1){
		return "ONE";
	}elseif($digit == 2){
		return "TWO";
	}elseif($digit == 3){
		return "THREE";
	}elseif($digit == 4){
		return "FOUR";
	}elseif($digit == 5){
		return "FIVE";
	}elseif($digit == 6){
		return "SIX";
	}elseif($digit == 7){
		return "SEVEN";
	}elseif($digit == 8){
		return "EIGHT";
	}elseif($digit == 9){
		return "NINE";
	}elseif($digit == 0){
		return "ZERO";
	}
}
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
if ($_GET[autoSave] == 1){
	ob_start();
}
include 'common.php';
$user = $_COOKIE[psdata][user_id];
$packet = $_GET[packet];
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Service Instructions for Packet '.$packet);
$query2="SELECT * FROM ps_instructions WHERE packetID='$packet' LIMIT 0,1";
$result2=@mysql_query($query2);
$data2=mysql_fetch_array($result2,MYSQL_ASSOC);
if ($data2 == ''){
	$query="SELECT attorneys_id, circuit_court, lossMit FROM ps_packets WHERE packet_id='$packet' LIMIT 0,1";
	$result=@mysql_query($query);
	$data=mysql_fetch_array($result,MYSQL_ASSOC);
	if($data[attorneys_id] == 56){
		if ($_GET['autoSave'] == 1){
			$typeC = getPage("http://service.mdwestserve.com/ps_instructions.brennan.php?packet=$packet&noField=1", 'MDWS Instructions Type C', '5', '');
		}else{
			$typeC = getPage("http://service.mdwestserve.com/ps_instructions.brennan.php?packet=$packet", 'MDWS Instructions Type C', '5', '');
		}
		echo $typeC;
	}elseif($data[attorneys_id] == 1){
		if ($_GET['autoSave'] == 1){
			$typeB = getPage("http://service.mdwestserve.com/ps_instructions.burson.php?packet=$packet&noField=1", 'MDWS Instructions Type B', '5', '');
		}else{
			$typeB = getPage("http://service.mdwestserve.com/ps_instructions.burson.php?packet=$packet", 'MDWS Instructions Type B', '5', '');
		}
		echo $typeB;
	}elseif($data[attorneys_id] == 70 || $data[attorneys_id] == 80){
		if ($_GET['autoSave'] == 1){
			$typeD = getPage("http://service.mdwestserve.com/ps_instructions.bgw.php?packet=$packet&noField=1", 'MDWS Instructions Type D', '5', '');
		}else{
			$typeD = getPage("http://service.mdwestserve.com/ps_instructions.bgw.php?packet=$packet", 'MDWS Instructions Type D', '5', '');
		}
		echo $typeD;
	}else{
		if ($_GET['autoSave'] == 1){
			$typeA = getPage("http://service.mdwestserve.com/ps_instructions.php?packet=$packet&noField=1", 'MDWS Instructions Type A', '5', '');
		}else{
			$typeA = getPage("http://service.mdwestserve.com/ps_instructions.php?packet=$packet", 'MDWS Instructions Type A', '5', '');
		}
		echo $typeA;
	}
	if ($_GET['autoSave'] == 1){
		$query3="SELECT packet_id, otd FROM ps_packets WHERE packet_id='$packet' LIMIT 0,1";
		$result3=@mysql_query($query3);
		$data3=mysql_fetch_array($result3,MYSQL_ASSOC);
		$contents=ob_get_clean();
		$folder=getFolder($data3['otd']);
		require_once("/thirdParty/dompdf-0.5.1/dompdf_config.inc.php");
		$html = stripslashes($contents);
		$old_limit = ini_set("memory_limit", "50M");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		echo $html;
		$dompdf->set_paper('letter', 'portrait');
		$dompdf->render();
		echo "2!";
		$unique = '/data/service/orders/'.$folder.'/Service Instructions For Packet '.$data3['packet_id'].'.PDF';
		echo "1!";
		echo $folder;
		file_put_contents($unique, $dompdf->output()); //save to disk
		echo "<script>window.open('instructionSave.php?packet=".$data3['packet_id']."&folder=".$folder."');</script>";
	}
}else{
	$query="SELECT * FROM ps_packets WHERE packet_id = '$packet' LIMIT 0,1";
	$result=@mysql_query($query);
	$data=mysql_fetch_array($result,MYSQL_ASSOC);
	$deadline=strtotime($data[date_received]);
	$received=date('n/j/y',$deadline);
	$estFileDate=fileDate($data[estFileDate]);
	$today=date('n/j/y');
	$r1=mysql_query("SELECT * FROM gasRates ORDER BY id DESC LIMIT 0,1");
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	if ($d1[id]){
		$rate = "<br><center><div style='font-size:14px;'>[GAS PRICE: $$d1[gasPrice] | CONTRACTOR SURCHARGE: $$d1[contractor_rate] | DATE: $today]</div></center>";
	}
	if ($d[rush] != ''){
		$rush='<b>RUSH</b>';
	}
	?>
	<style>
	body {
		margin:0px; padding:0px;
	}
	div {
		border: .2em dotted #900;
	}
	#border {
		border-width: 1px;
		border-style: solid;
		border-color: #900;
	} 
	pre {
		padding:0px;
	}
	li {
		font-size:12px;
	}
	</style>
	<img style="position:absolute; left:0px; top:0px; width:100px; height:100px;" src="http://staff.mdwestserve.com/small.logo.gif" class="logo">
	<table align="center" style="font-variant:small-caps; font-size:14px; width:700px;" border="0">
		<tr>
			<td valign="bottom" align="center" style="font-size:18px; font-variant:small-caps;" height="50px;">MDWestServe, Inc.<br><?=$data2[contact]?><br><?=$rush?>Service Instructions For Packet <?=$_GET[packet]?></td>
		</tr>
		<tr>
			<td align="center" style="font-size:18px; font-variant:small-caps;">Received: <?=$received?> || Affidavit Deadline: <?=$estFileDate?><?=$rate?></td>
		</tr>
		<tr>
			<td align="center"><div id='border'>
	<?
	if ($data2[allowPosting] != 'checked'){
		if ($data2[contact] == ""){
			echo "POSTING IS NOT ALLOWED FOR THIS DEFENDANT. DOCUMENTS MUST BE PERSONALLY DELIVERED.<br>
			IF SERVICE IS UNSUCCESSFUL, PLEASE CONTACT MDWESTERVE BY PHONE AT <B>(410) 828-4568</B> M-F 9-5 EST, OR BY EMAIL AT <b style='font-variant:small-caps;'>service@mdwestserve.com</b><br>";
		}else{
			echo "POSTING IS NOT ALLOWED FOR THIS DEFENDANT. DOCUMENTS MUST BE PERSONALLY DELIVERED.<br>
			IF THE NUMBER OF LISTED ATTEMPTS HAVE BEEN PERFORMED UNSUCCESSFULLY, PLEASE CONTACT MDWESTERVE AS INDICATED ABOVE, OR BY EMAIL TO service@mdwestserve.com<br>";
		}
	}
	if ($data2[postSeparateDay] == 'checked' && $data2[allowPosting] == 'checked'){
		echo strtoupper("<b>Posting must occur on a separate day from any other attempts.</b><br>");
	}
	if ($data2[photograph] != ''){
		echo strtoupper("<u>Photographs to Be Taken:</u> ".$data2[photograph]."<br>");
	}
	if ($data2[envInstruct] == 'GREEN'){
		//if file is a final or preliminary, instruct to include available envelope stuffings
		$toAttorney=id2attorneyName($data[attorneys_id]);
		//if preliminary, instruct to include one envelope to client
		$lossMit = "Per Maryland law HB472, please include one of the provided <u><b>GREEN</b></u>, preprinted #10 envelope addressed to '$toAttorney'";
		if ($data[lossMit] == 'FINAL'){
			//if final, instruct to include two envelopes: one to court and one to client
			$toCounty=county2envelope2($data[circuit_court]);
			$lossMit .= " and another <u><b>GREEN</b></u>, preprinted #10 envelope addressed to '".$toCounty."'";
		}
		echo "<span style='font-variant:small-caps; font-style:italic;'>$lossMit</span>";
	}elseif($data2[envInstruct] == 'WHITE'){
		//if file requires white BGW-style envelopes, then instruct to include envelope for attorney
		$toAttorney=id2attorneyName($data[attorneys_id]);
		$lossMit="Per Maryland law HB472, please include one of the provided <u><b>WHITE</b></u>, preprinted #10 envelope addressed to '$toAttorney'";
		if ($data[lossMit] == 'FINAL'){
			//if file is a final, instruct to include envelope for court
			$toCounty=county2envelope2($data[circuit_court]);
			$lossMit .= " and another <u><b>WHITE</b></u>, preprinted #10 envelope addressed to '".$toCounty."'";
		}
		$lossMit .= " with each defendant's service documents.";
		echo "<span style='font-variant:small-caps; font-style:italic;'>$lossMit</span>";
	}	?>

			</div></td>
		</tr>
	<?
	$i=0;
	$add = $data["address1"].', '.$data["city1"].', '.$data["state1"].' '.$data["zip1"];
	$bgw='';
	if ($data[attorneys_id] == 70){
		$bgw=" Complete attempts at this address before proceeding to other addresses (for service on this defendant).";
	}
	while ($i < 6){$i++;
		if ($data["name$i"]){
			$name=strtoupper($data["name$i"]);
			if ($data2["serveA$i"] == 'checked'){
				echo "<tr><td><div><strong>$name</strong>";
				$addCount=0;
				foreach(range('e','a') as $letter){
					$address=$i.$letter;
					if ($data2["customA$address"] != ''){$addCount++;
						echo strtoupper("<li>".id2name($data["server_id$letter"])." is to make ".$data2["attempts$letter"]." service attempts on $name at ".$data["address1$letter"].", " .$data["city1$letter"].", ".$data["state1$letter"]." ".$data["zip1$letter"]." on different days.$bgw</li>");
					}
				}
				if ($data2["customA$i"] != ''){$addCount++;
					if ($data[avoidDOT] == 'checked' && $addCount > 1){
						echo strtoupper("<li>".id2name($data[server_id])." is <b>NOT</b> to attempt service on $name at $add.</li>");
					}else{
						echo strtoupper("<li>".id2name($data[server_id])." is to make ".$data2[attempts]." service attempts on $name at $add on different days.</li>");
					}
				}
				if ($data2[allowPosting] == 'checked'){
					if ($data[avoidDOT] == 'checked' && $data2["customA$i"] == ''){
						echo strtoupper("<li>After all other attempts have been made, ".id2name($data[server_id])." is to post documents for $name at $add.  <b>PLEASE DO NOT MAKE ANY ATTEMPTS AT THIS ADDRESS, SIMPLY POST DOCUMENTS. IF YOU ENCOUNTER A PARTY OF SUITABLE DISCRETION, DO NOT DELIVER PAPERS, BUT CONTACT OUR OFFICE INSTEAD. ALSO, CONTACT OUR OFFICE UNLESS YOU ARE ABSOLUTELY SURE YOU ARE AUTHORIZED TO PROCEED WITH POSTING.</b></li>");
					}elseif ($data2[postSeparateDay] == 'checked'){
						echo strtoupper("<li>After all other attempts have been made, ".id2name($data[server_id])." is to post documents for $name at $add.  <b>This must be done on a separate day from any other attempts made at $add.</b></li>");
					}else{
						echo strtoupper("<li>After all other attempts have been made, ".id2name($data[server_id])." is to post documents for $name at $add.</li>");
					}
					
				}
				if ($data2["allowSubService$i"] == 'checked'){
					echo strtoupper("<center>Substitute Service Allowed (see service requirements at bottom).</center>");
				}else{
					echo strtoupper("<center>Substitute Service <b>NOT</b> Allowed.  Only deliver documents to $name.</center>");
				}
			}else{
				echo "<tr><td><div>";
				echo "<table width='100%' style='font-weight:bold;'><tr><td align='left' width='33%'>$name:</td><td align='left'>DO NOT ATTEMPT TO SERVE THIS DEFENDANT</td></tr></table>";
			}
			echo "</div></td></tr>";
		}
	}
	if ($data2[useNotes] == 'checked'){
		echo "<tr><td align='center'>".strtoupper($data[server_notes])."</td></tr>";
	} ?>
		<tr>
			<td align="center" style="width:700px;font-size:13px;"><div style="width:700px; text-align:left; border: 1px solid black;"><fieldset><legend>SERVICE REQUIREMENTS</legend><div style="border:3px ridge black; font-size: 16px;"><b style="text-decoration:underline;">ALL SERVICE MUST TAKE INTO ACCOUNT:</b><br>'Two good faith attempts on separate days' - MD Rule 14-209(b)</div>
		<li>You cannot make two attempts at the same property within the same 24 hour period.</li>
        <li>Posting must be done <b>after</b> <u>all attempts</u> have been completed.</li>
        <li>Attempts are to be performed in order listed on service instructions.</li>
		<li><b>Make one attempt either before 8 AM or after 6 PM, and another attempt between 9AM and 5PM.  Please avoid attempts between 8AM-9AM & 5PM-6PM.  "Good Faith" efforts must be made at different times of day, meaning that one attempt should be made <b>before</b> noon, and another afterwards, and they must be at least 24 hours apart.</b></li>
		<li>Personal delivery can only be achieved in the following manner:
<pre>	1.  Direct Delivery to the defendants themselves.<br>
-OR-	2.  Substitute Delivery to someone <b>over the age of 18</b> who resides with
	the defendant in question <i>at the address being served</i>.</pre>
		<b>All personal delivery affidavits <b>REQUIRE</b> a physical description of the individual served.</b></li>
		<li><b>Delivery to MDWestServe of all service affidavits for this file must be accomplished by <?=$estFileDate?></b></li>
		</fieldset></div></td>
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
		$folder=getFolder($data['otd']);
		require_once("/thirdParty/dompdf-0.5.1/dompdf_config.inc.php");
		$html = stripslashes($contents);
		$old_limit = ini_set("memory_limit", "50M");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		echo $html;
		$dompdf->set_paper('letter', 'portrait');
		$dompdf->render();
		//echo "2!";
		$unique = '/data/service/orders/'.$folder.'/Service Instructions For Packet '.$data['packet_id'].'.PDF';
		//echo "1!";
		//echo $folder;
		file_put_contents($unique, $dompdf->output()); //save to disk
		echo "<script>window.open('instructionSave.php?packet=".$data['packet_id']."&folder=".$folder."');</script>";
	}else{
		if (!$_GET[noField]){
			include "http://service.mdwestserve.com/fieldSheet.php?packet=".$data['packet_id']."&pageBreak=1";
		}
	}
}
mysql_close();
?>