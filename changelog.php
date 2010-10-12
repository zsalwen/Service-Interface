<?
include 'common.php';
include 'menu.php';
?>
<style>div {border:solid 1px #666666;}</style>
<?
function changelog($ver){
echo "<div><strong>PS-CORE v$ver</strong></div>";
$q="select changelog from version_control where core='PS-CORE' and core_version = '$ver'";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
echo stripslashes(stripslashes($d[changelog]));
}

$q="SELECT DISTINCT core_version from version_control where core='PS-CORE' order by core_version desc";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
changelog($d[core_version]);
}
include 'footer.php';
?><script>hideshow(document.getElementById('sysop'))</script>
