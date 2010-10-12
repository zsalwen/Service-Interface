<? include 'common.php';
	include 'menu.php';
	?>
	
		<script>
function toCount(entrance,exit,text,characters) {
  var entranceObj=getObject(entrance);
  var exitObj=getObject(exit);
  var length=characters - entranceObj.value.length;
  
  var testObj=entranceObj.value.substr(length-1,length);
	//alert('ping:'+entranceObj.value);
  
	//alert('testing: '+testObj.value);

 if(length == 80) {
	alert('submit article number');
		var uri;
		//uri ='?art='+document.form1.text2.value+'&logic2=<?=$_GET[logic]?>';

	  //window.location.href=uri;	}
  
  if(length <= 0) {
    length=0;
    text='<span class="disable"> '+text+' </span>';
    entranceObj.value=entranceObj.value.substr(0,characters);
    }
  exitObj.innerHTML = text.replace("{CHAR}",length);
  
}
function getObject(obj) {
  var theObj;
  if(document.all) {
    if(typeof obj=="string") {
      return document.all(obj);
    } else {
      return obj.style;
    }
  }
  if(document.getElementById) {
    if(typeof obj=="string") {
      return document.getElementById(obj);
    } else {
      return obj.style;
    }
  }
  return null;
}
	
	</script>

	
	
	<?
if ($_GET[art] && $_GET[packetDef]){
$packetDef=explode('-',$_GET[packetDef]);
$packet=$packetDef[0];
$def=strtoupper($packetDef[1]);
$add=$_GET[add];
	$q="update ps_packets set article$def$add = '$_GET[art]', gcStatus='PRINTED' where packet_id = '$packet'";
	@mysql_query($q) or die("Query: $q<br>".mysql_error());
	?>
	<br><br><h1>Article # <?=$_GET['art']?> Applied to Packet <?=$packet?>, Defendant <?=$def?></h1>
<div>
<form name="form3">
Enter Packet-Def: <input name="packetDef" size="50" value=""></form>
<script>form3.packetDef.focus()</script>
</div>	
	
<? }else{ ?>
<style type="text/css">
    div {
      font-size: 24px;
    }
  </style> 
 <br><br><br><br>
<?  if ($_GET[packetDef]){ 
$packetDef=explode('-',$_GET[packetDef]);
$packet=$packetDef[0];
$def=$packetDef[1];
?>
 <div>
<form name="form1">
Article: <input name="art" size="50" value="<?=$_GET['art']?>"> for packet <?=$packet?>, defendant <?=$def?>
<input type="hidden" name="packetDef" value="<?=$_GET[packetDef]?>">
</form>
</div>
<script>form1.art.focus()</script>
<? }else{ ?>
<div>
<form name="form2">
Enter Packet-Def: <input name="packetDef" size="50" value="<?=$_GET['packetDef']?>" onKeyUp="toCount('packetDef','sBann','{CHAR} characters left',100);"></form>
</div>
<script>form2.packetDef.focus()</script>
<? } 
		}?> 