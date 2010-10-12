<?
include '../common/functions.php';
db_connect('delta.mdwestserve.com','intranet','root','zerohour');

function initals($str){
	$str = explode(' ',$str);
	return strtoupper(substr($str[0],0,1).substr($str[1],0,1).substr($str[2],0,1).substr($str[3],0,1));
}

function id2server($id){
	$q=@mysql_query("SELECT name from ps_users where id='$id'") or die(mysql_error());
	$d=mysql_fetch_array($q, MYSQL_ASSOC);
	return initals($d[name]);
}

$q = "SELECT * FROM ps_packets WHERE packet_id = '$_GET[packet]'";		
$r = @mysql_query ($q) or die(mysql_error());
//portal_log("Accessing Details for Process Service $data[client_file] ($data[address1] : $data[date_received])", $user[contact_id]);
$data = mysql_fetch_array($r, MYSQL_ASSOC);
$i=0;
$q1 = "SELECT *, DATE_FORMAT(date_received,'%M %D, $Y at %l:%i%p') as date_received_f FROM ps_packets WHERE packet_id = '$_GET[packet]'";		
$r1 = @mysql_query ($q1) or die("Query: $q1<br>".mysql_error());
if ($data[status] == 'RECIEVED'){
	$status='RECEIVED';
}else{
	$status=$data[status];
}
?>
<style>

li, td {font-size:14px}
</style>
<table width="100%">
	<tr>
    	<td align="left"><center><font size="+2">Service Completed for Packet #<?=$data[packet_id]?></font><br>Printed <?=date('r')?></center>
		<li>Client File Number: <strong><?=$data[client_file]?></strong></li>
		<li>Intake Status: <strong><?=$data[status]?></strong> on <strong><?=$data[date_received]?></strong></li>
		<li>Process Status: <strong><?=$data[process_status]?></strong></li>
		<li>Affidavit Status: <strong><?=$data[affidavit_status]?></strong></li>
		<li>Service Status: <strong><?=$data[service_status]?></strong></li>
		<li>Client Instructions: <strong><?=$data[attorney_notes]?></strong></li>
         </td>
	</tr>
</table>

<table><tr>
<?
function getMark($in){
            $out = explode('http://mdwestserve.com/ps/photographs//', $in);
			return 'http://mdwestserve.com/ps/photographs//small.'.$out[1];
            }
while($data1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
	while($i < 5){
	$i++;
		if ($data1['name'.$i]){
	?>
	<td valign="top" align="center"><table border="1" width="100%" style="border-collapse:collapse; font-size:24px" cellspacing="0" cellpadding="5">
		<tr>
			<td><?=$data1['name'.$i]?><br /><?=$data1['address'.$i]?><br /><?=$data1['city'.$i]?>, <?=$data1['state'.$i]?> <?=$data1['zip'.$i]?><br />Track USPS: <?=$data1["article$i"];?></td>
            <? $vera=$i.'a';
				$verb=$i.'b';
			if ($data1['address'.$vera]){ ?>
            	<td><?=$data1['address'.$vera]?><br /><?=$data1['city'.$vera]?>, <?=$data1['state'.$vera]?> <?=$data1['zip'.$vera]?></td>
            <? } 
			if ($data1['address'.$verb]){ ?>
            	<td><?=$data1['address'.$verb]?><br /><?=$data1['city'.$verb]?>, <?=$data1['state'.$verb]?> <?=$data1['zip'.$verb]?></td>
            <? } ?>
		</tr>
        
		<tr>
			<td>
<?  if ($data1['address'.$i] && !$data1['address'.$vera]){ ?>
<?
		if ($data1['photo'.$i.'a']){?><img src="<?=getMark($data1['photo'.$i.'a'])?>"><? }
		if ($data1["photo".$i."b"]){?><img src="<?=getMark($data1["photo".$i."b"])?>"><? }
		if ($data1['photo'.$i.'c']){?><img src="<?=getMark($data1['photo'.$i.'c'])?>"><? }
		 
	}elseif($data1['address'.$i] && $data1['address'.$verb]){ 
		
		if ($data1["photo".$i."c"]){?></td><td><img src="<?=getMark($data1["photo".$i."c"])?>"><? } 
		if ($data1['photo'.$i.'a']){?><img src="<?=getMark($data1['photo'.$i.'a'])?>"><? }
		if ($data1["photo".$i."b"]){?><img src="<?=getMark($data1["photo".$i."b"])?>"><? } 
		if ($data1['photo'.$i.'d']){?></td><td><img src="<?=getMark($data1['photo'.$i.'d'])?>"><? }
		if ($data1["photo".$i."e"]){?><img src="<?=getMark($data1["photo".$i."e"])?>"><? } 
	
	} ?>
    		</td>
		</tr>
<?  $q2="SELECT * from ps_affidavits where packetID = '$_GET[id]' and defendantID='$i'"; 
	$r2=@mysql_query($q2) or die("Query $q2<br>".mysql_error());
	$d2=mysql_num_rows($r2);
	if ($d2 > 0){
?>        
<?	} ?>
		<tr>
			<td>
			<? 
			$qn="SELECT * FROM ps_history WHERE packet_id = '$_GET[packet]' and defendant_id = '$i' order by history_id ASC";
			$rn=@mysql_query($qn);
			while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){
				echo "<div style='border:solid 1px'>#$dn[history_id] : ".id2server($dn[serverID]).stripslashes($dn[action_str])."</div>";
			}
			?>
			</td>
            <? if ($data1['address'.$vera]){ ?>
            <td>
			<? 
			$qn="SELECT * FROM ps_history WHERE packet_id = '$_GET[packet]' and defendant_id = '$i' order by history_id ASC";
			$rn=@mysql_query($qn);
			while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){
				echo "<div style='border:solid 1px'>#$dn[history_id] :".id2server($dn[serverID]).stripslashes($dn[action_str])."</div>";
			}
			?>
			</td>
            <? } ?>
            <? if ($data1['address'.$verb]){ ?>
            <td>
			<? 
			$qn="SELECT * FROM ps_history WHERE packet_id = '$_GET[packet]' and defendant_id = '$i' order by history_id ASC";
			$rn=@mysql_query($qn);
			while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){
				echo "<div style='border:solid 1px'>#$dn[history_id] :".id2server($dn[serverID]).stripslashes($dn[action_str])."</div>";
			}
			?>
			</td>
            <? } ?>
	</table></td>   
	<?
		}
	}
}
echo "</tr></table>";





?>

<table width="100%"><tr>
<? function account($id){ 
$r=@mysql_query("select * from ps_users where id = '$id'");
$d=mysql_fetch_array($r, MYSQL_ASSOC);
?>
<td valign="top">
<FIELDSET>
  <LEGEND ACCESSKEY=C><?=$d[name]?> (<?=initals($d[name]);?>)</LEGEND>
<table>
	<tr>
    	<td><?=$d[company]?></td>
	</tr>
	<tr>
    	<td><?=$d[phone]?></td>
	</tr>
	<tr>
    	<td><?=$d[address]?><br><?=$d[city]?> <?=$d[state]?> <?=$d[zip]?></td>
	</tr>
	<tr>
    	<td></td>
	</tr>
</table>    
</FIELDSET>
</td>
<? }
$rx=@mysql_query("select distinct serverID from ps_history where packet_id='$data[packet_id]'");
while ($dx=mysql_fetch_array($rx, MYSQL_ASSOC)){
	account($dx[serverID]);
}
?>

</tr></table>
<FIELDSET style="height:250px">
  <LEGEND ACCESSKEY=C>Certified Mail Receipt</LEGEND>
</FIELDSET>


