<?
include 'common.php';
function fileDate($date){
	$date=strtotime($date)-86400;
	return date('n/j/y',$date); 
}
$user = $_COOKIE[psdata][user_id];
$eviction = $_GET[id];
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Service Instructions for Packet '.$eviction);
$query="SELECT * FROM evictionPackets WHERE eviction_id = '$eviction'";
$result=@mysql_query($query);
$data=mysql_fetch_array($result,MYSQL_ASSOC);
$deadline=strtotime($data[date_received]);
$received=date('m/d/Y',$deadline);
$deadline=$deadline+432000;
$estFileDate=fileDate($data[estFileDate]);
$server_notes=$data[server_notes];
$r1=mysql_query("SELECT * FROM gasRates ORDER BY id DESC LIMIT 0,1");
$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
if ($d1[id]){
	$rate = "<br><center><div style='font-size:14px;'>[GAS PRICE: $$d1[gasPrice] | CONTRACTOR SURCHARGE: $$d1[contractor_rate]]</div></center>";
}
?>
<style>body { margin:0px; padding:0px;}</style>
<img style="position:absolute; left:0px; top:0px; width:100px; height:100px;" src="smallLogo.jpg" class="logo">
<table align="center" width="700px" style="font-variant:small-caps;" border="0">
	<tr>
    	<td valign="bottom" align="center" style="font-size:18px; font-variant:small-caps;" height="50px;">MDWestServe, Inc.<br>Day: 410-828-4568 || Night: 443-386-2584<br>Service Type 'A' For Eviction <?=$_GET[id]?></td>
    </tr>
	<tr>
		<td align="center" style="font-size:18px; font-variant:small-caps;">Received: <?=$received?> || Affidavit Deadline: <?=$estFileDate?><?=$rate?></td>
	</tr>
<?
$add1x = $data["address1"].' '.$data["city1"].', '.$data["state1"].' '.$data["zip1"];
?>
		<tr>
		<td style='font-size:16px'>
		<strong>ALL OCCUPANTS:</strong>
		<ol><li><?=id2name($data[server_id])?> is to make 2 service attempts on all occupants of <?=$add1x?> on different days.</li><li>
		After all other attempts have proven unsuccessful, 
		If <?=id2name($data[server_id])?> is unable to serve an occupant of suitable age and discretion:<br />
		<?=id2name($data[server_id])?> is to post <?=$add1x?>, addressing the documents to "ALL OCCUPANTS".</li></ol>
		</ol></td></tr>
<?
if ($data[attorneys_id] == 3){
	$i=1;
	while ($i < 6){$i++;
		if ($data["name$i"] && (strtoupper($data["onAffidavit$i"]) != 'CHECKED')){
			$name=ucwords($data["name$i"]);
			?>
			<tr>
			<td style='font-size:16px;'>
			<strong><?=$name?>:</strong>
			<ol><li><?=id2name($data[server_id])?> is to make 2 service attempts on <?=$name?> at <?=$add1x?> on different days.</li><li>
			After all other attempts have proven unsuccessful, 
			If <?=id2name($data[server_id])?> is unable to serve <?=$name?>:<br />
			<?=id2name($data[server_id])?> is to post <?=$add1x?>, addressing the documents to "<?=$name?>".</li></ol>
			</ol></td></tr>
	<?	}
	}
} ?>
		<tr>
			<td align='center'><fieldset><legend>Staff Instructions to Server</legend><div style="border:ridge 3px; font-size: 12px; width:650px; align:justify;"><b style="text-decoration:underline;">ALL SERVICE MUST TAKE INTO ACCOUNT:</b><br>'Two good faith attempts on separate days' - MD Rule 14-209(b)</div>
		<li>You cannot make two attempts at the same property within the same 24 hour period.</li><li>In The Event Of Posting, Write The Name Of The Party For Whom You Are Posting The Documents, As Well As The Date And Time Of Posting On The Documents Being Left. Please Ensure That This Date Is Also Visible In The Posting Picture.</li><li><b>Make one attempt either before 8 AM or after 6 PM, and another attempt between 9 AM and 5 PM.  "Good Faith" efforts must be made at different times of day, meaning that one attempt should be made before noon, and another afterwards, and they must be at least 24 hours apart.</b></li><li><b>Delivery to MDWestServe of all service affidavits for this file must be accomplished before <?=$estFileDate?></b></li><?=strtoupper($server_notes);?></fieldset></td>
		</tr>
</table>
<? 
if ($_GET[autoPrint] == 1){
	echo "<script>
	if (window.self) window.print();
	self.close();
	</script>";
}elseif (!$_GET[noField]){
	include "http://service.mdwestserve.com/fieldSheet.php?eviction=".$data['eviction_id']."&pageBreak=1";
}
mysql_close(); ?>