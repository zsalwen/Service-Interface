<?
include 'common.php';
if ($_POST[submit]){
	foreach ( $_POST[reopen] as $value){
		$q="UPDATE ps_packets SET process_status='ASSIGNED' WHERE packet_id ='$value'";
		@mysql_query($q);
		$client_file = $_POST[client_file];
		$user_id = $_COOKIE[psdata][user_id];
		$subject="File $client_file Reopened";
		$message="Reason: ".addslashes($_POST[msg]);
		@mysql_query("insert into ps_mailbox (from_id, to_id, message, subject, send_date) values ('$user_id', '$value', '$message', '$subject', NOW()) ");
	}
}

include 'menu.php';
$q="SELECT * from ps_packets order by packet_id ASC";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
?>
<style>
a.pff{color:#000000; text-decoration:none;}
a.pff:link{color:#000000; text-decoration:none;}
a.pff:visited{color:#000000; text-decoration:none;}
a.pff:hover{ color:#990000; cursor:pointer; text-decoration:none;}
</style>
<table width="1100px"><tr><td width="50%">
<table border="1">
<form method="post">
	<tr>
    	<td align="center">Reopen</td>
        <td align="center">Affidavits</td>
        <td align="center">Packet #</td>
    </tr>
<?
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
?>
	<tr>
    	<input type="hidden" name="server_id<?=$d[packet_id]?>" value="<?=$d[server_id]?>">
    	<input type="hidden" name="client_file<?=$d[packet_id]?>" value="<?=$d[client_file]?>">
    	<td><input type="checkbox" name="reopen[<?=$d[packet_id]?>]" value="<?=$d[packet_id]?>"></td>
        <td nowrap="nowrap">
        <? if ($d[name1]){?><a target="affidavit" class="pff" title="Affidavit for <?=$d[name1]?>" href="affidavit.php?packet=<?=$d[packet_id]?>&def=1">| <small><?=$d[name1]?></small> | </a><? }else{ } ?>
        <? if ($d[name2]){?><a target="affidavit" class="pff" title="Affidavit for <?=$d[name2]?>" href="affidavit.php?packet=<?=$d[packet_id]?>&def=2"><small><?=$d[name2]?></small> | </a><? }else{ } ?>
        <? if ($d[name3]){?><a target="affidavit" class="pff" title="Affidavit for <?=$d[name3]?>" href="affidavit.php?packet=<?=$d[packet_id]?>&def=3"><small><?=$d[name3]?></small> | </a><? }else{ } ?>
        <? if ($d[name4]){?><a target="affidavit" class="pff" title="Affidavit for <?=$d[name4]?>" href="affidavit.php?packet=<?=$d[packet_id]?>&def=4"><small><?=$d[name4]?></small> | </a><? }else{ } ?>
        </td>

        <td align="center"><?=$d[packet_id]?></td>
    </tr>
<? } ?>
	<tr>
    	<td colspan="3" align="center"><textarea name="msg" id="msg" rows="5" cols="50"></textarea></td>
    </tr>
    <tr>
    	<td colspan="3" align="center"><input type="submit" name="submit" value="Reopen"></td>
    </tr>
</form>
</table></td><td valign="top">
<iframe style="background-color:#FFFFFF;" frameborder="1" height="1050px" width="650px" name="affidavit"></iframe>
</td>
</tr>
</table>
<? include 'footer.php'; ?>