<? include 'common.php';?>
<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
  </style> 
<div class='noprint'>
<form>
Slot 1 <input size='5' name='packet1'>-<input size='2' name='def1'>-<input size='2' name='add1'><br>
Slot 2 <input size='5' name='packet2'>-<input size='2' name='def2'>-<input size='2' name='add2'><br>
Slot 3 <input size='5' name='packet3'>-<input size='2' name='def3'>-<input size='2' name='add3'><br>  
Slot 4 <input size='5' name='packet4'>-<input size='2' name='def4'>-<input size='2' name='add4'><br>
Slot 5 <input size='5' name='packet5'>-<input size='2' name='def5'>-<input size='2' name='add5'><br>
<input type='submit'>
</form>  
  
  </div>
  <br><br><br><br>
 <table>
	<tr><td>
  
  <?
	
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet1]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def1]"];
	if ($_GET[add1] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def1]$_GET[add1]"];
		$csz = $d["city$_GET[def1]$_GET[add1]"].', '.$d["state$_GET[def1]$_GET[add1]"].' '.$d["zip$_GET[def1]$_GET[add1]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet1]-$_GET[def1]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  <br><br><br><br><br>
</td><td>

<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet1]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def1]"];
	if ($_GET[add1] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def1]$_GET[add1]"];
		$csz = $d["city$_GET[def1]$_GET[add1]"].', '.$d["state$_GET[def1]$_GET[add1]"].' '.$d["zip$_GET[def1]$_GET[add1]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet1]-$_GET[def1]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  <br><br><br><br><br>
</td></tr><tr><td>

<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet2]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def2]"];
	if ($_GET[add2] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def2]$_GET[add2]"];
		$csz = $d["city$_GET[def2]$_GET[add2]"].', '.$d["state$_GET[def2]$_GET[add2]"].' '.$d["zip$_GET[def2]$_GET[add2]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet2]-$_GET[def2]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  <br><br><br><br><br><br>
</td><td>

<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet2]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def2]"];
	if ($_GET[add2] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def2]$_GET[add2]"];
		$csz = $d["city$_GET[def2]$_GET[add2]"].', '.$d["state$_GET[def2]$_GET[add2]"].' '.$d["zip$_GET[def2]$_GET[add2]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet2]-$_GET[def2]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  <br><br><br><br><br><br>
</td></tr><tr><td>

<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet3]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def3]"];
	if ($_GET[add3] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def3]$_GET[add3]"];
		$csz = $d["city$_GET[def3]$_GET[add3]"].', '.$d["state$_GET[def3]$_GET[add3]"].' '.$d["zip$_GET[def3]$_GET[add3]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet3]-$_GET[def3]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  <br><br><br><br><br><br>
</td><td>

<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet3]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def3]"];
	if ($_GET[add3] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def3]$_GET[add3]"];
		$csz = $d["city$_GET[def3]$_GET[add3]"].', '.$d["state$_GET[def3]$_GET[add3]"].' '.$d["zip$_GET[def3]$_GET[add3]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet3]-$_GET[def3]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  <br><br><br><br><br>
</td></tr><tr><td>

<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet4]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def4]"];
	if ($_GET[add4] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def4]$_GET[add4]"];
		$csz = $d["city$_GET[def4]$_GET[add4]"].', '.$d["state$_GET[def4]$_GET[add4]"].' '.$d["zip$_GET[def4]$_GET[add4]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet4]-$_GET[def4]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  <br><br><br><br><br><br>
</td><td>

<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet4]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def4]"];
	if ($_GET[add4] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def4]$_GET[add4]"];
		$csz = $d["city$_GET[def4]$_GET[add4]"].', '.$d["state$_GET[def4]$_GET[add4]"].' '.$d["zip$_GET[def4]$_GET[add4]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet4]-$_GET[def4]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  <br><br><br><br><br><br><br>
</td></tr><tr><td>

<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet5]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def5]"];
	if ($_GET[add5] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def5]$_GET[add5]"];
		$csz = $d["city$_GET[def5]$_GET[add5]"].', '.$d["state$_GET[def5]$_GET[add5]"].' '.$d["zip$_GET[def5]$_GET[add5]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet5]-$_GET[def5]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>

</td><td>


<?
	$r=@mysql_query("select * from ps_packets where packet_id = '$_GET[packet5]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$card = $_GET[card];
	$name = $d["name$_GET[def5]"];
	if ($_GET[add5] == 'PO'){
		$po = strtoupper($d[pobox]);
		$line1 = $d[pobox];
		$csz = $d[pocity].', '.$d[postate].' '.$d[pozip];
	}else{
		$line1 = $d["address$_GET[def5]$_GET[add5]"];
		$csz = $d["city$_GET[def5]$_GET[add5]"].', '.$d["state$_GET[def5]$_GET[add5]"].' '.$d["zip$_GET[def5]$_GET[add5]"];
		$art = $_GET[art];
	}
	$cord = "$_GET[packet5]-$_GET[def5]";
?>
<img src="http://mdwestserve.com/ps/returncard.jpg.php?name=<?=strtoupper($name)?>&line1=<?=strtoupper(str_replace('#','no. ',$line1))?>&line2=<?=strtoupper($line2)?>&csz=<?=strtoupper($csz)?>&art=<?=$art?>&cord=<?=$cord?>&case_no=<?=str_replace('0','&Oslash;',strtoupper($d[case_no]))?>"><? if($card=='mail'){echo "<img src='gfx/mail.logo.gif'>";}?></div>
  </td></tr></table>
  