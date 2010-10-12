<?
include 'common.php';


if ($_COOKIE[psdata][level] != "Operations"){
	if ($_COOKIE[psdata][level] == "SysOp"){
		// ok to ba admin	
	} else{
		$event = 'manager.php';
		$email = $_COOKIE[psdata][email];
		$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
		//@mysql_query($q1) or die(mysql_error());
		header('Location: home.php');
	}
}

if ($_POST[submit]){

function assignFile($server_id, $file_id){
	$q1 = "UPDATE private_process SET 
									server_id='$server_id',
									process_status='Assigned'
										WHERE id = '$file_id'";
	$r=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
}




foreach ($_POST[assign] as $value) {
    //echo "Assign $value to $_POST[server_id]<br />";
	assignFile($_POST[server_id],$value);
}




}


//		$q= "select * from private_process where assign_id = ''";
//		$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());


include 'menu.php';


$r0 = mysql_query("SELECT id FROM ps_users WHERE verify = 'NO' AND level <> 'DELETED' AND level <> 'Administrator' AND level <> 'Manager' AND level <> 'Data Entry' ");
$stat[0] = mysql_num_rows($r0);

$r1 = mysql_query("SELECT id FROM ps_users WHERE email = '' AND level <> 'DELETED' AND level <> 'Administrator' AND level <> 'Manager' AND level <> 'Data Entry' ");
$stat[1] = mysql_num_rows($r1);

$r2 = mysql_query("SELECT id FROM ps_users WHERE phone = '' AND level <> 'DELETED' AND level <> 'Administrator' AND level <> 'Manager' AND level <> 'Data Entry' ");
$stat[2] = mysql_num_rows($r2);

$r3 = mysql_query("SELECT id FROM ps_users WHERE manager_review = '' AND level <> 'DELETED' AND level <> 'Administrator' AND level <> 'Manager' AND level <> 'Data Entry' ");
$stat[3] = mysql_num_rows($r3);

$r4 = mysql_query("SELECT id FROM ps_users WHERE verify = '' AND level <> 'DELETED' AND level <> 'Administrator' AND level <> 'Manager' AND level <> 'Data Entry' ");
$stat[4] = mysql_num_rows($r4);

$r5 = mysql_query("SELECT id FROM ps_users WHERE email_status <> 'VERIFIED' AND level <> 'DELETED' ");
$stat[5] = mysql_num_rows($r5);

$r6 = mysql_query("SELECT id FROM ps_users WHERE level <> 'DELETED' AND level <> 'Administrator' AND level <> 'Manager' AND level <> 'Data Entry' ");
$stat[6] = mysql_num_rows($r6);


?>
<table style="font-size:12px;" width="100%" bgcolor="#FFFFFF">
    <tr>
    	<td><b><? $go = explode('.',number_format($stat[4] / $stat[6], 2)); echo $go[1]; ?>%</b></td>
    	<td >New Process Servers to Verify Account information</td>
    	<td ><b><? $go = explode('.',number_format($stat[0] / $stat[6], 2)); echo $go[1]; ?>%</b></td>
    	<td >Process Servers to Verify Account information (contact attempted)</td>
    	<td><b><? $go = explode('.',number_format($stat[1] / $stat[6], 2)); echo $go[1]; ?>%</b></td>
    	<td>Missing E-Mail Addresses</td>
    	<td><b><? $go = explode('.',number_format($stat[5] / $stat[6], 2)); echo $go[1]; ?>%</b></td>
    	<td>Unverified E-Mail Addresses</td>
    	<td><b><? $go = explode('.',number_format($stat[2] / $stat[6], 2)); echo $go[1]; ?>%</b></td>
    	<td>Missing Phone Numbers</td>
    	<td><b><? $go = explode('.',number_format($stat[3] / $stat[6], 2)); echo $go[1]; ?>%</b></td>
    	<td>Missing Manager Review Notes</td>
	</tr>
</table>

