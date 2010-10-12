<?
function getFolder($otd){
	$path=explode("/",$otd);
	$count=(count($path)-2);
	$folder=$path["$count"];
	return $folder;
}
if ($_GET[autoSave] == 1){
	ob_start();
}
include 'common.php';
$user = $_COOKIE[psdata][user_id];
$packet = $_GET[packet];
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Service Instructions for Packet '.$packet);
$query="SELECT attorneys_id FROM standard_packets WHERE packet_id='$packet'";
$result=@mysql_query($query);
$data=mysql_fetch_array($result,MYSQL_ASSOC);
if($data[attorneys_id] == '56'){
	if ($_GET['autoSave'] == 1){
		$typeC = getPage("http://service.mdwestserve.com/s_instructions.brennan.php?packet=$packet&noField=1", 'MDWS Instructions Type C', '5', '');
	}else{
		$typeC = getPage("http://service.mdwestserve.com/s_instructions.brennan.php?packet=$packet", 'MDWS Instructions Type C', '5', '');
	}
	echo $typeC;
}elseif($data[attorneys_id] == '1'){
	if ($_GET['autoSave'] == 1){
		$typeB = getPage("http://service.mdwestserve.com/s_instructions.burson.php?packet=$packet&noField=1", 'MDWS Instructions Type B', '5', '');
	}else{
		$typeB = getPage("http://service.mdwestserve.com/s_instructions.burson.php?packet=$packet", 'MDWS Instructions Type B', '5', '');
	}
	echo $typeB;
}elseif($data[attorneys_id] == '70'){
	if ($_GET['autoSave'] == 1){
		$typeD = getPage("http://service.mdwestserve.com/s_instructions.bgw.php?packet=$packet&noField=1", 'MDWS Instructions Type D', '5', '');
	}else{
		$typeD = getPage("http://service.mdwestserve.com/s_instructions.bgw.php?packet=$packet", 'MDWS Instructions Type D', '5', '');
	}
	echo $typeD;
}else{
	if ($_GET['autoSave'] == 1){
		$typeA = getPage("http://service.mdwestserve.com/s_instructions.php?packet=$packet&noField=1", 'MDWS Instructions Type A', '5', '');
	}else{
		$typeA = getPage("http://service.mdwestserve.com/s_instructions.php?packet=$packet", 'MDWS Instructions Type A', '5', '');
	}
	echo $typeA;
}
if ($_GET['autoSave'] == 1){
	$query3="SELECT packet_id, otd FROM standard_packets WHERE packet_id='$packet'";
	$result3=@mysql_query($query3);
	$data3=mysql_fetch_array($result3,MYSQL_ASSOC);
	$contents=ob_get_clean();
	$folder=getFolder($data3['otd']);
	require_once("/thirdParty/dompdf-0.5.1/dompdf_config.inc.php");
	$html = stripslashes($contents);
	$old_limit = ini_set("memory_limit", "50M");
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	echo $html;
	$dompdf->set_paper('letter', 'portrait');
	$dompdf->render();
	echo "2!";
	$unique = '/data/service/orders/'.$folder.'/Service Instructions For Packet '.$data3['packet_id'].'.PDF';
	echo "1!";
	echo $folder;
	file_put_contents($unique, $dompdf->output()); //save to disk
	echo "<script>window.open('instructionSave.php?packet=".$data3['packet_id']."&folder=".$folder."');</script>";
}
mysql_close();
?>