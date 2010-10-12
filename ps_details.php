<?
include 'common.php';

function id2package($package_id){
	$q="SELECT name from ps_packages WHERE id='$package_id'";
	$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[name];
}
if ($_POST[pkg]){
$pkg = $_POST[pkg];
}else{
$pkg = $_GET[pkg];
}
if ($_POST[submit]){
	if ($_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Administrator" || $_COOKIE[psdata][level] == "Operations"){
		$q4="UPDATE ps_packets SET server_id = '$_POST[server_id]' where packet_id = '$pkg'";
		$r4=@mysql_query($q4) or die("query: $q4<br>".mysql_error());
		header("Location: ps_details.php?pkg=$pkg");
	}else{
		echo "<script>alert('You do not have the authority to do that!')</script>";
	}
}
if ($_POST[submit2]){
	if ($_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Administrator" || $_COOKIE[psdata][level] == "Operations"){
		$q4="UPDATE ps_packets SET server_ida = '$_POST[server_id]' where packet_id = '$pkg'";
		$r4=@mysql_query($q4) or die("query: $q4<br>".mysql_error());
		header("Location: ps_details.php?pkg=$pkg");
	}else{
		echo "<script>alert('You do not have the authority to do that!')</script>";
	}
}
include 'menu.php';
//include 'ps_tabs.php';
$user_id=$_COOKIE[userdata][user_id];
$q= "select * from ps_packets where packet_id = '$pkg'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC);
?>
<table bgcolor="#FFFFFF" border="1" width="100%">
    <tr>
        <td colspan="2" align="center" bgcolor="#99CCFF"><b>Case Information</b></td>
    </tr>
<?
if (($_COOKIE[psdata][level] == "Green Member") || ($_COOKIE[psdata][level] == "Gold Member") || ($_COOKIE[psdata][level] == "Platinum Member")){
}else{
?>
    <tr>
      <td>ID #</td>
      <td width="75%"><?=$d['packet_id']?></td>
    </tr>
    <tr>
      <td>Part of Package</td>
      <td width="75%"><?=id2package($d['package_id']);?></td>
    </tr>                  
    <tr>
      <td>Case</td>
      <td><?=$d['case_no']?></td>
    </tr>
    <tr>
      <td>Client File #</td>
      <td><?=$d['client_file']?></td>
    </tr>
    <tr>
      <td>Attorney</td>
      <td><?=id2attorney($d['attorneys_id'])?></td>
    </tr>
    <tr>
    	<td>Date Received</td>
        <td><?=$d[date_received]?></td>
    </tr>
    <tr>
    	<td>Server</td>
        <td><?=id2name($d[server_id])?></td>
    </tr>
    <? if ($d[server_ida]){ ?>
    <tr>
    	<td>Second Server</td>
        <td><?=id2name($d[server_ida])?></td>
    </tr>
<? } ?>
    <? if ($d[server_idb]){ ?>
    <tr>
    	<td>Third Server</td>
        <td><?=id2name($d[server_idb])?></td>
    </tr>
<? }?>
	<tr>
    	<td>OTD</td>
        <td><a style="text-decoration:none; color:#000000" href="<?=$d[otd]?>">Papers</a></td>
    </tr>
<? }?>
    <tr>
        <td>Circuit Court</td>
        <td><?=$d['circuit_court']?></td>
    </tr>
    <tr>  
        <td colspan="2" align="center" bgcolor="#99CCFF"><b>Plaintiff Information</b></td>
    </tr>
<? if ($d[name1]){ ?>
    <tr>
        <td>Defendant 1</td>
        <td><?=$d['name1']?></td>
    </tr>
<? } ?>
<? if ($d[name2]){ ?>
    <tr>
	    <td>Defendant 2</td>
        <td><?=$d['name2']?></td>
    </tr>
<? } ?>
<? if ($d[name3]){ ?>
    <tr>
    	<td>Defendant 3</td>
        <td><?=$d['name3']?></td>
    </tr>
<? } ?> 
<? if ($d[name4]){ ?>  
    <tr>
    	<td>Defendant 4</td>
        <td><?=$d['name4']?></td>
    </tr>
<? } ?>
<? if ($d[address1] && $d[address1a]){ ?>
    <tr>
        <td>First Address to Serve</td>
        <td><?=$d['address1a']?>, <?=$d['city1a']?>, <?=$d['state1a']?> <?=$d['zip1a']?></td>
    </tr>
    <tr>
        <td>First Address to Post</td>
        <td><?=$d['address1']?>, <?=$d['city1']?>, <?=$d['state1']?> <?=$d['zip1']?></td>
    </tr>
<? }elseif ($d[address1]){ ?>
    <tr>
        <td>First Address to Serve &amp; Post</td>
        <td><?=$d['address1']?>, <?=$d['city1']?>, <?=$d['state1']?> <?=$d['zip1']?> (<?=$d['state1']?>/<?=$d['state1a']?>)</td>
    </tr>
<? } ?>
<? if ($d[address1b]){ ?>
    <tr>
        <td>Alternate First Address to Serve</td>
        <td><?=$d['address1b']?>, <?=$d['city1b']?>, <?=$d['state1b']?> <?=$d['zip1b']?></td>
    </tr>
<? } ?>

