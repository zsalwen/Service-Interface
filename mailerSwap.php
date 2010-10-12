<?
include "common.php";
include "menu.php";
$packet=$_GET[packet];

if ($_GET[mailer]){
	$mailer=$_GET[mailer];
	$q1="SELECT * FROM ps_history WHERE packet_id='$packet' AND wizard='MAILING DETAILS'";
	$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
	while($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){
		$id=$d1[history_id];
		$history=explode(", ",$d1[action_str]);
		$name=id2name($mailer);
		$history[1] = strtoupper($name);
		$newHistory = implode(", ", $history);
		$newHistory = addslashes($newHistory);
		echo $newHistory."<br>";
		$q2="UPDATE ps_history SET action_str='$newHistory', serverID='$mailer' WHERE history_id='$id'";
		$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
		
	}
	echo "Packet $packet has had its affidavits updated to reflect ".id2name($mailer)." as new mailer.";
}
if($_GET[packet] && !$_GET[mailer]){
	$q="SELECT * FROM ps_history WHERE packet_id='$packet' AND wizard='MAILING DETAILS'";
	$r=@mysql_query($q) or die (mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC); ?>
<table align="center"><tr><td>
<h1>Mailing entries for packet <?=$packet?> were done by <?=id2name($d[serverID])?></h1>
</td></tr><tr><td>
<h1>Change to ID #: </h1><br>
<form><input name="mailer" value="<?=$d[serverID]?>"><input type="submit" value="SUBMIT"><input type="hidden" name="packet" value="<?=$_GET[packet]?>"></form>
</td></tr></table>
<? }elseif($_GET[packet] && $_GET[mailer]){ ?>
<table align="center"><tr><td>
<h1>Mailing entries updated for packet # <?=$packet?>.</h1><br>
<h1>Enter another packet to change mailing entries for:</h1><br>
<form><input name="packet" value="<?=$packet?>"><input type="submit" value="SUBMIT"></form>
</tr></td></table>
<? }else{ ?>
<table align="center"><tr><td>
<h1>Change mailing entries for packet:</h1><br>
<form><input name="packet"><input type="submit" value="SUBMIT"></form>
</tr></td></table>
<? } ?>