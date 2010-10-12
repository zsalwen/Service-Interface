<? session_start(); if ($_GET[start]){ $_SESSION[loop] = $_GET[start]; }else{$_SESSION[loop] = $_SESSION[loop] + 1;}?>
<form><div style="border:double 5px #0000FF; background-color:#FFFF00; padding:5px; text-align:center;"><input type="text" value="<?=$_SESSION[loop]?>" name="start" /> 60 Second Review, <a href="?start=<?=$_SESSION[loop]+1;?>">NEXT</a></div>
<meta http-equiv="refresh" content="60;http://mdwestserve.com/ps/review.php" />
<center><iframe name="review" src="order.php?packet=<?=$_SESSION[loop]?>" width="1600" height="800"></iframe></center>
<style>body {background-color:#000000; padding:0px; margin:0px;}</style></form>