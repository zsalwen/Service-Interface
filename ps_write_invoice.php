<?
mysql_connect ();
mysql_select_db ('core');
$r=@mysql_query("select attorneys_id, case_no from ps_packets where packet_id = '$_GET[id]' ");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$r=@mysql_query("select display_name from attorneys where attorneys_id = '$d[attorneys_id]' ");
$d2=mysql_fetch_array($r,MYSQL_ASSOC);
// check file system
$directory = '/data/service/invoices/$d2[display_name]/';
$url='http://mdwestserve.com/invoices/$d2[display_name]/';
$results = array();
$handler = opendir($directory);
while ($file = readdir($handler)) {
if ($file != '.' && $file != '..' && $file != 'CVS')
$pos = strpos($file, $d[case_no]);
if ($pos === false) {
//  echo "."; // too many results =)
} else {
    echo "<li><a href='$file'>$file</a></li>";
}
}
closedir($handler);
?>