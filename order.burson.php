<?
include 'common.php';
include 'lock.php';
include 'menu.php';

function addressCheck($address){
// do not serve the following addresses EVER
if ($address == "Foreclosure Unit"){ return 0;} 

return 1;
}
function personCheck($person){
// do not serve the following addresses EVER
if ($person == "Commissioner of Financial Regulation"){ return 0;} 

return 1;
}
$dir = "/opt/lampp/htdocs/portal/PS_ORDERS/";
$filename = "08-128518_CONTACT_LST1234266_VA-03927566H.txt";
$row = 1;
$client_file = explode('_',$filename);
$client_file = $client_file[0];

echo "<div align='center' style='font-size:30px'>$client_file</div>";
echo "<div align='center'>$filename</div>";
echo "<table border='1' align='center'><tr><td valign='top'>";

$handle = fopen($dir.$filename, "r");
echo "<b> Raw order from FTP: </b><br>";
$count=0;
while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
    $num = count($data);
    echo "<div  style='padding:10px;'><b> NOI #$row Sent to: </b><br />";
	if (personCheck($data[1]) == 1){
			$order[$row]['person']=strtoupper($data[1]);
			$order[$row]['address1']=strtoupper($data[8]);
			$order[$row]['city'] = strtoupper($data[10]);
			$order[$row]['state'] = strtoupper($data[11]);
			$order[$row]['zip'] = strtoupper($data[12]);
    $row++;
	}
   for ($c=0; $c < $num; $c++) {
        if($data[$c]){
		echo $data[$c] . "<br />\n";
		}
    }
	echo "</div><br>";

}
fclose($handle);

echo "</td><td valign='top'>";
echo "<b> Order placed for the following:</b><br>";
$counta = count($order);
$countb = 0;
$ins = 0;
$outs = 0;

while ($countb++ < $counta){
 echo "<div style='padding:10px;'>SERVE ".$order[$countb]['person']."<br>AT ".$order[$countb]['address1']."<br>".$order[$countb]['city'].", ".$order[$countb]['state']." ".$order[$countb]['zip']."</div>";
 if ($order[$countb]['state'] == "MD"){
 $ins++;
 }else{
 $outs++;
 }
 
}

echo "</td><td valign='top'>";
echo "<b> Billing rates for this file:</b><br>";

?>
<div  style='padding:10px;'>
<table cellspacing="0">
	<tr bgcolor="#CCCCCC">
		<td>Item</td>
		<td>Units</td>
		<td>Total</td>
	</tr>
	<tr>
		<td>In-State Service</td>
		<td><?=$ins?></td>
		<td>$<?=$ins*75?>.00</td>
	</tr>
	<tr>
		<td>Out-of-State Service</td>
		<td><?=$outs?></td>
		<td>$<?=$outs*125?>.00</td>
	</tr>
	<tr>
		<td>Mailing Service*</td>
		<td><?=$counta?></td>
		<td>$<?=$counta*25?>.00</td>
	</tr>
	<tr>
		<td>File and Return Service**</td>
		<td>n/a</td>
		<td>$25.00</td>
	</tr>
    <tr>
    	<td style="border-top:solid 1px;" colspan="2">Max Bill</td>
        <td style="border-top:solid 1px;"><strong>$<?=($ins*75)+($outs*125)+($counta*25)+(25)?>.00</strong></td>
    </tr>
</table>
<br>
<div>* Only when service is by 'Mailing and Posting'</div>
<div>** Will not be applied if cancelled before filing.</div>
</div>
</td></tr></table>
<?
include 'footer.php';
?>