<? 
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Marketplace');
include 'menu.php';
$id=$_COOKIE[psdata][user_id];

function fetchRate($county){
	$q="select ps_rate from ps_county where ps_name = '$county'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	
	if ($d[ps_rate]){
	return "$".$d[ps_rate].".oo";
	}
}

function coverage($county){
$q="SELECT * from ps_users where $county > '0' AND contract = 'YES' ORDER BY $county";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	//if ($d[$county] == '100'){ @mysql_query("UPDATE ps_users SET $county = '99' WHERE id = '$d[id]'"); }
	if ($_COOKIE[psdata][level] == "Administrator" || $_COOKIE[psdata][level] == "Operations" || $_COOKIE[psdata][level] == "Dispatch" || $_COOKIE[psdata][level] == "SysOp"){
		$name = id2name($d[id]);
		echo "<a title='$name' href='contractor_review.php?admin=$d[id]'>";
		if ($d[id] == $_COOKIE[psdata][user_id]){
		echo "<font color='FF0000'>";
		}
		if ($d[verify] == "YES"){
		echo "<strong>$$d[$county]</strong>, ";
		}else{
		echo "$$d[$county], ";
		}
		if ($d[id] == $_COOKIE[psdata][user_id]){
		echo "</font></a>";
		}
	}else{
		$XX = "?";
		if ($d[id] == $_COOKIE[psdata][user_id]){
		echo "<strong><font color='0000FF'>$$d[$county], </font></strong>";
		} else{
		echo "<font color='000000'>$XX, </font>";
		}
	}	
}
}

if ($_POST[submit]){
$q1 = "UPDATE ps_users SET 
							p_update=NOW(),
							garrett='$_POST[garrett]',
							cecil='$_POST[cecil]',
							kent='$_POST[kent]',
							allegany='$_POST[allegany]',
							washington='$_POST[washington]',
							frederick='$_POST[frederick]',
							carroll='$_POST[carroll]',
							harford='$_POST[harford]',
							baltimore_county='$_POST[baltimore_county]',
							baltimore_city='$_POST[baltimore_city]',
							howard='$_POST[howard]',
							montgomery='$_POST[montgomery]',
							pg='$_POST[pg]',
							anne_arundel='$_POST[anne_arundel]',
							calvert='$_POST[calvert]',
							caroline='$_POST[caroline]',
							charles='$_POST[charles]',
							dorchester='$_POST[dorchester]',
							queen_anne='$_POST[queen_anne]',
							st_mary='$_POST[st_mary]',
							somerset='$_POST[somerset]',
							talbot='$_POST[talbot]',
							wicomico='$_POST[wicomico]',
							worcester='$_POST[worcester]'
						WHERE id = '$id'";

monitor('Query: '.$q1);
@mysql_query($q1);
// testing new monitor
$me = "Service <service@hwestauctions.com>";
$subject = "$_POST[name] Updated Bids";
$headers .= "From: $me \n";
$msg = "Process Server Bid's Updated";
//mail($me,$subject,$msg,$headers);
}
?>
<?
$q= "select * from ps_users where id = '$id'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC); 
?>

<table width="100%" cellpadding="5" cellspacing="0" style="font-weight:bold"><form method="post">
    <tr><td colspan="2" align="center"><input type="submit" name="submit" value="Update My Bid's" style="font-size:16px;" /></td></tr>

