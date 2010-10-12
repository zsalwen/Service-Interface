<?
include 'common.php';
if ($_COOKIE[psdata][level] != "Operations" && $_COOKIE[psdata][level] != "SysOp"){
			$event = 'dispatch.php';
			$email = $_COOKIE[psdata][email];
			$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
			//@mysql_query($q1) or die(mysql_error());
			header('Location: home.php');
}
function packageTimeline($pkg){
	$r=@mysql_query("select packet_id from ps_packets where package_id = '$pkg'");
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
		timeline($d[packet_id],$_COOKIE[psdata][name]." Dispatched Order");
	}
}

function printCost($packet_id){
	$q="SELECT name1, name2, name3, name4 from ps_packets where packet_id = '$packet_id'";
	$r=@mysql_query($q) or die("Query: printCost<br>".mysql_error());
	$i=0;
	$t=0;
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		while ($i < 5){$i++;
			if ($d["name$i"] != ''){
				$t++;
			}
		}
	}
	$cost=3.5 * $t;
	return $cost;
}

function inPackage($id){
	$r=@mysql_query("SELECT * from ps_packets where package_id = '$id' AND process_status <> 'CANCELLED'");
	$files=0;
	$total=0;
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		$files++;
		
		if ($d[name1]){ $total++; }
		if ($d[name2]){ $total++; }
		if ($d[name3]){ $total++; }
		if ($d[name4]){ $total++; }
		
		
	}
	return $files.'F / '.$total.'D';
}
function inPacket($id){
	$r=@mysql_query("SELECT * from ps_packets where packet_id = '$id' AND process_status <> 'CANCELLED'");
	$files=0;
	$total=0;
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		$files++;
		
		if ($d[name1]){ $total++; }
		if ($d[name2]){ $total++; }
		if ($d[name3]){ $total++; }
		if ($d[name4]){ $total++; }
		
		
	}
	return $total.'D';
}
if ($_POST[submit]){
	foreach ( $_POST[assign] as $value){
		packageTimeline($value);
		$q="SELECT address1a, address1b, address1c, address1d, address1e from ps_packets WHERE package_id='$value'";
		$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
		while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
			$q="UPDATE ps_packets SET server_id = '$_POST[server_id]', ";
			if ($d[address1a]){
				$q .= "server_ida = '$_POST[server_id]', ";
			}
			if ($d[address1b]){
				$q .= "server_idb = '$_POST[server_id]', ";
			}
			if ($d[address1c]){
				$q .= "server_idc = '$_POST[server_id]', ";
			}
			if ($d[address1d]){
				$q .= "server_idd = '$_POST[server_id]', ";
			}
			if ($d[address1e]){
				$q .= "server_ide = '$_POST[server_id]', ";
			}
			$q.="process_status='ASSIGNED' WHERE package_id ='$value'";
			@mysql_query($q);
		}
		$q3 = "UPDATE ps_packages SET assign_date = NOW() where id = '$value'";
		@mysql_query($q3);
		
	}
	if ($_POST[print_cost]){
	foreach ( $_POST[print_cost] as $value){
		$q="SELECT packet_id from ps_packets where package_id = '$value'";
		$r=@mysql_query($q);
		while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
			$cost = printCost($d[packet_id]);
			$q="UPDATE ps_packets SET print_cost='$cost' WHERE packet_id ='$d[packet_id]'";
			@mysql_query($q);
		}
	}}
}

include 'menu.php';
?>
<br /><br /><br /><br /><br />
<script>
function show(which){
if (!document.getElementById)
return
which.style.display="block"
}

function hide(which){
if (!document.getElementById)
return
which.style.display="none"
}
function accord(id){
	if (id=='pub'){
		show(document.getElementById('pub'))
		hide(document.getElementById('acc'))
		hide(document.getElementById('prop'))
		hide(document.getElementById('sale'))
		hide(document.getElementById('history'))
		hide(document.getElementById('system'))
		hide(document.getElementById('att'))
		hide(document.getElementById('status'))
	}
}
</script>
<style>
.fff{color:#FFFFFF;}
</style>
<table width="1090px"><tr><td valign="top" width="480px" bgcolor="#006699">
<div style="height:508px; width:480px;">
<table border="1" style="border-collapse:collapse;" align="left" width="480px">
	<tr>
    	<td colspan="6" bgcolor="#FFFFCC" align="center">Set <strong>In-State</strong> Server</td>
    </tr>
<form method="post" name="form1">
    <tr class="fff" bgcolor="#6699CC">
    	<td align="left" width="10%"><small><strong>Assign</strong></small></td>
    	<td align="left" width="10%"><small><strong>Print Cost</strong></small></td>
        <td align="center"><small><strong>Name</strong></small></td>
        <td align="center" width="10%"><small><strong>Map</strong></small></td>
        <td align="center" width="15%"><small><strong>Volume</strong></small></td>
        <td align="center" width="15%"><small><strong>Details</strong></small></td>
    </tr>
<?
$q="select * from ps_packages where set_date > '0' and assign_date < '1'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {$i++;
?>
<script>
function packagePopup(id) {
window.open( "http://mdwestserve.com/ps/package_map.php?package="+id, "Package Map", "status = 1, height = 500, width = 700, resizable = 0" )
}
</script>
    <tr bgcolor="<?=row_color($i,'#9999cc','#99ccff')?>">
		<td><input type="checkbox" name="assign[<?=$d[id]?>]" value="<?=$d[id]?>" /></td>
        <td><input type="checkbox" name="print_cost[<?=$d[id]?>]" value="<?=$d[id]?>" /></td>
        <td align="center"><?=$d[name] ?></td>
        <td align="center"><a onClick="packagePopup(<?=$d[id]?>)"><font color="#FFFF99" size="-1" style="font-weight:bold">Map</font></a></td>
        <td align="center"><small><?=inPackage($d[id]);?></small></td>
        <td align="center"><a style="text-decoration:none" href="dispatch.php?pkginfo=<?=$d[id]?>">Details <strong>&raquo;</strong></a></td>
	</tr>
<?
} 
?>
	<tr>
    	<td colspan="6" align="center" bgcolor="#99ccff"><select name="server_id">
