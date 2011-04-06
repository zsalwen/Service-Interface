<?
include 'common.php';
if ($_GET[svc] == 'Eviction'){
	$table = 'evictionPackets';
	$table2 = 'evictionHistory';
	$idType = 'eviction_id';
	$instructionsLink = 'ev_customInstructions';
	$field='id';
	$wizardLink = 'ev_wizard';
	$docType='EVICTION';
	$linkAppend="&svc=Eviction";
}else{
	$table = 'ps_packets';
	$table2 = 'ps_history';
	$idType = 'packet_id';
	$instructionsLink = 'customInstructions';
	$field='packet';
	$wizardLink = 'wizard';
	$docType='PRESALE';
	$linkAppend="&svc=presale";
}
if ($_GET[status] && $_COOKIE[psdata][level] == 'Operations'){
	$linkAppend .= "&status=$_GET[status]";
}
function mkAlert($alertStr,$entryID,$serverID,$packetID){
	mysql_select_db('core');
	@mysql_query("INSERT INTO ps_alert (alertStr, entryID, entryTime, serverID, packetID) VALUES ('$alertStr', '$entryID', NOW(), '$serverID', '$packetID')");
}
function id2name3($id){
$q="SELECT name FROM ps_users WHERE id = '$id' LIMIT 0,1";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($id == '' || $d[name] == ''){
		return "<i>&lt;blank&gt;</i>";
	}else{
		return $d[name];
	}
}
hardLog("loaded active files list.",'contractor');
if ($_GET[status]){
	$id = $_GET[status];
	$status = "&status=$id";
}else{
	$id = $_COOKIE['psdata']['user_id'];
	$status="";
}
function washURI2($uri){
$uri = str_replace('portal/','',$uri);
$uri = str_replace('/var/www/dataFiles/service/orders/','PS_PACKETS/',$uri);
$uri=str_replace('data/service/orders/','PS_PACKETS/',$uri);
return $uri;
}

function stripHours($date){
$hours = explode(':',$date);
return $hours[0];
}

function colorCode($hours){
if ($hours <= 0){ return "ff0000"; }
if ($hours > 0 && $hours <= 24){ return "ffFF00"; }
if ($hours > 24){ return "00FF00"; }
}

function envAllowed($server){
	$r=@mysql_query("SELECT envPrint FROM ps_users WHERE id='$server' LIMIT 0,1");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	return $d[envPrint];
}

