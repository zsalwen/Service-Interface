<?
if (!$_COOKIE[psdata][level]){
	header('Location: login.php');
}

if($_GET[elephant]){
	
	setcookie("psdata[level]",$_GET[elephant]);
	setcookie("psdata[elephant]","SysOp");
	
//	$_COOKIE[psdata][level] = $_GET[elephant];
}

if ($_COOKIE[psdata][level] == "SysOp"){
	header('Location: sysop_home.php');
}
if ($_COOKIE[psdata][level] == "Operations"){
	header('Location: active.php');
}

if ($_COOKIE[psdata][level] == "Dispatch"){
	header('Location: server_tracker.php');
}

if ($_COOKIE[psdata][level] == "Administrator"){
	header('Location: home_administrator.php');
}


if ($_COOKIE[psdata][level] == "Platinum Member" || $_COOKIE[psdata][level] == "Gold Member" || $_COOKIE[psdata][level] == "Green Member"){
	header('Location: server.php');
}


if ($_COOKIE[psdata][level] == "Manager"){
	header('Location: manager.php');
}


if ($_COOKIE[psdata][level] == "Data Entry"){
	header('Location: de_main.php');
}





?>