<div class='noprint'>
<?
$ThisServer = $server[$counter1];
echo "Compile Affidavits for Server ID: ".$server[$counter1]."<br>";



// first we seperate by defendant and then pull all the entries entered 



$r11= @mysql_query("select DISTINCT defendant_id from ps_packets where packet_id='$packet' and serverID= '$ThisServer' ");
while ($d11 = mysql_fetch_array($r11,MYSQL_ASSOC)){

}
?>

</div>