<form method="post">
<table width="100%" bgcolor="#FFFF99" border="1">
	<tr>
    	<td align="center" <? if ($_GET[county] == "allegany"){?> bgcolor="99ff66"<? } ?>><a href="?county=allegany">Allegany</a></td>
        <td align="center" <? if ($_GET[county] == "anne_arundel"){?> bgcolor="99ff66"<? } ?>><a href="?county=anne_arundel">AA</a></td>
        <td align="center" <? if ($_GET[county] == "baltimore_city"){?> bgcolor="99ff66"<? } ?>><a href="?county=baltimore_city">Baltimore City</a></td>
        <td align="center" <? if ($_GET[county] == 'baltimore_county'){?> bgcolor="99ff66"<? } ?>><a href="?county=baltimore_county">Baltimore County</a></td>
        <td align="center" <? if ($_GET[county] == 'calvert'){?> bgcolor="99ff66"<? } ?>><a href="?county=calvert">Calvert</a></td>
        <td align="center" <? if ($_GET[county] == 'caroline'){?> bgcolor="99ff66"<? } ?>><a href="?county=caroline">Caroline</a></td>
        <td align="center" <? if ($_GET[county] == 'carroll'){?> bgcolor="99ff66"<? } ?>><a href="?county=carroll">Carroll</a></td>
        <td align="center" <? if ($_GET[county] == 'cecil'){?> bgcolor="99ff66"<? } ?>><a href="?county=cecil">Cecil</a></td>
        <td align="center" <? if ($_GET[county] == 'charles'){?> bgcolor="99ff66"<? } ?>><a href="?county=charles">Charles</a></td>
        <td align="center" <? if ($_GET[county] == 'dorchester'){?> bgcolor="99ff66"<? } ?>><a href="?county=dorchester">Dorchester</a></td>
        <td align="center" <? if ($_GET[county] == 'frederick'){?> bgcolor="99ff66"<? } ?>><a href="?county=frederick">Frederick</a></td>
        <td align="center" <? if ($_GET[county] == 'garrett'){?> bgcolor="99ff66"<? } ?>><a href="?county=garrett">Garrett</a></td>
    </tr>
    <tr>
        <td align="center" <? if ($_GET[county] == 'harford'){?> bgcolor="99ff66"<? } ?>><a href="?county=harford">Harford</td>
        <td align="center" <? if ($_GET[county] == 'howard'){?> bgcolor="99ff66"<? } ?>><a href="?county=howard">Howard</td>
        <td align="center" <? if ($_GET[county] == 'kent'){?> bgcolor="99ff66"<? } ?>><a href="?county=kent">Kent</td>
        <td align="center" <? if ($_GET[county] == 'montgomery'){?> bgcolor="99ff66"<? } ?>><a href="?county=montgomery">Montgomery</td>
        <td align="center" <? if ($_GET[county] == 'pg'){?> bgcolor="99ff66"<? } ?>><a href="?county=pg">PG</td>
        <td align="center" <? if ($_GET[county] == 'queen_anne'){?> bgcolor="99ff66"<? } ?>><a href="?county=queen_anne">Queen Anne</td>
        <td align="center" <? if ($_GET[county] == 'st_mary'){?> bgcolor="99ff66"<? } ?>><a href="?county=st_mary">St. Mary</td>
        <td align="center" <? if ($_GET[county] == 'somerset'){?> bgcolor="99ff66"<? } ?>><a href="?county=somerset">Somerset</td>
        <td align="center" <? if ($_GET[county] == 'talbot'){?> bgcolor="99ff66"<? } ?>><a href="?county=talbot">Talbot</td>
        <td align="center" <? if ($_GET[county] == 'washington'){?> bgcolor="99ff66"<? } ?>><a href="?county=washington">Washington</td>
        <td align="center" <? if ($_GET[county] == 'wicomico'){?> bgcolor="99ff66"<? } ?>><a href="?county=wicomico">Wicomico</td>
        <td align="center" <? if ($_GET[county] == 'worcester'){?> bgcolor="99ff66"<? } ?>><a href="?county=worcester">Worcester</td>
    </tr>
</table>

<table bgcolor="#FFFFFF" border="1" width="100%">
<? 
function cleanField2($str){
	$str = strtolower($str);
	$str = explode(' ',$str);
	$str1 = ucwords($str[0]);
	$str2 = ucwords($str[1]);
return $str1.' '.$str2;
}

