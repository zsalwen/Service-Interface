<? if (!$dname){ echo "<h1>NO DEFENDANT</h1>";} 
	if ($ddr[affidavit_status] == "IN PROGRESS"){
		$instructions = "SELECT AN ACTION SUCH AS:<br>
		<ul><li>Mailing and Posting (to enter service attempts or document postings),</li>
		<li>Personal Delivery (to make entries for if the service documents were left with the defendant or a co-resident),</li>
		<li>an Invalid Address (if an address, to the best of your knowledge, does not exist),</li>
		<li>or the Photo Manager (to upload service photos).</li>";
		if ($defendant == 'ALL'){
			$instructions .= "<li><b>PERSONAL DELIVERY ENTRIES MUST BE MADE SEPARATELY FOR EACH DEFENDANT.</b></li>";
		}
		$instructions .= "</ul>";
	}else{
				$instructions = "SELECT AN ACTION SUCH AS:<br>
		<ul><li>Printing the Affidavits (remember to print two copies per defendant),</li>
		<li>or the Photo Manager (to upload service photos).</li></ul>";
	}
	echo "<br>".$instructions;
	?>
<? if ($ddr[affidavit_status] != "IN PROGRESS" && $ddr[affidavit_status] != "NEED CORRECTION"){
 if($ddr[process_status] == 'AWAITING MAIL CONFIRMATION' && $_COOKIE[psdata][level] == "Operations"){?>
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="close.1" /> REQUEST CLOSE</div>
<?
	}
 }else{?>
<div class="nav"><input onClick="submitLoader()" type="radio" name="service_type" value="MAILING AND POSTING" /> MAILING AND POSTING</div>
<? if ($defendant != "ALL"){ ?>
<div class="nav"><input onClick="submitLoader()" type="radio" name="service_type" value="PERSONAL DELIVERY" /> PERSONAL DELIVERY</div>
<? }

if ($_COOKIE[psdata][level] == "Operations"){
	if ($defendant == "ALL"){
		$history_items = @mysql_query("select history_id from ps_history where packet_id='$packet' LIMIT 0,1") or die(mysql_error());
	}else{
		$history_items = @mysql_query("select history_id from ps_history where packet_id='$packet' and defendant_id='$defendant' LIMIT 0,1") or die(mysql_error());
	}
}else{
	if ($defendant == "ALL"){
		$history_items = @mysql_query("select history_id from ps_history where packet_id='$packet' and serverID='".$_COOKIE[psdata][user_id]."' LIMIT 0,1") or die(mysql_error());
	}else{
		$history_items = @mysql_query("select history_id from ps_history where packet_id='$packet' and defendant_id='$defendant' and serverID='".$_COOKIE[psdata][user_id]."' LIMIT 0,1") or die(mysql_error());
	}
}
$item=mysql_fetch_array($history_items, MYSQL_ASSOC);
if ($item[history_id]){ ?>
<div class="nav3"><input onClick="submitLoader()" type="radio" name="service_type" value="MAKE CORRECTION" /> MAKE CORRECTIONS</div>
<? } ?>
<div class="nav3"><input onClick="submitLoader()" type="radio" name="service_type" value="CHANGE SIGNATORY" /> CHANGE SIGNATORY</div>
<? if ($item[history_id] || ($_COOKIE[psdata][level] == "Operations")){ ?>
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="close.1" /> REQUEST CLOSE</div>
<? 
}
}?>
<div class="nav0"><input onClick="submitLoader()" Checked type="radio" name="i" value="2" /> NEXT</div>
<div class="nav4"><input onClick="submitLoader()" type="radio" name="i" value="photo.review" /> PHOTO MANAGER</div>
<div class="nav2"><input onClick="submitLoader()" type="radio" name="i" value="a" /> NEW</div>
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">

<? if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? } ?>