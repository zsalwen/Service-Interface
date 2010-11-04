<?
if ($_COOKIE[psdata][level] == 'Operations'){
	echo "<pre>";
	echo htmlspecialchars(print_r($_GET, true));
	echo "</pre><hr>";
	foreach ($_GET as $var => $value){
		$varList .= "$var=$value&amp;";
	}
	$varList=substr($varList,0,-5);
	echo "$varList<hr>";
}
include 'obAffidavit.php';
if ($_GET[ev] == "YES"){
	include "evictionAff.php?$varList";
}
?>