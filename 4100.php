<?
// ok to print something out we will need a function to write the file and print it

function print4100($string){
	$fh = fopen("printer.tmp", 'w') or die("can't open file");
	fwrite($fh, $string);
	fclose($fh);
	system("lp -d LaserJet printer.tmp");
}



	system("lp -d LaserJet '/opt/lampp/htdocs/ps/photographs/100.1.a-1215026847.jpg'");


?>



