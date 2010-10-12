<? ob_start();?>
<style>
<!--
.intro{
position:absolute;
left:0;
top:0;
/*layer-background-color:#<?=color();?>;*/
background-color:#<?=color();?>;
border:0.1px solid #<?=color();?>;
z-index:10;
}
-->
</style>
</head>
<body>
<div id="i1" class="intro"></div><div id="i2" class="intro"></div>

<script language="JavaScript1.2">

/*
Top-Down Curtain Script- By Dynamic Drive (www.dynamicdrive.com)
For full source code, installation instructions, and TOS,
visit http://www.dynamicdrive.com
*/

var ns4=document.layers?1:0
var ie4=document.all?1:0
var ns6=document.getElementById&&!document.all?1:0
var speed=20
var temp=new Array()
var temp2=new Array()
if (ns4){
for (i=1;i<=2;i++){
temp[i]=eval("document.i"+i+".clip")
temp2[i]=eval("document.i"+i)
temp[i].width=window.innerWidth
temp[i].height=window.innerHeight/2
temp2[i].top=(i-1)*temp[i].height
}
}
else if (ie4||ns6){
var clipbottom=ns6?parseInt(window.innerHeight)/2:document.body.offsetHeight/2
cliptop=0
for (i=1;i<=2;i++){
temp[i]=ns6?document.getElementById("i"+i).style:eval("document.all.i"+i+".style")
temp[i].width=ns6?window.innerWidth-15:document.body.clientWidth
temp[i].height=ns6?window.innerHeight/2:document.body.offsetHeight/2
temp[i].top=(i-1)*parseInt(temp[i].height)
}
}

function openit(){
window.scrollTo(0,0)
if (ns4){
temp[1].bottom-=speed
temp[2].top+=speed
if (temp[1].bottom<=0)
clearInterval(stopit)
}
else if (ie4||ns6){
clipbottom-=speed
temp[1].clip="rect(0 auto "+clipbottom+" 0)"
cliptop+=speed
temp[2].clip="rect("+cliptop+" auto auto auto)"
if (clipbottom<=-5){
clearInterval(stopit)
if (ns6){
temp[1].display="none"
temp[2].display="none"
}
}
}
}
function gogo(){
stopit=setInterval("openit()",50)
}
gogo()

</script>
<? $splash1 = ob_get_clean();?>
<? ob_start();?>
<style>
<!--
.intro{
position:absolute;
left:0;
top:0;
/*layer-background-color:#<?=color();?>;*/
background-color:#<?=color();?>;
border:2px solid #<?=color();?>;
z-index:9;
}
-->
</style>
<body bgcolor="#ffffff">
<div id="i1" class="intro"></div><div id="i2" class="intro"></div>
<script language="JavaScript1.2">

/*
Left-Right Curtain Script- © Dynamic Drive (www.dynamicdrive.com)
For full source code, 100's more free DHTML scripts, and TOS,
visit http://dynamicdrive.com
*/

var ns4=document.layers?1:0
var ie4=document.all?1:0
var ns6=document.getElementById&&!document.all?1:0

var speed=20
var temp=new Array()
var temp2=new Array()
if (ns4){
for (i=1;i<=2;i++){
temp[i]=eval("document.i"+i+".clip")
temp2[i]=eval("document.i"+i)
temp[i].width=window.innerWidth/2
temp[i].height=window.innerHeight
temp2[i].left=(i-1)*temp[i].width
}
}
else if (ie4||ns6){
var clipright=ns6?window.innerWidth/2*0.98:document.body.clientWidth/2,clipleft=0
for (i=1;i<=2;i++){
temp[i]=ns6?document.getElementById("i"+i).style:eval("document.all.i"+i+".style")
temp[i].width=ns6?window.innerWidth/2*0.98:document.body.clientWidth/2
temp[i].height=ns6?window.innerHeight-1: document.body.offsetHeight
temp[i].left=(i-1)*parseInt(temp[i].width)
}
}


function openit(){
window.scrollTo(0,0)
if (ns4){
temp[1].right-=speed
temp[2].left+=speed
if (temp[2].left>window.innerWidth/2)
clearInterval(stopit)
}
else if (ie4||ns6){
clipright-=speed
temp[1].clip="rect(0 "+clipright+" auto 0)"
clipleft+=speed
temp[2].clip="rect(0 auto auto "+clipleft+")"
if (clipright<=0){
clearInterval(stopit)
if (ns6){
temp[1].display="none"
temp[2].display="none"
}
}
}
}

function gogo(){
stopit=setInterval("openit()",50)
}
gogo()

</script>
<? $splash2 = ob_get_clean();
if (time()%2){
echo $splash1;
}else{
echo $splash2;
}
