<?
$to = "sysop@hwestauctions.com";
$subject = "Service Completed for Packet XXX (XX-XXXXXX)";
$headers  = "MIME-Version: 1.0 \n";
$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
$headers .= "From: $to \n";
//$headers .= "Cc: HWA Archive <archive@hwestauctions.com> \n";
$body ="
<strong>Thank you for selecting MDWestServe as Your Process Service Provider.</strong><br>
Service for packet XXX (<strong>XX-XXXXXX</strong>) is completed, closeout documents as follows:
<li><a href='$file1'>Invoice</a></li>
<li><a href='$file2'>Affidavit for John Doe</a></li>
<li><a href='$file3'>Affidavit for Jane Doe</a></li>
<li><a href='$file4'>Affidavit for Billy Bob</a></li>
";



mail($to,$subject,$body,$headers);











