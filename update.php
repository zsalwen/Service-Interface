<?
include 'common.php';



?>
<script>
function hideshow(which){
if (!document.getElementById)
return
if (which.style.display=="block")
which.style.display="none"
else
which.style.display="block"
}
</script>
<?

function isEntered(){

return "<img src='http://www.schweissenuschneiden.de/sus2009/specialpages/messeplaner/img/help_checkbox.gif'>";
}
function mkmonth($keep){
	//if (!$keep){$keep = date('M');}
	if ($keep != ''){
		$opt = "<option selected value='$keep'>$keep</option>";
	}
	$opt .= "<option value='01'>1</option>";
	$opt .= "<option value='02'>2</option>";
	$opt .= "<option value='03'>3</option>";
	$opt .= "<option value='04'>4</option>";
	$opt .= "<option value='05'>5</option>";
	$opt .= "<option value='06'>6</option>";
	$opt .= "<option value='07'>7</option>";
	$opt .= "<option value='08'>8</option>";
	$opt .= "<option value='09'>9</option>";
	$opt .= "<option value='10'>10</option>";
	$opt .= "<option value='11'>11</option>";
	$opt .= "<option value='12'>12</option>";
	return $opt;
}
function mkday($keep){
	if ($keep != ''){
		$opt = "<option selected value='$keep'>$keep</option>";
	}
	$opt .= "<option value='01'>1</option>";
	$opt .= "<option value='02'>2</option>";
	$opt .= "<option value='03'>3</option>";
	$opt .= "<option value='04'>4</option>";
	$opt .= "<option value='05'>5</option>";
	$opt .= "<option value='06'>6</option>";
	$opt .= "<option value='07'>7</option>";
	$opt .= "<option value='08'>8</option>";
	$opt .= "<option value='09'>9</option>";
	$opt .= "<option value='10'>10</option>";
	$opt .= "<option value='11'>11</option>";
	$opt .= "<option value='12'>12</option>";
	$opt .= "<option value='13'>13</option>";
	$opt .= "<option value='14'>14</option>";
	$opt .= "<option value='15'>15</option>";
	$opt .= "<option value='16'>16</option>";
	$opt .= "<option value='17'>17</option>";
	$opt .= "<option value='18'>18</option>";
	$opt .= "<option value='19'>19</option>";
	$opt .= "<option value='20'>20</option>";
	$opt .= "<option value='21'>21</option>";
	$opt .= "<option value='22'>22</option>";
	$opt .= "<option value='23'>23</option>";
	$opt .= "<option value='24'>24</option>";
	$opt .= "<option value='25'>25</option>";
	$opt .= "<option value='26'>26</option>";
	$opt .= "<option value='27'>27</option>";
	$opt .= "<option value='28'>28</option>";
	$opt .= "<option value='29'>29</option>";
	$opt .= "<option value='30'>30</option>";
	$opt .= "<option value='31'>31</option>";
	return $opt;
}
function mkminute($keep){
	if ($keep != ''){
		$opt = "<option selected value='$keep'>$keep</option>";
	}
	$opt .= "<option value='00'>00</option>";
	$opt .= "<option value='01'>01</option>";
	$opt .= "<option value='02'>02</option>";
	$opt .= "<option value='03'>03</option>";
	$opt .= "<option value='04'>04</option>";
	$opt .= "<option value='05'>05</option>";
	$opt .= "<option value='06'>06</option>";
	$opt .= "<option value='07'>07</option>";
	$opt .= "<option value='08'>08</option>";
	$opt .= "<option value='09'>09</option>";
	$opt .= "<option value='10'>10</option>";
	$opt .= "<option value='11'>11</option>";
	$opt .= "<option value='12'>12</option>";
	$opt .= "<option value='13'>13</option>";
	$opt .= "<option value='14'>14</option>";
	$opt .= "<option value='15'>15</option>";
	$opt .= "<option value='16'>16</option>";
	$opt .= "<option value='17'>17</option>";
	$opt .= "<option value='18'>18</option>";
	$opt .= "<option value='19'>19</option>";
	$opt .= "<option value='20'>20</option>";
	$opt .= "<option value='21'>21</option>";
	$opt .= "<option value='22'>22</option>";
	$opt .= "<option value='23'>23</option>";
	$opt .= "<option value='24'>24</option>";
	$opt .= "<option value='25'>25</option>";
	$opt .= "<option value='26'>26</option>";
	$opt .= "<option value='27'>27</option>";
	$opt .= "<option value='28'>28</option>";
	$opt .= "<option value='29'>29</option>";
	$opt .= "<option value='30'>30</option>";
	$opt .= "<option value='31'>31</option>";
	$opt .= "<option value='32'>32</option>";
	$opt .= "<option value='33'>33</option>";
	$opt .= "<option value='34'>34</option>";
	$opt .= "<option value='35'>35</option>";
	$opt .= "<option value='36'>36</option>";
	$opt .= "<option value='37'>37</option>";
	$opt .= "<option value='38'>38</option>";
	$opt .= "<option value='39'>39</option>";
	$opt .= "<option value='40'>40</option>";
	$opt .= "<option value='41'>41</option>";
	$opt .= "<option value='42'>42</option>";
	$opt .= "<option value='43'>43</option>";
	$opt .= "<option value='44'>44</option>";
	$opt .= "<option value='45'>45</option>";
	$opt .= "<option value='46'>46</option>";
	$opt .= "<option value='47'>47</option>";
	$opt .= "<option value='48'>48</option>";
	$opt .= "<option value='49'>49</option>";
	$opt .= "<option value='50'>50</option>";
	$opt .= "<option value='51'>51</option>";
	$opt .= "<option value='52'>52</option>";
	$opt .= "<option value='53'>53</option>";
	$opt .= "<option value='54'>54</option>";
	$opt .= "<option value='55'>55</option>";
	$opt .= "<option value='56'>56</option>";
	$opt .= "<option value='57'>57</option>";
	$opt .= "<option value='58'>58</option>";
	$opt .= "<option value='59'>59</option>";
	return $opt;
}
function mkyear($keep){
	if ($keep != ''){
		$opt = "<option selected value='$keep'>$keep</option>";
	}
	$opt .= "<option value='2006'>2006</option>";
	$opt .= "<option value='2007'>2007</option>";
	$opt .= "<option value='2008'>2008</option>";
	$opt .= "<option value='2009'>2009</option>";
	$opt .= "<option value='2010'>2010</option>";
	$opt .= "<option value='2011'>2011</option>";
	return $opt;
}
function monthConvert($month){
	if ($month == '01'){ return 'January'; }
	if ($month == '02'){ return 'February'; }
	if ($month == '03'){ return 'March'; }
	if ($month == '04'){ return 'April'; }
	if ($month == '05'){ return 'May'; }
	if ($month == '06'){ return 'June'; }
	if ($month == '07'){ return 'July'; }
	if ($month == '08'){ return 'August'; }
	if ($month == '09'){ return 'September'; }
	if ($month == '10'){ return 'October'; }
	if ($month == '11'){ return 'November'; }
	if ($month == '12'){ return 'December'; }
}

