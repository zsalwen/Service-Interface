<?


if ($_GET[type] == "non"){
$article = "14-204(b)(2)";
$result = "MAILING AND POSTING";
if ($_GET[att] == 2){
$history = "<div style='font-weight:300'>( i )<u>Describe with particularity the good faith efforts to serve the mortgagor or grantor by personal delivery:</u></div>
<li>First Effort: Last Known Address of Record</li>
7/19/2008 5:45 PM<br>
456 Another Street, Baltimore, MD 21293<br>
Knocked on door and rang doorbell, no lights on in house, no cars in driveway, appears abandoned.<br>

<li>Second Effort: Acquired Address Through Skip Trace</li>
7/20/2008 8:30 AM<br>
773 South Avenue, Baltimore, MD 21286<br>
Knocked on door and rang doorbell, one car in driveway but no lights are on.<br>
";
}else{
$history = "<div style='font-weight:300'>( i )<u>Describe with particularity the good faith efforts to serve the mortgagor or grantor by personal delivery:</u></div>
<li>First Effort: Last Known Address of Record</li>
7/19/2008 5:45 PM<br>
456 Another Street, Baltimore, MD 21293<br>
Knocked on door and rang doorbell, no lights on in house, no cars in driveway, appears abandoned.<br>

<li>Second Effort: Last Known Address of Record</li>
7/20/2008 9:30 AM<br>
456 Another Street, Baltimore, MD 21293<br>
Knocked on door and rang doorbell, overflowing mailbox, grass uncut approx. 2ft tall, no cars in driveway.<br>

<li>First Effort: Acquired Address Through Skip Trace</li>
7/20/2008 8:30 PM<br>
773 South Avenue, Baltimore, MD 21286<br>
Knocked on door and rang doorbell, one car in driveway but no lights are on.<br>

<li>Second Effort: Acquired Address Through Skip Trace</li>
7/21/2008 8:30 AM<br>
773 South Avenue, Baltimore, MD 21286<br>
Knocked on door and rang doorbell, one car in driveway but no lights are on.<br>
";
}
$history2 = "<div style='font-weight:300'>( ii )<u>State the date on which the required papers were mailed by first-class and certified mail, return receipt requested, and the name and address of the addressee:</u></div>
<li>Mailed Papers to John Doe at 456 Another Street, Baltimore, MD 21293 'Last Known Address of Record' by certified mail, return receipt requested, and by first-class mail.</li>
7/21/2008 12:10 PM<br>
<li>Mailed Papers to John Doe at 357 North Street, Baltimore, MD 21293 'Residential Property Subject to Mortgage or Deed of Trust' by certified mail, return receipt requested, and by first-class mail.</li>
7/21/2008 12:12 PM<br>";
$history3 = "<div style='font-weight:300'>( iii )<u>Include the date of the posting and a description of the location of the posting on the property:</u></div>
<li>Posting the Property:</li>
7/20/2008 8:30 PM<br>
357 North Street, Baltimore, MD 21293<br>
Front Door (red) inside the screen door
";
$history4 = "<u>If available, the original certified mail return receipt shall be attached to the affidavit.</u><div style='height:350px; width:550px; border:double 4px; color:#666'>Affix original certified mail return receipt here.</div>";
}else{
$article = "14-204(b)(1)";
$result = "PERSONAL DELIVERY";
if ($_GET[pd]==2){
/*
$history = "<li style='font-weight:300'>Delivering the Papers:</li>
John Doe<br>
Mortgagor / Grantor<br>
7/19/2008 6:45 PM<br>
Delivered papers to defendant in front yard of property while defendant was doing yard work.<br>
456 Another Street<br>
Baltimore, MD 21293";
*/
$history = "<div style='font-weight:300'><u>Name of person served</u>:</div>
John Doe<br>
Mortgagor / Grantor<br>
<div style='font-weight:300'><u>Date</u>:</div>
7/19/2008 6:45 PM<br>
<div style='font-weight:300'><u>Particular place of service</u>:</div>
Residential Property Subject to Mortgage or Deed of Trust<br>
Delivered papers to defendant in front yard of property while defendant was doing yard work.<br>
456 Another Street<br>
Baltimore, MD 21293";

}else{
$history = "
<div style='font-weight:300'><u>Name of person served</u>:</div>
Jane Doe
<div style='font-weight:300'><u>Date</u>:</div>
7/12/2008 5:45 PM<br>
<div style='font-weight:300'><u>Particular place of service</u>:</div>
Residential Property Subject to Mortgage or Deed of Trust<br>
Delivered papers at the front door (dark red color)<br>
456 Another Street<br>
Baltimore, MD 21293
<div style='font-weight:300'><u>Description of the individual served and the facts upon which the individual making service concluded that the individual served is of suitable age and discretion</u>:</div>
Jane Doe announced herself as the 48 year old wife to the defendant. She stated that her husband was at work and accepted the papers on his behalf.<br>
";
}
}






