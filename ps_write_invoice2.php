<?
// client invoice to print | email?



// common in each pdf
ini_set("memory_limit","12M");
error_reporting(E_ALL);
set_time_limit(1800);
include 'class.ezpdf.php';
// let's set the page size and the margins
$pdf =& new Cezpdf('LETTER','portrait');
$pdf -> ezSetMargins(50,70,50,50);
function addNote($id,$note){
	$q1 = "SELECT notes FROM schedule_items WHERE schedule_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	$d1 = mysql_fetch_array($r1, MYSQL_ASSOC);
	$notes = $note.", ".$d1['notes'];
	$notes = addslashes($notes);
	$q1 = "UPDATE schedule_items set notes='$notes' WHERE schedule_id = '$id'";		
	//$r1 = @mysql_query ($q1) or die(mysql_error());
}

function dbout($full){
	$split = str_split($full);
	$out['year'] = $split[0].$split[1].$split[2].$split[3];
	$out['month'] = $split[4].$split[5];
	$out['day'] = $split[6].$split[7];
	return $out;
}

function db_connect($host,$database,$user,$password){
	$step1 = @mysql_connect ();
	$step2 = mysql_select_db ($database);
	return mysql_error();
}
db_connect('192.168.1.101','core','root','zerohour');


function log_action($user_id,$action){
	$user_id = $_COOKIE['userdata']['user_id'];
	$q1 = "INSERT INTO activity_log (user_id, action, action_on) VALUES ( '$user_id', '$action', NOW() )";		
	//$r1 = @mysql_query ($q1) or die(mysql_error());
}


// put a line top and bottom on all the pages, this is done in layers from top lowest built up
$all = $pdf->openObject();
$pdf->saveState();
$pdf->addJpegFromFile('../templates/logo3.jpg',0,$pdf->y-110,600,150); // add an image file in the common footer
$pdf->ezSetDy(-110); //gives us a buffer under the header
$pdf->setStrokeColor(0,0,0,1);
$pdf->line(20,40,578,40); // bottem line
$pdf->line(20,680,578,680); //top line
$pdf->restoreState();
$pdf->closeObject();
$pdf->addObject($all,'all'); // place on all pages
// define the font's here
$mainFont = 'fonts/Times-Roman.afm';
$codeFont = 'fonts/Courier.afm';
// set the font
$pdf->selectFont($mainFont);
$data = array();
$pdf->openHere('Fit'); // this set's where we want to open the pdf and at what zoom
$pdf->line(20,635,578,635);  // above attorney
$pdf->line(20,570,578,570); // under attorney
//$pdf->line(300,570,300,510); // LINE BETWEEN ADDRESS AND DETAILS
$pdf->line(20,570,578,570); // under attorney
//$pdf->line(20,510,578,510); // under address
$pdf->line(20,550,578,550); // under desc / totals
$pdf->line(20,255,578,255); // under advertising
$pdf->line(20,225,578,225); // under amount due
$pdf->addTextWrap(160,650,500,20,'INVOICE: PROCESS SERVING');

$id=$_GET[id];
$q = "SELECT * FROM ps_packets, attorneys WHERE ps_packets.attorneys_id = attorneys.attorneys_id AND packet_id = '$id'";
$r = @mysql_query ($q) or die(mysql_error());
$data = mysql_fetch_array($r, MYSQL_ASSOC);


$mail_address = explode('-',$data['address']);
$mail_address1 = trim($mail_address[0]);
$mail_address2 = trim($mail_address[1]);
$mail_address3 = trim($mail_address[2]);
$mail_address4 = trim($mail_address[3]);

$a = "SELECT name FROM ps_users where id = '".$data['server_id']."'";
$b = @mysql_query($a);
$c = mysql_fetch_array($b, MYSQL_ASSOC);

$pdf->addText(50,32,8,'Harvey West Auctioneers - MDWestServe.com - '.date('l, F jS Y g:iA'));

$pdf->addTextWrap(20,620,300,15,$mail_address1);								
$pdf->addTextWrap(20,605,300,15,$mail_address2);								
$pdf->addTextWrap(20,590,300,15,$mail_address3);								
$pdf->addTextWrap(20,575,300,15,$mail_address4);								


$pdf->addTextWrap(305,610,300,15,'Server Packet: #'.$data['packet_id']);								
$pdf->addTextWrap(305,595,300,15,'File Number: '.$data['client_file']);								
$pdf->addTextWrap(305,580,300,15,'Civil Case Number: '.$data['case_no']);								




$pdf->addTextWrap(40,555,300,15,'SERVICE');								
$pdf->addTextWrap(500,555,300,15,'TOTALS');								




$total=0;


$pdf->addTextWrap(210,555,300,10,'FILE RECEIVED: '.$data['date_received']);								

