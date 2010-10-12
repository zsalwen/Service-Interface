<? include 'common.php';$i=0;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pull Case Numbers</title>
</head>


<body bgcolor="#000000">
<style>
div {border:solid 1px #990066;}

</style>
<div><a href="?next=<?=time()?>">NEXT &gt; &gt; &gt; &gt; &gt; &gt;</a></div>
<table width="100%" border="1" style="border-collapse:collapse">
	<tr>
    	<td valign="top" bgcolor="#cccccc">
<ol><?
$q="select * from ps_packets where case_no = '' and filing_status='FILED WITH COURT' and caseLookupFlag = '0'";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$i++;
echo "<li><a href='order.php?packet=$d[packet_id]' target='order'>".strtoupper($d[packet_id]).'</a><div>'.strtoupper($d[name1]).'</div><div>'.strtoupper($d[name2]).'</div><div>'.strtoupper($d[name3]).'</div><div>'.strtoupper($d[name4]).'</div></li>';
        }
?>        </ol><hr />
<ol><?
$q="select * from ps_packets where case_no = '' and caseLookupFlag = '0' and filing_status <> 'FILED WITH COURT' and (status = 'RECEIVED' or status = 'RECIEVED')";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$i++;
echo "<li><a href='order.php?packet=$d[packet_id]' target='order'>".strtoupper($d[packet_id]).'</a><div>'.strtoupper($d[name1]).'</div><div>'.strtoupper($d[name2]).'</div><div>'.strtoupper($d[name3]).'</div><div>'.strtoupper($d[name4]).'</div></li>';
        }
?>        </ol>




</td>
        <td valign="top" align="center">
        
        
        
        <iframe name="court" id="court" width="970" height="300" frameborder="0" src="http://casesearch.courts.state.md.us/inquiry/processDisclaimer.jis"></iframe>        
        <iframe id="order" name="order" width="970" height="300" frameborder="0" src="gfx/break.gif"></iframe>

        
        
        </td>

        
        
        
</tr>
<?=$i?>
</table>


</body>
</html>
