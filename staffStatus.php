<?
include 'functions.php';
mysql_connect();
function lastPunch($id){
	mysql_select_db('core');
	$r=@mysql_query("select user_id, punch_time, punch_date, action from MDWestServeTimeClock where user_id = '$id' order by punch_id desc LIMIT 0,1");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return "$d[punch_time] $d[punch_date] ".id2name($id)." $d[action]<br>";
}
function lastPunch2($id){
	mysql_select_db('intranet');
	$r=@mysql_query("select user_id, punch_time, punch_date, action from timeclock where user_id = '$id' order by punch_id desc LIMIT 0,1");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return "$d[punch_time] $d[punch_date] ".id2name2($id)." $d[action]<br>";
}
function getLevel($id){
	mysql_select_db('core');
	$r=@mysql_query("select level from ps_users where id = '$id' LIMIT 0,1");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	return $d[level];
}
mysql_select_db('core');
$r=@mysql_query("SELECT distinct user_id from MDWestServeTimeClock order by user_id");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	if (getLevel($d[user_id]) == 'Operations'){
		echo "<span style='background-color:yellow;' id='$d[user_id]'>".lastPunch($d[user_id])."</span>";
	}else{
		echo "<span id='$d[user_id]'>".lastPunch($d[user_id])."</span>";
	}
}


/*mysql_select_db('intranet');
$r=@mysql_query("SELECT distinct user_id from timeclock order by user_id");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
echo lastPunch2($d[user_id]);
}*/


?>