$mail_count='';
$add='';
if ($data['name1']){
$pdf->addTextWrap(40,535,300,15,strtoupper($data['name1']));
$pdf->addTextWrap(50,520,300,13,strtoupper($data['address1'].', '.$data['city1'].', '.$data['state1'].' '.$data['zip1']));	
$pdf->addTextWrap(500,520,300,13,'$'.$data['client_rate']);	
$add=$data['client_rate'] ;
$mail_count++;
if ($data['address1a']){
	$pdf->addTextWrap(50,505,300,13,strtoupper($data['address1a'].', '.$data['city1a'].', '.$data['state1a'].' '.$data['zip1a']));	
	$mail_count++;
	if ($data['client_ratea']){
		$add= $add+$data['client_ratea'];
		$pdf->addTextWrap(500,505,300,13,'$'.$data['client_ratea']);	
	}else{
		$add= $add+$data['client_rate'];
		$pdf->addTextWrap(500,505,300,13,'$'.$data['client_rate']);	
	}
	
}
if ($data['address1b']){
	$pdf->addTextWrap(50,490,300,13,strtoupper($data['address1b'].', '.$data['city1b'].', '.$data['state1b'].' '.$data['zip1b']));	
	$mail_count++;
	if ($data['client_rateb']){
		$add= $add+$data['client_rateb'];
		$pdf->addTextWrap(500,490,300,13,'$'.$data['client_rateb']);	
	}elseif($data['client_ratea']){
		$add= $add+$data['client_ratea'];
		$pdf->addTextWrap(500,490,300,13,'$'.$data['client_ratea']);	
	}else{
		$add= $add+$data['client_rate'];
		$pdf->addTextWrap(500,490,300,13,'$'.$data['client_rate']);	
	}
}
//$pdf->addTextWrap(500,535,300,15,'$'.$add);	
$total = $total+$add; 
}
$add='';

//x2
if ($data['name2']){
$pdf->addTextWrap(40,475,300,15,strtoupper($data['name2']));
$pdf->addTextWrap(50,460,300,13,strtoupper($data['address2'].', '.$data['city2'].', '.$data['state2'].' '.$data['zip2']));	
$pdf->addTextWrap(500,460,300,13,'$'.$data['client_rate']);	
$add=$data['client_rate'];
$mail_count++;							
if ($data['address2a']){
	$pdf->addTextWrap(50,445,300,13,strtoupper($data['address2a'].', '.$data['city2a'].', '.$data['state2a'].' '.$data['zip2a']));	
	$mail_count++;
	if ($data['client_ratea']){
		$add=$add+$data['client_ratea'];
		$pdf->addTextWrap(500,445,300,13,'$'.$data['client_ratea']);	
	}else{
		$add=$add+$data['client_rate'];
		$pdf->addTextWrap(500,445,300,13,'$'.$data['client_rate']);	
	}
}
if ($data['address2b']){
	$pdf->addTextWrap(50,430,300,13,strtoupper($data['address2b'].', '.$data['city2b'].', '.$data['state2b'].' '.$data['zip2b']));	
	$mail_count++;
	if ($data['client_rateb']){
		$add=$add+$data['client_rateb'];
		$pdf->addTextWrap(500,430,300,13,'$'.$data['client_rateb']);	
	}elseif($data['client_ratea']){
		$add=$add+$data['client_ratea'];
		$pdf->addTextWrap(500,430,300,13,'$'.$data['client_ratea']);	
	}else{
		$add=$add+$data['client_rate'];
		$pdf->addTextWrap(500,430,300,13,'$'.$data['client_rate']);	
	}
}
//$pdf->addTextWrap(500,475,300,15,'$'.$add);	
$total = $total+$add; 
}
$add='';

//x3
if ($data['name3']){
$pdf->addTextWrap(40,415,300,15,strtoupper($data['name3']));
$pdf->addTextWrap(50,400,300,13,strtoupper($data['address3'].', '.$data['city3'].', '.$data['state3'].' '.$data['zip3']));	
$pdf->addTextWrap(500,400,300,13,'$'.$data['client_rate']);	
$mail_count++;
$add=$data['client_rate'];
if ($data['address3a']){
	$pdf->addTextWrap(50,385,300,13,strtoupper($data['address3a'].', '.$data['city3a'].', '.$data['state3a'].' '.$data['zip3a']));	
	$mail_count++;
	if ($data['client_ratea']){
		$add=$add+$data['client_ratea'];
		$pdf->addTextWrap(500,385,300,13,'$'.$data['client_ratea']);	
	}else{
		$add=$add+$data['client_rate'];
		$pdf->addTextWrap(500,385,300,13,'$'.$data['client_rate']);	
	}
}
if ($data['address3b']){
	$pdf->addTextWrap(50,370,300,13,strtoupper($data['address3b'].', '.$data['city3b'].', '.$data['state3b'].' '.$data['zip3b']));	
	$mail_count++;
	if ($data['client_rateb']){
		$add=$add+$data['client_rateb'];
		$pdf->addTextWrap(500,370,300,13,'$'.$data['client_rateb']);	
	}elseif($data['client_ratea']){
		$add=$add+$data['client_ratea'];
		$pdf->addTextWrap(500,370,300,13,'$'.$data['client_ratea']);	
	}else{
		$add=$add+$data['client_rate'];
		$pdf->addTextWrap(500,370,300,13,'$'.$data['client_rate']);	
	}
}
//$pdf->addTextWrap(500,415,300,15,'$'.$add);	
$total = $total+$add; 
}
$add='';

