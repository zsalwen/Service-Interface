<?
if ($_COOKIE[psdata][level] == 'Operations'){
	echo "<pre>";
	echo htmlspecialchars(print_r($_GET, true));
	echo "</pre><hr>";
}
include 'obAffidavit.php';
if ($_GET[ev] == "YES"){
	include 'evictionAff.php';
}
?>