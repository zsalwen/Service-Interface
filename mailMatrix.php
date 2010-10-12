<? include 'common.php';
$packet=$_GET[packet];
if ($_POST[mailDate]){
	$mailDate = $_POST[mailDate];
}elseif ($_GET[mailDate]){
	$mailDate = $_GET[mailDate];
}else{
	$mailDate = date('Y-m-d');
}
$q="SELECT * FROM mailMatrix WHERE packetID='$packet'";
$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$q1="SELECT name1, name2, name3, name4, name5, name6, address1, address1a, address1b, address1c, address1d, address1e, city1, city1a, city1b, city1c, city1d, city1e, state1, state1a, state1b, state1c, state1d, state1e, zip1, zip1a, zip1b, zip1c, zip1d, zip1e, pobox, pocity, postate, pozip, pobox2, pocity2, postate2, pozip2, service_status FROM ps_packets WHERE packet_id='$packet'";
$r1=@mysql_query($q1) or die ("Query: $q1<br>".mysql_error());
$d1=mysql_fetch_array($r1,MYSQL_ASSOC);
if ($_POST[submit]){
	$i=0;
	if ($d[packetID]){
		$qs = "UPDATE mailMatrix SET packetID='$packet'";
		while ($i < 6){$i++;
			if ($d1["name$i"]){
				$qs2 .= ", add$i='".$_POST["add$i"]."'";
				foreach(range('a','e') as $letter){
					if ($d1["address1$letter"]){
						$var = $i.$letter;
						$qs2 .= ", add$var='".$_POST["add$var"]."'";
					}
				}
				if ($d1[pobox]){
					$field="add".$i."PO";
					$qs2 .= ", $field='".$_POST["$field"]."'";
				}
				if ($d1[pobox2]){
					$field="add".$i."PO2";
					$qs2 .= ", $field='".$_POST["$field"]."'";
				}
			}
		}
		$qs .= $qs2;
		$qs .= " WHERE packetID='$packet'";
		echo "<center><h2>MAIL MATRIX UPDATED FOR PACKET $packet</h2></center>";
	}else{
		$qs="INSERT INTO mailMatrix (packetID";
			while ($i < 6){$i++;
				if ($d1["name$i"]){
					$fields .= ", add$i";
					$values .= ", '".$_POST["add$i"]."'";
					foreach(range('a','e') as $letter){
						if ($d1["address1$letter"]){
							$var = $i.$letter;
							$fields .= ", add$var";
							$values .= ", '".$_POST["add$var"]."'";
						}
					}
					if ($d1[pobox]){
						$field="add".$i."PO";
						$fields .= ", $field";
						$values .= ", '".$_POST["$field"]."'";
					}
					if ($d1[pobox2]){
						$field="add".$i."PO2";
						$fields .= ", $field";
						$values .= ", '".$_POST["$field"]."'";
					}
				}
			}
		$qs .= $fields.") values ('$packet'".$values.")";
		echo "<center><h2>MAIL MATRIX CREATED FOR PACKET $packet</h2></center>";
	}
	@mysql_query($qs) or die("Query: $qs<br>".mysql_error());
	//if not "MAIL ONLY" keep mailMatrix open, then pop open matrixEntries
	if ($_POST[matrixEntries] == 'checked' && $d1[service_status] != "MAIL ONLY"){
		echo "<script>window.open('http://service.mdwestserve.com/matrixEntries.php?packet=$packet&autoClose=1&mailDate=$mailDate','Mail Entries')</script>";
	}
	//for "MAIL ONLY" files
	if ($d1[service_status] == "MAIL ONLY"){
		if ($_POST[matrixEntries] == 'checked'){
			//redirect to matrixEntries, which will bill for mailing, make affidavits, and then in turn open affidavit and checklist
			echo "<script>window.location='http://service.mdwestserve.com/matrixEntries.php?packet=$packet&mailDate=$mailDate&mailCost=1'</script>";
		}
	}
	if ($_POST[matrixEntries] != 'checked'){
		timeline($packet,$_COOKIE[psdata][name]." Set mailMatrix");
	}
}
if ($d1[service_status] == 'MAIL ONLY'){
	$meridian=date('A');
	if ($meridian == 'PM'){
		$mailDate=strtotime($mailDate);
		$mailDate=$mailDate+86400;
		while (date('w',$mailDate) == 0 || date('w',$mailDate) == 6){
			$mailDate=$mailDate+86400;
		}
		$mailDate=date('Y-m-d',$mailDate);
	}
}
echo "<fieldset><legend style='font-weight:bold;'>Mail Matrix</legend><form name='matrix' method='post'><input type='hidden' name='packetID' value='$packet'><table align='center' style='border-collapse:collapse; font-size:small; font-variant:small-caps; text-align=center;' border='1'>";
$header="<td>OTD$packet</td>";
$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$i=0;
$columns=0;
while ($i < 6){$i++;
	if ($d1["name$i"]){
		$row .= "<tr><td>".strtoupper($d1["name$i"])."</td>";
		$columns++;
		if ($d1[address1]){
			$onclick .= "document.matrix.add$i.checked='checked';
			";
			if ($i == 1){
				$header .= "<td>".strtoupper($d1[address1])."<br>".strtoupper($d1[city1]).", ".strtoupper($d1[state1])." ".strtoupper($d1[zip1])."</td>";
				$columns++;
			}
			$row .= "<td><input name='add$i' id='add$i' type='checkbox' value='1'";
			if ($d["add$i"] == 1){
				$row .= " checked ";
			}
			$row .= "></td>";
		}
		foreach(range('a','e') as $letter){
			if ($d1["address1$letter"]){
				$onclick .= "document.matrix.add$i$letter.checked='checked';
				";
				if ($i == 1){
					$header .= "<td>".strtoupper($d1["address1$letter"])."<br>".strtoupper($d1["city1$letter"]).", ".strtoupper($d1["state1$letter"])." ".strtoupper($d1["zip1$letter"])."</td>";
					$columns++;
				}
				$row .= "<td><input name='add$i$letter' id='add$i$letter' type='checkbox' value='1'";
				$var=$i.$letter;
				if ($d["add$var"] == 1){
					$row .= " checked ";
				}
				$row .= "></td>";
			}
		}
		if ($d1[pobox]){
			$field="add".$i."PO";
			$onclick .= "document.matrix.$field.checked='checked';
			";
			if ($i == 1){
				$header .= "<td>".strtoupper($d1[pobox])."<br>".strtoupper($d1[pocity]).", ".strtoupper($d1[postate])." ".strtoupper($d1[pozip])."</td>";
				$columns++;
			}
			$row .= "<td><input name='$field' id='$field' type='checkbox' value='1'";
			if ($d["$field"] == 1){
				$row .= " checked ";
			}
			$row .= "></td>";
		}
		if ($d1[pobox2]){
			$field="add".$i."PO2";
			$onclick .= "document.matrix.$field.checked='checked';
			";
			if ($i == 1){
				$header .= "<td>".strtoupper($d1[pobox2])."<br>".strtoupper($d1[pocity2]).", ".strtoupper($d1[postate2])." ".strtoupper($d1[pozip2])."</td>";
				$columns++;
			}
			$row .= "<td><input name='$field' id='$field' type='checkbox' value='1'";
			if ($d["$field"] == 1){
				$row .= " checked ";
			}
			$row .= "></td>";
		}
		$row .= "</tr>";
	}
}
?>
<script>
function selectAll(){
	<?=$onclick?>
}
</script>
<?
echo $header;
echo $row;
$footer = "<tr><td colspan='$columns' align='center'><table align='center'><tr><td align='center'><input type='button' name='select' value='Select All' onclick='selectAll();'></td><td align='center'>";
if ($_GET[checked] != 1 && $d1[service_status] == 'MAIL ONLY'){
	$footer .= "<input type='checkbox' name='matrixEntries' value='checked' checked onclick=\"mailDate.value=''\"><small>Update Affidavits for the date: </small><br /><input name='mailDate' size=10 value='$mailDate' />";
}elseif ($_GET[checked] != 1){
	$footer .= "<input type='checkbox' name='matrixEntries' value='checked' onclick=\"mailDate.value='$mailDate'\"><small>Update Affidavits for the date: </small><br /><input name='mailDate' size=10 value='' />";
}
$footer .= "</td><td align='center'><input type='submit' name='submit' value='Submit'></td></tr></table></td></tr></table></form></fieldset>";
echo $footer;
?>