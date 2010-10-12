<?
include 'common.php';
include 'lock.php';
//include 'menu.php';
?>
<style>
#terminal { width:800; height:300; border:ridge 15px #000033; font:terminal; font-size:14px; background-color:#0000FF; color:#FFFFFF;}
a { border:groove 5px #000066; text-align:center; text-decoration:none; background-color:#0000FF}
a:hover { border:groove 5px #66FFFF; text-align:center; text-decoration:none; width:100px; background-color:#66FFFF; }
td {text-align:center;}
</style>
<fieldset style="width:810px;">
<legend>Mobile Service Updater</legend>
<div id="terminal">Welcome Process Server,<br /><br />Where would <br /></div>
<table width="100%">
	<tr>
    	<td style="font-size:36px"><a class="button" onclick="buttonA()">A</a></td>
    	<td style="font-size:36px"><a class="button" onclick="buttonB()">B</a></td>
    	<td style="font-size:36px"><a class="button" onclick="buttonC()">C</a></td>
    	<td style="font-size:36px"><a class="button" onclick="buttonD()">D</a></td>
    	<td style="font-size:36px"><a class="button" onclick="buttonE()">E</a></td>
	</tr>
</table>
</fieldset>
<script>
function buttonA(){
	alert('Button A');
}
function buttonB(){
	alert('Button B');
}
function buttonC(){
	alert('Button C');
}
function buttonD(){
	alert('Button D');
}
function buttonE(){
	alert('Button E');
}


</script>
<? // include 'footer.php';?>