<?
include 'common.php';
include 'lock.php';
include 'menu.php';
$q="select * from psActivity order by today DESC";
$r=@mysql_query($q);
?>
<meta http-equiv="refresh" content="120">
<table border="1" style="border-collapse:collapse;">
	<tr bordercolor="#FFFF00">
    	<td>Date</td>
    	<td>Case&nbsp;Numbers&nbsp;Looked&nbsp;Up</td>
    	<td>Case&nbsp;Numbers&nbsp;Requested</td>
    	<td>Mail&nbsp;Prepared</td>
    	<td>Mail&nbsp;Printed</td>
    	<td>Mail&nbsp;Sent</td>
    	<td>Service&nbsp;Confirmed</td>
    	<td>Service&nbsp;Printed</td>
    	<td>Service&nbsp;Completed</td>
    	<td>Service&nbsp;Filed</td>
	</tr>
<? while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ ?>
	<tr>
    	<td><?=$d[today]?></td>
    	<td><?=$d[caseNumber]?></td>
    	<td><?=$d[caseNumberFlag]?></td>
    	<td><?=$d[mailPrep]?></td>
    	<td><?=$d[mailPrint]?></td>
    	<td><?=$d[mailSent]?></td>
    	<td><?=$d[serviceConfirmed]?></td>
    	<td><?=$d[servicePrinted]?></td>
    	<td><?=$d[serviceCompleted]?></td>
    	<td><?=$d[serviceFiled]?></td>
	</tr>
<? } ?>
</table>
<?
include 'footer.php';
?>