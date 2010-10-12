<? 
include 'common.php';
if ($_COOKIE[psdata][level] != "Operations"){
	if ($_COOKIE[psdata][level] == "Administrator"){
		// ok to ba admin	
	} else{
		$event = 'ps_review.php';
		$email = $_COOKIE[psdata][email];
		$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
		//@mysql_query($q1) or die(mysql_error());
		header('Location: home.php');
	}
}
if ($_GET[delete]){
@mysql_query("UPDATE ps_users SET level='DELETED' where id = '$_GET[delete]'");
}

if ($_POST[submit]){

$review = addslashes($_POST[manager_review]);
$q1 = "UPDATE ps_users SET 
							contract='$_POST[contract]',
							oc='$_POST[oc]',
							w9='$_POST[w9]',
							level='$_POST[level]',
							verify='$_POST[verify]',
							manager_review='$review'
						WHERE id = '$_GET[admin]'";

@mysql_query($q1) or die("Query: $q1<br>".mysql_error());
$message = "<font color='#FFFFFF' size='+1'><b>+++ Review Saved +++</b></font>";

}

include 'menu.php';



$q= "select * from ps_users where id = '$_GET[admin]'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC); 

?>
<?=$message?>
<table width="100%"><tr><td valign="top">
        	<table border="1" width="100%" bgcolor="#CCFFFF">
      <form method="post">
            	<tr>
                	<td colspan="2" align="center" bgcolor="#FFFF99"><input  type="submit" name="submit" value="Save Member Review" /></td>
                </tr>
				<tr>
                	<td>Name</td>
                    <td><?=$d[name]?></td>
                </tr>
				<tr>
                	<td>County of Residence</td>
                    <td><?=$d[county]?></td>
                </tr>
                 <tr>
                	<td>Address</td>
                	<td><?=$d[address]?></td>
				</tr>
                <tr>
                	<td>City, State ZIP </td>
                	<td><?=$d[city]?>, <?=$d[state]?> <?=$d[zip]?></td>
				</tr>
                <tr>
                	<td>Phone</td>                
                	<td><?=$d[phone]?></td>
				</tr>
                <tr>
                	<td>Email Address, Status</td>
                    <td><?=$d[email]?> (<?=$d[email_status]?>)</td>
                </tr>
                <tr>
                	<td>Experence</td>
                    <td><?=$d[experence]?></td>
                </tr>
                <tr>
                	<td>Drivers / Staff</td>
                    <td><?=$d[drivers]?></td>
                </tr>
                <tr>
                    <td>User Notes</td>
                    <td><pre><?=stripslashes($d[user_notes])?></pre></td>
                </tr>
            </table>
            </td><td align="center" width="10"><?=image($d[img],250,'');?></td></tr></table>
<table bgcolor="#FFFFCC" width="100%" align="center" cellpadding="3" border="1" style="border-collapse:collapse; font-size:18px; font-variant:small-caps">
	<tr>
    	<td <? if($d[allegany]){ echo "bgcolor='00FFFF'"; }?>>allegany <?=$d[allegany]?>
        <td>anne_arundel <?=$d[anne_arundel]?> 
        <td>baltimore_city <?=$d[baltimore_city]?> 
        <td>baltimore_county <?=$d[baltimore_county]?> 
        <td>caroline <?=$d[caroline]?> 
        <td>carroll <?=$d[carroll]?> 
        <td>calvert <?=$d[calvert]?> 
        <td>charles <?=$d[charles]?> 
    </tr>
    <tr>
        <td>cecil <?=$d[cecil]?> 
        <td>dorchester <?=$d[dorchester]?> 
        <td>frederick <?=$d[frederick]?> 
        <td>garrett <?=$d[garrett]?> 
        <td>harford <?=$d[harford]?> 
        <td>howard <?=$d[howard]?> 
       <td>kent <?=$d[kent]?> 
        <td>montgomery <?=$d[montgomery]?> 
     </tr>
    <tr>
        <td>pg <?=$d[pg]?> 
        <td>queen_anne <?=$d[queen_anne]?> 
        <td>st_mary <?=$d[st_mary]?> 
        <td>somerset <?=$d[somerset]?> 
        <td>talbot <?=$d[talbot]?> 
        <td>washington <?=$d[washington]?> 
        <td>wicomico <?=$d[wicomico]?> 
        <td>worcester <?=$d[worcester]?> 
   </tr>     
</table>

<table><tr><td valign="top">
<table bgcolor="#CCFFFF" width="100%">
	<tr>
    	<td>Account Level</td>
    	<td><select name="level">
        	<option><?=$d[level]?></option>
            <option>Platinum Member</option>
            <option>Gold Member</option>
            <option>Green Member</option>
            <option>Data Entry</option>
            <option>Manager</option>
            <option>Accounting</option>
         </select></td>
    </tr>
	<tr>
    	<td>Account Verified</td>
    	<td><select name="verify"><option><? if ($d[verify]){ echo $d[verify]; }else{ echo "NO";}?></option><option>YES</option><option>NO</option></select></td>
    </tr>
	<tr>
    	<td>Under Contract</td>
    	<td><select name="contract"><option><?=$d[contract];?></option><option>YES</option><option>NO</option></select></td>
    </tr>
	<tr>
    	<td>Recieved Original Contract</td>
    	<td><select name="oc"><option><?=$d[oc];?></option><option>YES</option><option>NO</option></select></td>
    </tr>
	<tr>
    	<td>Recieved W9</td>
    	<td><select name="w9"><option><?=$d[w9];?></option><option>YES</option><option>NO</option></select></td>
    </tr>
    
	<tr>
    	<td>Manager Notes</td>
        <td><textarea name="manager_review" cols="70" rows="5"><?=stripslashes($d[manager_review])?></textarea> </td>
    </tr>
    <tr><td colspan="2"><center><a href="?delete=<?=$_GET[admin];?>">Flag Account for Deletion</a></center></td></tr>
</form></table>
</td><td valign="top" bgcolor="#FFCC33"><?=$d[whois]?></td></tr></table>



<?
include 'footer.php';
?>