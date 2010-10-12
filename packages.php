<? include 'common.php';
		


function defTotal($packet_id){
mysql_select_db ('core');
	$q="SELECT name1, name2, name3, name4 FROM ps_packets WHERE packet_id='$packet_id'";
	$r=@mysql_query($q) or die("Query: defendantTotal: $q<br>".mysql_error());
	$i=0;
	while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		if($d[name1]){ $i++; }
		if($d[name2]){ $i++; }
		if($d[name3]){ $i++; }
		if($d[name4]){ $i++; }
		if($d[name5]){ $i++; }
		if($d[name6]){ $i++; }
	}
	return $i;
}

function outOfState($packet_id){
	$q="SELECT state1, state1a, state1b, state1c, state1d, state1e, state2, state2a, state2b, state2c, state2d, state2e, state3, state3a, state3b, state3c, state3d, state3e, state4, state4a, state4b, state4c, state4d, state4e, state5, state5a, state5b, state5c, state5d, state5e, state6, state6a, state6b, state6c, state6d, state6e from ps_packets WHERE packet_id = '$packet_id'";
	$r=@mysql_query($q) or die("Query: outOfState: $q<br>".mysql_error());
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		$i=0;
		if ($d[state1e] != 'MD' && $d[state1e] != 'md' && $d[state1e] != ''){ $i++; }
		if ($d[state1d] != 'MD' && $d[state1d] != 'md' && $d[state1d] != ''){ $i++; }
		if ($d[state1c] != 'MD' && $d[state1c] != 'md' && $d[state1c] != ''){ $i++; }
		if ($d[state1b] != 'MD' && $d[state1b] != 'md' && $d[state1b] != ''){ $i++; }
		if ($d[state1a] != 'MD' && $d[state1a] != 'md' && $d[state1a] != ''){ $i++; }
		if ($d[state1] != 'MD' && $d[state1] != 'md' && $d[state1] != ''){ $i++; }
		if ($d[state2e] != 'MD' && $d[state2e] != 'md' && $d[state2e] != ''){ $i++; }
		if ($d[state2d] != 'MD' && $d[state2d] != 'md' && $d[state2d] != ''){ $i++; }
		if ($d[state2c] != 'MD' && $d[state2c] != 'md' && $d[state2c] != ''){ $i++; }
		if ($d[state2b] != 'MD' && $d[state2b] != 'md' && $d[state2b] != ''){ $i++; }
		if ($d[state2a] != 'MD' && $d[state2a] != 'md' && $d[state2a] != ''){ $i++; }
		if ($d[state2] != 'MD' && $d[state2] != 'md' && $d[state2] != ''){ $i++; }
		if ($d[state3e] != 'MD' && $d[state3e] != 'md' && $d[state3e] != ''){ $i++; }
		if ($d[state3d] != 'MD' && $d[state3d] != 'md' && $d[state3d] != ''){ $i++; }
		if ($d[state3c] != 'MD' && $d[state3c] != 'md' && $d[state3c] != ''){ $i++; }
		if ($d[state3b] != 'MD' && $d[state3b] != 'md' && $d[state3b] != ''){ $i++; }
		if ($d[state3a] != 'MD' && $d[state3a] != 'md' && $d[state3a] != ''){ $i++; }
		if ($d[state3] != 'MD' && $d[state3] != 'md' && $d[state3] != ''){ $i++; }
		if ($d[state4e] != 'MD' && $d[state4e] != 'md' && $d[state4e] != ''){ $i++; }
		if ($d[state4d] != 'MD' && $d[state4d] != 'md' && $d[state4d] != ''){ $i++; }
		if ($d[state4c] != 'MD' && $d[state4c] != 'md' && $d[state4c] != ''){ $i++; }
		if ($d[state4b] != 'MD' && $d[state4b] != 'md' && $d[state4b] != ''){ $i++; }
		if ($d[state4a] != 'MD' && $d[state4a] != 'md' && $d[state4a] != ''){ $i++; }
		if ($d[state4] != 'MD' && $d[state4] != 'md' && $d[state4] != ''){ $i++; }
		if ($d[state5e] != 'MD' && $d[state5e] != 'md' && $d[state5e] != ''){ $i++; }
		if ($d[state5d] != 'MD' && $d[state5d] != 'md' && $d[state5d] != ''){ $i++; }
		if ($d[state5c] != 'MD' && $d[state5c] != 'md' && $d[state5c] != ''){ $i++; }
		if ($d[state5b] != 'MD' && $d[state5b] != 'md' && $d[state5b] != ''){ $i++; }
		if ($d[state5a] != 'MD' && $d[state5a] != 'md' && $d[state5a] != ''){ $i++; }
		if ($d[state5] != 'MD' && $d[state5] != 'md' && $d[state5] != ''){ $i++; }
		if ($d[state6e] != 'MD' && $d[state6e] != 'md' && $d[state6e] != ''){ $i++; }
		if ($d[state6d] != 'MD' && $d[state6d] != 'md' && $d[state6d] != ''){ $i++; }
		if ($d[state6c] != 'MD' && $d[state6c] != 'md' && $d[state6c] != ''){ $i++; }
		if ($d[state6b] != 'MD' && $d[state6b] != 'md' && $d[state6b] != ''){ $i++; }
		if ($d[state6a] != 'MD' && $d[state6a] != 'md' && $d[state6a] != ''){ $i++; }
		if ($d[state6] != 'MD' && $d[state6] != 'md' && $d[state6] != ''){ $i++; }
	}
	return ($i * 20);
}

