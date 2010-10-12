<?
include 'functions.php';
db_connect('delta.mdwestserve.com','intranet','root','zerohour');

@mysql_query("UPDATE browsers SET status = 'Unstable' WHERE agent = '".$_SERVER['HTTP_USER_AGENT']."' ");



?>
Your browser now has unstable clearance, you should know some things will look a little different. Click <a href="http://mdwestserve.com">Here</a> to log in.