function entryLoop($packet,$def){
	$q="SELECT * FROM ps_packets WHERE packet_id='$packet'";
	$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	$name=$d["name$def"];
	$addressSelect="<option value='1'>$d[address1], $d[city1], $d[state1] $d[zip1]</option>";
    if ($d[address1a]){
		$addressSelect .= "<option value='1a'>$d[address1a], $d[city1a], $d[state1a] $d[zip1a]</option>";
    }
	if ($d[address1b]){
		$addressSelect .= "<option value='1b'>$d[address1b], $d[city1b], $d[state1b] $d[zip1b]</option>";
    }
	if ($d[address1c]){
		$addressSelect .= "<option value='1c'>$d[address1c], $d[city1c], $d[state1c] $d[zip1c]</option>";
    } 
	if ($d[address1d]){
		$addressSelect .= "<option value='1d'>$d[address1d], $d[city1d], $d[state1d] $d[zip1d]</option>";
    } 
	if ($d[address1e]){
		$addressSelect .= "<option value='1e'>$d[address1e], $d[city1e], $d[state1e] $d[zip1e]</option>";
    }
	$data .= "<div  class='def$def'><table style='display:none;' id='a1$d[apacket_id]$def'><tr><td><b>Attempt 1 at $d[address1]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr><table>";
	$data .= "<table style='display:none;' id='a2$d[apacket_id]$def'><tr><td><b>Attempt 2 at $d[address1]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
	if ($d[address1a]){
		$data .= "<table style='display:none;' id='a1a$d[apacket_id]$def'><tr><td><b>Attempt 1 at $d[address1a]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
		$data .= "<table style='display:none;' id='a2a$d[apacket_id]$def'><tr><td><b>Attempt 2 at $d[address1a]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
	}
	if ($d[address1b]){
		$data .= "<table style='display:none;' id='a1b$d[apacket_id]$def'><tr><td><b>Attempt 1 at $d[address1b]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
		$data .= "<table style='display:none;' id='a2b$d[apacket_id]$def'><tr><td><b>Attempt 2 at $d[address1b]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
	}
	if ($d[address1c]){
		$data .= "<table style='display:none;' id='a1c$d[apacket_id]$def'><tr><td><b>Attempt 1 at $d[address1c]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
		$data .= "<table style='display:none;' id='a2c$d[apacket_id]$def'><tr><td><b>Attempt 2 at $d[address1c]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
	}
	if ($d[address1d]){
		$data .= "<table style='display:none;' id='a1d$d[apacket_id]$def'><tr><td><b>Attempt 1 at $d[address1d]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
		$data .= "<table style='display:none;' id='a2d$d[apacket_id]$def'><tr><td><b>Attempt 2 at $d[address1d]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
	}
	if ($d[address1e]){
		$data .= "<table style='display:none;' id='a1e$d[apacket_id]$def'><tr><td><b>Attempt 1 at $d[address1e]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
		$data .= "<table style='display:none;' id='a2e$d[apacket_id]$def'><tr><td><b>Attempt 2 at $d[address1e]</b> Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Effort to Rouse Defendant: <input size='50'></td></tr></table>";
	}
	$data .= "<table style='display:none;' id='pd$d[apacket_id]$def'><tr><td><div style='border: solid 1px;'><b>Personal Delivery to $name</b><br>Address: <select>$addressSelect</select> <br>Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select><br>Sex: <input size='3'> Race: <input> Age: <input size='3'> Height: <input size='3'> Weight: <input size='3'> Hair: <input> Glasses/Facial Hair/Other: <input></div></td></tr></table>";
	$data .= "<table style='display:none;' id='sub$d[apacket_id]$def'><tr><td><div style='border: solid 1px;'><b>Substitute Service</b><br>Address: <select>$addressSelect</select> Name: <input> <br>Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select><br>
 Relationship Between Resident and Defendant: <input size='50'> <br>
 Relationship Between Resident and Residency: <input size='50'> <br>
 Relationship Between Defendant and Residency <input size='50'><br>
 Sex: <input size='3'> Race: <input> Age: <input size='3'> Height: <input size='3'> Weight: <input size='3'> Hair: <input size='3'> Glasses/Facial Hair/Other: <input></div></td></tr></table>";
	$data .= "<table style='display:none;' id='pos$d[apacket_id]$def'><tr><td><div style='border: solid 1px;'><b>Posting at $d[address1]</b><br>Month/Day/Year: <select>".mkmonth('')."</select> <select>".mkday('')."</select> <select>".mkyear('')."</select> Hour/Minute/AM-PM: <select>".mkmonth('')."</select> <select>".mkminute('')."</select>
 <select ><option value='AM'>AM</option><option value='PM'>PM</option></select> Detail the Place of Posting: <input size='50'></div></td></tr></table>";
	return $data."</div>";
}
function elementLoop($packet,$def){
	$q="SELECT * FROM ps_packets WHERE packet_id='$packet'";
	$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	$name=$d["name$def"];
	$addressSelect="<option value='1'>$d[address1], $d[city1], $d[state1] $d[zip1]</option>";
    if ($d[address1a]){
		$addressSelect .= "<option value='1a'>$d[address1a], $d[city1a], $d[state1a] $d[zip1a]</option>";
    }
	if ($d[address1b]){
		$addressSelect .= "<option value='1b'>$d[address1b], $d[city1b], $d[state1b] $d[zip1b]</option>";
    }
	if ($d[address1c]){
		$addressSelect .= "<option value='1c'>$d[address1c], $d[city1c], $d[state1c] $d[zip1c]</option>";
    } 
	if ($d[address1d]){
		$addressSelect .= "<option value='1d'>$d[address1d], $d[city1d], $d[state1d] $d[zip1d]</option>";
    } 
	if ($d[address1e]){
		$addressSelect .= "<option value='1e'>$d[address1e], $d[city1e], $d[state1e] $d[zip1e]</option>";
    }
	$data = "<fieldset class='def$def'><legend accesskey='C'><b>$name</b></legend><table>";
	$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a1$d[apacket_id]$def'))\"><b> Attempt 1 at $d[address1]</b></a></td></tr>";
	$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a2$d[apacket_id]$def'))\"><b> Attempt 2 at $d[address1]</b></a></td></tr>";
	if ($d[address1a]){
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a1a$d[apacket_id]$def'))\"> <b>Attempt 1 at $d[address1a]</b></a></td></tr>";
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a2a$d[apacket_id]$def'))\"> <b>Attempt 2 at $d[address1a]</b></a></td></tr>";
	}
	if ($d[address1b]){
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a1b$d[apacket_id]$def'))\"> <b>Attempt 1 at $d[address1b]</b></a></td></tr>";
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;'border: solid 1px #000000;>".isEntered()."<a onClick=\"hideshow(document.getElementById('a2b$d[apacket_id]$def'))\"> <b>Attempt 2 at $d[address1b]</b></a></td></tr>";
	}
	if ($d[address1c]){
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a1c$d[apacket_id]$def'))\"> <b>Attempt 1 at $d[address1c]</b></a></td></tr>";
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a2c$d[apacket_id]$def'))\"> <b>Attempt 2 at $d[address1c]</b></a></td></tr>";
	}
	if ($d[address1d]){
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a1d$d[apacket_id]$def'))\"> <b>Attempt 1 at $d[address1d]</b></a></td></tr>";
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a2d$d[apacket_id]$def'))\"> <b>Attempt 2 at $d[address1d]</b></a></td></tr>";
	}
	if ($d[address1e]){
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a1e$d[apacket_id]$def'))\"> <b>Attempt 1 at $d[address1e]</b></a></td></tr>";
		$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('a2e$d[apacket_id]$def'))\"> <b>Attempt 2 at $d[address1e]</b></a></td></tr>";
	}
	$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('pd$d[apacket_id]$def'))\"> <b>Personal Delivery to $name</b></a></td></tr>";
	$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('sub$d[apacket_id]$def'))\"> <b>Substitute Service</b></a></td></tr>";
	$data .= "<tr><td nowrap=nowrap style='background-color:#FFFFFF;border: solid 1px #000000;'>".isEntered()."<a onClick=\"hideshow(document.getElementById('pos$d[apacket_id]$def'))\"> <b>Posting</b></a></td></tr>";
 $data .= "</table></fieldset>";
	return $data;
}?>
<style>
fieldset{border: solid 1px #000000; width: 80%;}
.def1{background-color:#CCFFFF;}
.def2{background-color:#00FF66;}
.def3{background-color:#FFFFCC;}
.def4{background-color:#CC6633;}
.def5{background-color:#FFCCFF;}
.def6{background-color:#6666CC;}
b {background-color:#FFFFFF; padding 2px; }
</style>
<?if (!$_GET[packet]){?>
<form>
<table>
	<tr>
		<td>Packet #: <input name="packet"></td>
	</tr>
</table>
</form>
<? }else{
	$packet=$_GET[packet];
	$q1="SELECT name1, name2, name3, name4, name5, name6 FROM ps_packets WHERE packet_id='$packet'";
?>
<table cellspacing="0" cellpadding="0">
	<tr><td valign='top'>
		
	<?	
	$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	$i=0;
	while ($i < 6){$i++;
		if ($d1["name$i"]){
			echo elementLoop($packet,$i);
		}
	}
?>	
		

	</td><td valign='top'>
<?	
	$r1=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
	$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
	$i=0;
	echo "<form method='post'>";
		echo "<fieldset><legend accesskey='C'><b>MDWestServe Affidavit Data</b></legend>";

	while ($i < 6){$i++;
		if ($d1["name$i"]){
			echo entryLoop($packet,$i);
		}
	}
	echo '<input type="submit" value="Record Affidavit Information"></fieldset></form>';
} ?> </td></tr></table>
<script>document.title='System Ready'</script>