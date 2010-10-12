<? include 'common.php';
if ($_COOKIE[psdata][level] == "Data Entry" || $_COOKIE[psdata][level] == "Administrator"){
if ($_POST[submit]){

$id = $_POST[id];

$q1 = "UPDATE private_process SET 
								case_no='$_POST[case_no]',
								client_file='$_POST[client_file]',
								p_name='$_POST[name]',
								p_add='$_POST[p_add]',
								p_city='$_POST[p_city]',
								p_state='$_POST[p_state]',
								p_zip='$_POST[p_zip]',
								p_phone='$_POST[p_phone]',
								county='$_POST[county]',
								serve_add='$_POST[serve_add]',
								po_add='$_POST[po_add]',
								deadline='$_POST[deadline]',
								approved_list='$_POST[approved_list]',
								attorneys_id='$_POST[attorneys_id]',
								notes='$_POST[notes]',
								process_status='$_POST[process_status]'
									WHERE id = '$id'";



	
	$r=@mysql_query($q1) or die("Query: $q1<br>".mysql_error());

header ('Location: ps_details.php?id='.$id);
} 

$q= "select * from private_process where id = '$_GET[id]'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC);

include 'menu.php'; ?>


<table align="center" width="100%">
	<tr>
    	<td colspan="2" align="center"><b>Edit Process Serving Information</b></td>
    </tr>
<form method="post">
<input type="hidden" name="id" value="<?=$_GET[id]?>" />
	<tr>
    	<td valign="top">
        
        	<table border="1" bgcolor="#FFFFFF" width="100%">
                <tr>
                	<td colspan="2" bgcolor="#99CCCC">Client Information</td>
                </tr>    

            	<tr>
                	<td><select name="attorneys_id"><?=attorneysList($d[attorneys_id])?></select></td>
                	<td>Defendant</td>
				</tr>
                <tr>
                	<td><select name="county"><?=countyList($d[county])?></select></td>
                	<td>Circuit Court</td>
				</tr>
                <tr>
                	<td><input name="case_no" value="<? if ($_POST[case_no]){ echo $_POST[case_no];}else{echo $d[case_no] ;}?>" /></td>
                	<td>Case #</td>
				</tr>
                <tr>
                	<td><input name="client_file" value="<? if ($_POST[client_file]){ echo $_POST[client_file];}else{echo $d[client_file] ;}?>" /></td>
                	<td>File Number</td>
				</tr>
                <tr>
                	<td colspan="2" bgcolor="#99CCCC">Plaintiff Information</td>
                </tr>    
                <tr>
                	<td><input size="70" name="p_name" value="<? if ($_POST[p_name]){ echo $_POST[p_name];}else{echo $d[p_name] ;}?>" /></td>
                	<td>Name</td>
				</tr>
                <tr>
                	<td><input size="70" name="p_add" value="<? if ($_POST[p_add]){ echo $_POST[p_add];}else{echo $d[p_add] ;}?>" /></td>
                	<td>Address</td>
				</tr>
                <tr>
                	<td nowrap="nowrap"><input name="p_city" value="<? if ($_POST[p_city]){ echo $_POST[p_city];}else{echo $d[p_city] ;}?>" /><select name="p_state"><option>MD</option></select><input name="p_zip" value="<? if ($_POST[p_zip]){ echo $_POST[p_zip];}else{echo $d[p_zip] ;}?>" /></td>
                	<td nowrap="nowrap">City, State ZIP </td>
				</tr>
                <tr>
                	<td><input name="p_phone" value="<? if ($_POST[p_phone]){ echo $_POST[p_phone];}else{echo $d[p_phone] ;}?>" /></td>
                	<td>Phone</td>
				</tr>


             </table>        
        
        
        </td>
        <td valign="top">
        
        
        	<table border="1" bgcolor="#FFFFFF" width="100%">
                <tr>
                	<td colspan="2" bgcolor="#99CCCC">Private Process Information</td>
                </tr>    
                <tr>
                	<td width="70%"><input name="deadline" value="<? if ($_POST[deadline]){ echo $_POST[deadline];}else{echo $d[deadline] ;}?>" /></td>
                	<td width="30%">Service Deadline</td>
				</tr>
                <tr>
                <td><input name="process_status" value="<? if ($_POST[process_status]){ echo $_POST[process_status];}else{echo $d[process_status] ;}?>" /></td>
                <td>Process Status</td>
                </tr>
            	<tr>
                	<td><textarea name="approved_list" cols="35" rows="2"><?=$d[approved_list]?></textarea></td>
                	<td>Approved Persons to be Served, Seperate with comma.</td>
				</tr>
                <tr>
                	<td><input size="50" name="serve_add" value="<? if ($_POST[serve_add]){ echo $_POST[serve_add];}else{echo $d[serve_add] ;}?>" /></td>
                	<td>Address to Serve</td>
				</tr>
                <tr>
                	<td><input size="50" name="po_add" value="<? if ($_POST[po_add]){ echo $_POST[po_add];}else{echo $d[po_add] ;}?>" /></td>
                	<td>Address to Post</td>
				</tr>
                <tr>
                	<td><textarea name="notes" cols="35" rows="3"><?=$d[notes]?></textarea></td>
                	<td>Addtional Instructions</td>
				</tr>
                <tr>
                	<td colspan="2" align="center"><input type="submit" name="submit" value="Update File" /></td>
                </tr>    

             </table>        
        
        
        
        </td>
    </tr>
</form>    
</table>    

<? include 'footer.php';
}else{
	$event = 'ps_edit.php';
	$email = $_COOKIE[psdata][email];
	$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
	//@mysql_query($q1) or die(mysql_error());
	header('Location: home.php');
}

?>