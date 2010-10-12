<?
include 'common.php';
/*
$user = $_COOKIE['psdata']['user_id'];
$packet = $_GET['packet'];
$ip = $_SERVER['REMOTE_ADDR'];
$attid = $user['attorneys_id'];
$id = $user['contact_id'];
$name=$_COOKIE['psdata']['name'];
if ($_POST['tab']){
$tab = $_POST['tab'];
}elseif($_GET['tab']){
$tab = $_GET['tab'];
}else{
$tab = "1";
}
logAction($_COOKIE['psdata']['user_id'], $_SERVER['PHP_SELF'], 'Viewing Photo Manager for Packet '.$packet.', Defendant '.$tab);
if ($_FILES['photo1']){
	@mysql_query("insert into ps_file_array (name, type, size, tmp_name, error, uploadDate, user) values ('".$_FILES['photo1']['name']."','".$_FILES['photo1']['type']."','".$_FILES['photo1']['size']."','".$_FILES['photo1']['tmp_name']."','".$_FILES['photo1']['error']."', NOW(), '$name' )") or die(mysql_error());
	if ($_FILES['photo1']['size'] < 3145728){
		if ($_FILES['photo1']['size'] == 0){
			$ps = id2name($_COOKIE[psdata][user_id]);
			$error = "<div>Your file size registered as zero (due to oversized files), contact 410-828-4568 for assistance.</div>";
			mail('sysop@hwestauctions.com','failed upload 0 size',$ps);
		}else{
			// ok first we need to go get the files
			$path = "photographs/";
			if (!file_exists($path)){
				mkdir ($path,0777);
			}
 
			$file_path = $path;
			if (!file_exists($file_path)){
				mkdir ($file_path,0777);
			}
			$ext = explode('.', $_FILES['photo1']['name']);
			$target_path = $file_path."/".$packet.".".$tab.".a-".time().".".$ext[1];  
			if(move_uploaded_file($_FILES['photo1']['tmp_name'], $target_path)) {
			}

			$link1 = "http://mdwestserve.com/ps/$target_path"; 
			//system("lp -s -d LaserJet '/opt/lampp/htdocs/ps/$target_path'");
			$query = "UPDATE ps_packets SET photo".$tab."a='$link1' where packet_id = '$packet'";
			@mysql_query($query);
			$ps = id2name($_COOKIE[psdata][user_id]).' '.$link1;
			mail('sysop@hwestauctions.com','photo uploaded to data entry',$ps);
		}
		}else{
			$ps = id2name($_COOKIE[psdata][user_id])."<br>".$link1;
			$error = "<div>Your file size was to large, contact 410-828-4568 for assistance.</div>";
			$message = "<table>";
			foreach($_FILES as $key => $value){
			$message .="<tr><td>$key</td><td>$value</td></tr>";
			}
			foreach($_SERVER as $key => $value){
			$message .="<tr><td>$key</td><td>$value</td></tr>";
			}
			$message .="</table>";

			mail('sysop@hwestauctions.com','failed photo upload too large',$ps.$message);
	}
	header('Location: ps_photo_manager.php?packet='.$packet.'&tab='.$tab);
}


if ($_FILES['photo2']){
	@mysql_query("insert into ps_file_array (name, type, size, tmp_name, error, uploadDate, user) values ('".$_FILES['photo2']['name']."','".$_FILES['photo2']['type']."','".$_FILES['photo2']['size']."','".$_FILES['photo2']['tmp_name']."','".$_FILES['photo2']['error']."', NOW(), '$name' )") or die(mysql_error());
	if ($_FILES['photo2']['size'] < 3145728){
		if ($_FILES['photo2']['size'] == 0){
			$ps = id2name($_COOKIE[psdata][user_id]);
			$error = "<div>Your file size registered as zero (normally due to oversized files), contact 410-828-4568 for assistance.</div>";
			mail('sysop@hwestauctions.com','failed upload 0 size',$ps);
		}else{
			// ok first we need to go get the files
			$path = "photographs/";
			if (!file_exists($path)){
				mkdir ($path,0777);
			}
 
			$file_path = $path;
			if (!file_exists($file_path)){
				mkdir ($file_path,0777);
			}
			$ext = explode('.', $_FILES['photo2']['name']);
			$target_path = $file_path."/".$packet.".".$tab.".b-".time().".".$ext[1]; 
			if(move_uploaded_file($_FILES['photo2']['tmp_name'], $target_path)) {
			}
			$link1 = "http://mdwestserve.com/ps/$target_path"; 
			//system("lp -s -d LaserJet '/opt/lampp/htdocs/ps/$target_path'");
			$query = "UPDATE ps_packets SET photo".$tab."b='$link1' where packet_id = '$packet'";
			@mysql_query($query);
			$ps = id2name($_COOKIE[psdata][user_id])." ".$link1;
			mail('sysop@hwestauctions.com','photo uploaded to data entry',$ps);
		}
	}else{
		$error = "<div>Your file size was to large, contact 410-828-4568 for assistance.</div>";
		mail('sysop@hwestauctions.com','failed photo upload too large',$ps);
	}
	header('Location: ps_photo_manager.php?packet='.$packet.'&tab='.$tab);
}
if ($_FILES['photo3']){
	@mysql_query("insert into ps_file_array (name, type, size, tmp_name, error, uploadDate, user) values ('".$_FILES['photo3']['name']."','".$_FILES['photo3']['type']."','".$_FILES['photo3']['size']."','".$_FILES['photo3']['tmp_name']."','".$_FILES['photo3']['error']."', NOW(), '$name' )") or die(mysql_error());
	if ($_FILES['photo3']['size'] < 3145728){
		if ($_FILES['photo3']['size'] == 0){
			$ps = id2name($_COOKIE[psdata][user_id]);
			$error = "<div>Your file size registered as zero (normally due to oversized files), contact 410-828-4568 for assistance.</div>";
			mail('sysop@hwestauctions.com','failed upload 0 size',$ps);
		}else{
			// ok first we need to go get the files
			$path = "photographs/";
			if (!file_exists($path)){
				mkdir ($path,0777);
			}
 
			$file_path = $path;
			if (!file_exists($file_path)){
				mkdir ($file_path,0777);
			}
			$ext = explode('.', $_FILES['photo3']['name']);
			$target_path = $file_path."/".$packet.".".$tab.".c-".time().".".$ext[1]; 
			if(move_uploaded_file($_FILES['photo3']['tmp_name'], $target_path)) {
			}
			$link1 = "http://mdwestserve.com/ps/$target_path";
			//system("lp -s -d LaserJet '/opt/lampp/htdocs/ps/$target_path'");
			$query = "UPDATE ps_packets SET photo".$tab."c='$link1' where packet_id = '$packet'";
			@mysql_query($query);
			$ps = id2name($_COOKIE[psdata][user_id])." ".$link1;
			mail('sysop@hwestauctions.com','photo uploaded to data entry',$ps);
		}
	}else{
		$error = "<div>Your file size was to large, contact 410-828-4568 for assistance.</div>";
		mail('sysop@hwestauctions.com','failed photo upload too large',$ps);
	}
	header('Location: ps_photo_manager.php?packet='.$packet.'&tab='.$tab);
}
if ($_FILES['photo4']){
	@mysql_query("insert into ps_file_array (name, type, size, tmp_name, error, uploadDate, user) values ('".$_FILES['photo4']['name']."','".$_FILES['photo4']['type']."','".$_FILES['photo4']['size']."','".$_FILES['photo4']['tmp_name']."','".$_FILES['photo4']['error']."', NOW(), '$name' )") or die(mysql_error());
	if ($_FILES['photo4']['size'] < 3145728){
		if ($_FILES['photo4']['size'] == 0){
			$ps = id2name($_COOKIE[psdata][user_id]);
			$error = "<div>Your file size registered as zero (normally due to oversized files), contact 410-828-4568 for assistance.</div>";
			mail('sysop@hwestauctions.com','failed upload 0 size',$ps);
		}else{
			// ok first we need to go get the files
			$path = "photographs/";
			if (!file_exists($path)){
				mkdir ($path,0777);
			}
 
			$file_path = $path;
			if (!file_exists($file_path)){
				mkdir ($file_path,0777);
			}
			$ext = explode('.', $_FILES['photo4']['name']);
			$target_path = $file_path."/".$packet.".".$tab.".d-".time().".".$ext[1]; 
			//system("lp -s -d LaserJet '/opt/lampp/htdocs/ps/$target_path'");
			if(move_uploaded_file($_FILES['photo4']['tmp_name'], $target_path)) {
			}
			$link1 = "http://mdwestserve.com/ps/$target_path"; 
			$query = "UPDATE ps_packets SET photo".$tab."d='$link1' where packet_id = '$packet'";
			@mysql_query($query);
			$ps = id2name($_COOKIE[psdata][user_id])." ".$link1;
			mail('sysop@hwestauctions.com','photo uploaded to data entry',$ps);
		}
	}else{
		$error = "<div>Your file size was to large, contact 410-828-4568 for assistance.</div>";
		mail('sysop@hwestauctions.com','failed photo upload too large',$ps);
	}
	header('Location: ps_photo_manager.php?packet='.$packet.'&tab='.$tab);
}
if ($_FILES['photo5']){
	@mysql_query("insert into ps_file_array (name, type, size, tmp_name, error, uploadDate, user) values ('".$_FILES['photo5']['name']."','".$_FILES['photo5']['type']."','".$_FILES['photo5']['size']."','".$_FILES['photo5']['tmp_name']."','".$_FILES['photo5']['error']."', NOW(), '$name' )") or die(mysql_error());
	if ($_FILES['photo5']['size'] < 3145728){
		if ($_FILES['photo5']['size'] == 0){
			$ps = id2name($_COOKIE[psdata][user_id]);
			$error = "<div>Your file size registered as zero (normally due to oversized files), contact 410-828-4568 for assistance.</div>";
			mail('sysop@hwestauctions.com','failed upload 0 size',$ps);
		}else{
			// ok first we need to go get the files
			$path = "photographs/";
			if (!file_exists($path)){
				mkdir ($path,0777);
			}
 
			$file_path = $path;
			if (!file_exists($file_path)){
				mkdir ($file_path,0777);
			}
			$ext = explode('.', $_FILES['photo5']['name']);
			$target_path = $file_path."/".$packet.".".$tab.".e-".time().".".$ext[1]; 
			if(move_uploaded_file($_FILES['photo5']['tmp_name'], $target_path)) {
			}
			$link1 = "http://mdwestserve.com/ps/$target_path"; 
			//system("lp -s -d LaserJet '/opt/lampp/htdocs/ps/$target_path'");
			$query = "UPDATE ps_packets SET photo".$tab."e='$link1' where packet_id = '$packet'";
			@mysql_query($query);
			$ps = id2name($_COOKIE[psdata][user_id])." ".$link1;
			mail('sysop@hwestauctions.com','photo uploaded to data entry',$ps);
		}
	}else{
		$error = "<div>Your file size was to large, contact 410-828-4568 for assistance.</div>";
		mail('sysop@hwestauctions.com','failed photo upload too large',$ps);
	}
	header('Location: ps_photo_manager.php?packet='.$packet.'&tab='.$tab);
}
*/
include 'menu.php'; 
/*
$q="SELECT * FROM ps_packets WHERE packet_id = '$packet'";
$r=@mysql_query($q);
$d=mysql_fetch_array($r, MYSQL_ASSOC);
if ($tab == "2"){
	$name = $d[name2];
	$add1 = $d[address2].'<br>'.$d[city2].', '.$d[state2].' '.$d[zip2];
	$add1x = $d[address2].' '.$d[city2].', '.$d[state2].' '.$d[zip2];
	if ($d[address2a] != ''){
		$add1a=$d[address2a].'<br>'.$d[city2a].', '.$d[state2a].' '.$d[zip2a];
		$add1ax=$d[address2a].' '.$d[city2a].', '.$d[state2a].' '.$d[zip2a];
	}
	if ($d[address2b] != ''){
		$add1b=$d[address2b].'<br>'.$d[city2b].', '.$d[state2b].' '.$d[zip2b];
		$add1bx=$d[address2b].' '.$d[city2b].', '.$d[state2b].' '.$d[zip2b];
	}
} elseif ($tab == "3"){
	$name = $d[name3];
	$add1 = $d[address3].'<br>'.$d[city3].', '.$d[state3].' '.$d[zip3];
	$add1x = $d[address3].' '.$d[city3].', '.$d[state3].' '.$d[zip3];
	if ($d[address3a] != ''){
		$add1a=$d[address3a].'<br>'.$d[city3a].', '.$d[state3a].' '.$d[zip3a];
		$add1ax=$d[address3a].' '.$d[city3a].', '.$d[state3a].' '.$d[zip3a];
	}
	if ($d[address3b] != ''){
		$add1b=$d[address3b].'<br>'.$d[city3b].', '.$d[state3b].' '.$d[zip3b];
		$add1bx=$d[address3b].' '.$d[city3b].', '.$d[state3b].' '.$d[zip3b];
	}
} elseif ($tab == "4"){
	$name = $d[name4];
	$add1 = $d[address4].'<br>'.$d[city4].', '.$d[state4].' '.$d[zip4];
	$add1x = $d[address4].' '.$d[city4].', '.$d[state4].' '.$d[zip4];
	if ($d[address4a] != ''){
		$add1a=$d[address4a].'<br>'.$d[city4a].', '.$d[state4a].' '.$d[zip4a];
		$add1ax=$d[address4a].' '.$d[city4a].', '.$d[state4a].' '.$d[zip4a];
	}
	if ($d[address4b] != ''){
		$add1b=$d[address4b].'<br>'.$d[city4b].', '.$d[state4b].' '.$d[zip4b];
		$add1bx=$d[address4b].' '.$d[city4b].', '.$d[state4b].' '.$d[zip4b];
	}
} else {
	$name = $d[name1];
	$add1 = $d[address1].'<br>'.$d[city1].', '.$d[state1].' '.$d[zip1];
	$add1x = $d[address1].' '.$d[city1].', '.$d[state1].' '.$d[zip1];
	if ($d[address1a] != ''){
		$add1a=$d[address1a].'<br>'.$d[city1a].', '.$d[state1a].' '.$d[zip1a];
		$add1ax=$d[address1a].' '.$d[city1a].', '.$d[state1a].' '.$d[zip1a];
	}
	if ($d[address1b] != ''){
		$add1b=$d[address1b].'<br>'.$d[city1b].', '.$d[state1b].' '.$d[zip1b];
		$add1bx=$d[address1b].' '.$d[city1b].', '.$d[state1b].' '.$d[zip1b];
	}
}
?>
<style>
a.ser{color:#FFFFFF; text-decoration:none;}
a.ser:hover{color:#FF0000; text-decoration:none;}
a.spo{text-decoration:none;}
a.spu{text-decoration:none; font-size:15px;}
</style>

<?
include 'ps_defendant_tabs2.php';

?>

<table border="1" width="900px" style="border-collapse:collapse;" cellpadding="0" align="center"><tr><td>

            <div id="tabinfo" style="height:208px; width:550px; padding-left:5px; padding-right:5px; background-color:#CC99FF; overflow:auto">
    <table align="center" width="100%" vspace="90%">
    <form name="select" id="select" method="get">
    <input type="hidden" name="defendant" value="<?=$name?>" />
    <input type="hidden" name="tab" value="<?=$tab?>"  />
    <input type="hidden" name="packet" value="<?=$packet?>" />

    	<tr valign="bottom" align="center">
            	<td><? if (($d[server_id] == $user || $d[server_ida] == $user) && $d[process_status] == "ASSIGNED"){?>
                <select onchange="this.form.submit();" name="action">
                <option>Select From Below</option>
                <? if ($d[server_id] && !$d[server_ida]){ ?>
                <option>Upload First Service Photo</option><option>Upload Second Service Photo</option><option>Upload Posted Property Photo</option>
				<? }elseif($d[server_ida] && $user=$d[server_ida]){ ?>
                <option>Upload First Service Photo</option><option>Upload Second Service Photo</option>
				<? }elseif($d[server_ida] && $user=$d[server_id]){ ?>
                <option>Upload Posted Property Photo</option>
                <? }elseif($d[server_idb] && $user=$d[server_idb]){ ?>
                <option value="Upload Service Photo D">Upload First Service Photo</option><option value="Upload Service Photo E">Upload Second Service Photo</option>
				<? } ?>
                </select>
				<? }?></td>
        </tr>
    </form>
    </table>
</div></td>
<td rowspan="2">
        <div id="photos" style="height:473px; width:405px; overflow:auto; background-color:#FFCC99">
        <center>
        <?
    if ($d["photo".$tab."a"]){
		$pic = explode('http://mdwestserve.com/ps/photographs//',$d['photo'.$tab.'a']);
		echo "<br><iframe frameborder='0' scrolling='no' width='150' height='150' src='watermark.php?pic=$pic[1]'></iframe>";
	}
	if ($d["photo".$tab."b"]){
		$pic = explode('http://mdwestserve.com/ps/photographs//',$d['photo'.$tab.'b']);
		echo "<br><iframe frameborder='0' scrolling='no' width='150' height='150' src='watermark.php?pic=$pic[1]'></iframe>";
	}
	if ($d["photo".$tab."c"]){
		$pic = explode('http://mdwestserve.com/ps/photographs//',$d['photo'.$tab.'c']);
		echo "<br><iframe frameborder='0' scrolling='no' width='150' height='150' src='watermark.php?pic=$pic[1]'></iframe>";
	}
		if ($d["photo".$tab."d"]){
		$pic = explode('http://mdwestserve.com/ps/photographs//',$d['photo'.$tab.'d']);
		echo "<br><iframe frameborder='0' scrolling='no' width='150' height='150' src='watermark.php?pic=$pic[1]'></iframe>";
	}
		if ($d["photo".$tab."e"]){
		$pic = explode('http://mdwestserve.com/ps/photographs//',$d['photo'.$tab.'e']);
		echo "<br><iframe frameborder='0' scrolling='no' width='150' height='150' src='watermark.php?pic=$pic[1]'></iframe>";
	}
		?>
        </center>
        </div></td></tr>
<tr><td>
<div id="update" style="height:250px; width:550px; padding:5px; background-color:#99CCFF">
<? if($_GET[action] == 'Upload First Service Photo'){
?>
			<br />

			<table align="center" width="100%" vspace="90%">
            <form enctype="multipart/form-data" method="post" name="photoupload1">
            <input type="hidden" name="defendant" value="<?=$name?>" />
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
            <input type="hidden" name="case_no" value="<?=$d[case_no]?>" />
            <input type="hidden" name="tab" value="<?=$tab?>" />
            <input type="hidden" name="packet" value="<?=$packet?>" />
				<tr>
                	<td align="center"><input size="50" name="photo1" type="file" /></td>
                </tr>

	            <tr align="center">
    	        	<td colspan="2"><input type="submit" name="submit" value="Upload First Service Photo" /></td>
        	    </tr>
            </form>
            </table> 
<?
}elseif($_GET[action] == 'Upload Second Service Photo'){
?>
			<br />
			<table align="center" width="100%">
            <form enctype="multipart/form-data" method="post" name="photoupload2">
            <input type="hidden" name="defendant" value="<?=$name?>" />
            <input type="hidden" name="case_no" value="<?=$d[case_no]?>" />
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
            <input type="hidden" name="tab" value="<?=$tab?>" />
            <input type="hidden" name="packet" value="<?=$packet?>" />
				<tr>
                	<td align="center"><input size="50" name="photo2" type="file" /></td>
                </tr>
	            <tr align="right">
    	        	<td colspan="2"><input type="submit" name="submit" value="Upload Second Service Photo" /></td>
        	    </tr>
            </form>
            </table> 
<?
}elseif($_GET[action] == 'Upload Posted Property Photo'){
?>
			<br />
			<table align="center" width="100%">
            <form enctype="multipart/form-data" method="post" name="photoupload3">
            <input type="hidden" name="defendant" value="<?=$name?>" />
            <input type="hidden" name="case_no" value="<?=$d[case_no]?>" />
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
            <input type="hidden" name="tab" value="<?=$tab?>" />
            <input type="hidden" name="packet" value="<?=$packet?>" />
				<tr>
                	<td align="center"><input size="50" name="photo3" type="file" /></td>
                </tr>
	            <tr align="right">
    	        	<td colspan="2"><input type="submit" name="submit" value="Upload Posted Property Photo" /></td>
        	    </tr>
            </form>
            </table> 
<?
}elseif($_GET[action] == 'Upload Service Photo D'){
?>
			<br />
			<table align="center" width="100%">
            <form enctype="multipart/form-data" method="post" name="photoupload4">
            <input type="hidden" name="defendant" value="<?=$name?>" />
            <input type="hidden" name="case_no" value="<?=$d[case_no]?>" />
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
            <input type="hidden" name="tab" value="<?=$tab?>" />
            <input type="hidden" name="packet" value="<?=$packet?>" />
				<tr>
                	<td align="center"><input size="50" name="photo4" type="file" /></td>
                </tr>
	            <tr align="right">
    	        	<td colspan="2"><input type="submit" name="submit" value="Upload First Service Photo" /></td>
        	    </tr>
            </form>
            </table> 
<?
}elseif($_GET[action] == 'Upload Service Photo E'){
?>
			<br />
			<table align="center" width="100%">
            <form enctype="multipart/form-data" method="post" name="photoupload5">
            <input type="hidden" name="defendant" value="<?=$name?>" />
            <input type="hidden" name="case_no" value="<?=$d[case_no]?>" />
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
            <input type="hidden" name="tab" value="<?=$tab?>" />
            <input type="hidden" name="packet" value="<?=$packet?>" />
				<tr>
                	<td align="center"><input size="50" name="photo5" type="file" /></td>
                </tr>
	            <tr align="right">
    	        	<td colspan="2"><input type="submit" name="submit" value="Upload Second Service Photo" /></td>
        	    </tr>
            </form>
            </table> 
<?
}else{
?>
        <table align="center" width="100%">
			<tr>
            	<td align="center"><strong>Please select an action from the drop-down menu.</strong></td>
            </tr>
        </table>
<? } ?>        
        </div></td></tr></table>
        
<? include 'updateTabs.php';?>
*/
?>
<a href="wizard.php">Photos are now uploaded through the wizard!</a>

<? include 'footer.php';?>