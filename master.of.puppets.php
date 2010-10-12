<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HacktheDOM</title>
<script language="javascript">


function copy(inElement) {
  if (inElement.createTextRange) {
    var range = inElement.createTextRange();
    if (range && BodyLoaded==1)
      range.execCommand('Copy');
  } else {
    var flashcopier = 'flashcopier';
    if(!document.getElementById(flashcopier)) {
      var divholder = document.createElement('div');
      divholder.id = flashcopier;
      document.body.appendChild(divholder);
    }
    document.getElementById(flashcopier).innerHTML = '';
    var divinfo = '<embed src="_clipboard.swf" FlashVars="clipboard='+encodeURIComponent(inElement.value)+'" width="0" height="0" type="application/x-shockwave-flash"></embed>';
    document.getElementById(flashcopier).innerHTML = divinfo;
  }
}


</script>
</head>

<body>
<br />
<br />
<br />
<br />
<br />
<br />

<form name="formtocopy" action="">
<textarea name="texttocopy">
var test
</textarea>
<br>
<a href="javascript:copy(document.formtocopy.texttocopy);">Copy the Text!</a>
</form>
<br />
<br />
<br />
<br />
<br />
<br />


<hr />



 <iframe name="slave" id="slave" width="970" height="400" frameborder="0" src="http://casesearch.courts.state.md.us/inquiry/processDisclaimer.jis"></iframe>    


<hr /><hr /><hr />


<html>
<head>
<title>JavaScript Text Highlighting</title>

<style>
body, input {
	margin: 20;
	font: .9em Verdana, 'Lucida Grande', Geneva, Lucida, sans-serif;
	}
</style>

<script language=JavaScript>
/*
 * This is the function that actually highlights a text string by
 * adding HTML tags before and after all occurrences of the search
 * term. You can pass your own tags if you'd like, or if the
 * highlightStartTag or highlightEndTag parameters are omitted or
 * are empty strings then the default <font> tags will be used.
 */
function doHighlight(bodyText, searchTerm, highlightStartTag, highlightEndTag) 
{
  // the highlightStartTag and highlightEndTag parameters are optional
  if ((!highlightStartTag) || (!highlightEndTag)) {
    highlightStartTag = "<font style='color:blue; background-color:yellow;'>";
    highlightEndTag = "</font>";
  }
  
  // find all occurences of the search term in the given text,
  // and add some "highlight" tags to them (we're not using a
  // regular expression search, because we want to filter out
  // matches that occur within HTML tags and script blocks, so
  // we have to do a little extra validation)
  var newText = "";
  var i = -1;
  var lcSearchTerm = searchTerm.toLowerCase();
  var lcBodyText = bodyText.toLowerCase();
    
  while (bodyText.length > 0) {
    i = lcBodyText.indexOf(lcSearchTerm, i+1);
    if (i < 0) {
      newText += bodyText;
      bodyText = "";
    } else {
      // skip anything inside an HTML tag
      if (bodyText.lastIndexOf(">", i) >= bodyText.lastIndexOf("<", i)) {
        // skip anything inside a <script> block
        if (lcBodyText.lastIndexOf("/script>", i) >= lcBodyText.lastIndexOf("<script", i)) {
          newText += bodyText.substring(0, i) + highlightStartTag + bodyText.substr(i, searchTerm.length) + highlightEndTag;
          bodyText = bodyText.substr(i + searchTerm.length);
          lcBodyText = bodyText.toLowerCase();
          i = -1;
        }
      }
    }
  }
  
  return newText;
}


/*
 * This is sort of a wrapper function to the doHighlight function.
 * It takes the searchText that you pass, optionally splits it into
 * separate words, and transforms the text on the current web page.
 * Only the "searchText" parameter is required; all other parameters
 * are optional and can be omitted.
 */
function highlightSearchTerms(searchText, treatAsPhrase, warnOnFailure, highlightStartTag, highlightEndTag)
{
  // if the treatAsPhrase parameter is true, then we should search for 
  // the entire phrase that was entered; otherwise, we will split the
  // search string so that each word is searched for and highlighted
  // individually
  if (treatAsPhrase) {
    searchArray = [searchText];
  } else {
    searchArray = searchText.split(" ");
  }
  
  if (!document.body || typeof(document.body.innerHTML) == "undefined") {
    if (warnOnFailure) {
      alert("Sorry, for some reason the text of this page is unavailable. Searching will not work.");
    }
    return false;
  }
  
  var bodyText = document.body.innerHTML;
  for (var i = 0; i < searchArray.length; i++) {
    bodyText = doHighlight(bodyText, searchArray[i], highlightStartTag, highlightEndTag);
  }
  
  document.body.innerHTML = bodyText;
  return true;
}


/*
 * This displays a dialog box that allows a user to enter their own
 * search terms to highlight on the page, and then passes the search
 * text or phrase to the highlightSearchTerms function. All parameters
 * are optional.
 */
function searchPrompt(defaultText, treatAsPhrase, textColor, bgColor)
{
  // This function prompts the user for any words that should
  // be highlighted on this web page
  if (!defaultText) {
    defaultText = "";
  }
  
  // we can optionally use our own highlight tag values
  if ((!textColor) || (!bgColor)) {
    highlightStartTag = "";
    highlightEndTag = "";
  } else {
    highlightStartTag = "<font style='color:" + textColor + "; background-color:" + bgColor + ";'>";
    highlightEndTag = "</font>";
  }
  
  if (treatAsPhrase) {
    promptText = "Please enter the phrase you'd like to search for:";
  } else {
    promptText = "Please enter the words you'd like to search for, separated by spaces:";
  }
  
  searchText = prompt(promptText, defaultText);

  if (!searchText)  {
    alert("No search terms were entered. Exiting function.");
    return false;
  }
  
  return highlightSearchTerms(searchText, treatAsPhrase, true, highlightStartTag, highlightEndTag);
}


