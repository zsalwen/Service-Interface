<?
include 'common.php';
include 'lock.php';
include 'menu.php';
opLog($_COOKIE[psdata][name]." Loaded Quality Control Report");

function rowColor($i){
    $bg1 = "#8CE88C"; // color one   
    $bg2 = "#008900"; // color two
    if ( $i%2 ) {
        return $bg1;
    } else {
        return $bg2;
    }
}
?>
<fieldset>
<legend>Daily Productivity</legend>
<?
$i=0;
$q="select * from psActivity order by today DESC";
$r=@mysql_query($q);
?>
<meta http-equiv="refresh" content="120">
<table border="1" style="border-collapse:collapse;">
	<tr bordercolor="#FFFF00">
    	<td>Date</td>
    	<td>Case&nbsp;Number&nbsp;LookUp</td>
    	<td>Case&nbsp;Number&nbsp;Request</td>
    	<td>Mail&nbsp;Prep</td>
    	<td>Mail&nbsp;PrinT</td>
    	<td>Mail&nbsp;Sent</td>
    	<td>Green&nbsp;Cards</td>
    	<td>Service&nbsp;Confirmed</td>
    	<td>Service&nbsp;Printed</td>
    	<td>Service&nbsp;Prep</td>
    	<td>Service&nbsp;Completed</td>
    	<td>Service&nbsp;Filed</td>
    	<td>Payment&nbsp;Entered</td>
        <td>DocUpload</td>
        <td>Case&nbsp;Load</td>
	</tr>
<? while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ $i++;?>
	<tr bgcolor="<?=rowColor($i)?>">
    	<td><?=$d[today]?></td>
    	<td><?=$d[caseNumber]?></td>
    	<td><?=$d[caseNumberFlag]?></td>
    	<td><?=$d[mailPrep]?></td>
    	<td><?=$d[mailPrint]?></td>
    	<td><?=$d[mailSent]?></td>
    	<td><?=$d[mailGreenCard]?></td>
    	<td><?=$d[serviceConfirmed]?></td>
    	<td><?=$d[servicePrinted]?></td>
    	<td><?=$d[servicePrep]?></td>
    	<td><?=$d[serviceCompleted]?></td>
    	<td><?=$d[serviceFiled]?></td>
    	<td><?=$d[clientPayment]?></td>
    	<td><?=$d[docUpload]?></td>
        <td><?=$d[caseNumber]+$d[caseNumberFlag]+$d[mailPrep]+$d[mailPrint]+$d[mailSent]+$d[mailGreenCard]+$d[serviceConfirmed]+$d[servicePrinted]+$d[servicePrep]+$d[serviceCompleted]+$d[serviceFiled]+$d[clientPayment]+$d[docUpload]?></td>
	</tr>
<? } ?>
</table>


</fieldset>
<fieldset>
<legend>Cancelations on Case Lookup Requests</legend>
<table width="100%">
<? $i=0; $r=@mysql_query("select * from ps_packets where caseLookupFlag=1 and status='cancelled' order by circuit_court"); while($d=mysql_fetch_array($r,MYSQL_ASSOC)){$i++;?>
<tr bgcolor="<?=rowColor($i);?>"><td><?=$i?>) </td><td><?=$d[date_received]?></td><td><?=$d[client_file]?></td><td><?=$d[circuit_court]?></td><td><?=$d[case_no]?></td><td><?=$d[packet_id]?></td></tr>
<? }?>
</table>
</fieldset>

<?
include 'footer.php';
?>