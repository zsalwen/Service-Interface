<? include 'common.php';
$search = $_GET['q'];
include 'lock.php';
 
?>
<? include 'menu.php'; if ($_GET['q']){?>
<style>a {text-decoration:none} a:hover {text-decoration:underline overline;}</style>
<div style="font-size:24px; border:solid 1px;" align="center">Running complete search of process serving files and users for <?=$search?></div>
<? 
function systemLookup($field, $query){ 
	if ($_GET[field] == 'client_file'){
		$q2="client_file like '%$query%'";
	}elseif($_GET[field] == 'case_no'){
		$q2="case_no like '%$query%'";
	}elseif($_GET[field] == 'packet_id'){
		$q2="packet_id like '%$query%'";
	}elseif($_GET[field] == 'name'){
		$q2="name1 like '%$query%' OR name2 like '%$query%' OR name3 like '%$query%' OR name4 like '%$query%' OR name5 like '%$query%' OR name6 like '%$query%'";
	}else{
		//field=address
		$q2="address1 like '%$query%' OR address1a like '%$query%' OR address1b like '%$query%' OR address1c like '%$query%' OR address1d like '%$query%' OR address1e like '%$query%'";
	}
	$r=@mysql_query("select * from ps_packets where ".$q2);
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		if ($d[packet_id]){
			?>
			<div style="border:solid 1px;">
			<div style="font-size:16px; text-align:center;"><?=$d[packet_id]?> <strong><?=$d[status]?></strong>  
            :: <a href="affidavitUpload.php?packet=<?=$d[packet_id]?>">Document Upload Manager</a> 
            :: <a href="order.php?packet=<?=$d[packet_id]?>">Service Order</a> 
            ::  <a href="dataSheet.php?id=<?=$d[packet_id]?>">Data Sheet</a> 
            :: <a href="customInstructions.php?packet=<?=$d[packet_id]?>">Service Instructions</a> 
            :: <a href="hardcopy.php?packet=<?=$d[packet_id]?>">Hard Copy</a>
            </div><div style="font-size:12px"><li>Found string '<?=$d[$field]?>' in delta.mdwestserve.com.intranet.ps_packets.<?=$field?></li></div>
</div>
			<?
		}
	} 
}
//$q="SHOW FIELDS FROM ps_packets";
//$r=@mysql_query($q);
//$i = 0;
//while ($row = mysql_fetch_array($r)){
	systemLookup($_GET['field'], $search);
//}


function systemLookup2($field, $query){ 
	$r=@mysql_query("select * from ps_users where $field like '%$query%'");
	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
		if ($d[id]){
			?>
			<div style="font-size:18px">Found string '<?=$d[$field]?>' in delta.mdwestserve.com.intranet.ps_users.<?=$field?></div>
			<div style="font-size:16px; padding-left:50px;">User #<?=$d[id]?> :: <a href="contractor_review.php?admin=<?=$d[id]?>">Go to the Contractor Review</a></div>
			<?
		}
	} 
}
//$q="SHOW FIELDS FROM ps_users";
//$r=@mysql_query($q);
//$i = 0;
//while ($row = mysql_fetch_array($r)){
//	systemLookup2($_GET['field'], $search);
//}
}
?>
<form><input name="q" /> <select name="field">
		<option value="client_file">File Number</option>
		<option value="packet_id">Packet Number</option>
		<option value="case_no">Case Number</option>
		<option value="name">Name</option>
		<option value="address">Address</option>
	</select> <input type="submit" value="Search Service Records" /></form>
<?

include 'footer.php';?>
