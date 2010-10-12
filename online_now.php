<?
// this file should be included anywhere we want to ping user activity
$q="UPDATE ps_users SET location='".$_SERVER['PHP_SELF']."', online_now='".time()."' WHERE id = '".$_COOKIE[psdata][user_id]."'";
@mysql_query($q);
?>