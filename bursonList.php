<? include 'common.php'; ?>

<ol>
<?
$q="select * from ps_packets where address1a='' and process_status='ASSIGNED' and attorneys_id ='1'";
$r=@mysql_query($r);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
?>
<li>OTD - ORDER</li>


<? }?></ol>