<? if ($d[address2] && $d[address2a]){ ?>
    <tr>
        <td>Second Address to Serve</td>
        <td><?=$d['address2a']?>, <?=$d['city2a']?>, <?=$d['state2a']?> <?=$d['zip2a']?></td>
    </tr>
    <tr>
        <td>Second Address to Post</td>
        <td><?=$d['address2']?>, <?=$d['city2']?>, <?=$d['state2']?> <?=$d['zip2']?></td>
    </tr>
<? }elseif ($d[address2]){ ?>
    <tr>
        <td>Second Address to Serve &amp; Post</td>
        <td><?=$d['address2']?>, <?=$d['city2']?>, <?=$d['state2']?> <?=$d['zip2']?></td>
    </tr>
<? } ?>
<? if ($d[address2b]){ ?>
    <tr>
        <td>Alternate Second Address to Serve</td>
        <td><?=$d['address2b']?>, <?=$d['city2b']?>, <?=$d['state2b']?> <?=$d['zip2b']?></td>
    </tr>
<? } ?>
<? if ($d[address3] && $d[address3a]){ ?>
    <tr>
        <td>Third Address to Serve</td>
        <td><?=$d['address3a']?>, <?=$d['city3a']?>, <?=$d['state3a']?> <?=$d['zip3a']?></td>
    </tr>
    <tr>
        <td>Third Address to Post</td>
        <td><?=$d['address3']?>, <?=$d['city3']?>, <?=$d['state3']?> <?=$d['zip3']?></td>
    </tr>
<? }elseif ($d[address3]){ ?>
    <tr>
        <td>Third Address to Serve &amp; Post</td>
        <td><?=$d['address3']?>, <?=$d['city3']?>, <?=$d['state3']?> <?=$d['zip3']?></td>
    </tr>
<? } ?>
<? if ($d[address3b]){ ?>
    <tr>
        <td>Alternate Third Address to Serve</td>
        <td><?=$d['address3b']?>, <?=$d['city3b']?>, <?=$d['state3b']?> <?=$d['zip3b']?></td>
    </tr>
<? } ?>
<? if ($d[address4] && $d[address4a]){ ?>
    <tr>
        <td>Fourth Address to Serve</td>
        <td><?=$d['address4a']?>, <?=$d['city4a']?>, <?=$d['state4a']?> <?=$d['zip4a']?></td>
    </tr>
    <tr>
        <td>Fourth Address to Post</td>
        <td><?=$d['address4']?>, <?=$d['city4']?>, <?=$d['state4']?> <?=$d['zip4']?></td>
    </tr>
<? }elseif ($d[address4]){ ?>
    <tr>
        <td>Fourth Address to Serve &amp; Post</td>
        <td><?=$d['address4']?>, <?=$d['city4']?>, <?=$d['state4']?> <?=$d['zip4']?></td>
    </tr>
<? } ?>
<? if ($d[address1b]){ ?>
    <tr>
        <td>Alternate Fourth Address to Serve</td>
        <td><?=$d['address4b']?>, <?=$d['city4b']?>, <?=$d['state4b']?> <?=$d['zip4b']?></td>
    </tr>
<? } ?>
    <tr>
         <td align="center" colspan="2" bgcolor="#99CCFF"><b>Additional Information</b></td>
    </tr>
    <tr>
         <td>Process Status</td>
         <td><?=$d['process_status']?></td>
    </tr>
<?
if (($_COOKIE[psdata][level] == "Green Member") || ($_COOKIE[psdata][level] == "Gold Member") || ($_COOKIE[psdata][level] == "Platinum Member")){
}else{
?>
    <tr>
        <td>Server </td>
        <td><?=id2name($d['server_id'])?></td>
    </tr>
<?
}
if (($_COOKIE[psdata][level] == "Administrator") || ($_COOKIE[psdata][level] == "SysOp") || ($_COOKIE[psdata][level] == "Operations")){?>
    <tr>
        <td>Entered By</td>
        <td><?=id2name($d['entry_id'])?></td>
    </tr>
<? }?>
   </tr>
      <? if ($_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Administrator" || $_COOKIE[psdata][level] == "Operations"){?>
		<form name="form1" method="post">
		<input type="hidden" name="pkg" value="<?=$d[packet_id]?>" />
      <tr>
      	<td>Transfer Server 1</td>
    	<td><select name="server_id">
<?
$q2= "select * from ps_users where contract = 'YES' and id <> $d[server_id]";
$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
while ($d2=mysql_fetch_array($r2, MYSQL_ASSOC)) {
?>
<option value="<?=$d2[id]?>"><? if ($d2[company]){echo $d2[company].', '.$d2[name] ;}else{echo $d2[name] ;}?></option>
<?        } ?>
        </select>  <input type="submit" name="submit" value="Transfer File" /></td>
      </tr>
		</form> 
		<form name="form2" method="post">
		<input type="hidden" name="pkg" value="<?=$d[packet_id]?>" />
      <tr>
      	<td>Transfer Server 2</td>
    	<td><select name="server_id">
<?
$q2= "select * from ps_users where contract = 'YES' and id <> $d[server_id]";
$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
while ($d2=mysql_fetch_array($r2, MYSQL_ASSOC)) {
?>
<option value="<?=$d2[id]?>"><? if ($d2[company]){echo $d2[company].', '.$d2[name] ;}else{echo $d2[name] ;}?></option>
<?        } ?>
        </select>  <input type="submit" name="submit2" value="Transfer File" /></td>
		</form>
      </tr>     
	<tr bgcolor="#CCCCCC">
		<td colspan="3" align="center" style="border-right:hidden"><font size="+1"><a href="ps_edit.php?id=<?=$d['id']?>">Edit File Details</a></font></td>
     </tr>
	<? }?>
</table>
<? include 'footer.php'; ?>