//x4
if ($data['name4']){
$pdf->addTextWrap(40,355,300,15,strtoupper($data['name4']));
$pdf->addTextWrap(50,340,300,13,strtoupper($data['address4'].', '.$data['city4'].', '.$data['state4'].' '.$data['zip4']));	
$mail_count++;
$add=$data['client_rate'];
$pdf->addTextWrap(500,340,300,13,'$'.$data['client_rate']);	
	
if ($data['address4a']){
	$pdf->addTextWrap(50,325,300,13,strtoupper($data['address4a'].', '.$data['city4a'].', '.$data['state4a'].' '.$data['zip4a']));	
	$mail_count++;
	if ($data['client_ratea']){
		$add=$add+$data['client_ratea'];
		$pdf->addTextWrap(500,325,300,13,'$'.$data['client_ratea']);	
	}else{
		$add=$add+$data['client_rate'];
		$pdf->addTextWrap(500,325,300,13,'$'.$data['client_rate']);	
	}
}
if ($data['address4b']){
	$pdf->addTextWrap(50,310,300,13,strtoupper($data['address4b'].', '.$data['city4b'].', '.$data['state4b'].' '.$data['zip4b']));	
	$mail_count++;
	if ($data['client_rateb']){
		$add=$add+$data['client_rateb'];
		$pdf->addTextWrap(500,310,300,13,'$'.$data['client_rateb']);	
	}elseif($data['client_ratea']){
		$add=$add+$data['client_ratea'];
		$pdf->addTextWrap(500,310,300,13,'$'.$data['client_ratea']);	
	}else{
		$add=$add+$data['client_rate'];
		$pdf->addTextWrap(500,310,300,13,'$'.$data['client_rate']);
	}
}
//$pdf->addTextWrap(500,355,300,15,'$'.$add);	
$total = $total+$add; 
}

$crr = "Mailed First Class and Certified Return Receipt";
$fc = "Mailed First Class";

if($data['mail_status'] == $crr){
	$mail_cost = 25 * $mail_count;
	$pdf->addTextWrap(40,290,300,13,strtoupper($crr));								
	$pdf->addTextWrap(500,290,300,13,'$'.$mail_cost);								
	$total = $total + $mail_cost;
}

if($data['mail_status'] == $fc){
	$def_count=0;
	if ($data['name1']){ $def_count++; }
	if ($data['name2']){ $def_count++; }
	if ($data['name3']){ $def_count++; }
	if ($data['name4']){ $def_count++; }
	$mail_cost = 10 * $def_count;
	$pdf->addTextWrap(40,290,300,13,strtoupper($fc));								
	$pdf->addTextWrap(500,290,300,13,'$'.$mail_cost);								
	$total = $total + $mail_cost;
}

if (($data['filing_status'] != 'CANCELLED') && ($data['process_status'] != 'CANCELLED') && ($data['process_status'] != 'PENDING CANCELLATION') && ($data['status'] != 'CANCELLED')){
	$pdf->addTextWrap(40,270,300,13,'FILE AND RETURN - '.$data['circuit_court']);								
	$pdf->addTextWrap(500,270,300,13,'$25');
	$total = $total + 25;
}



$pdf->addTextWrap(40,235,300,15,$data['service_status']." DUE:");								
$pdf->addTextWrap(500,235,300,15,'$'.$total);								

$pdf->addTextWrap(300,110,300,15,'MAKE ALL CHECKS PAYABLE TO');								
$pdf->addTextWrap(340,95,300,15,'Harvey West Auctioneers');								
$pdf->addTextWrap(340,80,300,15,'300 East Joppa Road');								
$pdf->addTextWrap(340,65,300,15,'Hampton Plaza - Suite 1103');								
$pdf->addTextWrap(340,50,300,15,'Baltimore, MD 21286');								

$pdfcode = $pdf->ezOutput();

$dir = './invoices';
if (!file_exists($dir)){
	mkdir ($dir,0777);
}

$dir = './invoices/'.$data["display_name"];
$dir2 = 'invoices/'.$data["display_name"];
if (!file_exists($dir)){
	mkdir ($dir,0777);
}

if ($data["attorneys_id"] == 1 || $data["attorneys_id"] == 44){
$filename = $data["client_file"].'-'.$data["date_received"]."-"."CLIENT.PDF";
}else{
$filename = $data["case_no"]."-"."CLIENT.PDF";
}

$fname = $dir.'/'.$filename;
$fp = fopen($fname, 'w');
fwrite($fp, $pdfcode);
fclose($fp);
?>
<script>window.open('<?=$fname?>',   'invoice<?=$id?>',   'width=600, height=800'); </script>