if ($_COOKIE[psdata][level] != "Operations"){
			$event = 'packages.php';
			$email = $_COOKIE[psdata][email];
			$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
			//@mysql_query($q1) or die(mysql_error());
			header('Location: home.php');
}

if ($_POST[submit]){
	if (!$_POST[package][contractor] || !$_POST[name]){
	echo '<script>alert("Please make sure that you have entered a contractor rate and package name.")</script>';
	}else{


function packageFile($package_id, $file_id, $contractor_rate, $contractor_ratea, $contractor_rateb, $contractor_ratec, $contractor_rated, $contractor_ratee){
	$oosc=outOfState($file_id);
	timeline($file_id,$_COOKIE[psdata][name]." Packaged Order");

	$q = "UPDATE ps_packets SET 
									package_id='$package_id',
									contractor_rate='$contractor_rate',
									contractor_ratea='$contractor_ratea',
									contractor_rateb='$contractor_rateb',
									contractor_rateb='$contractor_ratec',
									contractor_rateb='$contractor_rated',
									contractor_rateb='$contractor_ratee',
									outofstate_cost='$oosc'
										WHERE packet_id = '$file_id'";
	$r=@mysql_query($q);
}

function makePackage($array1,$array2,$array3,$array4,$array5,$array6,$array7,$package_id){
//	echo "Package ID :: $package_id";
//	echo "Client Rate :: $array2[0]<br>";
//	echo "Contractor Rate :: $array3[0]<br>";
//	echo "for file id's (the foreach loop went here) :: ";
	foreach ($array1 as $id) {
		packageFile($package_id,$id,$array2[0],$array3[0],$array4[0],$array5[0],$array6[0],$array7[0]);
		//echo "$id ";
	}
}	


	
	$q1 = "INSERT into ps_packages (name, description, set_date) values ('$_POST[name]', '$_POST[description]', NOW()) ";
	$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
	$packageID = mysql_insert_id();	
	makePackage($_POST[package]['id'],$_POST[package]['contractor'],$_POST[package]['contractora'],$_POST[package]['contractorb'],$_POST[package]['contractorc'],$_POST[package]['contractord'],$_POST[package]['contractore'],$packageID);
	monitor('Your package "' .$_POST[name]. '" has been created.');
	}
}

include 'menu.php';
?><br />
<br />
<br />
<br />
<table width="100%"><tr><td valign="top">
<table border="1" style="border-collapse:collapse" align="center" width="100%">
    <tr bgcolor="<? if (outOfState($d[packet_id]) > 0){ echo '#ffff00';}else{ echo row_color(2,'#ccccff','#99cccc'); }?>">
		<td>Links</td>
        <td>Client</td>
        <td>Date Received</td>
        <td>Client File</td>
		<td>Case No.</td>
        <td>Circuit Court</td>
        <td>D</td>
        <td>Cities</td>
        <td>Notes</td>
	</tr>

