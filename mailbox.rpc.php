<? 
include 'common.php'; 

function makeStaff(){
$q="SELECT * from ps_users where level = 'Dispatch' or level='Operations' or level='SysOp'";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$option .= "<option value='$d[id]'>$d[name], $d[level]</option>";
}
return $option;
}
function makeUsers(){
$q="SELECT * from ps_users where level <> 'DELETED' and contract = 'YES' order by name";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$option .= "<option value='$d[id]'>$d[name], $d[level]</option>";
}
return $option; 
}

switch($_REQUEST['action']) {

    case 'form_send_staff':
	$div = "workspace";
	// code
	$html = $div.'|';
	$html .= "<form method='post'";
	$html .= "
	<table style='color:#ffffff' align='center'>
		<tr>
			<td>To</td>
			<td><select name='to'>".makeStaff()."</select></td>
		</tr>
		<tr>
			<td>Subject</td>
			<td><input name='subject' size='80' /></td>
		</tr>
		<tr>
			<td colspan='2'><textarea rows='19' cols='90' name='message'></textarea></td>
		</tr>
		<tr>
			<td colspan='2'><input type='submit' value='Send Message'></td>
		</tr>
	</table>
	</form>
	";
	echo $html;	 
      break;
	  
    case 'form_send_user':
	$div = "workspace";
	// code
	$html = $div.'|';
	$html .= "<form method='post'";
	$html .= "
	<table style='color:#ffffff' align='center'>
		<tr>
			<td>To</td>
			<td><select name='to'>".makeUsers()."</select></td>
		</tr>
		<tr>
			<td>Subject</td>
			<td><input name='subject' size='80' /></td>
		</tr>
		<tr>
			<td colspan='2'><textarea rows='19' cols='90' name='message'></textarea></td>
		</tr>
		<tr>
			<td colspan='2'><input type='submit' value='Send Message'></td>
		</tr>
	</table>
	</form>
	";
	echo $html;	 
      break;


    case 'msg_new':
	$div = "workspace";
	$found=0;
	$html = $div.'|';
	$html .= "<table width='100%' border='1' style='border: solid 1px; padding:5px'><tr><td></td><td align='center'><strong>Sent</strong></td><td align='center'><strong>From</strong></td><td align='center'><strong>Subject</strong></td></tr>";
	$q="select *,DATE_FORMAT(send_date, '%c/%d/%Y %r') as send_date_f from ps_mailbox where to_id = '".$_COOKIE[psdata][user_id]."' and read_date < '1' order by message_id DESC";
	$r=@mysql_query($q) or die(mysql_error());
	while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$found=1;
	$html .= '<tr onClick="sndReq(\'message_new\',\''.$d[message_id].'\')"><td align="center"><strong>OPEN</strong></td><td>'.$d[send_date_f].'</td><td>'.id2name($d[from_id]).'</td><td>'.$d[subject].'</td></tr>';
	}
	$html .='</table>';
	if (!$found){
	$html .= 'You have no new messages.';
	}
	echo $html;	 
      break;

    case 'msg_saved':
	$div = "workspace";
	$html = $div.'|';
	$html .= "<table width='100%' border='1' style='border: solid 1px; padding:5px'><tr><td></td><td align='center'><strong>Sent</strong></td><td align='center'><strong>From</strong></td><td align='center'><strong>Subject</strong></td></tr>";
	$found=0;
	$q="select *,DATE_FORMAT(send_date, '%c/%d/%Y %r') as send_date_f from ps_mailbox where to_id = '".$_COOKIE[psdata][user_id]."' and read_date > '1' order by message_id DESC";
	$r=@mysql_query($q) or die(mysql_error());
	while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$found=1;
	$html .= '<tr onClick="sndReq(\'message_saved\',\''.$d[message_id].'\')"><td align="center"><strong>OPEN</strong></td><td>'.$d[send_date_f].'</td><td>'.id2name($d[from_id]).'</td><td>'.$d[subject].'</td></tr>';
	}
	$html .='</table>';
	if (!$found){
	$html .= "You have no saved messages.";
	}
	echo $html;	 
      break;


    case 'msg_sent':
	$found=0;
	$div = "workspace";
	$html = $div.'|';
	$html .= "<table width='100%' border='1' style='border: solid 1px; padding:5px'><tr><td></td><td align='center'><strong>Recieved</strong></td><td align='center'><strong>To</strong></td><td align='center'><strong>Subject</strong></td></tr>";
	$q="select *,DATE_FORMAT(read_date, '%c/%d/%Y %r') as read_date_f from ps_mailbox where from_id = '".$_COOKIE[psdata][user_id]."' order by message_id DESC";
	$r=@mysql_query($q) or die(mysql_error());
	while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
	$found=1;
		if ($d[read_date] > 1){
		$html .= '<tr onClick="sndReq(\'message_sent\',\''.$d[message_id].'\')"><td align="center"><strong>OPEN</strong></td><td>'.$d[read_date_f].'</td><td>'.id2name($d[to_id]).'</td><td>'.$d[subject].'</td></tr>';
		}else{
		$html .= '<tr onClick="sndReq(\'message_sent\',\''.$d[message_id].'\')"><td align="center"><strong>OPEN</strong></td><td> - - - - UNREAD - - - - </td><td>'.id2name($d[to_id]).'</td><td>'.$d[subject].'</td></tr>';
		}
	}
	$html .='</table>';
	if (!$found){
	$html .= "You have no sent messages.";
	}
	echo $html;	 
      break;
	  
    case 'message_new':
	$div = "workspace";
	$q="select * from ps_mailbox where message_id = '$_REQUEST[id]'";
	$r=@mysql_query($q) or die(mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[read_date] < '1'){ @mysql_query("update ps_mailbox set read_date=NOW() where message_id='$_REQUEST[id]'"); }	
	$html = $div.'|';
	$html .= '<form><div onClick="sndReq(\'msg_new\',\'\')">';
	$html .= "<textarea id='print_area' rows='22' cols='90'>".stripslashes($d[message])."</textarea>";
	$html .= "<center><strong>CLOSE</strong></center>";
	$html .= "</div>";
	$html .= "<center><input type='button' id='.buttom' value='Print' onclick='pwin(form.print_area.value,500,400)' /></center></form>";
	echo $html;	 
      break;
    case 'message_sent':
	$div = "workspace";
	$q="select * from ps_mailbox where message_id = '$_REQUEST[id]'";
	$r=@mysql_query($q) or die(mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$html = $div.'|';
	$html .= '<form><div onClick="sndReq(\'msg_sent\',\'\')">';
	$html .= "<textarea id='print_area' rows='22' cols='90'>".stripslashes($d[message])."</textarea>";
	$html .= "<center><strong>CLOSE</strong></center>";
	$html .= "</div>";
	$html .= "<center><input type='button' id='.buttom' value='Print' onclick='pwin(form.print_area.value,500,400)' /></center></form>";
	echo $html;	 
      break;
    case 'message_saved':
	$div = "workspace";
	$q="select * from ps_mailbox where message_id = '$_REQUEST[id]'";
	$r=@mysql_query($q) or die(mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$html = $div.'|';
	$html .= '<form><div onClick="sndReq(\'msg_saved\',\'\')">';
	$html .= "<textarea id='print_area' rows='22' cols='90'>".stripslashes($d[message])."</textarea>";
	$html .= "<center><strong>CLOSE</strong></center>";
	$html .= "</div>";
	$html .= "<center><input type='button' id='.buttom' value='Print' onclick='pwin(form.print_area.value,500,400)' /></center></form>";
	echo $html;	 
      break;
}
?>