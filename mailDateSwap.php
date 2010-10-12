<?
include "common.php";
include "menu.php";
if ($_GET[replace]){
	$search=$_GET[search];
	$replace=strtoupper($_GET[replace]);
	$q1="SELECT * FROM ps_history WHERE action_str LIKE '%$search%' AND wizard='MAILING DETAILS'";
	$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
	echo "<table align='center' width='50%'>";
	echo "<tr><td>PACKET ID</td><td width='80%'>UPDATED ACTION</td></tr>";
	while($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){
	while($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){
		$id=$d1[history_id];
		$history=explode($search,$d1[action_str]);
		$newHistory = implode($replace, $history);
		$newHistory = addslashes($newHistory);
		echo '<tr><td>'.$id.'</td><td>'.$newHistory."</tr></td>";
		$q2="UPDATE ps_history SET action_str='$newHistory' WHERE history_id='$id'";
		$r2=@mysql_query($q2) or die("Query: $q2<br>".mysql_error());
	}
	echo "</table>";
	//echo "Packet $packet has had its affidavits updated to replace <i>$search</i> with <i>$replace</i>.";
}
}
if($_GET[search] && $_GET[replace]){ ?>
<table align="center"><tr><td>
<h1>Mailing entries updated for search term <?=$_GET[search]?>, replaced with <?=$_GET[replace]?>.</h1><br>
</td></tr></table>
<? }elseif($_GET[search]){ ?>
	<table align="center"><tr><td>
	<h1>Enter Replacement Term:</h1><br>
	<form><input name="replace"><input type="submit" value="SUBMIT">
	<input type="hidden" name="search" value="<?=$_GET[search]?>">
	</form>
	</tr></td></table>
<?	$search=$_GET[search];
	$q1="SELECT * FROM ps_history WHERE action_str LIKE '%$search%' AND wizard='MAILING DETAILS'";
	$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
	echo "<table align='center' width='50%'><tr><td align='2' colspan='2'>SEARCHING FOR: <i>$search</i></td></tr>";
	echo "<tr><td>PACKET ID</td><td width='80%'>ACTION</td></tr>";
	while($d1=mysql_fetch_array($r1, MYSQL_ASSOC)){
		echo "<tr><td>$d1[packet_id]</td><td>$d1[action_str]</td></tr>";
	}
	echo "</table>";
}else{ ?>
<table align="center"><tr><td>
<h1>Enter History Search Term:</h1><br>
<form><input name="search"><input type="submit" value="SUBMIT"></form>
</tr></td></table>
<? } ?>