<form method="post">
<?
$q= "select * from ps_packets where process_status = 'READY' and package_id = '' order by circuit_court";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {$i++;
?>
    <tr bgcolor="<? if($d[alertMax] && $d[attorneys_id] == '1'){  echo row_color(1,'#ff0000','#990000');}elseif (outOfState($d[packet_id]) > 0){ echo row_color(2,'#009999','#00FFFF');}else{ echo row_color($i,'#FFFFFF','#cccccc'); }?>">
		<td nowrap="nowrap"><input type="checkbox" name="package[id][<?=$d[packet_id]?>]" value="<?=$d[packet_id]?>" />&nbsp;<a href="order.php?packet=<?=$d[packet_id]?>" target="_blank" style="text-decoration:none"><?=$d[packet_id]?>)</a></td>
        <td><?=id2attorney($d[attorneys_id])?></td>
        <td><?=substr($d[date_received],0,10)?></td>
        <td><?=$d[client_file] ?></td>
		<td><?=$d[case_no] ?></td>
        <td><?=str_replace(' ','&nbsp;',$d[circuit_court]) ?></td>
        <td align="center"><?=defTotal($d[packet_id]);?></td>
        <td nowrap="nowrap"><? if ($d[address1e]){
				echo "<a target='_Blank' href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1e]&city=$d[city1e]&state=$d[state1e]&miles=20' title='$d[address1e], $d[city1e], $d[state1e] $d[zip1e]'>Service: $d[address1e], $d[city1e], $d[state1e] $d[zip1e]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1d]&city=$d[city1d]&state=$d[state1d]&miles=20' title='$d[address1d], $d[city1d], $d[state1d] $d[zip1d]'>Alt. Service: $d[address1d], $d[city1d], $d[state1d] $d[zip1d]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1c]&city=$d[city1c]&state=$d[state1c]&miles=20' title='$d[address1c], $d[city1c], $d[state1c] $d[zip1c]'>Alt. Service: $d[address1c], $d[city1c], $d[state1c] $d[zip1c]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1b]&city=$d[city1b]&state=$d[state1b]&miles=20' title='$d[address1b], $d[city1b], $d[state1b] $d[zip1b]'>Alt. Service: $d[address1b], $d[city1b], $d[state1b] $d[zip1b]</a><br><a   href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1a]&city=$d[city1a]&state=$d[state1a]&miles=20' title='$d[address1a], $d[city1a], $d[state1a] $d[zip1a]'>Alt. Service: $d[address1a], $d[city1a], $d[state1a] $d[zip1a]</a><br><a   href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1]&city=$d[city1]&state=$d[state1]&miles=20' title='$d[address1], $d[city1], $d[state1] $d[zip1]'>Posting: $d[address1], $d[city1], $d[state1] $d[zip1]</a>";	
			}elseif ($d[address1d]){
				echo "<a target='_Blank' href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1d]&city=$d[city1d]&state=$d[state1d]&miles=20' title='$d[address1d], $d[city1d], $d[state1d] $d[zip1d]'>Service: $d[address1d], $d[city1d], $d[state1d] $d[zip1d]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1c]&city=$d[city1c]&state=$d[state1c]&miles=20' title='$d[address1c], $d[city1c], $d[state1c] $d[zip1c]'>Alt. Service: $d[address1c], $d[city1c], $d[state1c] $d[zip1c]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1b]&city=$d[city1b]&state=$d[state1b]&miles=20' title='$d[address1b], $d[city1b], $d[state1b] $d[zip1b]'>Alt. Service: $d[address1b], $d[city1b], $d[state1b] $d[zip1b]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1a]&city=$d[city1a]&state=$d[state1a]&miles=20' title='$d[address1a], $d[city1a], $d[state1a] $d[zip1a]'>Alt. Service: $d[address1a], $d[city1a], $d[state1a] $d[zip1a]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1]&city=$d[city1]&state=$d[state1]&miles=20' title='$d[address1], $d[city1], $d[state1] $d[zip1]'>Posting: $d[address1], $d[city1], $d[state1] $d[zip1]</a>";	
			}elseif ($d[address1c]){
				echo "<a target='_Blank' href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1c]&city=$d[city1c]&state=$d[state1c]&miles=20' title='$d[address1c], $d[city1c], $d[state1c] $d[zip1c]'>Service: $d[address1c], $d[city1c], $d[state1c] $d[zip1c]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1b]&city=$d[city1b]&state=$d[state1b]&miles=20' title='$d[address1b], $d[city1b], $d[state1b] $d[zip1b]'>Alt. Service: $d[address1b], $d[city1b], $d[state1b] $d[zip1b]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1a]&city=$d[city1a]&state=$d[state1a]&miles=20' title='$d[address1a], $d[city1a], $d[state1a] $d[zip1a]'>Alt. Service: $d[address1a], $d[city1a], $d[state1a] $d[zip1a]</a><br><a title='$d[address1], $d[city1], $d[state1] $d[zip1]'>Posting: $d[address1], $d[city1], $d[state1] $d[zip1]</a>";		
			}elseif ($d[address1b]){
				echo "<a target='_Blank' href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1b]&city=$d[city1b]&state=$d[state1b]&miles=20' title='$d[address1b], $d[city1b], $d[state1b] $d[zip1b]'>Service: $d[address1b], $d[city1b], $d[state1b] $d[zip1b]</a><br><a target='_Blank' href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1a]&city=$d[city1a]&state=$d[state1a]&miles=20'  title='$d[address1a], $d[city1a], $d[state1a] $d[zip1a]'>Alt. Service: $d[address1a], $d[city1a], $d[state1a] $d[zip1a]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1]&city=$d[city1]&state=$d[state1]&miles=20' title='$d[address1], $d[city1], $d[state1] $d[zip1]'>Posting: $d[address1], $d[city1], $d[state1] $d[zip1]</a>";		
			}elseif ($d[address1a]){
				echo "<a target='_Blank' href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1a]&city=$d[city1a]&state=$d[state1a]&miles=20' title='$d[address1a], $d[city1a], $d[state1a] $d[zip1a]'>Service: $d[address1a], $d[city1a], $d[state1a] $d[zip1a]</a><br><a target='_Blank'  href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1]&city=$d[city1]&state=$d[state1]&miles=20' title='$d[address1], $d[city1], $d[state1] $d[zip1]'>Posting: $d[address1], $d[city1], $d[state1] $d[zip1]</a>";
			}else{
				echo "<a target='_Blank' href='http://mdwestserve.com/ps/dispatcher.php?aptsut=&address=$d[address1]&city=$d[city1]&state=$d[state1]&miles=20' title='$d[address1], $d[city1], $d[state1], $d[zip1]'>Serve &amp; Post: $d[address1], $d[city1], $d[state1] $d[zip1]</a>";
			}?></td>
            <td><?=strtoupper($d[processor_notes])?></td>
	</tr>
