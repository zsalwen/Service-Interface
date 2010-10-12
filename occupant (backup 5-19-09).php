<?
include 'lock.php';
mysql_connect();
mysql_select_db('core');
$mailerID=$_COOKIE[psdata][user_id];
//$r1=@mysql_query("UPDATE occNotices SET sendDate='$_GET[sendDate]', mailerID='$mailerID' WHERE occID='$_GET[id]'");
$r=@mysql_query("select * from ps_packets where packet_id='$_GET[packet]'");
$d=mysql_fetch_array($r,MYSQL_ASSOC);


@mysql_query("INSERT INTO occNotices (requirements, packet_id, sendDate, clientFile, caseNo, mailerID, county, attorneysID, address, city, state, zip, bill, requestDate ) values ('14-209', '$_GET[packet]', NOW(), '$d[client_file]', '$d[case_no]', '$mailerID', '$d[circuit_court]', '$d[attorneys_id]', '$d[address1]', '$d[city1]', '$d[state1]', '$d[zip1]', '5.00', NOW() )");





ob_start();
?>


<center>
<div align="left" style="width:600px; font-size: 16px; padding-top: 100px;">
<?=date('F jS, Y')?><br>
<b>Dear Occupant,</b><br>
</div>
<div align="justify" style="width:600px; font-size: 20px; padding-top: 50px;">
<center>NOTICE REQUIRED BY MARYLAND LAW</center><br>
AN ACTION TO FORECLOSE A<br>
<span style="padding-left: 30px;"><input  type="checkbox"> MORTGAGE</span><br>
<span style="padding-left: 30px;"><input type="checkbox" checked> DEED OF TRUST</span><br>
<span style="padding-left: 30px;"><input type="checkbox"> LAND INSTALLMENT CONTRACT</span><br>
<span style="padding-left: 30px;"><input type="checkbox"> CONTRACTOR OR STATUTORY LIEN</span><br>
ON THE PROPERTY LOCATED AT <b><?=strtoupper($d[address1]).', '.strtoupper($d[city1]).', '.strtoupper($d[state1]).' '.strtoupper($d[zip1]);?></b> HAS BEEN FILED IN THE CIRCUIT COURT FOR <b><?=strtoupper($d[circuit_court]);?></b>.<br><br>
A FORECLOSURE SALE OF THE PROPERTY MAY OCCUR AT ANY TIME AFTER 45 DAYS FROM THE DATE OF THIS NOTICE.<br><br>
YOU MAY WANT TO CONSULT WITH AN ATTORNEY BECAUSE YOU COULD BE EVICTED, EVEN IF YOU ARE A TENANT AND HAVE PAID THE RENT DUE AND COMPLIED WITH YOUR LEASE.<br><br>
<em><b>FOR FURTHER INFORMATION, YOU MAY REVIEW THE FILE IN THE OFFICE OF THE CLERK OF THE CIRCUIT COURT.</b></em>
</div>
</center>
<?
$buffer = ob_get_clean();
//if ($d[bill] == '14-204'){
	echo $buffer;
	echo "<br><br><small>14-209 ($_GET[packet])</small>";
/*}else{
	ob_start();
?>
<center>
<div align="left" style="width:700px; padding-top: 50px;">
<span style="font-size: 14px; font-weight:bold;">BY FIRST CLASS MAIL</span><br><br>

<span style="font-size: 16px; font-weight:bold;">TO ALL OCCUPANTS</span><br><br>

<center style="font-size: 16px; font-weight:bold;">IMPORTANT NOTICE</center><br><br>
<div style="font-size: 16px; text-indent: 30px; font-weight:bold;">
A FORECLOSURE ACTION HAS BEEN FILED AGAINST THE PROPERTY LOCATED AT
<?=strtoupper($d[address])?>, <?=strtoupper($d[city])?>, <?=strtoupper($d[state])?> <?=strtoupper($d[zip])?> IN THE CIRCUIT COURT FOR <?=strtoupper($d[county])?>. THIS NOTICE IS BEING SENT TO YOU AS A PERSON WHO LIVES IN THIS PROPERTY.<br><br>
</div>
<div style="font-size: 16px; text-indent: 30px; font-weight:bold;">
A FORECLOSURE SALE OF THE PROPERTY MAY OCCUR AT ANY TIME AFTER 45
DAYS FROM THE DATE OF THIS NOTICE. YOU MAY WANT TO CONSULT WITH AN ATTORNEY BECAUSE IF A FORECLOSURE SALE OF THE PROPERTY OCCURS, YOU COULD BE EVICTED, EVEN IF YOU ARE A TENANT AND EVEN IF YOU HAVE PAID THE RENT DUE AND COMPLIED WITH YOUR LEASE. <br><br>
</div>
<div style="font-size: 16px; text-indent: 30px; font-weight:bold;">
BELOW YOU WILL FIND THE NAME, ADDRESS, AND TELEPHONE NUMBER OF THE PERSON AUTHORIZED TO SELL THE PROPERTY. YOU MAY CONTACT THIS PERSON TO FIND OUT MORE ABOUT THE SALE. FOR FURTHER INFORMATION, YOU MAY REVIEW THE FILE IN THE OFFICE OF THE CLERK OF THE CIRCUITCOURT. <br><br>
</div>
<div style="font-size: 16px; text-indent: 30px; font-weight:bold;">
YOU ALSO MAY CONTACT THE MARYLAND DEPARTMENT OF HOUSING AND COMMUNITY DEVELOPMENT,  AT 1-877-462-7555, OR CONSULT THE DEPARTMENT'S WEBSITE, HTTP://WWW.MDHOPE.ORG/ FOR ASSISTANCE.<br><br>
</div>
<div style="font-size: 16px; font-weight:bold;">
PERSON AUTHORIZED TO SELL THE PROPERTY:<br><br>

__________________________________________<br>
NAME<br>
__________________________________________<br>
ADDRESS<br>
___________________________________________<br>
TELEPHONE<br>
___________________________________________<br>
DATE OF THIS NOTICE<br>
</div>
<div style="font-size: 14px;">
<center style="font-weight:bold;text-decoration:underline;">NOTICE</center>
PURSUANT TO THE FEDERAL FAIR DEBT COLLECTION PRACTICES ACT, WE ADVISE YOU THAT THIS FIRM IS A DEBT COLLECTOR ATTEMPTING TO COLLECT THE INDEBTEDNESS REFERRED TO HEREIN AND ANY INFORMATION WE OBTAIN FROM YOU WILL BE USED FOR THAT PURPOSE.  IN THE EVENT YOU ARE NOW IN A BANKRUPTCY PROCEEDING, HAVE OBTAINED A DISCHARGE IN BANKRUPTCY OR HAVE OTHERWISE BEEN RELEASED FROM PERSONAL LIABILTY, THIS NOTICE (AND OUR COLLECTION EFFORTS) MAY ONLY AFFECT YOUR OWNERSHIP OR POSSESSORY INTEREST IN THE SUBJECT PROPERTY AND NOT YOUR PERSONAL OBLIGATIONS UNDER THE MORTGAGE DOCUMENTS.
</div>
<?
	$buffer2 = ob_get_clean();
	echo $buffer2;
}*/
?>