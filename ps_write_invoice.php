<?
mysql_connect ();
mysql_select_db ('core');
$r=@mysql_query("select attorneys_id, case_no, client_file from ps_packets where packet_id = '$_GET[id]' ");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$r=@mysql_query("select display_name from attorneys where attorneys_id = '$d[attorneys_id]' ");
$d2=mysql_fetch_array($r,MYSQL_ASSOC);
// check file system
$directory = '/data/service/invoices/'.$d2[display_name].'/';
$url='http://mdwestserve.com/serviceInvoices/'.$d2[display_name];
$results = array();
$handler = opendir($directory);
while ($file = readdir($handler)) {
if ($file != '.' && $file != '..' && $file != 'CVS'){
$pos = strpos($file, $d[case_no]);
if ($pos === false) {
// all invoices for this case number
} else {
    echo "<li><a href='$url/$file' target='_Blank'>Invoice (c): $file</a></li>";
}
$pos = strpos($file, $d[client_file]);
if ($pos === false) {
//  only match client file number
} else {
$pos = strpos($file,'SERVER');
if ($pos === false) {
    echo "<li><a href='$url/$file' target='_Blank'>Invoice (f): $file</a></li>";
} else {
 // make sure we don't list any server invoices circa early 2008
}
}
}
}
closedir($handler);
?>