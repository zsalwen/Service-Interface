<? include 'common.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pull Case Numbers</title>
</head>


<body bgcolor="#99ff66">
<a href="http://casesearch.courts.state.md.us/inquiry/processDisclaimer.jis" target="_blank">http://casesearch.courts.state.md.us/inquiry/processDisclaimer.jis</a>
<ol><?
$q="select * from ps_packets where case_no = '' and filing_status='FILED WITH COURT'";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
echo "<li><a href='order.php?packet=$d[packet_id]' target='order'>".strtoupper($d[packet_id]).', '.strtoupper($d[name1]).', '.strtoupper($d[name2]).', '.strtoupper($d[name3]).', '.strtoupper($d[name4]).'</a></li>';
        }
?>        </ol><hr />
<ol><?
$q="select * from ps_packets where case_no = '' and filing_status <> 'FILED WITH COURT' and (status = 'RECEIVED' or status = 'RECIEVED')";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
echo "<li><a href='order.php?packet=$d[packet_id]' target='_blank'>".strtoupper($d[packet_id]).', '.strtoupper($d[name1]).', '.strtoupper($d[name2]).', '.strtoupper($d[name3]).', '.strtoupper($d[name4]).'</a></li>';
        }
?>        </ol>
        
        
       
        


</body>
</html>
