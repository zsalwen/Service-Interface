<?
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Main Page');
include 'common.php';

$user = $_COOKIE[psdata][user_id];

if ($_GET[tab]){
$tab = $_GET[tab];
}else{
$tab = "New";
}




if ($_GET[pending]){
@mysql_query("UPDATE private_process SET process_status='Pending' WHERE id = '$_GET[pending]'");
$status = "Service Started";
echo "<script>alert('$status')</script>";
}

if ($_GET[served]){
@mysql_query("UPDATE private_process SET process_status='Served' WHERE id = '$_GET[served]'");
$status = "File Served";
echo "<script>alert('$status')</script>";
}

if ($_GET[posted]){
@mysql_query("UPDATE private_process SET process_status='Posted' WHERE id = '$_GET[posted]'");
$status = "File Posted";
echo "<script>alert('$status')</script>";
}

if ($_GET[close]){
@mysql_query("UPDATE private_process SET process_status='Completed' WHERE id = '$_GET[close]'");
$status = "File Closed";
echo "<script>alert('$status')</script>";
}

$q= "select * from private_process, attorneys where private_process.attorneys_id = attorneys.attorneys_id AND private_process.process_status = '$tab' AND private_process.server_id = '$user'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());

$test = explode(' ',$_COOKIE[psdata][level]);
if ($test[1] != "Member"){
	if (($_COOKIE[psdata][level] == "Administrator") || ($_COOKIE[psdata][level] == "Operations") || ($_COOKIE[psdata][level] == "SysOp")){
		// ok to ba admin	
	} else{
		$event = 'ps_main.php';
		$email = $_COOKIE[psdata][email];
		$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
		//@mysql_query($q1) or die(mysql_error());
		header('Location: home.php');
	}
}

include 'menu.php';
//include 'ps_tabs.php';

?>

<!--
<table bgcolor="#FFFFFF" colspan="4" width="100%" border="1">

	<tr>
    <td><?=$tab?></td>
		<td>Circut Court:</td>
		<td>Serve Address:</td>
		<td>Post Address:</td>     
    </tr>
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){

$add = str_replace(' ', '+',$d[p_add]);
$zip = $d[p_zip];
$url = "http://maps.google.com/maps?f=q&hl=en&geocode=&q=$add,+$zip";

?>
    <tr>
    <td width="350"><a href="ps_details.php?id=<?=$d[id]?>">Details</a> | <a target="_blank" href="<?=$url?>">Map</a> 
    
    <? if ($d[process_status] == 'New') { ?>
    | <a href="?pending=<?=$d[id]?>">Start Service</a>
    <? } ?>
    <? if ($d[process_status] == 'Pending') { ?>
    | <a href="?served=<?=$d[id]?>">File Served</a>
    <? } ?>
    <? if ($d[process_status] == 'Pending') { ?>
    | <a href="?posted=<?=$d[id]?>">File Posted</a>
    <? } ?>
    <? if ($d[process_status] == 'Completed') { ?>
    | <a target="_blank" href="invoices/<?=$d[display_name]?>/<?=$d[client_file].'-SERVER.PDF'?>">View Invoice</a>
    <? } ?>
    
    
    </td>
		<td><?=$d[county]?></td>
        <td>$<?=$d[contractor_rate]?></td>
        <td><?=$d[serve_add]?></td>
        <td><?=$d[po_add]?></td>
   </tr>
  <? }?> 
   
</table>
-->
<table border="1" style="border-collapse:collapse"  width="100%" bgcolor="#FFFFFF">
    <tr bgcolor="#CCCCCC">
    	<td align="center" width="20%"><strong>More Information</strong></td>
        <td align="center"><strong>Service Address</strong></td>
    </tr>
<?
function mkStatus($status, $user){
?>
    <tr>
    	<td style="background-color:#333333; color:#CCCCCC;" bgcolor="#99CCFF" colspan="6" align="center"><strong><?=$status?> Files</strong></td>
    </tr>
<?
$q= "select * from private_process WHERE process_status = '$status' AND server_id = '$user'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {$i++;
?>
<style>
div.pcc:hover{ background-color:#333333; color:#FF0000; font-weight:bolder; font-variant:small-caps; cursor:pointer}
</style>

    <tr bgcolor="<?=row_color($i,'#99cccc','#99ccff')?>">
		<td align="center"><div class="pcc" onclick="window.location='ps_details.php?id=<?=$d[id]?>'">Details</div></td>
        <td><?=$d[serve_add] ?></td>
	</tr>
<?  
} 
if ($i == 0){
?>
	<tr bgcolor="#CCCCCC">
    	<td colspan="2" style="font-size:12px; font-variant:small-caps; font-weight:bold; color:#FF0000;" align="center">NONE</td>
    </tr>
<?
	}
}    

?>

<?=mkStatus('Assigned', $user)?>
<?=mkStatus('Accepted', $user)?>
<?=mkStatus('En Route: To Server', $user)?>
<?=mkStatus('Confirmed Start', $user)?>
<?=mkStatus('Service Completed', $user)?>
<?=mkStatus('En Route: To HWA', $user)?>

</table>        
<? include 'footer.php'; ?>