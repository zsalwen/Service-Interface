<? include 'common.php';
	//include 'menu.php';
if ($_GET[art] && $_GET[logic2]){
$logic = explode('X',$_GET[logic2]);
$packetDef=explode('-',$logic[0]);
$packet=$packetDef[0];
$def=strtoupper($packetDef[1]);
	$q="update ps_packets set article$def = '$_GET[art]', gcStatus='MAILED', process_status='SERVICE COMPLETED' where packet_id = '$packet'";
	@mysql_query($q) or die("Query: $q<br>".mysql_error());
	timeline($packet,$_COOKIE[psdata][name]." Entered tracking number for defendant $def.");

	?>
<?
}
$status ="MDWestServe Mail Terminal Loaded... Ready for Logic Number!";

if ($_GET[logic]){
$status = "File Prep Marked for Packet ".$_GET[logic];

$packet = explode('-',$_GET[logic]);
$packet = $packet[0];
	timeline($packet,$_COOKIE[psdata][name]." Prepared Affidavits for Filing OLD CODE - ".$_GET[logic]);

	@mysql_query("update ps_packets set filing_status = 'PREP TO FILE' where packet_id = '$packet'");
	opLog($_COOKIE[psdata][name]." Court Manager #$packet PREP TO FILE");








?>	<script>window.location.href='prepTerminal.php';</script><?

}
if ($_POST[text1]){



?><script>window.location.href='prepTerminal.php?logic=<?=$_POST[text1]?>';</script><?
}

?>

<script>

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

function toCheck(entrance) {
  var entranceObj=getObject(entrance);
  var mystring=entranceObj.value;

if (mystring.match(/%$/)) {
	//alert("match");
	form1.submit();
	}

  
;
}


function toCount(entrance,exit,text,characters) {
  var entranceObj=getObject(entrance);
  var exitObj=getObject(exit);
  var length=characters - entranceObj.value.length;
  
	toCheck(entrance);
 
 if(length == 80) {
	//alert('ping');
		var uri;
		uri ='?art='+document.form1.text2.value+'&logic2=<?=$_GET[logic]?>';

	  window.location.href=uri;	}
  
  if(length <= 0) {
    length=0;
    text='<span class="disable"> '+text+' </span>';
    entranceObj.value=entranceObj.value.substr(0,characters);
    }
  exitObj.innerHTML = text.replace("{CHAR}",length);
  
}

</script>

<script language="JavaScript">
  <!--
    string="";
    function app(cc) {
      string+=cc;
      document.form1.text1.value=string;
	  toCount('text1','sBann','{CHAR} characters left',100);
    }
    function clear() {
      string="";
      document.form1.text1.value=string;
    }
    function calc() {
      if(string.length > 0) {
        inp="out="+string;
        eval(inp);
      } else out="0";
      document.form1.text1.value=out;
      string=""+out;
	  
    }
    function upda() {
	  string=""+document.form1.text1.value; 
	  window.location.href='?logic='+document.form1.text1.value;
	}
    function upda2() {
	  string=""+document.form1.text1.value; 
	}
  //-->
  </script>
  <body onLoad="clear()">  
 <br><br><br><br><br><br> <br><br><br><br><br><br>
  <table style="padding-left:150px;">
	 <form action="prepTerminal.php" name="form1" method="POST" onSubmit="{calc(); return false;}"><tr>
	<td colspan='6'>Scan Prep'ed Affidavit<br><div style="width:600px;height:100px"><input style="width:1000px; height:100px;font-size:75px;" name="text1" onKeyUp="toCount('text1','sBann','{CHAR} characters left',100);" id="text1" value="" onChange="upda()" ></div></td>
<script>form1.text1.focus()</script>
<style>
input { background-color:ffff00 }
body { background-color:000000 }
td { background-color:ffffff; font-size: 50px; }
</style>
	</tr>
</table>
</form>
<center><a href='terminal.php'><h1>ReSeT</h1></a></center>
<div style="position:absolute; bottom:0px; right:0px; height:40px; font-size:30px; width:100%; background-color:999999; color:ff0000;">
<span id="sBann" class="minitext">100 characters left.</span> - <?=$status?></div>

</form>


