<?
if ($_COOKIE[psdata][level] == "Operations" || $_COOKIE[psdata][level] == "Dispatch" || $_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Administrator"){
include 'common.php';
function charge($str){
	if ($str == 'anne_arundel' || $str == 'baltimore_city' || $str == 'baltimore_county' || $str == 'harford' || $str == 'howard' || $str == 'montgomery' || $str == 'pg'){
		return 75;
	}else{
		return 125;
	}
}


function coverage($county, $cost){
	$q="SELECT * from ps_users where $county > '0'";
	$r=@mysql_query($q);
	$x=0;
	$y=0;
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		$x++;	
		$y = $y + $d[$county];
	}
	if ($y && $x){
		$z= $y / $x;
	}
	$return[0] = $z;
	if ($z){
		$return[1] = $z + $cost;
		$return[2] = charge($county) - $return[1];
		$return[3] = $x;
	}
	return $return;
}

function fetchRate($county){
	$q="select ps_rate from ps_county where ps_name = '$county'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[ps_rate];
}


if ($_POST[county]){

foreach( $_POST[county] as $key => $value ){

@mysql_query("update ps_county set ps_rate = '$value' where ps_name='$key'");

}

}
include 'menu.php';
?>
<style>
div { padding:5px}
</style>
<div align="center" style=" font-size:36px;">Set Last Paid Bid<br><?=date('r')?></div><br>
<table align="center" border="1" style="border-collapse:collapse">
<form method="post">
	<tr bgcolor="#CCCCCC">
    	<td align="center" width="200;">County</td>
        <td align="center">Average Bid</td>
        <td align="center"><input type="submit" /></td>
        <td align="center">Client Charge</td>
        <td align="center">Bid Margin</td>
    </tr>
<? 
$q="SHOW FIELDS FROM ps_users";
$r=@mysql_query($q);
$uu = 0;
$uu_total = 0;
$i = 0;
while ($row = mysql_fetch_array($r))
{
if ($i > 9 && $i < 34){
$stat = coverage($row['Field'], $cost);
?>
	<tr bgcolor="<?=row_color($i,'#CCFF00','#CCFF99')?>">
    	<td align="left" width="200;"><?=cleanField($row['Field']);?> <? if($stat[3]){ echo "($stat[3] bids)";}?></td>
        <td align="right">$<?=number_format($stat[0], 2);?></td>
        <td align="right">$<input size="2" maxlength="2" name="county[<?=$row['Field']?>]" value="<?=fetchRate($row['Field']);?>" />.oo</td>
        <td align="right">$<?=number_format(charge($row['Field']), 2);?></td>
        <? $uu++; $uu_total = $uu_total + $stat[2];?>
        <td align="right">$<?=number_format($stat[2], 2);?></td>
    </tr>
<?  } $i++; }?>
</form>
</table>
<div align="right" style="font-size:18px;">Average Margin $<?=number_format($uu_total / $uu, 2);?></div>
<? 
include 'footer.php';
} else {
include 'common.php';
include 'menu.php';
?>
<table border="0" align="center" vspace="100%">
	<tr>
    	<td align="center"> Go Away </td>
    </tr>
</table>
<?
include 'footer.php';
}?>