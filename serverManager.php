<?
include 'common.php';
include 'lock.php';
include 'menu.php';
function countServerStatus($status,$server){
$r=@mysql_query("select * from ps_packets where process_status LIKE '$status' and server_id = '$server'");
$r2=@mysql_query("select * from ps_packets where process_status LIKE '$status' and server_id = '$server' and ( affidavit_status = 'SERVICE CONFIRMED' or affidavit_status = 'FILED WITH COURT' or affidavit_status = 'FILED BY CLIENT')");
$r3=@mysql_query("select * from ps_packets where process_status LIKE '$status' and server_id = '$server' and affidavit_status = 'NEED CORRECTION'");
$count = mysql_num_rows($r);
$count2 = mysql_num_rows($r2);
$count3 = mysql_num_rows($r3);
if ($count && $count2){
$perc = number_format($count2/$count,2);
$perc = str_replace('.','',$perc);
}
return $count."</td><td bgcolor='#00FF00'>".$count2."</td><td bgcolor='#FFFF00'>".$perc."%</td><td bgcolor='#FF0000'>".$count3;
}
function serverData($id){
$r1=@mysql_query("select * from ps_users where id= '$id'");
$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
//$r2=@mysql_query("");
$outstanding = countServerStatus('ASSIGNED',$id) + countServerStatus('READY TO MAIL',$id) + countServerStatus('AWAITING MAIL CONFIRMATION',$id);
if ($id == '167'){ $color = "#CCCCCC"; }
$window="window.location.href='serverManager.php?user=".$id."'";
$data="<tr bgcolor='$color'><td>$id</td><td><a href='serverManager.php?user=".$id."'>$d1[name]</a></td><td>".countServerStatus('ASSIGNED',$id)."</td><td>".countServerStatus('READY TO MAIL',$id)."</td><td>".countServerStatus('AWAITING MAIL CONFIRMATION',$id)."</td><td>".countServerStatus('%',$id)."</td><td>    $outstanding    </td></tr>";
return $data;
}
if (isset($_GET[user])){?>
	<table align="center" width="50%">
    	<tr>
        	<td colspan="2" align="center"><?=id2name($_GET[user])?></td>
        </tr>
<?	$q4="SELECT DISTINCT process_status from ps_packets where (server_id='$_GET[user]' OR server_ida='$_GET[user]' OR server_idb='$_GET[user]' OR server_idc='$_GET[user]' OR server_idd='$_GET[user]' OR server_ide='$_GET[user]')";
	$r4=@mysql_query($q4) or die("Query $q4<br>".mysql_error());
	while ($d4=mysql_fetch_array($r4, MYSQL_ASSOC)){
		$r5=@mysql_query("SELECT * from ps_packets where process_status='$d4[process_status]' and server_id = '$_GET[user]'");
	?>
        <tr>
        	<td><small><?=$d4[process_status]?>:</small></td>
            <td><small><?=mysql_num_rows($r5)?></small></td>
        </tr>
<?	}?>
</table>
<? }
echo "<meta http-equiv='refresh' content='120' />
<table border='1' cellpadding='3' cellspacing='0' width='100%'><tr><td>Server ID</td><td>Name</td><td colspan='4'>In Progress</td><td colspan='4'>Ready to Mail</td><td colspan='4'>Mail Confirmation</td><td colspan='4'>All Files</td><td>Files Outstanding</td></tr>";

$r=@mysql_query("select distinct server_id from ps_packets");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	echo serverData($d[server_id]);
}
echo "</table>";
include 'footer.php';
?>