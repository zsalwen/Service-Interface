<?
//This Defendant Tabs page is specifically to be used within affidavitUpload.php
$packet = $_GET[packet];
$user = $_COOKIE[psdata][user_id];
$q20="SELECT * FROM ps_packets WHERE packet_id = '$packet'";
$r20=@mysql_query($q20);
$i=0;
?>
<table border="1" style="border-collapse:collapse" width="100%">
<tr>
<?

while($d20=mysql_fetch_array($r20, MYSQL_ASSOC)){
	while ($i < 5) {$i++;

	if ($d20["name$i"]){
		if (!$_GET[tab] && $i == 1){
			$color = '#000099';
		}elseif ($_GET[tab] == "$i"){
			$color = '#000099';
		}else{
			$color = '#0066FF';
		}
?>
		<td align="center" bgcolor="<?=$color?>" style="font-size:18px; border:inset 4px #0099FF;"><a class="ser" href="affidavitUpload.php?packet=<?=$packet?>&tab=<?=$i?>">$<? if ($user == $d[server_id]){echo $d20["contractor_rate"];} if ($user == $d[server_ida]){echo $d20["contractor_ratea"];}?>.oo <?=$d20["name$i"]?></a></td>
    
<?
		}
	}
}
?>
</tr>
<?
$i=0;
?>
</table>