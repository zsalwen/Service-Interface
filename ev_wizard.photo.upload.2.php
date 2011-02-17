<?
function alpha2ID($alpha){
	if ($alpha == 'a'){ return "1";}
	if ($alpha == 'b'){ return "1"; }
	if ($alpha == 'c'){ return "1"; }
	if ($alpha == 'd'){ return "2"; }
	if ($alpha == 'e'){ return "2"; }
	if ($alpha == 'f'){ return "3"; }
	if ($alpha == 'g'){ return "3"; }
	if ($alpha == 'h'){ return "4"; }
	if ($alpha == 'i'){ return "4"; }
	if ($alpha == 'j'){ return "5"; }
	if ($alpha == 'k'){ return "5"; }
	if ($alpha == 'l'){ return "6"; }
	if ($alpha == 'm'){ return "6"; }
}
if ($_FILES['upload']['tmp_name']){
	if ($_POST[photo] != 'x' || $_POST[freeDesc] != ''){
		// log all attempts
		@mysql_query("insert into ps_file_array (name, type, size, tmp_name, error, uploadDate, user) values ('".$_FILES['upload']['name']."','".$_FILES['upload']['type']."','".$_FILES['upload']['size']."','".$_FILES['upload']['tmp_name']."','".$_FILES['upload']['error']."', NOW(), '$name' )");
		// ok first we need to go get the files
		$path = "/data/service/photos/";
		$file_path = $path.'EV'.$packet;
		if (!file_exists($file_path)){
			mkdir ($file_path,0777);
		}
		$target_path = $file_path."/".$defendant.".".$_POST[photo].".".time().".jpg";  
		if (move_uploaded_file($_FILES['upload']['tmp_name'], $target_path)){ "file <b>NOT</b> saved...($target_path)<br>"; }else{ echo "file saved...($target_path)<br>"; }
		$link = "http://service.mdwestserve.com/photographs/EV".$packet."/".$defendant.".".$_POST[photo].".".time().".jpg";
		$user = $_COOKIE[psdata][user_id];
		if ($_POST[photo] == 'x'){
			$addressID=$_POST[freeAdd];
			$description=strtoupper($_POST[freeDesc]);
		}else{
			$addressID=alpha2ID($_POST[photo]);
			$description=alpha2desc($_POST[photo]);
		}
		$query2 = "INSERT into ps_photos (packetID,defendantID,addressID,serverID,localPath,browserAddress,description) VALUES ('EV$packet','$defendant','$addressID','$user','$target_path','$link','$description')";
		@mysql_query($query2) or die ("Query: $query2".mysql_error());
		// send html with img tags....
		$headers  = "MIME-Version: 1.0 \n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
		$headers .= "From: SYSTEM <sysop@hwestauctions.com> \n";
		$subject = "WIZARD: PHOTO UPLOAD FOR EV$packet";
		$ps = $info.id2name($_COOKIE[psdata][user_id]).' '.$link;
		$ps .= "<br><img src='http://mdwestserve.com/ps/$img'>";
		$to = "SYSTEM OPERATORS <sysop@hwestauctions.com>";
		//mail($to,$subject,$ps,$headers);
		mkAlert('UPLOADED PHOTO',$user,$user,$packet);
		?>
		<div class="nav2"><input onClick="submitLoader()" type="radio" name="i" value="photo.review" /> NEXT</div>
<? }else{?>
		NO DESCRIPTION ENTERED
		<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="photo.upload.1" /> BACK</div>
	<?
	}
} else {?>
	NO PHOTO SELECTED
	<div class="nav"><input onClick="submitLoader()" type="radio" name="i" value="photo.upload.1" /> BACK</div>
<? }?>
<input type="hidden" name="parts" value="<?=$_POST[parts]?>" />
<input type="hidden" name="opServer" value="<?=$_POST[opServer]?>" />
