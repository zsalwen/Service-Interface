<? include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Submitting Feedback');
if ($_POST['submit']){
	if ($_POST['description']){
		$q="INSERT into project_manager (core, reporter, short, description) values ('PS-CORE', '$_POST[reporter]', '$_POST[short]', '$_POST[description]')";
		$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
		$feedbackID = mysql_insert_id();	
	}else{
	echo "<script>alert('Please enter a description.')</script>";
	}
}
include 'menu.php';
if (!$feedbackID){ ?>
<style>
.sd{color:#CCCCCC;}
</style>

<table bgcolor="#FFFFFF" align="center" width="100%">
	<tr>
    	<td align="center"><strong>This page enables users to send feedback concerning bugs and site performance to the management.</strong></td>
    </tr>
    <tr>
        <td align="center"><strong>Please use this tool responsibly when system issues arise.</strong></td>
    </tr>
    <tr>
        <td align="center"><strong>For general management contact, please use the Mailbox link.</strong></td>
    </tr>
</table>
<hr />
<table bgcolor="#FFFFFF" align="center" width="100%">
<form method="post">
<input type="hidden" name="reporter" value="<?=$_COOKIE['psdata']['name']?>" />
	<tr>
    	<td class="sd" align="center" bgcolor="#666666"><strong>Enter Feedback Here</strong></td>
    </tr>
    <tr>
    	<td align="center"><textarea cols="95" rows="8" name="description"></textarea></td>
    </tr>
    <tr>
	    <td class="sd" align="right" bgcolor="#666666">Subject: <select name="short"><option>Display Problem</option><option>Broken Page</option><option>Missing Link</option></select><input type="submit" name="submit" value="Send" /></td>
    </tr>
</form>
</table>
<hr />
<table bgcolor="#FFFFFF" align="center" width="100%">
	<tr>
    	<td colspan="2" class="sd" align="center" bgcolor="#666666"><strong>Operating Environment</strong></td>
    </tr>
    <tr>
    	<td>Connected to web server</td>
        <td><?=$_SERVER['SERVER_NAME']?></td>
    </tr>
    <tr>
    	<td>You just came from</td>
        <td><?=$_SERVER['HTTP_REFERER']?></td>
    </tr>
    <tr>
    	<td>Your web browser identifies itself as</td>
        <td><?=$_SERVER['HTTP_USER_AGENT']?></td>
    </tr>
    <tr>
    	<td>Current server time</td>
        <td><?=date('m/d/Y h:i A')?></td>
    </tr>
    <tr>
    	<td>Current client time</td>
        <td><script>dateString();</script></td>
    </tr>
</table>
<? }else{?>

<pre>
Thank you for your feedback, 

Feedback is an essential part of the application development. With our dedicated IT staff
your feedback can be analyzed and if there is a positive action given the application
will be modified. Average feedback turnaround 9-5, M-F is about 3-6 hours and S/S the 
weekend staff will try to seek action approval for the modification with within 12 hours.
If you are interested in following up with your feedback send a SysOp a message and include
Feedback ID <?=$feedbackID?>,

Patrick McGuire
SysOp : PS-CORE

</pre>
<a href="ps_feedback2.php">Enter More Feedback</a>
<? }
include 'footer.php'; ?>