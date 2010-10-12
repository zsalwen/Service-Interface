<? include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Personal Profile');
if ($_GET[delete]){
	@mysql_query("UPDATE ps_users SET level='DELETED' where id = '$_GET[delete]'");
	if ($_COOKIE[psdata][level] != "Manager"){
		header('Location: login.php?message=Your account has been removed.');
	}else{
		$event = 'account deleted';
		$email = $_COOKIE[psdata][email];
		$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
		//@mysql_query($q1) or die(mysql_error());
		header('Location: home.php');
	}
}
$id = $_COOKIE[psdata][user_id];

if ($_POST[submit]){
	$img = str_replace('www.','',$_POST[img]);
	$img = str_replace('http://','',$img);
	$img = str_replace('https://','',$img);
	setcookie ("psdata[effects]", $_POST[effects]);

	$q1 = "UPDATE ps_users SET 
								p_update=NOW(),
								company='$_POST[company]',
								img='$img',
								user_notes='$_POST[user_notes]',
								notifications='$_POST[notifications]',
								effects='$_POST[effects]',
								drivers='$_POST[drivers]',
								experence='$_POST[experence]',
								county='$_POST[county]',
								profile_name='$_POST[profile_name]',
								password='$_POST[password]',
								name='$_POST[name]',
								email='$_POST[email]',
								address='$_POST[address]',
								city='$_POST[city]',
								state='$_POST[state]',
								zip='$_POST[zip]',
								max_volume='$_POST[max_volume]',
								min_volume='$_POST[min_volume]',
								phone='$_POST[phone]'
							WHERE id = '$id'";

	@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
}

function isChecked($value){
	if ($value > '0'){
	return 'checked';
	}
}

$q= "select * from ps_users where id = '$id'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC); 
?>
        	<table border="1" width="795px" align="center" style="border-collapse:collapse">
            	<form method="post"><tr>
                	<td colspan="4" align="center" bgcolor="#CCCCCC"><a href="profile.php?id=<?=$d[id]?>">++ Independent Contractor Profile ++</a></td>
                </tr>
				<tr>
                	<td>Profile Name</td>
                    <td colspan="3"><input name="profile_name" size="50" value="<?=$d[profile_name]?>" /></td>
                </tr>
				<tr>
                	<td>Photo</td>
                    <td colspan="3"><input name="img" size="60" value="<?=$d[img]?>" /></td>
                </tr>
				<tr>
                	<td>Company</td>
                    <td colspan="3"><input name="company" size="50" value="<?=$d[company]?>" /></td>
                </tr>
				<tr>
                	<td>Name</td>
                    <td colspan="3"><input name="name" size="50" value="<?=$d[name]?>" /></td>
                </tr>
				<tr>
                	<td>County</td>
                    <td colspan="3"><select name="county"><?=mkcountylist($d[county])?></select></td>
                </tr>
                 <tr>
                	<td>Address</td>
                	<td colspan="3"><input name="address" size="50" value="<?=$d[address]?>" /></td>
				</tr>
                <tr>
                	<td>City, State ZIP </td>
                	<td colspan="3"><input name="city" size="40" value="<?=$d[city]?>" /><select name="state"><option><?=$d[state]?></option><option>MD</option><option>PA</option><option>VA</option><option>WV</option></select><input name="zip" size="5" value="<?=$d[zip]?>" /></td>
				</tr>
                <tr>
                	<td>Phone</td>                
                	<td colspan="3"><input name="phone" size="50" value="<?=$d[phone]?>" /></td>
				</tr>
                <tr bgcolor="<? if ($d[email_status] != "VERIFIED"){ echo "FF0000"; }else{ echo "00FF00"; }?>">
                	<td>E-Mail 
					<? if ($d[email_status] != "VERIFIED"){ 
					echo "<a href='http://portal.hwestauctions.com/box/?red=$id' target='_blank'>Click Here to Verify</a>" ;
					}
					?>
                    </td>
                    <td colspan="3"><input name="email" size="50" value="<?=$d[email]?>" /></td>
                </tr>
                <tr>
                	<td>Notifications</td>
                    <td colspan="3"><select name="notifications"><? if ($d[notifications]){ echo "<option>$d[notifications]</option>";}?><option>OPT-IN</option><option>OPT-OUT</option></select></td>
                </tr>
                <tr>
                	<td>Graphic Effects</td>
                    <td colspan="3"><select name="effects"><option><?=$d[effects]?></option><option>ON</option><option>OFF</option></select></td>
                </tr>
                <tr>
                	<td>Password</td>
                    <td colspan="3"><input type="password" name="password" size="50" value="<?=$d[password]?>" /></td>
                </tr>
			    <tr>
					<td>Volume</td>
                    <td colspan="2" width="35%" style="border-right:hidden"><input type="text" size="4" maxlength="4" name="min_volume" value="<?=$d[min_volume]?>" /> <i>(min)</i></td>
                    <td><input type="text" size="4" maxlength="4" name="max_volume" value="<?=$d[max_volume]?>" /> <i>(max - files per month)</i></td>
                </tr>
                <tr>
                    <td width="25%" align="left">Experience</td>
                    <td align="left" style="border-right:hidden"><input type="text" size="4" maxlength="4" name="experence" value="<?=$d[experence]?>" /></td>
                    <td align="right" style="border-right:hidden">Drivers</td>
                    <td align="left"><input type="text" size="4" maxlength="4" name="drivers" value="<?=$d[drivers]?>" /></td>
	</tr> 
    	<tr>
    	<td valign="top">Extended</td>
        <td colspan="3" valign="top"><textarea name="user_notes" cols="40" rows="5"><?=stripslashes($d[user_notes])?></textarea> <?=image($d[img],'95','')?></td>
    </tr>
         <tr>
                	<td colspan="4" align="center"><? if ($id == $_COOKIE[psdata][user_id]){?><input  type="submit" name="submit" value="Update <?=$d[level]?>" /><? }?><? if ($id == $_COOKIE[psdata][user_id] || $_COOKIE[psdata][user_id] == "Administrator"){?>   
<a href="?delete=<?=$id;?>">Flag account for deletion.</a>
<? } ?></td>
                </tr>      
            </form></table>
<? include 'footer.php';?>