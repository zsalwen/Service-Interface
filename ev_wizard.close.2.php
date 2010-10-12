<?
$email=0;
$user = $_COOKIE[psdata][user_id];
$name = $_COOKIE[psdata][name];
$q11="SELECT needSignatory from ps_users where id='$user'";
$r11=@mysql_query($q11) or die ("Query: $q11<br>".mysql_error());
$d11=mysql_fetch_array($r11, MYSQL_ASSOC);
if ($d11[needSignatory] == "checked"){
	$q10="SELECT * FROM evictionSignatory WHERE evictionID='$packet' and serverID='$user'";
	$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
	if ($d10=mysql_fetch_array($r10, MYSQL_ASSOC)){
		mkAlert('REQUESTING CLOSE',$user,$user,$packet);
		psActivity("serviceCompleted");

		$user = $_COOKIE[psdata][user_id];
		ev_timeline($packet,$_COOKIE[psdata][name]." Completing Service");

			//update status
		echo "Checking server slot 1...<br>";
		if ($user == $ddr[server_id]){$email++;
			$q10="UPDATE evictionPackets SET request_close='YES' WHERE eviction_id = '$packet'";
			$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
			echo "Found!, Print Approval Request Sent...<br>";
		} elseif ($user != $ddr[server_ida] || $user != $ddr[server_idb]) {
		echo "You are not in server slot 1 for this file.<br>";
		}
		echo "Checking server slot 2...<br>";
		if($user == $ddr[server_ida]){$email++;
			$q10="UPDATE evictionPackets SET request_closea='YES' WHERE eviction_id = '$packet'";
			$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
			echo "Found!, Print Approval Request Sent...<br>";
		} elseif ($user != $ddr[server_id] || $user != $ddr[server_idb]) {
		echo "You are not in server slot 2 for this file.<br>";
		}
		echo "Checking server slot 3...<br>";
		if($user == $ddr[server_idb]){$email++;
			$q10="UPDATE evictionPackets SET request_closeb='YES' WHERE eviction_id = '$packet'";
			$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
			echo "Found!, Print Approval Request Sent...<br>";
		} elseif ($user != $ddr[server_id] || $user != $ddr[server_ida]) {
		echo "You are not in server slot 3 for this file.<br>";
		}
		echo "Checking server slot 4...<br>";
		if($user == $ddr[server_idc]){$email++;
			$q10="UPDATE evictionPackets SET request_closec='YES' WHERE eviction_id = '$packet'";
			$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
			echo "Found!, Print Approval Request Sent...<br>";
		} else{
		echo "You are not in server slot 4 for this file.<br>";
		}
		echo "Checking server slot 5...<br>";
		if($user == $ddr[server_idd]){$email++;
			$q10="UPDATE evictionPackets SET request_closed='YES' WHERE eviction_id = '$packet'";
			$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
			echo "Found!, Print Approval Request Sent...<br>";
		} else{
		echo "You are not in server slot 5 for this file.<br>";
		}
		echo "Checking server slot 6...<br>";
		if($user == $ddr[server_ide]){$email++;
			$q10="UPDATE evictionPackets SET request_closee='YES' WHERE eviction_id = '$packet'";
			$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
			echo "Found!, Print Approval Request Sent...<br>";
		} else{
		echo "You are not in server slot 6 for this file.<br>";
		}
		?>
	<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="a" /> NEXT FILE</div>

	<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
	<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
	<?
	}else{
		echo "You must enter a different signatory before you can request service print approval for this file.";
			?>
	<div class="nav"><input onClick="submitLoader()" type="radio" name="service_type" value="CHANGE SIGNATORY" /> CHANGE SIGNATORY</div>

	<input type="hidden" name="i" value="2">
	<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
	<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
	<?
	}

}else{
psActivity("serviceCompleted");

	$user = $_COOKIE[psdata][user_id];
	ev_timeline($packet,$_COOKIE[psdata][name]." Completing Service");

		//update status
	echo "Checking server slot 1...<br>";
	if ($user == $ddr[server_id]){$email++;
		$q10="UPDATE evictionPackets SET request_close='YES' WHERE eviction_id = '$packet'";
		$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
		echo "Found!, Print Approval Request Sent...<br>";
	} elseif ($user != $ddr[server_ida] || $user != $ddr[server_idb]) {
	echo "You are not in server slot 1 for this file.<br>";
	}
	echo "Checking server slot 2...<br>";
	if($user == $ddr[server_ida]){$email++;
		$q10="UPDATE evictionPackets SET request_closea='YES' WHERE eviction_id = '$packet'";
		$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
		echo "Found!, Print Approval Request Sent...<br>";
	} elseif ($user != $ddr[server_id] || $user != $ddr[server_idb]) {
	echo "You are not in server slot 2 for this file.<br>";
	}
	echo "Checking server slot 3...<br>";
	if($user == $ddr[server_idb]){$email++;
		$q10="UPDATE evictionPackets SET request_closeb='YES' WHERE eviction_id = '$packet'";
		$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
		echo "Found!, Print Approval Request Sent...<br>";
	} elseif ($user != $ddr[server_id] || $user != $ddr[server_ida]) {
	echo "You are not in server slot 3 for this file.<br>";
	}
	echo "Checking server slot 4...<br>";
	if($user == $ddr[server_idc]){$email++;
		$q10="UPDATE evictionPackets SET request_closec='YES' WHERE eviction_id = '$packet'";
		$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
		echo "Found!, Print Approval Request Sent...<br>";
	} else{
	echo "You are not in server slot 4 for this file.<br>";
	}
	echo "Checking server slot 5...<br>";
	if($user == $ddr[server_idd]){$email++;
		$q10="UPDATE evictionPackets SET request_closed='YES' WHERE eviction_id = '$packet'";
		$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
		echo "Found!, Print Approval Request Sent...<br>";
	} else{
	echo "You are not in server slot 5 for this file.<br>";
	}
	echo "Checking server slot 6...<br>";
	if($user == $ddr[server_ide]){$email++;
		$q10="UPDATE evictionPackets SET request_closee='YES' WHERE eviction_id = '$packet'";
		$r10=@mysql_query($q10) or die ("Query: $q10<br>".mysql_error());
		echo "Found!, Print Approval Request Sent...<br>";
	} else{
	echo "You are not in server slot 6 for this file.<br>";
	}
?>
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="a" /> NEXT FILE</div>

<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
<? }
if ($email > 0){
	$history=historyList($ddr[eviction_id],$ddr[attorneys_id]);
	if (strpos($history,'"')){
		$history=str_replace('"','\"',$history);
	}
	$to = "Service <service@mdwestserve.com>";
	$subject = "EV$packet, $name - Close Requested";
	$headers  = "MIME-Version: 1.0 \n";
	$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
	$headers .= "From: ".$_COOKIE[psdata][name]." <".$_COOKIE[psdata][email]."> \n";
	$body ="Server $name has requested close for eviction $packet.<br>
	<div style='border:solid 1px;'>Service in $ddr[circuit_court] COUNTY was completed by $ddr[service_status].<br>
	<center><h2>HISTORY ITEMS:</h2>
	$history
	</center></div><br>
	Please follow the link to quality control to process this file:<br>
	<a href='http://staff.mdwestserve.com/qualityControl.php'>Quality Control</a>";
	mail($to,$subject,$body,$headers);
}
if ($_POST[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_POST[mailDate]?>">
<? } ?>
<? if ($_GET[mailDate]){  ?>
<input type="hidden" name="mailDate" value="<?=$_GET[mailDate]?>">
<? } ?>