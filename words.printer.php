<?
include_once '/opt/lampp/htdocs/common/functions.php';
$print = lpwords('OTD','0',' ')		;
$print .= lpwords('ORDER','0',' ')	;	
$print .= lpwords('ERROR','0',' ')	;	
$fh = fopen("offsite.log", 'w') or die("can't open file");
fwrite($fh, $print);
fclose($fh);
system("lp -d LaserJet offsite.log");
?>