if ($_GET[county]){
	$county = ps2county($_GET[county]);
?>
	<tr>
    	<td colspan="11" align="center" bgcolor="#33CC00"><strong>Here are the unassigned files for <?=cleanField2($county)?> County</strong></td>
    </tr>
    <tr bgcolor="#CCCCCC">
    	<td colspan="2" align="center" width="10%"><strong>More Information</strong></td>
        <td colspan="2" align="center"><strong>Independent Contractor</strong></td>        
        <td colspan="2" align="center"><strong>Client File #</strong></td>
        <td colspan="2" align="center"><strong>Plaintiff Name</strong></td>
        <td colspan="2" align="center"><strong>Service Address</strong></td>
        <td colspan="2" align="center" width="7%"><strong>Assign</strong></td>
    </tr>
<?
$q2= "select * from ps_packets where (circuit_court = '$county') AND (process_status = 'New')";
$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
$i=0;
while ($d2=mysql_fetch_array($r2, MYSQL_ASSOC)){$i++;
?>
	<tr bgcolor="<?=row_color($i,'#ccffcc','#ccffff')?>">
    <td colspan="2" align="center"><a href="ps_details.php?id=<?=$d2[id]?>">Details</a></td>
    <td colspan="2" align="center"><? if ($d2[server_id]){ ?>
	<a href="ps_review.php?admin=<?=$d2[server_id]?>">
	<?=id2name($d2[server_id])?></a> <? }else{ echo '<i>No Contractor Assigned</i>' ;} ?></td>
    <td colspan="2" align="center"><?=$d2[client_file] ?></td>
    <td colspan="2" align="center"><?=$d2[name1] ?></td>
    <td colspan="2" align="center"><?=$d2[address1] ?></td>
    <td colspan="2" align="center"><input type="checkbox" name="assign[<?=$d2[id]?>]" value="<?=$d2[id]?>" /></td>
    </tr>
<?
	} 
}
if ($_GET[county]){
$county = $_GET[county];
?>
	<tr>
    	<td colspan="11" align="center" bgcolor="#CC6699"><font color="#FFFFFF"><strong>Independent Contractors Available For <?=cleanField2(ps2county($county))?> County</strong></font></td>
    </tr>
	<tr>
    	<td colspan="6" align="right"><select name="server_id"><?=serverList($county);?></select></td>
    <td colspan="6" align="left"><input type="submit" name="submit" value="Assign Files" /></td>
    </tr>
</form>
</table>
<?
	
}else{
?>
<tr bgcolor="#FF0033">
	<td align="center" colspan="11"><font color="#FFFFFF"><h2>Please select a county to display the available contractors</h2></font></td>
    </tr>
</table>
<?
}
if ($_GET[county]){
$county = $_GET[county];
?>
<center>
<div style="width:100%; height:395px; overflow:auto">
<table bgcolor="#FFFFFF" border="1" width="100%">
	<tr>
    	<td align="center">Contractor Name</td>
        <td width="90">Date Assigned</td>
        <td width="90">Date Received</td>
        <td width="60" bgcolor="#99FF33">Day 1</td>
        <td width="60" bgcolor="#CCCC66">Day 2</td>
        <td width="60" bgcolor="#CC9900">Day 3</td>
        <td width="60" bgcolor="#CC6633">Day 4</td>
        <td width="60" bgcolor="cc6666">Day 5</td>
        <td width="60" bgcolor="#CC0000">Day 6+</td>
        <td align="center" width="8%">Bid Amount</td>
        <td align="center" width="8%">Load</td>
	</tr>
<?
$q1= "select * from ps_users where contract = 'YES' AND verify = 'YES' AND $county > '0' and level <> 'DELETED'";
$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
$i=0;
while ($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){$i++;
?>
	<tr bgcolor="<?=row_color($i,'#ffcccc','#ff9999')?>">
		<td>
        <a href="ps_review.php?admin=<?=$d1[id] ?>">Review</a> | <a href="ps_report.php?id=<?=$d1[id] ?>">Report</a><br /><?=$d1[name]?></td>
        <td></td>
        <td></td>
        <td bgcolor="#99ff33"><strong>00</strong></td>
        <td bgcolor="#CCCC66"><strong>00</strong></td>
        <td bgcolor="#CC9900"><strong>00</strong></td>
        <td bgcolor="#CC6633"><strong>00</strong></td>
        <td bgcolor="cc6666"><strong>00</strong></td>
        <td bgcolor="#CC0000"><strong>00</strong></td>
        <td align="center"><?=$d1[$county]?></td>
        <td align="center">xx / <?=$d1[max_volume]?></td>

	</tr>

<? 
	}
}else{
};
?>
</table>
</div>
</center>
<?
include 'footer.php'; ?>