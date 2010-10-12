<?
include 'common.php';

if ($_COOKIE[psdata][level] != "Operations" && $_COOKIE[psdata][level] != "SysOp"){
header('Location: home.php');
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

if ($_POST[submit]){
$q="UPDATE ps_packets SET client_rate='$_POST[client]', contractor_rate='$_POST[contractor]' where package_id = $_POST[packages]";
$r=@mysql_query($q);
header('Location: adjust_rate.php');
}

include 'menu.php';
$q="SELECT * from ps_packages order by set_date DESC";
$r=@mysql_query($q) or die(mysql_error());
?>
<table><tr><td>
<div style="height:508px; width:480px;">
<table width="400px">
<form method="post">
	<tr>
    	<td>Client: <input name="client" id="client" value="Client Rate" onClick="value=''"></td>
    	<td>Contractor: <input name="contractor" id="contractor" value="Contractor Rate" onClick="value=''"></td>
    	<td valign="bottom"><select name="packages">
<?
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	if ($d[id] == $_POST[submit]){
	}else{ ?>
<option value="<?=$d[id]?>"><? echo $d[name].' - '.inPackage($d[id]) ;?></option>
<? } 
}?>
		</select></td>
    </tr>
    <tr>
    	<td colspan="2" align="center"><input type="submit" name="submit" value="Adjust Rates"></td>
        <td align="right"><input type="submit" name="submit3" value="Display Package"></td>
    </tr>
</form>
</table>
</div>
</td><td valign="top">
<? if ($_POST[submit3]){ ?>
	<div align="right" style="height:508px; width:600px; padding:0px; overflow:auto;">
	<table align="center" width="550px">
<?
	$q5="SELECT * from ps_packets where package_id = '$_POST[packages]' AND process_status <> 'CANCELLED'";  
	$r5=@mysql_query($q5) or die("Query: $q5<br>".mysql_error());
while ($d5=mysql_fetch_array($r5, MYSQL_ASSOC)){
	$i=1;
	$add .= '<tr bgcolor="'.row_color($p,'#999900','#99CC00').'" width="100%"><td width="12%"><small><b>File'.$p.': $'.$d5[contractor_rate].'</b></small></td>';
	while ($i < 5){
		if ($d5["name$i"] && $i != 1){
			$add .= '<td></td><td bgcolor="'.row_color($p,'#999900','#99CC00').'"><small>Defendant '.$d5["name$i"].'</small>: '.$d5["address$i"].' '.$d5["zip$i"].' '.$d5[circuit_court].'</td></tr>';
			$i++;
		}elseif($d5["name$i"] && $i == 1){
			$add .= '<td><small>Defendant '.$d5["name$i"].'</small>: '.$d5["address$i"].' '.$d5["zip$i"].' '.$d5[circuit_court].'</td></tr>';			
			$i++;
		}else{
			$i++;
		}
	}
	$p++;
}
?>
<?=$add?>
</table>
	</div>
<? } ?>
</td></tr></table>
<? include 'footer.php' ?>