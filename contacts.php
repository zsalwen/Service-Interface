<?
include 'common.php';
if ($_GET[submit] == "Add Contact"){
	mysql_select_db('ccdb');
	$q="INSERT INTO contacts (name, email, phone, attorneys_id, position) values ('$_GET[name]', '$_GET[email]', '$_GET[phone]', '$_GET[attorneys_id]', '$_GET[position]')";
	$r=@mysql_query($q) or die(mysql_error());
	//log_action($_COOKIE[userdata][user_id],"Added new company contact.");
	echo "<script>window.location.href = 'contacts.php';</script>";
}

if ($_GET[submit] == "Update Contact"){
	mysql_select_db('ccdb');
	$q="UPDATE contacts SET name='$_GET[name]',
							email='$_GET[email]',
							phone='$_GET[phone]',
							user_id='$_GET[user_id]',
							user_admin='$_GET[user_admin]',
							attorneys_id='$_GET[attorneys_id]',
							position='$_GET[position]'
								WHERE contact_id = '$_GET[id]'";
	$r=@mysql_query($q) or die(mysql_error());
	//log_action($_COOKIE[userdata][user_id],"Updated attorney contact.");
	echo "<script>window.location.href = 'contacts.php';</script>";
}


$i=0;
?>
<table align="center" border="1">
        <tr>
        <td valign="top" align="center" bgcolor="#66CCFF">
<? if ($_GET[edit]){
mysql_select_db('ccdb');
$q = "SELECT * FROM contacts WHERE contact_id = '$_GET[edit]'";
$r = @mysql_query($q) or die(mysql_error());
$d = mysql_fetch_array($r, MYSQL_ASSOC);
?>
        	<form>
            <input type="hidden" name="page" value="contacts" />
            <input type="hidden" name="id" value="<?=$d[contact_id]?>" />
            	<table>
                	<tr>
                    	<td>Name</td>
                    	<td><input size="100" name="name" value="<?=$d[name]?>" /></td>
                    </tr>
                	<tr>
                    	<td>Position</td>
                    	<td><input size="100" name="position" value="<?=$d[position]?>" /></td>
                    </tr>
                	<tr>
                    	<td>E-Mail</td>
                    	<td><input size="100" name="email" value="<?=$d[email]?>" /></td>
                    </tr>
                	<tr>
                    	<td>Phone</td>
                    	<td><input size="100" name="phone" value="<?=$d[phone]?>" /></td>
                    </tr>
                	<tr>
                    	<td>Bind to User ID</td>
                    	<td><input size="100" name="user_id" value="<?=$d[user_id]?>" /></td>
                    </tr>
                	<tr>
                    	<td>User Admin</td>
                    	<td><select name="user_admin"><option><?=$d[user_admin]?></option><option>NO</option><option>YES</option></select></td>
                    </tr>
                	<tr>
                    	<td>Attorney</td>
                    	<td><select name="attorneys_id">
								<?
								mysql_select_db('ccdb');
                                $q8 = "SELECT * FROM attorneys where attorneys_id >'0' ORDER BY attorneys_id";		
                                $r8 = @mysql_query ($q8) or die("Query: $q8<br>".mysql_error());
								if ($d[attorneys_id]){
	                            	echo "<option value='$d[attorneys_id]'>".id2attorney($d[attorneys_id])."</option>";
								}
                                while ($data8 = mysql_fetch_array($r8, MYSQL_ASSOC)){ 
	                            	echo "<option value='$data8[attorneys_id]'>$data8[display_name]</option>";
                                }
								?>
							</select>
                        </td>
                    </tr>
                	<tr>
                    	<td colspan="2" align="center"><input type="submit" name="submit" value="Update Contact" /></td>
                    </tr>
               </table>
            </form>
<? }else{ ?>
        	<form>
            <input type="hidden" name="page" value="contacts" />
            	<table>
                	<tr>
                    	<td>Name</td>
                    	<td><input size="100" name="name" /></td>
                    </tr>
                	<tr>
                    	<td>Position</td>
                    	<td><input size="100" name="position" /></td>
                    </tr>
                	<tr>
                    	<td>E-Mail</td>
                    	<td><input size="100" name="email" /></td>
                    </tr>
                	<tr>
                    	<td>Phone</td>
                    	<td><input size="100" name="phone" /></td>
                    </tr>
                	<tr>
                    	<td>Attorney</td>
                    	<td><select name="attorneys_id">
								<?
								mysql_select_db('ccdb');
                                $q8 = "SELECT * FROM attorneys where attorneys_id >'0' ORDER BY attorneys_id";		
                                $r8 = @mysql_query ($q8) or die(mysql_error());
                                while ($data8 = mysql_fetch_array($r8, MYSQL_ASSOC)){ 
	                            echo "<option value='$data8[attorneys_id]'>$data8[display_name]</option>";
                                }
								?>
							</select>
                        </td>
                    </tr>
                	<tr>
                    	<td colspan="2" align="center"><input type="submit" name="submit" value="Add Contact" /></td>
                    </tr>
               </table>
            </form>
<? } ?>            
            
            
        </td>            
	</tr>
	<tr>
    	<td>
            <?
			mysql_select_db('ccdb');
            $q="SELECT * FROM contacts ORDER BY attorneys_id, email";
            $r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
            ?>
            <table border="1" style="border-collapse:collapse" cellpadding="3">
                <tr bgcolor="#99CCFF">
                	<td></td>
                    <td>Attorney</td>
                    <td>Name</td>
                    <td>Position</td>
                    <td>E-Mail</td>
                    <td>Password</td>
                    <td>Phone</td>
                </tr>
            <? while($d = mysql_fetch_array($r, MYSQL_ASSOC)){ $i++;?>
                <tr>
                	<td><a href="?edit=<?=$d[contact_id]?>">EDIT <em>#<?=$d[contact_id]?></em></a></td>
                    <td><?=id2attorney($d[attorneys_id])?></td>
                    <td><?=$d[name]?> </td>
                    <td><?=$d[position]?></td>
                    <td><?=$d[email]?></td>
                    <td><center><form method="post" target="_blank" action="portal/reset.php"><strong><?=$d[password]?></strong>
                    	<input type="hidden" name="email" value="<?=$d[email]?>" />
                        <input name="submit" type="submit" value="RESET" /></form></center></td>
                    <td><?=$d[phone]?></td>
                </tr>
            <? } ?>
            </table>
		</td>
        </tr>
</table>
<?
include 'footer.php'; ?>