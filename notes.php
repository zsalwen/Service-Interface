<?
include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Whiteboard');
$user = $_COOKIE[psdata][user_id];
if ($_POST[submit] && $_POST[whiteboard]){
$whiteboard = addslashes($_POST[whiteboard]);
$q1 = "UPDATE ps_users SET whiteboard='$whiteboard'";
$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
$message = 'Your notes have been updated.';
}
include 'menu.php';
$q="SELECT * from ps_users where id = '$user'";
$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC);
?>
<div style="background-color:#FFFFFF; border:double;">
<script language="JavaScript" type="text/javascript" src="../common/ps_wysiwyg.js"></script>
            <form method="post">
            <center>
            <textarea id="whiteboard" rows="30" cols="100" name="whiteboard"><?=stripslashes($d[whiteboard])?></textarea>
             <script language="JavaScript">
              generate_wysiwyg('whiteboard');
            </script> <br>
            <input style="font-size:24px; color:#006666;" name="submit" type="submit" value="Save Template"></center>
            </form>

</div>
<?
include 'footer.php'; ?>
<script>hideshow(document.getElementById('home'))</script>
<? if ($message){
	echo "<script>alert('$message')</script>";
} ?>