/*
 * This function takes a referer/referrer string and parses it
 * to determine if it contains any search terms. If it does, the
 * search terms are passed to the highlightSearchTerms function
 * so they can be highlighted on the current page.
 */
function highlightGoogleSearchTerms(referrer)
{
  // This function has only been very lightly tested against
  // typical Google search URLs. If you wanted the Google search
  // terms to be automatically highlighted on a page, you could
  // call the function in the onload event of your <body> tag, 
  // like this:
  //   <body onload='highlightGoogleSearchTerms(document.referrer);'>
  
  //var referrer = document.referrer;
  if (!referrer) {
    return false;
  }
  
  var queryPrefix = "q=";
  var startPos = referrer.toLowerCase().indexOf(queryPrefix);
  if ((startPos < 0) || (startPos + queryPrefix.length == referrer.length)) {
    return false;
  }
  
  var endPos = referrer.indexOf("&", startPos);
  if (endPos < 0) {
    endPos = referrer.length;
  }
  
  var queryString = referrer.substring(startPos + queryPrefix.length, endPos);
  // fix the space characters
  queryString = queryString.replace(/%20/gi, " ");
  queryString = queryString.replace(/\+/gi, " ");
  // remove the quotes (if you're really creative, you could search for the
  // terms within the quotes as phrases, and everything else as single terms)
  queryString = queryString.replace(/%22/gi, "");
  queryString = queryString.replace(/\"/gi, "");
  
  return highlightSearchTerms(queryString, false);
}


/*
 * This function is just an easy way to test the highlightGoogleSearchTerms
 * function.
 */
function testHighlightGoogleSearchTerms()
{
  var referrerString = "http://www.google.com/search?q=javascript%20highlight&start=0";
  referrerString = prompt("Test the following referrer string:", referrerString);
  return highlightGoogleSearchTerms(referrerString);
}

</script>
</head>

<body onload="highlightSearchTerms('search');">
<h2>Using JavaScript to Search For and Highlight Text on a Web Page</h2>
<p>
This is the page that I will be searching and replacing on. Some text will be 
already be highlighted because I called the highlightSearchTerms function from 
the "onload" event in the &lt;body&gt; tag. You can also highlight your own 
search terms by clicking the buttons below. To steal this code, just copy the 
JavaScript functions from the source of this page.

<br>
<input type="button" value="Highlight multiple search terms" 
onClick="searchPrompt('this and that', false);"> 
<input type="button" value="Highlight a search phrase" 
onClick="searchPrompt('the page', true, 'green', 'pink');">
<br>
The highlightSearchTerms function has an optional parameter to determine whether 
the individual words in a search term should be highlighted separately, or if they 
should be treated as a phrase. By default, terms will be split and highlighted 
individually. SeArChEs aRe nOt cAsE-sEnSiTiVe.
<p>
<div id='thethe' style='color:yellow; background-color:blue; padding:5;'>
<font size=3>
Here's some text inside a div, just to show that <b>the search and replace</b> 
feature works on text blocks that are already being formatted with &lt;div&gt;, 
&lt;font&gt;, etc. without altering the existing formatting (other than adding 
the highlight). The doHighlight function that actually performs the searching 
and replacing uses simple logic to exclude search terms that are found within 
HTML tags or script blocks.
</font>

</div>
<p>
One possible use of this code is to write a JavaScript function to check the document 
referrer, and if someone has reached this page from a search engine, then the search terms 
that brought the visitor here could automatically be highlighted when the page loads by 
calling the function in the "onload" event of the &lt;body&gt; tag. You should be able to 
use the highlightGoogleSearchTerms function on this page as a starting point for such a 
thing.
<br>
<input type="button" value="Test highlightGoogleSearchTerms function" 
onClick="testHighlightGoogleSearchTerms();">
<br>
A few notes about using these functions:
<p><ul>
<li>you should only call the functions from the onload event of the body tag, or from a 
button or link or something that's triggered after the page is loaded. If you try to call 
these functions before a page has finished loading (for example, from a script block in 
the &lt;head&gt; or &lt;body&gt; section of the page), you will have unpredictable 
results.</li>

<p>
<li>The performance is a little slow if you have a large number of matches on a big web 
page (for example, if you try to match "a" on a 100k page). For a moderate number of 
matches, even on a large page, the performance is generally fine.</li>
<p>
<li>If there are HTML tags between letters of a word or between words in a phrase, then 
the word/phrase will not be highlighted as a match. For example, a search for "plant" 
will not match the word p<u>lan</u>t, because the HTML representation of the word is 
"p&lt;u&gt;lan&lt;/u&gt;t", and the HTML tags will throw the search off. Likewise, if 
you highlight part of a word using a search, and then try to highlight the word itself, 
the word will not be matched for the same reason (if you search for and highlight "ant" 
and then try to search for and highlight "plant", you won't get any matches for "plant" 
because the HTML for the word will have been changed to 
"pl&lt;highlightStartTag&gt;ant&lt;highlightEndTag&gt;").</li>
<p>

<li>I have no idea how cross-browser compatible this code is. I tested it with IE 6 and 
Mozilla Firebird 0.6, and it worked on both of those (which was good enough for me).</li>
</ul><p>
<hr>
<center>You are on the <a href='http://www.nsftools.com'>nsftools.com</a> website.
<br>
http://www.nsftools.com/misc/SearchAndHighlight.htm</center><p>
</body>

</html>




</body>
</html>
