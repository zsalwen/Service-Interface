<?
include 'common.php';
include 'menu.php';
include 'lock.php';
if (($_POST[case_no] != '')&& ($_POST[packet_id] != '')){
	$q1=@mysql_query("UPDATE ps_packets SET case_no='$_POST[case_no]' WHERE packet_id='$_POST[packet_id]'");
}
if ($_POST[client_file] != ''){
	$q="SELECT * from ps_packets where client_file='$_POST[client_file]' and process_status <> 'DAMAGED PDF' and process_status <> 'DUPLICATE' and process_status <> 'FILE COPY' and process_status <> 'DUPLICATE/DIFF-PDF'";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
}else{
	$q="SELECT * from ps_packets where client_file='$_GET[client_file]' and process_status <> 'DAMAGED PDF' and process_status <> 'DUPLICATE' and process_status <> 'FILE COPY' and process_status <> 'DUPLICATE/DIFF-PDF'";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
}
?>
<form method="post">
<table align="center" bgcolor="#33CCCC">
	<tr>
    	<td align="center">CLIENT FILE LOOKUP</td>
    </tr>
	<tr>
    	<td>File #: <input name="client_file" value="<?=$d[client_file]?>" /><input type="submit" name="submit" value="GO" /></td>
    </tr>
    <tr>
    	<td>Case #: <input name="case_no" value="<?=$d[case_no]?>" /></td>
    </tr>
    <tr>
    	<td><strong>Packet #: <a style="text-decoration:none; color:#666666" href="order.php?packet=<?=$d[packet_id]?>" target="_blank"><?=$d[packet_id]?></a></strong></td>
    </tr>
    <tr>
    	<td><strong>Process Status: <?=$d[process_status]?></strong></td>
    </tr>
</table>
<input type="hidden" name="packet_id" value="<?=$d[packet_id]?>">
</form>
<?
include 'footer.php';
?>