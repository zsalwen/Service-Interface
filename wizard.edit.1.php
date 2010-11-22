<? 
foreach ($_POST[remove] as $key => $value){
	echo "Editing affidavit item #$key<br>";
	$history = "<div>Editing affidavit item #$key</div>";
	$r=@mysql_query("select * from ps_history where history_id = '$key'");		
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	//split up actionDate into separate time and date fields
	if ($d[actionDate] != '' && $d[actionDate] != '0000-00-00 00:00:00'){
		$time=explode(' ',$d[actionDate]);
		$date=$time[0];
		$time=$time[1];
		$date=explode('-',$date);
		$year=$date[0];
		$month=$date[1];
		$day=$date[2];
		$time=explode(':',$time);
		$hour=$time[0];
		$minute=$time[1];
		//if hour > 12, subtract 12, set ampm to pm
		if ($hour > 12){
			$hour=$hour-12;
			$ampm="PM";
		}else{
			$ampm="AM";
		}
	}else{
		$year='';
		$month='';
		$day='';
		$hour='';
		$minute='';
		$ampm='';
	}
	if ($d[action_str] == 'Attempted Service' || $d[action_str] == 'Posted Papers'){
		//1. address
		$address=$d[address];
		$addressType=getAddressType($address);
		//2. month, day, year dropdowns
		//3. hour, minute am/pm
		//4. explode desc
		$desc=explodeDesc($d[action_str]);
		//DISPLAY
		if ($d[action_str] == 'Posted Papers'){
			$detail='Detail the place of posting: ';
		}else{
			$detail='Detail effort to rouse defendant: ';
		}
		?>
		<table width="20%"><tr><td colspan=2>1) Select Address 
		<select name="address_source[<?=$key?>]">
			<option><?=$address?></option>
			<option value="1"><?=$ddr[address1]?>, <?=$ddr[city1]?>, <?=$ddr[state1]?> <?=$ddr[zip1]?></option>
			<? if ($ddr[address1a]){?>
			<option value="1a"><?=$ddr[address1a]?>, <?=$ddr[city1a]?>, <?=$ddr[state1a]?> <?=$ddr[zip1a]?></option>
			<? }
			if ($ddr[address1b]){?>
			<option value="1b"><?=$ddr[address1b]?>, <?=$ddr[city1b]?>, <?=$ddr[state1b]?> <?=$ddr[zip1b]?></option>
			<? }
			if ($ddr[address1c]){?>
			<option value="1c"><?=$ddr[address1c]?>, <?=$ddr[city1c]?>, <?=$ddr[state1c]?> <?=$ddr[zip1c]?></option>
			<? } 
			if ($ddr[address1d]){?>
			<option value="1d"><?=$ddr[address1d]?>, <?=$ddr[city1d]?>, <?=$ddr[state1d]?> <?=$ddr[zip1d]?></option>
			<? } 
			if ($ddr[address1e]){?>
			<option value="1e"><?=$ddr[address1e]?>, <?=$ddr[city1e]?>, <?=$ddr[state1e]?> <?=$ddr[zip1e]?></option>
			<? } ?>
		</select>
		</td></tr>
		<tr><td colspan=2>2) Month, Day, Year <select name="month[<?=$key?>]"><?=mkmonth($month)?></select> <select name="day[<?=$key?>]"><?=mkday($day)?></select> <select name="year[<?=$key?>]"><?=mkyear($year)?></select></td></tr>
		<tr><td colspan=2>3) Hour, Minute, AM/PM <select name="hour[<?=$key?>]"><?=mkmonth($hour)?></select> <select name="minute[<?=$key?>]"><?=mkminute($minute)?></select>
		 <select name="ampm[<?=$key?>]"><option value="<?=$ampm?>"><?=$ampm?></option><option value="AM">AM</option><option value="PM">PM</option></select></td></tr>
		<tr><td colspan="2">4) <?=$detail?> </td></tr>
		<tr><td colspan="2"><input name="defendant_detail[<?=$key?>]" value="<?=$desc;?>" size="60"></td></tr></table>
		<input type="hidden" name="served[<?=$key?>]" value="<?=$d[wizard]?>" />
		<input type="hidden" name="addressType[<?=$key?>]" value="<?=$addressType?>" />
		<?
	}elseif($d[wizard] == 'MAILING DETAILS'){
		echo "<h1>EDIT MAILING ENTRIES THROUGH historyModify.php</h1>";
	}elseif ($d[wizard] == 'NOT BORROWER'){
		//1. address
		$address=$d[address];
		$addressType=getAddressType($address);
		//2. resident name
		$name=$d[resident];
		//3. resident age
		$age=explodeAge($d[action_str]);
		//4. month, day, year dropdowns
		//5. hour, minute am/pm
		//6. residentDesc
		$desc=$d[residentDesc];
		//DISPLAY
		?>
		<table width="20%"><tr><td colspan=2>1) Select Address 
		<select name="address_source[<?=$key?>]">
			<option><?=$address?></option>
			<option value="1"><?=$ddr[address1]?>, <?=$ddr[city1]?>, <?=$ddr[state1]?> <?=$ddr[zip1]?></option>
			<? if ($ddr[address1a]){?>
			<option value="1a"><?=$ddr[address1a]?>, <?=$ddr[city1a]?>, <?=$ddr[state1a]?> <?=$ddr[zip1a]?></option>
			<? }
			if ($ddr[address1b]){?>
			<option value="1b"><?=$ddr[address1b]?>, <?=$ddr[city1b]?>, <?=$ddr[state1b]?> <?=$ddr[zip1b]?></option>
			<? }
			if ($ddr[address1c]){?>
			<option value="1c"><?=$ddr[address1c]?>, <?=$ddr[city1c]?>, <?=$ddr[state1c]?> <?=$ddr[zip1c]?></option>
			<? } 
			if ($ddr[address1d]){?>
			<option value="1d"><?=$ddr[address1d]?>, <?=$ddr[city1d]?>, <?=$ddr[state1d]?> <?=$ddr[zip1d]?></option>
			<? } 
			if ($ddr[address1e]){?>
			<option value="1e"><?=$ddr[address1e]?>, <?=$ddr[city1e]?>, <?=$ddr[state1e]?> <?=$ddr[zip1e]?></option>
			<? } ?>
		</select>
		</td></tr>
		<tr><td>2) Name</td><td><input name="name" value="<?=$name;?>" size="20"></td></tr>
		<tr><td>3) </td><td><input name="age" value="<?=$age;?>" size="8"> YEARS OF AGE</td></tr>
		<tr><td colspan=2>4) Month, Day, Year <select name="month[<?=$key?>]"><?=mkmonth($month)?></select> <select name="day[<?=$key?>]"><?=mkday($day)?></select> <select name="year[<?=$key?>]"><?=mkyear($year)?></select></td></tr>
		<tr><td colspan=2>5) Hour, Minute, AM/PM <select name="hour[<?=$key?>]"><?=mkmonth($hour)?></select> <select name="minute[<?=$key?>]"><?=mkminute($minute)?></select>
		 <select name="ampm[<?=$key?>]"><option value="<?=$ampm?>"><?=$ampm?></option><option value="AM">AM</option><option value="PM">PM</option></select></td></tr>
		<tr><td>6) Description of individual served</td><td><input name="defendant_detail[<?=$key?>]" value="<?=$desc?>" size="60"></td></tr></table>
		<input type="hidden" name="served[<?=$key?>]" value="<?=$d[wizard]?>" />
		<input type="hidden" name="addressType[<?=$key?>]" value="<?=$addressType?>" />
		<?
	}elseif($d[wizard] == 'BORROWER'){
		//1. address
		$address=$d[address];
		$addressType=getAddressType($address);
		//2. month, day, year dropdowns
		//3. hour, minute am/pm
		//4. residentDesc
		$desc=$d[residentDesc];
		//DISPLAY
		?>
		<table width="20%"><tr><td colspan=2>1) Select Address 
		<select name="address_source[<?=$key?>]">
			<option><?=$address?></option>
			<option value="1"><?=$ddr[address1]?>, <?=$ddr[city1]?>, <?=$ddr[state1]?> <?=$ddr[zip1]?></option>
			<? if ($ddr[address1a]){?>
			<option value="1a"><?=$ddr[address1a]?>, <?=$ddr[city1a]?>, <?=$ddr[state1a]?> <?=$ddr[zip1a]?></option>
			<? }
			if ($ddr[address1b]){?>
			<option value="1b"><?=$ddr[address1b]?>, <?=$ddr[city1b]?>, <?=$ddr[state1b]?> <?=$ddr[zip1b]?></option>
			<? }
			if ($ddr[address1c]){?>
			<option value="1c"><?=$ddr[address1c]?>, <?=$ddr[city1c]?>, <?=$ddr[state1c]?> <?=$ddr[zip1c]?></option>
			<? } 
			if ($ddr[address1d]){?>
			<option value="1d"><?=$ddr[address1d]?>, <?=$ddr[city1d]?>, <?=$ddr[state1d]?> <?=$ddr[zip1d]?></option>
			<? } 
			if ($ddr[address1e]){?>
			<option value="1e"><?=$ddr[address1e]?>, <?=$ddr[city1e]?>, <?=$ddr[state1e]?> <?=$ddr[zip1e]?></option>
			<? } ?>
		</select>
		</td></tr>
		<tr><td colspan=2>2) Month, Day, Year <select name="month[<?=$key?>]"><?=mkmonth($month)?></select> <select name="day[<?=$key?>]"><?=mkday($day)?></select> <select name="year[<?=$key?>]"><?=mkyear($year)?></select></td></tr>
		<tr><td colspan=2>3) Hour, Minute, AM/PM <select name="hour[<?=$key?>]"><?=mkmonth($hour)?></select> <select name="minute[<?=$key?>]"><?=mkminute($minute)?></select>
		 <select name="ampm[<?=$key?>]"><option value="<?=$ampm?>"><?=$ampm?></option><option value="AM">AM</option><option value="PM">PM</option></select></td></tr>
		<tr><td>4) Description of individual served</td><td><input name="defendant_detail[<?=$key?>]" value="<?=$desc?>" size="60"></td></tr></table>
		<input type="hidden" name="served[<?=$key?>]" value="<?=$d[wizard]?>" />
		<input type="hidden" name="addressType[<?=$key?>]" value="<?=$addressType?>" />
		<?
	}else{
		//if not above-listed types, deny access, send email to service
		echo "<h1>EDITING IS NOT YET SUPPORTED FOR THIS TYPE OF ENTRY.  PLEASE RE-ENTER.</h1>";
		$history .= "<div>ID: $d[history_id]</div>";
		$history .= "<div>Action Type $d[action_type]</div>";
		$history .= "<div>Wizard Type $d[wizard]</div>";
		$history .= "<div>$d[action_str]</div>";
		$to = "System Operators <service@mdwestserve.com>";
		$from = "System <service@mdwestserve.com>";
		$subject = "WIZARD: ATTEMPTED EDIT, FAILED";
		$headers  = "MIME-Version: 1.0 \n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
		$headers .= "From: $from \n";
		mail($to,$subject,$info.$history,$headers);
	}
	//display editing inputs
	echo "<div>
	<table width='20%'>
	</table>
	</div>";
}
?>
<input type="hidden" name="parts" value="<?=$_POST[parts]?>">
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />

<div class="nav3"><input onClick="submitLoader()" type="radio" name="i" value="edit.2" /> SAVE</div>
<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="2" /> BACK</div>
