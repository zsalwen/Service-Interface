<?
/**
 * Affidavit "Turn-In" report.
 * Since no updates are used in this query we will access alpha.mdwestserve.com, our first mysql slave.
 * @author Patrick McGuire <patrick@mdwestserve.com>
 */
//include 'alpha.php';
include 'common.php';
include 'menu.php';
if ($_GET[review]){
$id=$_GET[review];
}else{
$id=$_COOKIE[psdata][user_id];
}
function paidStatus($num){
if ($num){ return '00FF00';}else{ return 'ff0000'; }
}
function fStatus($id){
$r=@mysql_query("select status, filing_status from ps_packets where packet_id='$id'");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
if ( $d[filing_status] == "FILED WITH COURT"){
return 'X';
}elseif($d[filing_status] == "FILED WITH COURT - FBS"){
return 'S';
}elseif($d[filing_status] == "PREP TO FILE"){
return 'P';
}elseif($d[filing_status] == "DO NOT FILE"){
return 'D';
}elseif($d[status] == "CANCELLED"){
return 'C';
}
}
function mStatus($id){
$r=@mysql_query("select mail_status, service_status from ps_packets where packet_id='$id'");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
if (strtoupper($d[mail_status]) == "MAILED FIRST CLASS AND CERTIFIED RETURN RECEIPT" || strtoupper($d[mail_status]) == "MAILED FIRST CLASS"){
return 'X';
}elseif(strtoupper($d[service_status] == "PERSONAL DELIVERY")){
return 'PD';
}
}
function aStatus($id){
$r=@mysql_query("select affidavit_status from ps_packets where packet_id='$id'");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
if ( $d[affidavit_status] == "SERVICE CONFIRMED"){
return 'X';
}}
function authStatus($id){
$r=@mysql_query("select payAuth from ps_packets where packet_id='$id'");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
if ( $d[payAuth] == "1"){
return 'X';
}}
function slot($slot,$id){
$q="SELECT * FROM ps_packets where server_id".$slot." = '$id' ORDER BY packet_id";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){?>
    <tr bgcolor="#<?=paidStatus(fStatus($d[packet_id]));?>">
    	<td><a style="text-decoration:none" href="order.php?packet=<?=$d[packet_id]?>" target="_blank"><?=$d[packet_id]?></a></td>
        <td><?=aStatus($d[packet_id])?></td>
        <td><?=authStatus($d[packet_id])?></td>
        <td><?=mStatus($d[packet_id])?></td>
        <td><?=fStatus($d[packet_id])?></td>
		<td><?=$d["contractor_rate".$slot]?></td>
    	<td><?=$d["contractor_paid".$slot]?></td>
    	<td><?=$d["contractor_check".$slot]?></td>
	</tr>
<? }} ?>
<div align="center">This is a complete review of each file, it's rate, amount paid and by which check number. If it is green we have paid, if it is yellow we more than likely need the affidavit.</div>
<table>
	<tr>
    <td valign="top">

<table border="1" style="border-collapse:collapse;">
    <tr>
    	<td>Packet</td><td>Conf</td>
        <td>Auth</td>
        <td>Mailed</td>
        <td>Filed</td>
    	<td>Rate</td>
    	<td>Paid</td>
    	<td>Check</td>
	</tr>
<?=slot('',$id);?>
</table>

</td><td valign="top">


<table border="1" style="border-collapse:collapse;">
    <tr>
    	<td>Packet</td><td>Conf</td>
        <td>Auth</td>
        <td>Mailed</td>
        <td>Filed</td>
    	<td>Rate</td>
    	<td>Paid</td>
    	<td>Check</td>
	</tr>
<?=slot('a',$id);?>
</table>

</td><td valign="top">
<table border="1" style="border-collapse:collapse;">
    <tr>
    	<td>Packet</td><td>Conf</td>
        <td>Auth</td>
        <td>Mailed</td>
        <td>Filed</td>
    	<td>Rate</td>
    	<td>Paid</td>
    	<td>Check</td>
	</tr>
<?=slot('b',$id);?>
</table>

</td><td valign="top">
<table border="1" style="border-collapse:collapse;">
    <tr>
    	<td>Packet</td><td>Conf</td>
        <td>Auth</td>
        <td>Mailed</td>
        <td>Filed</td>
    	<td>Rate</td>
    	<td>Paid</td>
    	<td>Check</td>
	</tr>
<?=slot('c',$id);?>
</table>

</td><td valign="top">
<table border="1" style="border-collapse:collapse;">
    <tr>
    	<td>Packet</td><td>Conf</td>
        <td>Auth</td>
        <td>Mailed</td>
        <td>Filed</td>
    	<td>Rate</td>
    	<td>Paid</td>
    	<td>Check</td>
	</tr>
<?=slot('d',$id);?>
</table>

</td><td valign="top">
<table border="1" style="border-collapse:collapse;">
    <tr>
    	<td>Packet</td><td>Conf</td>
        <td>Auth</td>
        <td>Mailed</td>
        <td>Filed</td>
    	<td>Rate</td>
    	<td>Paid</td>
    	<td>Check</td>
	</tr>
<?=slot('e',$id);?>
</table>

</td></tr>
</table>
<? include 'footer.php';?>