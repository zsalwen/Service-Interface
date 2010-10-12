<?
if ($_GET[autoSave] == 1){
	ob_start();
}
include 'common.php';
$user = $_COOKIE[psdata][user_id];
$packet = $_GET[packet];
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Service Instructions for Packet '.$packet);
$query="SELECT packet_id, date_received, server_notes, name1, name2, name3, name4, name5, name6, server_id, server_ida, server_idb, server_idc, server_idd, server_ide, address1, address1a, address1b, address1c, address1d, address1e, city1, city1a, city1b, city1c, city1d, city1e, state1, state1a, state1b, state1c, state1d, state1e, zip1, zip1a, zip1b, zip1c, zip1d, zip1e, address2, address2a, address2b, address2c, address2d, address2e, city2, city2a, city2b, city2c, city2d, city2e, state2, state2a, state2b, state2c, state2d, state2e, zip2, zip2a, zip2b, zip2c, zip2d, zip2e, address3, address3a, address3b, address3c, address3d, address3e, city3, city3a, city3b, city3c, city3d, city3e, state3, state3a, state3b, state3c, state3d, state3e, zip3, zip3a, zip3b, zip3c, zip3d, zip3e, address4, address4a, address4b, address4c, address4d, address4e, city4, city4a, city4b, city4c, city4d, city4e, state4, state4a, state4b, state4c, state4d, state4e, zip4, zip4a, zip4b, zip4c, zip4d, zip4e, address5, address5a, address5b, address5c, address5d, address5e, city5, city5a, city5b, city5c, city5d, city5e, state5, state5a, state5b, state5c, state5d, state5e, zip5, zip5a, zip5b, zip5c, zip5d, zip5e, address6, address6a, address6b, address6c, address6d, address6e, city6, city6a, city6b, city6c, city6d, city6e, state6, state6a, state6b, state6c, state6d, state6e, zip6, zip6a, zip6b, zip6c, zip6d, zip6e FROM standard_packets WHERE packet_id = '$packet'";
$result=@mysql_query($query);
$data=mysql_fetch_array($result,MYSQL_ASSOC);
$deadline=strtotime($data[date_received]);
$received=date('m/d/Y',$deadline);
$deadline=$deadline+432000;
$deadline=date('m/d/Y',$deadline);
?>
<style>body { margin:0px; padding:0px; width:600px;}</style>
<img style="position:absolute; left:0px; top:0px; width:100px; height:100px;" src="http://service.mdwestserve.com/smallLogo.jpg" class="logo">
<table align="center" width="600px" style="font-variant:small-caps;" border="0">
	<tr>
    	<td valign="bottom" align="center" style="font-size:18px; font-variant:small-caps;" height="50px;">MDWestServe, Inc.<br>410-828-4568<br>Service Type 'B' For Packet <?=$_GET[packet]?></td>
    </tr>
	<tr>
		<td align="center" style="font-size:18px; font-variant:small-caps;">Received: <?=$received?> || Deadline: <?=$deadline?><br>This page must be returned with two sets of original affidavits for payment of service.</td>
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
		if ($data["address$vere"]){
		$add1ex=$data["address$vere"].', '.$data["city$vere"].', '.$data["state$vere"].' '.$data["zip$vere"];
		}
		if ($data["address$verd"]){
		$add1dx=$data["address$verd"].', '.$data["city$verd"].', '.$data["state$verd"].' '.$data["zip$verd"];
		}
		if ($data["address$verc"]){
		$add1cx=$data["address$verc"].', '.$data["city$verc"].', '.$data["state$verc"].' '.$data["zip$verc"];
		}
		if ($data["address$verb"]){
		$add1bx=$data["address$verb"].', '.$data["city$verb"].', '.$data["state$verb"].' '.$data["zip$verb"];
		}
		if ($data["address$ver"]){
		$add1ax=$data["address$ver"].', '.$data["city$ver"].', '.$data["state$ver"].' '.$data["zip$ver"];
		}
		$add1x = $data["address$i"].', '.$data["city$i"].', '.$data["state$i"].' '.$data["zip$i"];
		$s=id2name($data[server_id]);
		if ($data[server_ida] && $data[address1a]){
			$sa=id2name($data[server_ida]);
		}else{
			$sa=id2name($data[server_id]);
		}
		if ($data[server_idb] && $data[address1b]){
			$sb=id2name($data[server_idb]);
		}else{
			$sb=id2name($data[server_id]);
		}
		if ($data[server_idc] && $data[address1c]){
			$sc=id2name($data[server_idc]);
		}else{
			$sc=id2name($data[server_id]);
		}
		if ($data[server_idd] && $data[address1d]){
			$sd=id2name($data[server_idd]);
		}else{
			$sd=id2name($data[server_id]);
		}
		if ($data[server_ide] && $data[address1e]){
			$se=id2name($data[server_ide]);
		}else{
			$se=id2name($data[server_id]);
		}
	?>
	<tr>
		<td style="font-size:12px;">
		<strong><?=$name?>:</strong><br>
		<? if ($data[address1a]){?>
			<input type='checkbox'> <b><?=$sa?></b>: service attempt at <?=$add1ax?>.<br>
			<input type='checkbox'> <b><?=$sa?></b>: service attempt at <?=$add1ax?>.<br>
			<? if ($data[address1b]){ ?>
				<input type='checkbox'> <b><?=$sb?></b>: service attempt at <?=$add1bx?>.<br>
				<input type='checkbox'> <b><?=$sb?></b>: service attempt at <?=$add1bx?>.<br>
				<? if ($data[address1c]){ ?>
					<input type='checkbox'> <b><?=$sc?></b>: service attempt at <?=$add1cx?>.<br>
					<input type='checkbox'> <b><?=$sc?></b>: service attempt at <?=$add1cx?>.<br>
					<? if ($data[address1d]){ ?>
						<input type='checkbox'> <b><?=$sd?></b>: service attempt at <?=$add1dx?>.<br>
						<input type='checkbox'> <b><?=$sd?></b>: service attempt at <?=$add1dx?>.<br>
						<? if ($data[address1e]){ ?>
							<input type='checkbox'> <b><?=$se?></b>: service attempt at <?=$add1ex?>.<br>
							<input type='checkbox'> <b><?=$se?></b>: service attempt at <?=$add1ex?>.<br>
						<? } ?>
					<? } ?>
				<? } ?>
			<? } ?>
		<? } ?>
		<input type='checkbox'> <b><?=$s?></b>: service attempt at <?=$add1x?>.<br>
		<input type='checkbox'> <b><?=$s?></b>: service attempt at <?=$add1x?>.<br>
		<input type='checkbox'> After all other attempts have proven unsuccessful, <b><?=$s?></b> is to post <?=$add1x?>.<br>
		<input type='checkbox'> <b>MDWestServe</b> is to mail.
		</td></tr>
