<? 
include 'common.php';



if (!$_COOKIE[psdata][elephant]){
		$event = 'ps_users.php';
		$email = $_COOKIE[psdata][email];
		$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
		//@mysql_query($q1) or die(mysql_error());
		header('Location: home.php');
}
include 'menu.php';


function mkLevel($level){
	if ($level == "Green Member"){
		return "bgcolor='66cc66'";
	} 
	if ($level == "Gold Member"){
		return "bgcolor='cc9933'";
	}
	if ($level == "Platinum Member"){
		return "bgcolor='cccccc'";
	} 
	if ($level == "DELETED"){
		return "bgcolor='000000'";
	} 
}
?>

<style>
a {text-decoration:none;}
.pop { color: #0000FF; font-size:16px; cursor:pointer; }
</style>


<table  bgcolor="#FF0000" border="1" cellpadding="3" style="border-collapse:collapse;">
<?
$i=0;
$q="SELECT *, DATE_FORMAT(signup,'%a, %b %D %Y at %r') as signup, DATE_FORMAT(p_update,'%a, %b %D %Y at %r') as p_update , DATE_FORMAT(last_login,'%a, %b %D %Y at %r') as login FROM ps_users ORDER BY online_now DESC, last_login DESC";
$r=@mysql_query($q);
 echo "<tr bgcolor='#ccffcc'><td align='center' colspan='3'>Links</td><td nowrap>Profile Name<br>Name<br>Company</td><td nowrap>Signup Date<br />
Profile Updated<br />Last Login</td><td>Last Page<br>Timestamp</td></tr>";

while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){

$i++;
 echo "<tr ".mkLevel($d[level])."><td nowrap>$i) <a href='ps_profile.php?admin=$d[id]'>View</a></td><td><a href='ps_review.php?admin=$d[id]'>Review</a></td><td><a class=\"pop\" onclick=\"window.open('ps_geocode2.php?id=$d[id]','edit2','width=200,height=100,toolbar=no,location=no')\">Geocode</a></td><td>$d[profile_name]<br>$d[name]<br>$d[company]</td><td nowrap>$d[signup]<br>$d[p_update]<br>$d[login]</td><td>$d[location]<br>$d[online_now]</td></tr>";

}
?>
</table>
<? include 'footer.php'; ?>