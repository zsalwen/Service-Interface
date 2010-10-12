<?
include 'functions.php';
db_connect('delta.mdwestserve.com','intranet','root','zerohour');
 ?>

<table bgcolor="#99ff00" align="center" vspace="50">
	<tr>
    	<td align="center" style="font-size:24px"><font color="#FF0000">You <b>must verify</b> your email address before you can log in.</font></td>
    </tr>
    <tr>
    	<td><hr /></td>
    </tr>
    <tr>
	    <td align="center"><a href='http://portal.hwestauctions.com/box/?red=<?=$_GET[id]?>' target='_blank'><b>Click Here To Re-Send Verification E-Mail</b></a></td>
    </tr>
    <tr>
    	<td><hr /></td>
    </tr>
    <tr>
      	<td align="center" style="font-size:14px">Once you have received the new email, only that link will work for verification.<br />If you have previous verifications stored, disregard them--their links are no longer valid.</td>
    </tr>
</table>

<? include 'footer.php'; ?>