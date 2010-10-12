<style>
/*Example CSS for demo ticker*/

#ajaxticker1{
width: 900px;
height: 25px;
font-size:20px;
border: 1px ridge black;
padding: 0px;
background-color:#FFFF00;
}
.aitem{
font-size:20px;
padding: 0px;
background-color:#FFFF00;
text-decoration:none;
}


#ajaxticker1 div{ /*IE6 bug fix when text is bold and fade effect (alpha filter) is enabled. Style inner DIV with same color as outer DIV*/
background-color: #FFFF00;
}

.someclass{ //class to apply to your scroller(s) if desired
}

</style>

<script src="ajaxticker.js" type="text/javascript">

/***********************************************
* Ajax Ticker script (txt file source)- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

</script>
	
<center>


<script type="text/javascript">

var xmlfile="news.txt" //path to ticker txt file on your server.

//ajax_ticker(xmlfile, divId, divClass, delay, optionalfadeornot)
new ajax_ticker(xmlfile, "ajaxticker1", "someclass", 3500, "fade")
</script>
