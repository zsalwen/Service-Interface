<?
include 'functions.php';
mysql_connect();
function lastPunch($id){
mysql_select_db('core');
$r=@mysql_query("select user_id, punch_time, action from MDWestServeTimeClock where user_id = '$id' order by punch_id desc");
$d=mysql_fetch_array($r, MYSQL_ASSOC);
return "$d[punch_time] ".id2name($id)." $d[action]<br>";
}
function lastPunch2($id){
mysql_select_db('intranet');
$r=@mysql_query("select user_id, punch_time, action from timeclock where user_id = '$id' order by punch_id desc");
$d=mysql_fetch_array($r, MYSQL_ASSOC);
return "$d[punch_time] ".id2name2($id)." $d[action]<br>";
}
mysql_select_db('core');
$r=@mysql_query("SELECT distinct user_id from MDWestServeTimeClock order by user_id");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
echo lastPunch($d[user_id]);
}


mysql_select_db('intranet');
$r=@mysql_query("SELECT distinct user_id from timeclock order by user_id");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
echo lastPunch2($d[user_id]);
}


?>