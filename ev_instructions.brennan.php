<?
include 'common.php';
$user = $_COOKIE[psdata][user_id];
$eviction = $_GET[id];
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Service Instructions for Packet '.$eviction);
$query="SELECT * FROM evictionPackets WHERE eviction_id = '$eviction'";
$result=@mysql_query($query);
$data=mysql_fetch_array($result,MYSQL_ASSOC);
$deadline=strtotime($data[date_received]);
$received=date('m/d/Y',$deadline);
$deadline=$deadline+432000;
$estFileDate=strtotime($data[estFileDate]);
$estFileDate=date('m/d/Y',$estFileDate);
?>
<style>body { margin:0px; padding:0px;}</style>
<img style="position:absolute; left:0px; top:0px; width:100px; height:100px;" src="small.logo.gif" class="logo">
<table align="center" width="700px" style="font-variant:small-caps;" border="0">
	<tr>
    	<td valign="bottom" align="center" style="font-size:22px; font-variant:small-caps;" height="50px;">MDWestServe, Inc.<br>Day: 410-828-4568 || Night: 443-386-2584<br>Service Type 'C' For Eviction <?=$_GET[id]?></td>
    </tr>
	<tr>
		<td align="center" style="font-size:22px; font-variant:small-caps;">Received: <?=$received?> || Affidavit Deadline: <?=$estFileDate?><br>This page must be returned with affidavits for payment of service.</td>
	</tr>
<?
	$add1x = $data["address1"].' '.$data["city1"].', '.$data["state1"].' '.$data["zip1"];
	$i=0;
	while ($i < 6){$i++;
		if ($data["name$i"]){
			$name=ucwords($data["name$i"]);
?>
<tr>
	<td>
    <strong><?=$name?>:</strong>
		<ul><li><b>PERFORM ALL ATTEMPTS ON SEPARATE DAYS.</b></li></ul>
    <ol><li><?=id2name($data[server_id])?> is to make 2 service attempts on <?=$name?> at <?=$add1x?> on different days.</li><li>
    After all other attempts have proven unsuccessful, <b>and on a separate day from any other attempts,</b><br>
	If <?=id2name($data[server_id])?> is unable to serve <?=$name?>:<br />
    <?=id2name($data[server_id])?> is to post <?=$add1x?>.</li></ol>
    </ol></td></tr>
<?
 		}
	}
?>
		<tr>
			<td align='center'><fieldset><legend>Staff Instructions to Server</legend><li>In The Event Of Posting, Write The Date And Time Of Posting On The Documents Being Left. Please Ensure That This Date Is Also Visible In The Posting Picture.</li><li>Make At Least One Attempt Either Before 9 AM Or After 5 PM.</li><li><b>Delivery to MDWestServe of all service affidavits for this file must be accomplished before <?=$estFileDate?></b></li><?=strtoupper($server_notes);?></fieldset></td>
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