function rangeLinks($exStart,$exStop,$server,$idType,$table,$linkAppend){
	if ($table == 'evictionPackets'){
			$q1="SELECT $idType FROM $table WHERE server_id='$server' ORDER BY $idType ASC LIMIT 0,1";
	}else{
		$q1="SELECT $idType FROM $table WHERE (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') ORDER BY $idType ASC LIMIT 0,1";
	}
	$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	$i=floor($d1[$idType]/1000)-1;
	$q="SELECT $idType FROM $table ORDER BY $idType DESC LIMIT 0,1";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	$end=$d[$idType]/1000;
	$end=ceil($end);
	$header = "<table align='center'><tr>";
	$listCount=0;
	while ($i < ($end-1)){$i++;
		$start=$i;
		$stop=$i+1;
		if ($start != $exStart && $stop != $exStop){
			$newList = "<td><div style='border: 1px solid black; font-size:11px;'><center><a href='http://service.mdwestserve.com/ps_worksheet.php?start=$start".$linkAppend."'>";
			$start=$start*1000;
			$stop=$stop*1000;
			$newList .= "$start-$stop</a>";
			if ($table == 'evictionPackets'){
				$q2="SELECT $idType FROM $table WHERE server_id='$server' AND $idType >= '$start' AND $idType < '$stop'";
			}else{
				$q2="SELECT $idType FROM $table WHERE (server_id='$server' OR server_ida='$server' OR server_idb='$server' OR server_idc='$server' OR server_idd='$server' OR server_ide='$server') AND $idType >= '$start' AND $idType < '$stop'";
			}
			$r2=@mysql_query($q2) or die ("Query $q2<br>".mysql_error());
			$count = mysql_num_rows($r2);
			$newList .= "<br>($count)</center></div></td>";
			if ($count > 0){$listCount++;
				$list .= $newList;
			}
		}
	}
	$list .= "</tr></table>";
	if ($listCount > 1){
		$header .= "<td colspan='$listCount' align='center' style='font-weight:bold;font-variant:small-caps;'>FILE RANGE LINKS</td></tr><tr>";
		return $header.$list;
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

function getEntries($id,$server,$table,$idType){
	$r=@mysql_query("SELECT history_id FROM $table WHERE $idType='$id' AND serverID='$server'");
	$c=mysql_num_rows($r);
	if ($c > 1){
		return "<small>$c ENTRIES</small>";
	}elseif($c == 1){
		return "<small>1 ENTRY</small>";
	}else{
		return "<small>NO ENTRIES</small>";
	}
}

function justDate($dateTime){
	$date=explode(' ',$dateTime);
	$date=strtotime($date[0]);
	return date('n/j/y',$date); 
}

function fileDate($date){
	$date=strtotime($date)-86400;
	return date('n/j/y',$date); 
}

function dueDate($date){
	$deadline=strtotime($date);
	$deadline=$deadline+432000;
	return date('n/j/y',$deadline);
}

function id2attorney2($id){
	$q="SELECT full_name FROM attorneys WHERE attorneys_id = '$id' LIMIT 0,1";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[full_name];
}

function makeEntry($packet){
	if ($_GET[svc] == 'Eviction'){
		$table = 'evictionPackets';
		$table2 = 'evictionHistory';
		$idType = 'eviction_id';
		$instructionsLink = 'ev_customInstructions';
		$field='id';
		$wizardLink = 'ev_wizard';
		$docType='EVICTION';
		$dir='ev';
	}else{
		$table = 'ps_packets';
		$table2 = 'ps_history';
		$idType = 'packet_id';
		$instructionsLink = 'customInstructions';
		$field='packet';
		$wizardLink = 'wizard';
		$docType='PRESALE';
		$dir='otd';
	}
	$q="SELECT *, DATEDIFF(estFileDate, CURDATE()) as hours FROM $table WHERE $idType='$packet' LIMIT 0,1";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	if ($_GET[status] && $_COOKIE[psdata][level] == 'Operations'){
		$id = $_GET[status];
	}else{
		$id = $_COOKIE[psdata][user_id];
	}
	//calculate due date of 5pm on day previous to estFileDate
	$curHour=date('G');
	$hours=(($d[hours]-1)*24)+7+$curHour;
	if ($d[estFileDate] != '0000-00-00'){
		$fileDate=fileDate($d[estFileDate]);
		$due="<br>Due: $fileDate";
	}else{
		$dueDate=dueDate($d[date_received]);
		$due="<br>Due: $dueDate";
	}
	if ($d[reopenDate] != '0000-00-00'){
		$date=strtotime($d[reopenDate]);
		$received="Start: ".justDate($d['date_received'])."<br>REStart:".date('n/j/y',$date); 
	}else{
		$received="Start: ".justDate($d['date_received']);
	}
	?>  
	<tr bgcolor="<?=colorCode($hours)?>">
		<td style="border-top:solid 1px #000000; background-color:#FFFFFF; font-size:11px; font-variant:small-caps;" nowrap="nowrap" valign="top"><? if ($d[rush]){ echo "<b style='display:block; background-color:FFBB00;'>RUSH</b>";}?><?=$received?><?=$due?>
		</td>
		<td style="border-top:solid 1px #000000;" valign="top" nowrap="nowrap">
		<table><tr><td nowrap="nowrap">
				<font style="font-weight:bold">[<?=$d['package_id']?>]<big>[<? if ($_COOKIE[psdata][level] == 'Operations'){ echo "<a href='http://staff.mdwestserve.com/$dir/order.php?packet=".$d[$idType]."' target='_blank'>";}?><?=$d[$idType]?><? if ($_COOKIE[psdata][level] == 'Operations'){ echo "</a>";}?>]</big></font>
				<? echo "<form style='display:inline;' name='$packet' action='".$wizardLink.".php' target='_blank'><select style='background-color:CCEEFF; font-size:11px;' name='jump' onchange='this.form.submit();'><option value=''>JUMP TO WIZARD</option>";
                if ($_GET[svc] != 'Eviction'){
					$optList='';
				    $i2=0;
				    while ($i2 < 6){$i2++;
						if ($d["name$i2"]){
							$defCount++;
							$optList .= "<option value='".$d[$idType]."-$i2'>".$i2.". ".substr($d["name$i2"],0,25)."</option>";
						}
				    }
					if ($defCount > 1){
						echo "<option value='".$d[$idType]."-ALL'>ALL DEFENDANTS</option>";
					}
					echo $optList;
	            }else{
					$optList='';
					//skip first defendant, to minimize any conflicts with data entry for all occupants
				    echo "<option value='".$d[$idType]."-1'>1. ALL OCCUPANTS</option>";
					if ($d[attorneys_id] == 3){
						$i2=1;
						while ($i2 < 6){$i2++;
							if ($d["name$i2"] && (strtoupper($d["onAffidavit$i2"]) != 'CHECKED')){
								$defCount++;
								$optList .= "<option value='".$d[$idType]."-$i2'>".$i2.". ".substr($d["name$i2"],0,25)."</option>";
							}
						}
					}
					echo $optList;
				}
				echo "</select></form>";  ?>
			   </td></tr><tr><td >
				<? if ($d['payAuth'] == 1){?><img src="/gfx/icon.pay.jpg" height="35" border="0" /><? }?>
				<? if ($d['affidavit_status'] == "NEED CORRECTION"){?><a href="ps_corrections.php?server=<?=$id?>"><img src="/gfx/icon.alert.jpg" height="35" border="0" /></a><? }?>
				<? if ($d['affidavit_status'] == "SERVICE CONFIRMED"){ ?><a href="markPrinted.php?print=<?=$_COOKIE[psdata][user_id]?>&packet=<?=$d[$idType]?>&all=<?=$_GET[all]?>&status=<?=$id?>&svc=<?=$_GET[svc]?>" target="_blank"><img src="/gfx/icon.print.jpg" height="35" border="0" /></a><? }?>		
				<? if ($d['request_close'] == "YES" || $d['request_closea'] == "YES" || $d['request_closeb'] == "YES" || $d['request_closec'] == "YES" || $d['request_closed'] == "YES" || $d['request_closee'] == "YES"){?><img src="/gfx/icon.closed.jpg" height="35" border="0" /><? }?>
				<a href="<?=$instructionsLink?>.php?<?=$field?>=<?=$d[$idType]?>" target="_blank"><img src="/gfx/icon.instructions.jpg" height="35" border="0" /></a>
				<a href="<?=washURI2($d['otd']);?>" target="_blank"><img src="/gfx/icon.envelope.jpg" height="35" border="0" /></a>
				<? if($idType == 'packet_id' && $d[$idType] >= 12435 && $d[lossMit] != "N/A - OLD L" && $d[lossMit] != ''  && $d[attorneys_id] != 1){
					if (envAllowed($id) == 'YES'){
						if ($d[attorneys_id] == '70'){
							echo "<a href='http://service.mdwestserve.com/stuffPacket.bgw.php?packet=$d[$idType]' target='_blank'><img src='/gfx/icon.green.envelope.jpg' height='35' border='0' /></a>";
						}else{
							echo "<a href='http://service.mdwestserve.com/stuffPacket.2.php?packet=$d[$idType]' target='_blank'><img src='/gfx/icon.green.envelope.jpg' height='35' border='0' /></a>";
						}
					}
					$lossMitInstructions="include a WHITE, preprinted #10 envelope addressed to <span style='color:#990000;'>".strtoupper(id2attorney2($d[attorneys_id]))."</span>";
					if ($d[lossMit] == "FINAL"){
						//if file is a final, also instruct to include envelope for court
						$toCounty=county2envelope2($d[circuit_court]);
						$lossMitInstructions .= ", and another WHITE envelope addressed to <span style='color:#990000;'>".$toCounty."</span>";
					}
					$lossMit .= " with each defendant's service documents.";
					echo " <div style='display:inline-block; font-weight:bold; width:250px; font-size:10px; padding:0px; border: double 2px; background-color:FFFFFF; line-height: 9px;'>".strtoupper($lossMitInstructions)."</div> "; 
				?>
				<!----------
				<a href="http://service.mdwestserve.com/stuffPacket.php?packet=<?=$d[$idType]?>" target='_blank'><img src="/gfx/icon.green.envelope.jpg" height="35" border="0" /></a>
				-------------------------->
				<? }elseif($idType == 'packet_id' && $d[$idType] >= 12435 && $d[lossMit] != "N/A - OLD L" && $d[lossMit] != '' && $d[attorneys_id] == 1){
					//if file is a final or preliminary, instruct to include envelope for attorney
					$lossMitInstructions="include a GREEN, preprinted #10 envelope addressed to <span style='color:#990000;'>".strtoupper(id2attorney2($d[attorneys_id]))."</span>";
					if ($d[lossMit] == "FINAL"){
						//if file is a final, also instruct to include envelope for court
						$toCounty=county2envelope2($d[circuit_court]);
						$lossMitInstructions .= ", and another GREEN envelope addressed to <span style='color:#990000;'>".$toCounty."</span>";
					}
					$lossMit .= " with each defendant's service documents.";
					echo " <div style='display:inline-block; font-weight:bold; width:250px; font-size:10px; padding:0px; border: double 2px; background-color:FFFFFF; line-height: 9px;'>".strtoupper($lossMitInstructions)."</div> "; 
				} ?>	
			</td></tr></table>
		</td>
		<td style="border-top:solid 1px #000000;" align="left" valign="top"><?=$d['circuit_court']?><br /><small>(<?=$d['client_file']?>)<br><?=$d[case_no]?></small></td>
		<td style="border-top:solid 1px #000000;" nowrap="nowrap" valign="top">
			<li style="font-size:small;"><?=id2name3($d['server_id'])?>:<br><?=getEntries($d[$idType],$d["server_id$letter"],$table2,$idType)?>-<?=strtoupper(trim($d['state1']))?><? if($d[svrPrint]==1){ echo "PRINTED";}
			$list2 .= "|$d[server_id]|"; 
			if ($_GET[svc] != 'Eviction'){
				foreach(range('a','e') as $letter){
					if ($d["server_id$letter"]){
						if(strpos($list2,"|".$d["server_id$letter"]."|") === false){
							$list2 .= "|".$d["server_id$letter"]."|";
							echo "</li><li style='font-size:small;'>".id2name3($d["server_id$letter"]).":<br>".getEntries($d[$idType],$d["server_id$letter"],$table2,$idType)."-".strtoupper(trim($d["state1$letter"]));
							if($d["svrPrint$letter"]==1){ echo "PRINTED";}
						}else{
							echo "-".strtoupper($d["state1$letter"]);
						}
					}
				}
			}
			echo "</li>"; ?>	
		</td>
		<td style="border-top:solid 1px #000000; background-color:#FFFFFF; font-size:11px; font-variant:small-caps;" nowrap="nowrap" valign="top"><? if ($d[rush]){ echo "<b style='display:block; background-color:FFBB00;'>RUSH</b>";}?>Status:<br /><?=$d[affidavit_status];?><br /><?=$d[filing_status];?></td>
	</tr>
	<? 
}


//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//===------------------------------------END FUNCTIONS------------------------------------===
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


?>
<style>
td.psc { color:#FFFFFF; background-color: #6699cc;}
td.psc:hover { color:#000000; background-color: #666699; cursor:pointer; font-size:16px;}
li,ol,table,tr,td, body {padding:0px;}
ol {display:inline;}
</style>
<?
if (!$_GET[all]){
	$r1=@mysql_query("SELECT packet_id FROM ps_packets WHERE (server_id = '$id' OR server_ida = '$id' OR server_idb = '$id' OR server_idc = '$id' OR server_idd = '$id' OR server_ide = '$id') AND process_status='ASSIGNED'");
	$r2=@mysql_query("SELECT eviction_id FROM evictionPackets WHERE server_id = '$id' AND process_status='ASSIGNED'");
	$all='';
}else{
	$r1=@mysql_query("SELECT packet_id FROM ps_packets WHERE (server_id = '$id' OR server_ida = '$id' OR server_idb = '$id' OR server_idc = '$id' OR server_idd = '$id' OR server_ide = '$id')");
	$r2=@mysql_query("SELECT eviction_id FROM evictionPackets WHERE server_id = '$id'");
	$all="&all=1";
}
$count1 = mysql_num_rows($r1);
$count2 = mysql_num_rows($r2);
?>
<div style="text-align:center; font-size:25px;"><a href="?svc=presale<?=$all?><?=$status?>"><?=$count1?> Presale Cases</a> | <a href="?svc=Eviction<?=$all?><?=$status?>"><?=$count2?> Eviction Cases</a> | <a href="ps_standard.php"><?=$count3?> Standard Cases</a></div> 
<table width="100%" class="noprint">
	<tr>
    	<td align="center"><img src="/gfx/icon.alert.jpg" height="30" border="0" /></td>
    	<td align="center"><img src="/gfx/icon.print.jpg" height="30" border="0" /></td>
    	<td align="center"><img src="/gfx/icon.closed.jpg" height="30" border="0" /></td>
        <td align="center"><img src="/gfx/icon.instructions.jpg" height="30" border="0" /></td>
        <td align="center"><img src="/gfx/icon.envelope.jpg" height="30" border="0" /></td>
		<td align="center"><img src="/gfx/icon.green.envelope.jpg" height="30" border="0" /></td>
    	<td align="center"><img src="/gfx/icon.pay.jpg" height="30" border="0" /></td>
		<form action="liveAffidavit.php" target="_blank">
		<td align="center"><input type="hidden" name="start" value="0"><input type="hidden" name="stop" value="200000"><input type="hidden" name="server" value="<?=$id?>"><input type="hidden" name="ev" value="YES"><input type="submit" name="submit" value="GO"></td>
        </form>
		<form action="http://service.mdwestserve.com/ps_worksheet.php">
		<td align="center"><select name='svc'><option value='presale'>PRESALE</option><option value='Eviction'>EVICTION</option></select>&nbsp;<input name='psFile' size='6' <? if ($_GET[psFile] != ''){ echo "value='$_GET[psFile]'";}else{ echo "value='File #'";}?> onclick="value=''";>&nbsp;<input type="submit" name="submit" value="Go!"></td>
		</form>
    </tr>
    <tr>
        <td align="center" style='border:0px !important;'>Needs Corrections</td>
    	<td align="center" style='border:0px !important;'>Printing Approved</td>
        <td align="center" style='border:0px !important;'>Close Requested</td>
        <td align="center" style='border:0px !important;'>Service Instructions</td>
        <td align="center" style='border:0px !important;'>Papers to Serve</td>
		<td align="center" style='border:0px !important;'>Envelope Stuffings</td>
    	<td align="center" style='border:0px !important;'>Pay Approved</td>
		<td align="center" style='border:0px !important;'>Print Presale & Eviction Affidavits</td>
		<td align="center" style='border:0px !important;'>Load File Detail</td>
	</tr>
</table>
<div class="noprint" style="text-align:center; font-variant:small-caps; font-size:24px; background-color:#FF0000; color:#FFFFFF; font-weight:bold;">SERVICE ALL FILES EXACTLY AS LISTED ON INSTRUCTION SHEET</div>
<table width="100%" style="border-collapse:collapse; padding:0px !important;" border="1">
<?
if ($_COOKIE['psdata']['level'] != "Operations"){
	logAction($_COOKIE['psdata']['user_id'], $_SERVER['PHP_SELF'], 'Viewing Active File Tracker');
}
if ($_GET[svc] == "Eviction"){
	$q= "select * from $table where server_id = '$id'";
}else{
	$q= "select * from $table where (server_id = '$id' OR server_ida = '$id' OR server_idb = '$id' OR server_idc = '$id' OR server_idd = '$id' OR server_ide = '$id')";
}
//if viewing assigned files...
if ($_GET[all] != 1  && $_GET[psFile] == ''){
	$q .= " and (process_status = 'ASSIGNED' or process_status = 'READY') ORDER BY estFileDate, $idType ASC";
//or viewing a specific single file
}elseif($_GET[psFile] != ''){
	//allow Operations to view details of any file
	if ($_COOKIE[psdata][level] == 'Operations'){
		$q = "select * from $table where $idType='".$_GET[psFile]."'";
	//but servers can only view details of files on which they are set as server in our database
	}else{
		$q .= " and $idType='".$_GET[psFile]."'";
	}
//or viewing all
}else{
	$linkAppend .= "&all=1";
	//then display rangeLinks, and perform necessary calculations.
	if (!$_GET[start]){
		if ($_GET[svc] == "Eviction"){
			$r2=@mysql_query("SELECT $idType FROM $table WHERE server_id='$id' ORDER BY $idType DESC LIMIT 0,1") or die (mysql_error());
		}else{
			$r2=@mysql_query("SELECT $idType FROM $table WHERE server_id='$id' OR server_ida='$id' OR server_idb='$id' OR server_idc='$id' OR server_idd='$id' OR server_ide='$id' ORDER BY $idType DESC LIMIT 0,1") or die (mysql_error());
		}
		$d2=mysql_fetch_array($r2,MYSQL_ASSOC);
		$i=floor($d2[$idType]/1000);
	}else{
		$i=$_GET[start];
	}
	$rangeLinks="<tr><td colspan='20' align='center'>".rangeLinks($i,$i+1,$id,$idType,$table,$linkAppend)."</td></tr>";
	echo $rangeLinks;
	$start=$i*1000;
	$stop=($i+1)*1000;
	$q .= " AND $idType >= $start AND $idType < $stop ORDER BY estFileDate, $idType";
}
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {$i++;
	makeEntry($d[$idType]);
}
if ($i == 0){
	echo "<tr bgcolor='#FF0000'><td colspan='7' align='center'><font color='#FFFF00'><strong>No Files To Display</strong></font></td></tr>";
}
if ($_GET[all] == 1){
	echo $rangeLinks;
	$listType="$docType All Files List Range $start-$stop";
}elseif($_GET[psFile] != ''){
	$listType="Individual Files List for $docType ".$_GET[psFile];
}else{
	$listType="$docType Active Files List";
}
if ($_COOKIE[psdata][level] == 'Operations' && $_GET[status] != ''){
	$listType .= " for Server ".id2name3($_GET[status]);
}
echo "</table>";

error_log("[".date('h:iA n/j/y')."] ".$_COOKIE[psdata][name]." Viewing $listType \n",3,"/logs/user.log");
include 'footer.php'; ?>