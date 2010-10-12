<? include 'common.php'; $tab=0; function macroName($full){ $part = explode(' ',strtoupper($full)); return $part; } ?>
VERSION BUILD=6111205 RECORDER=FX<br>
<?
$q="select * from ps_packets where case_no = '' and process_status <> 'CANCELLED' and caseLookupFlag = '0' order by packet_id";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){$tab++;
$nameArray=macroName($d[name]);
$end = count($nameArray); 
$first = $nameArray[0];
$last = $nameArray[$end];
?>
TAB OPEN<br>
TAB T=<?=$tab?><br>
URL GOTO=http://casesearch.courts.state.md.us/inquiry/<br>
TAG POS=1 TYPE=INPUT:CHECKBOX FORM=NAME:main ATTR=NAME:disclaimer CONTENT=YES<br>
TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:main ATTR=NAME:action&&VALUE:Continue<br>
TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:inquiryForm ATTR=NAME:lastName CONTENT=<?=$last;?><br>
TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:inquiryForm ATTR=NAME:firstName CONTENT=<?=$first;?><br>
TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:inquiryForm ATTR=NAME:courtSystem&&VALUE:C<br>
TAG POS=1 TYPE=SELECT FORM=NAME:inquiryForm ATTR=NAME:countyName CONTENT=%<?=$d[circuit_court];?><SP>COUNTY<br>
TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:inquiryForm ATTR=NAME:action&&VALUE:Search<br>
<?

$nameArray2=macroName($d[name2]);
$end = count($nameArray2); 
$first = $nameArray2[0];
$last = $nameArray2[$end];
?>
TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:inquiryForm ATTR=NAME:lastName CONTENT=<?=$last;?>
TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:inquiryForm ATTR=NAME:firstName CONTENT=<?=$first;?>
TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:inquiryForm ATTR=NAME:courtSystem&&VALUE:C
TAG POS=1 TYPE=SELECT FORM=NAME:inquiryForm ATTR=NAME:countyName CONTENT=%<?=$d[circuit_court];?><SP>COUNTY
TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:inquiryForm ATTR=NAME:action&&VALUE:Search
<?

$nameArray3=macroName($d[name3]);
$nameArray4=macroName($d[name4]);
$nameArray5=macroName($d[name5]);
$nameArray6=macroName($d[name6]);
}
        
?>       