<tr>
<td colspan="2" style="width:300px;">
<table align="center" border="1" style="border-collapse:collapse; font-size:12px;">
            		<tr>
                		<td nowrap="nowrap">Garrett</td>
                    	<td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="garrett" value="<?=$d[garrett]?>" />.00</td>
                   		<td nowrap="nowrap">Allegany</td>
                   		<td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="allegany" value="<?=$d[allegany]?>" />.00</td>
                   		<td nowrap="nowrap">Washington</td>
                   		<td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="washington" value="<?=$d[washington]?>" />.00</td>
                   		<td nowrap="nowrap">Frederick</td>
                   		<td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="frederick" value="<?=$d[frederick]?>" />.00</td>
                                           		<td nowrap="nowrap">Caroline</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="caroline" value="<?=$d[caroline]?>" />.00</td>
                   		<td nowrap="nowrap">Dorchester</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="dorchester" value="<?=$d[dorchester]?>" />.00</td>

                   </tr>
                   <tr>
                   		
                        <td nowrap="nowrap">Carroll</td>
                   		<td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="carroll" value="<?=$d[carroll]?>" />.00</td>
                        <td nowrap="nowrap">Cecil</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="cecil" value="<?=$d[cecil]?>" />.00</td>
                   		<td nowrap="nowrap">Harford</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="harford" value="<?=$d[harford]?>" />.00</td>
                   		<td nowrap="nowrap">Baltimore County</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="baltimore_county" value="<?=$d[baltimore_county]?>" />.00</td>
                   		<td nowrap="nowrap">Baltimore City</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="baltimore_city" value="<?=$d[baltimore_city]?>" />.00</td>
                   		<td nowrap="nowrap">Howard</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="howard" value="<?=$d[howard]?>" />.00</td>
                   </tr>
                   <tr>
                   		<td nowrap="nowrap">Montgomery</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="montgomery" value="<?=$d[montgomery]?>" />.00</td>
                   		<td nowrap="nowrap">Anne Arundel</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="anne_arundel" value="<?=$d[anne_arundel]?>" />.00</td>
                   		<td nowrap="nowrap">Prince George's</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="pg" value="<?=$d[pg]?>" />.00</td>
                   		<td nowrap="nowrap">Calvert</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="calvert" value="<?=$d[calvert]?>" />.00</td>
                   		<td nowrap="nowrap">Charles</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="charles" value="<?=$d[charles]?>" />.00</td>
                   		<td nowrap="nowrap">St. Mary's</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="st_mary" value="<?=$d[st_mary]?>" />.00</td>
                   </tr>
            	<tr>
                   		<td nowrap="nowrap">Queen Anne's</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="queen_anne" value="<?=$d[queen_anne]?>" />.00</td>
                   		<td nowrap="nowrap">Somerset</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="somerset" value="<?=$d[somerset]?>" />.00</td>
                   		<td nowrap="nowrap">Talbot</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="talbot" value="<?=$d[talbot]?>" />.00</td>
                   		<td nowrap="nowrap">Wicomico</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="wicomico" value="<?=$d[wicomico]?>" />.00</td>
                   		<td nowrap="nowrap">Worcester</td>
                        <td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="worcester" value="<?=$d[worcester]?>" />.00</td>
                                        	<td nowrap="nowrap">Kent</td><td nowrap="nowrap">$<input type="text" size="1" maxlength="2" name="kent" value="<?=$d[kent]?>" />.00</td>

                   </tr>
			</table>
        </td>
    </tr>
    <tr><input type="hidden" name="name" value="<?=$d[name]?>" />
    	<td valign="top" width="50%">
<table align="center" border="1" width="100%" style="border-collapse:collapse; color:#000000; font-size:12px;">
	<tr>
    	<td nowrap="nowrap">Local Market</td>
    	<td nowrap="nowrap">Winning Bid</td>
        <td nowrap="nowrap">Bid Position</td>
    </tr>

<? 
$q="SHOW FIELDS FROM ps_users";
$r=@mysql_query($q);
$i = 0;
while ($row = mysql_fetch_array($r))
{
if ($i > 9 && $i < 22){
?>
	<tr>
    	<td nowrap="nowrap"><?=ps2county($row['Field']);?></td>
    	<td nowrap="nowrap"><?=fetchRate($row['Field']);?></td>
        <td><?=coverage($row['Field']);?></td>
    </tr>
<?  } $i++; }?>
</table>

</td>
    	<td width="50%" valign="top">
        
<table align="center" border="1" width="100%" style="border-collapse:collapse; color:#000000; font-size:12px;">
	<tr>
    	<td nowrap="nowrap">Local Market</td>
    	<td nowrap="nowrap">Winning Bid</td>
        <td nowrap="nowrap">Bid Position</td>
    </tr>
<? 
$q="SHOW FIELDS FROM ps_users";
$r=@mysql_query($q);
$i = 0;
while ($row = mysql_fetch_array($r))
{
if ($i > 21 && $i < 34){
?>
	<tr>
    	<td nowrap="nowrap"><?=ps2county($row['Field']);?></td>
    	<td nowrap="nowrap"><?=fetchRate($row['Field']);?></td>
        <td><?=coverage($row['Field']);?></td>
    </tr>
<?  } $i++; }?>
</table>

</td>
</tr></form>
</table>

<?
include 'footer.php';
?>
<script>hideshow(document.getElementById('home'))</script>