?>
<table width="80%" align="center">
	<tr>
    	<td colspan="2" align="center" style="font-size:24px; font-variant:small-caps;">State of Maryland</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-size:20px;">Circuit Court for Baltimore County</td>
    </tr>
    <tr>
    </tr>
    <tr>
    	<td><?=$plaintiff;?><br><small>_____________________<br /><em>Plaintiff</em></small><br /><br />v.<br /><br />John Doe<br /><small>_____________________<br /><em>Defendant</em></small></td>
        	<td align="right" valign="top">Case No. XX-XXX-XXXXXX-XX </td>
</tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; text-decoration:underline" height="30px" valign="top">Affidavit of Service</td>
    </tr>
	<tr>
    	<td colspan="2" align="center" style="font-weight:bold; font-size:20px;" height="30px" valign="top"><?=$result?></td>
    </tr>
    <tr>
    	<td colspan="2" align="left">Pursuant to Maryland Real Property Article 7-105.1 and Maryland Rules of Procedure <?=$article?> <?=$result?> a copy of the Order to Docket and all other papers filed with it (the "Papers") in the above-captioned case by:<br></td>
    </tr>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px;"><?=stripslashes($history)?></td>
    </tr>
    <tr>
    	<td colspan="2">I, Patrick McGuire, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of <? if ($type == 'non'){ ?>section (i) of<? }?>this affidavit are true and correct.<br></td>
    </tr>
    <tr>
    	<td valign="top">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top">________________________<?=date('m/d/Y')?><br />Patrick McGuire<br />123 Here Street<br />Baltimore, MD 21286<br />443-368-2584</td> 
	</tr>
<? if($history2){ ?>
    <tr style="page-break-before:always">
    	<td colspan="2" style="font-weight:bold; padding-left:20px"><?=stripslashes($history2)?></td>
    </tr>
    <tr>
    	<td colspan="2">I, Zach Salwen, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of section (ii) of this affidavit are true and correct.<br></td>
    </tr>
    <tr>
    	<td valign="top">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top">________________________<?=date('m/d/Y')?><br />Zach Salwen<br />567 There Street<br />Baltimore, MD 21286<br />410-828-4568</td> 
	</tr>
<? } ?>
<? if($history3){ ?>
    <tr>
    	<td colspan="2" style="font-weight:bold; padding-left:20px"><?=stripslashes($history3)?></td>
    </tr>
    <tr>
    	<td colspan="2">I, Patrick McGuire, certify that I am over eighteen years old and not a party to this action.<br /></td>
    </tr>
	<tr>
    	<td colspan="2">I solemnly affirm under the penalties of perjury that the contents of section (iii) of this affidavit are true and correct.<br></td>
    </tr>
    <tr>
    	<td valign="top">____________________________________<br />Notary Public<br /><br /><br />SEAL</td>
        <td valign="top">________________________<?=date('m/d/Y')?><br />Patrick Mcguire<br />123 Here Street<br />Baltimore, MD 21286<br />410-828-4568</td> 
	</tr>
<? } ?>
<? if($history4){ ?>
    <tr>
    	<td colspan="2" style="padding-left:20px"><?=stripslashes($history4)?></td>
    </tr>
<? } ?>
</table>	
