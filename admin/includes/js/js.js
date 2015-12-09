window.onload=function(){
if(!getCookie("rcs")){setCookie('rcs','tasks','365','FALSE');}
if($("input[type='text']:first")){$("input[type='text']:first").focus();}

window.onscroll=function(){
$('a[href="#top"]').css({"display":"none","opacity":"0.7","bottom":"50px","right":"10px","position":"fixed","height":"49px","width":"49px","background":"url(http://aftalt.dk/admin/styles/funall.png) no-repeat -1px -89px"});
if($(window).scrollTop()>300){$('a[href="#top"]').fadeIn(300);}else{$('a[href="#top"]').fadeOut(300);}
};
$('a[href="#top"]').mouseover(function(){$(this).animate({opacity:1},300);});
$('a[href="#top"]').mouseout(function(){$(this).animate({opacity:0.7},300);});
$('a[href="#top"]').click(function(){$('body,html').animate({scrollTop:0},700);return false;});

$("#q").click(function(){
if(document.getElementById('q').value!=""){
$("#qReset").fadeIn(475).css("display","inline-block");
}
});
$("#q").keyup(function(){
if(document.getElementById('q').value!=""){
$("#qReset").fadeIn(475).css("display","inline-block");
}
else{
$("#qReset").fadeOut(475);
}
});
$("#q").blur(function(){
if(document.getElementById('q').value==""){
$("#qReset").fadeOut(475);
}
});
$("#qReset").click(function(){
$(this).css("background","url(styles/funall.png) -2px -63px");
$("#q").val("");
$("#q").focus();
$("#qReset").fadeOut(475);
});

window.onkeydown=function(){
var e=event.keyCode? event.keyCode: event.charCode? event.charCode: event.which;
if(event.ctrlKey && e==13){window.location="index.php";return false;}
if(event.ctrlKey && e==32){$('body,html').animate({scrollTop:0},500);return false;}
if(event.ctrlKey && e==187){window.location="wset.php";return false;}

if(document.getElementById("q") && event.ctrlKey && e==83) {
$("#q").focus();
$("#q").select();
return false;
}
if(document.getElementById("q") && (/[a-zA-Z0-9-_ ]/.test(String.fromCharCode(e)) || e==8)){$("#q").focus();}
};
$(".msg").css('display','none').delay(500).fadeIn("slow").delay(4000).fadeOut(1000,function(){$(this).remove();});
$(".error").css('display','none').delay(500).fadeIn("slow").append("<a href='#close' style='font-size:15px;top:0;right:5px;position:absolute;text-decoration:none;'>x</a>");
$('a[href="#close"]').click(function(){$(".error").fadeOut(1000,function(){$(this).remove();});return false;});
};
function setCookie(c_name,value,exdays,msg){
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name+"="+c_value;
var doneMsg=document.createElement('div');
if(msg=="TRUE"){
doneMsg.className="msg";
doneMsg.innerHTML="Indstillingerne er gemt.";
document.body.insertBefore(doneMsg,document.getElementById("linksTopRight"));
$(".msg").css({display:'none',top:$('body').scrollTop()+15+'px'}).delay(500).fadeIn("slow").delay(4000).fadeOut(1000,function(){$(this).remove();});
}
}
function getCookie(c_name){
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++){
x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
x=x.replace(/^\s+|\s+$/g,"");
if (x==c_name){
return unescape(y);
}
}
}

function genRand(rsId){
var text = "";
var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
var ids = Array();
ids = rsId.split(",");

for(var i=0; i < 15;i++){
text += possible.charAt(Math.floor(Math.random() * possible.length));
for(var j=0;j < ids.length;j++){
var id = ids[j];
document.getElementById(id).value=text;
}
}
}

function textCounter(textarea, rs, maxLen) {
var rEle = document.getElementById(rs);
if(textarea.value.length > maxLen){
textarea.value = textarea.value.substring(0,maxLen);
}
rEle.innerHTML = maxLen - textarea.value.length+" tegn tilbage.";
}

function confirmB(conMsg){
return confirm(conMsg) ? true:false;
}

function getInstant(iThis){
var iURL=null;
var pTitle=null;
if(iThis.className=="fq"){
iURL="includes/fs.php";
pTitle="Freelancere";
}
else if(iThis.className=="tq"){
iURL="includes/ts.php";
pTitle="Opgaver";
}
else if(iThis.className=="mq"){
iURL="includes/msg.php";
pTitle="Beskeder";
}
var xhr; 
try {
xhr = new ActiveXObject("MSXML2.XMLHTTP.6.0","MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP","Microsoft.XMLHTTP");
}
catch(e){
try {
xhr = new XMLHttpRequest();
}
catch(e){
xhr = false;
}
}
xhr.onreadystatechange=function()
{
if (xhr.readyState==1 || xhr.readyState==2 || xhr.readyState==3){
if(document.getElementById("qReset")){
document.getElementById("qReset").style.background="url(styles/loading.gif) no-repeat 0px 7px";
}
}
else if (xhr.readyState==4 && xhr.status==200){
document.getElementById("globalListContentRs").innerHTML=xhr.responseText;
if(document.getElementById("qReset")){
document.getElementById("qReset").style.background="url(styles/funall.png) -2px -41px";
}
if(iThis.value!=""){
iThis.addEventListener("blur",function(){window.history.pushState("act:true","","?q="+iThis.value);});
document.title=iThis.value+" - S\u00f8gning";
}
else{
document.title=pTitle+" | Aftalt";
}
}
};
xhr.open("GET",iURL+"?q="+encodeURIComponent(iThis.value),true);
xhr.send();
}

function loadRs(sQ,limit){
var lURL=null;
if($("."+sQ).val()!=""){var cQ="&q="+$("."+sQ).val();}else{cQ="";}
if(sQ=="fq"){
lURL="includes/fs.php";
}
else if(sQ=="tq"){
lURL="includes/ts.php";
}
else if(sQ=="mq"){
lURL="includes/msg.php";
}
var xhr; 
try{
xhr = new ActiveXObject("MSXML2.XMLHTTP.6.0","MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP","Microsoft.XMLHTTP");
}
catch(e){
try {
xhr = new XMLHttpRequest();
}
catch(e){
xhr = false;
}
}
xhr.onreadystatechange=function(){
if (xhr.readyState==1 || xhr.readyState==2 || xhr.readyState==3){
document.getElementById("showMore").innerHTML="Loading...";
}
else if (xhr.readyState==4 && xhr.status==200){
document.getElementById("globalListContentRs").innerHTML=xhr.responseText;
window.history.pushState("act:true","","?s="+limit+cQ);
}
};
xhr.open("GET",lURL+"?s="+limit+cQ,true);
xhr.send();
}