<?
$q2= "select * from ps_users where contract = 'YES'";
$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
while ($d2=mysql_fetch_array($r2, MYSQL_ASSOC)) {
?>
<option value="<?=$d2[id]?>"><? if ($d2[company]){echo $d2[company].', '.$d2[name] ;}else{echo $d2[name] ;}?></option>
<?        } ?>
        </select>  <input type="submit" name="submit" value="Assign Files" /></td>
    </tr>
</form>
</table>
</td><td valign="top" bgcolor="#CCCC99" width="550px">
<?
if ($_GET[pkginfo]){
	if ($_COOKIE[psdata][level] != "Operations" && $_COOKIE[psdata][level] != "SysOp"){
	}else{
$q5="SELECT * from ps_packets where package_id = '$_GET[pkginfo]' AND process_status <> 'CANCELLED'";  
$r5=@mysql_query($q5) or die("Query: $q5<br>".mysql_error());
?>
<div align="right" style="height:508px; width:600px; padding:0px; overflow:auto;">
<table align="center" width="550px">
<?
$p=1;
while ($d5=mysql_fetch_array($r5, MYSQL_ASSOC)){
	$i=1;
	while ($i < 5){
		$ver=$i."a";
		if ($d5["name$i"]){
			if ($d5["address$ver"] != ''){
				$add .= '<tr bgcolor="'.row_color($p,'#999900','#99CC00').'" width="100%"><td><small><b>F'.$p.' D'.$i.': $'.$d5[contractor_rate].'</b> - SERVE:</small> '.$d5[circuit_court].' '.$d5["city$ver"].' '.$d5["state$ver"].' '.$d5["zip$ver"].'</td></tr>';
				$add .= '<tr bgcolor="'.row_color($p,'#999900','#99CC00').'" width="100%"><td><small><b>F'.$p.' D'.$i.': $'.$d5[contractor_rate].'</b> - POST:</small> '.$d5[circuit_court].' '.$d5["city$i"].' '.$d5["state$i"].' '.$d5["zip$i"].'</td></tr>';
			}else{
				$add .= '<tr bgcolor="'.row_color($p,'#999900','#99CC00').'" width="100%"><td><small><b>F'.$p.' D'.$i.': $'.$d5[contractor_rate].'</b> - SERVE&amp;POST:</small> '.$d5[circuit_court].' '.$d5["city$i"].' '.$d5["state$i"].' '.$d5["zip$i"].'</td></tr>';
			}
		}
		$i++;
	}
	$p++;
}
?>
<?=$add?>
<? 
	}
}
if ($_GET[pktinfo]){
	if ($_COOKIE[psdata][level] != "Dispatch" && $_COOKIE[psdata][level] != "SysOp"){
	}else{
$q5="SELECT * from ps_packets where packet_id = '$_GET[pktinfo]' AND process_status <> 'CANCELLED'";  
$r5=@mysql_query($q5) or die("Query: $q5<br>".mysql_error());
?>
<div align="right" style="height:508px; width:600px; padding:0px; overflow:auto;">
<table align="center" width="550px">
<?
$p=1;
while ($d5=mysql_fetch_array($r5, MYSQL_ASSOC)){
	$i=1;
	while ($i < 5){
		$ver=$i."a";
		if ($d5["name$i"]){
			if ($d5["address$ver"] != ''){
				$add .= '<tr bgcolor="'.row_color($p,'#999900','#99CC00').'" width="100%"><td><small><b>D'.$i.': $'.$d5[contractor_rate].'</b> - SERVE:</small> '.$d5[circuit_court].' '.$d5["city$ver"].' '.$d5["state$ver"].' '.$d5["zip$ver"].'</td></tr>';
				$add .= '<tr bgcolor="'.row_color($p,'#999900','#99CC00').'" width="100%"><td><small><b>D'.$i.': $'.$d5[contractor_rate].'</b> - POST:</small> '.$d5[circuit_court].' '.$d5["city$i"].' '.$d5["state$i"].' '.$d5["zip$i"].'</td></tr>';
			}else{
				$add .= '<tr bgcolor="'.row_color($p,'#999900','#99CC00').'" width="100%"><td><small><b>D'.$i.': $'.$d5[contractor_rate].'</b> - SERVE&amp;POST:</small> '.$d5[circuit_court].' '.$d5["city$i"].' '.$d5["state$i"].' '.$d5["zip$i"].'</td></tr>';
			}
		}
		$i++;
	}
	$p++;
}
?>
<?=$add?>
<? 
	}
} ?>
</table>
</div></td></tr></table>
<script>window.onLoad=hideshow(document.getElementById('disp'));</script>

<?
include 'footer.php';
?>