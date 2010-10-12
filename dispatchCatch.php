<?

$q="SELECT * from ps_packets where service_status='IN PROGRESS' and server_id='' and process_status <> 'DUPLICATE' and process_status <> 'FILE COPY' and process_status <> 'DAMAGED PDF' and process_status <> 'DUPLICATE/DIFF-PDF'";
$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());

?>