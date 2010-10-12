<?
$folder=$_GET[folder];
$packet=$_GET[packet];
$unique = '/data/service/orders/'.$folder.'/Service Instructions For Packet '.$packet.'.PDF';
if (file_exists($unique)) {
		header('Content-Disposition: attachment; filename="Service Instructions For Packet '.$packet.'.PDF"');
		readfile($unique);
		echo "<script>self.close();</script>";
	}else{
		echo "<center>".$unique." does not exist.</center><br>";
	}
?>