<? 		
	}
} 
?>
		<tr>
			<td align='center'><?=strtoupper($data[server_notes]);?></td>
		</tr>
		<tr><td>
<table style="border:solid 1px; font-size: 12px;" border=1 width="100%" align="center">
	<tr>
    	<td colspan="6" align="center"><b>Service Type 'B':</b></td>
    </tr>
    <tr>
    	<td colspan="6" align="center"><ul><li>You cannot make two attempts at the same property on the same day.</li>
        <li>The Deed of Trust Address is to be attempted before any other addresses.</li>
        <li><b>posting</b> must be done <b>after</b> <u>all attempts</u> have been completed.</li>
        <li>Attempts are to be performed in order listed on service instructions.</li>
		<li><b>Make one attempt either before 8 AM or after 6 PM, and another attempt between 9AM and 5PM.  Please avoid attempts between 8AM-9AM & 5PM-6PM.  "Good Faith" efforts must be made at different times of day.</b></li>
        <li>Photographs are required for <b>posting</b>s as well as for <b>attempt</b>s.</li></ul></td>
    </tr>
    <tr>
    	<td width="9%"><small># of Addresses</small></td>
   	  <td colspan="5" align="center"><small>Activity</small></td>
    </tr>
	<tr>
    	<td>1</td>
      	<td colspan='5'>All attempts (and <b>posting</b>) at Deed of Trust address</td>
    </tr>
	<tr>
    	<td>2</td>
      	<td width="21%">Two attempts at Deed of Trust address</td>
      <td colspan="2">Two attempts at second address</td>
        <td colspan="2"><b>posting</b> at Deed of Trust address</td>
    </tr>
	<tr>
    	<td>3</td>
      	<td>Two attempts at Deed of Trust address</td>
        <td width="17%">Two attempts at second address</td>
      <td width="16%">Two attempts at third address</td>
      <td width="20%"><b>posting</b> at Deed of Trust address</td>
  </tr>
	<tr>
    	<td>4+</td>
      	<td>Two attempts at Deed of Trust address</td>
        <td>Two attempts at second address</td>
        <td>Two attempts at third address</td>
        <td>Two attempts at fourth address</td>
        <td width="17%"><b>posting</b> at Deed of Trust address</td>
  </tr>