<?  
} 
?>
</table>
<style>
.ppd{border-bottom:hidden; border-right:hidden;}
.ppp{border-right:hidden;}
</style>
<table width="100%" class="noprint">
	<tr bgcolor="<?=row_color($i,'#99cccc','#ccccff')?>">
        <td class="ppd" align="left">Service Rate: <input size="3" name="package[contractor][<?=$d[packet_id]?>]"/></td>
        <td class="ppd" align="left">Service Rate "a": <input size="3" name="package[contractora][<?=$d[packet_id]?>]"/></td>
    	<td class="ppd">Service Rate "b": <input size="3" name="package[contractorb][<?=$d[packet_id]?>]" /></td>
		<td class="ppd">Service Rate "c": <input size="3" name="package[contractorc][<?=$d[packet_id]?>]" /></td>
		<td class="ppd">Service Rate "d": <input size="3" name="package[contractord][<?=$d[packet_id]?>]" /></td>
		<td class="ppd">Service Rate "e": <input size="3" name="package[contractore][<?=$d[packet_id]?>]" /></td>
    	<td class="ppp">Name: <input size="5" name="name" /></td>
        <td class="ppp"><input type="submit" name="submit" value="Package Files" /></td>
    </tr>
</form>
</table></td></tr></table>
<? include 'footer.php' ; ?>