</table>
</td></tr></table>

<!-----------------------------------
<center><div align="left" style="width:600px; border:dashed 1px #000000;">
1. All files must be updated daily.<hr>
2. Log into http://mdwestserve.com as "Server" <small>(not as "Client" or "Auctioneer")</small> (OR)<br>
2. Email service updates to service@hwestauctions.com (OR)<br>
2. Fax updates to 410-828-6856 (OR)<br>
2. 9-5 EST M-F, phone updates to 410-828-4568 ask for Patrick (x213) or Zach (x214)<hr>
3. If another server is making attempts and you are only posting the property, Patrick or Zach will contact you when to proceed with service<hr>
4. Two copies of each affidavit are to be printed, signed, notarized, and mailed to Harvey West Auctioneers 300 East Joppa Road, Suite 1103, Towson, MD 21286<hr />
5. Fax notarized affidavit to 410-828-6856 (OR)<br />
5. Scan and email notarized affidavit to service@hwestauctions.com
</div></center>
<center><div align="left" style="width:600px">
<b>You may not make more than one attempt on an address per day.</b>
<b>When serving Corporations (INC):</b><br />
Service is made upon a corporation, incorporated association, or joint stock company by serving its resident agent, president, secretary, or treasurer. If the corporation, incorporated association, or joint stock company has no resident agent or if a good faith attempt to serve the resident agent, president, secretary, or treasurer has failed, service may be made by serving the manager, any director, vice president, assistant secretary, assistant treasurer, or other person expressly or impliedly authorized to receive service of process.
</div>
<div align="left" style="width:600px">
<strong>When serving Limited Liability Companies (LLC):</strong><br />
Service is made upon a limited liability company by serving its resident agent. If the limited liability company has no resident agent or if a good faith attempt to serve the resident agent has failed, service may be made upon any member or other person expressly or impliedly authorized to receive service of process.  
</div><div align="center" style="width:600px; font-size:24px;">
SERVICE ONLY LISTED ADDRESSES
</div></center>
------------------------->
<?
if ($_GET[autoPrint] == 1){
	echo "<script>
	if (window.self) window.print();
	self.close();
	</script>";
}
if ($_GET[autoSave] == 1){
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
	echo "<script>window.open('instructionSave.php?packet=".$data[packet_id]."');</script>";
	echo "<script>self.close();</script>";
}else{
	/*if (!$_GET[noField]){
		$count=0;
		while($count < 6){$count++;
			if ($data["name$count"]){
				include "http://service.mdwestserve.com/fieldSheet.php?packet=".$data['packet_id']."&def=$count&pageBreak=1";
			}
		}
	}*/
}
mysql_close();
?>