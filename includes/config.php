<?php
mysql_connect("localhost","root","") or die(mysql_error());
mysql_select_db("db") or die(mysql_error());
session_start();
setlocale(LC_ALL, "danish");
error_reporting("E_ALL&~E_NOTICE");
$host = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$company = "Aftalt";
$webTitle=" | Aftalt";
$cDate = date('d-m-Y H:i:s');
$cTime = htmlentities(time());

function protection(){
global $host,$path;
if(isset($_COOKIE['a_userid'])){
$_SESSION['a_userid']=$_COOKIE['a_userid'];
}
if(!isset($_SESSION['a_userid'])){header("location:http://$host$path/login.php");}
}
function logged(){
global $host,$path;
return isset($_COOKIE['a_userid']) || isset($_SESSION['a_userid'])?true:false;
}
function logout(){
global $host,$path;
setcookie('a_userid',$_SESSION['a_userid'],time()-60*60*24*365);
unset($_SESSION['a_userid']);
session_destroy();
header("location:http://$host$path/login.php");
}

function renderPage($page,$fromId){
$file = file_get_contents($page);
preg_match("'<div id=\"".$fromId."\">(.*?)</div>'si", $file, $matches);
echo $matches[1];
}
function highlight($q, $string){
$qs = array_unique(explode(" ", $q));
foreach ($qs as $q) {
$string = preg_replace("/(".preg_quote($q).")/i", "<span class='highlight'>$1</span>", $string);
}
return $string;
}
function getUserInfo($iNo){
$iRs = mysql_fetch_array(mysql_query("SELECT id,name,username,password,email,phone,website,postal,city,address,competencies,a_userid,ip,time,last_login,register_date FROM users WHERE a_userid='$_SESSION[a_userid]'"));
return $iRs[$iNo];
}
function userRole(){
$iRs = mysql_fetch_row(mysql_query("SELECT level FROM users WHERE a_userid='$_SESSION[a_userid]' AND approval='1'"));
return $iRs[0];
}
function addDots($str, $from, $char){
echo (strlen($str) > $char) ? substr($str, $from, $char)."..." : substr($str, $from, $char);
}
function isAlpha($alpha,$alphaStartStr=0,$alphaEndStr=15){
return preg_match('/^[a-z\d_]{'.$alphaStartStr.','.$alphaEndStr.'}$/i', $alpha) ? TRUE : FALSE;
}
function isText($text,$textStartStr=0,$textEndStr=15){
return preg_match('/^[\w\d\n\r-.& ]{'.$textStartStr.','.$textEndStr.'}$/i', $text) ? TRUE : FALSE;
}
function isLen($lenStr,$lenStrStart=0,$lenStrEnd=15){
return strlen($lenStr)>=$lenStrStart && strlen($lenStr)<=$lenStrEnd ? TRUE : FALSE;
}
function isEmail($email){
return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU',$email) ? TRUE : FALSE;
}
function isURL($url){
return preg_match('/^([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url) ? TRUE : FALSE;
} 
function isNumber($no,$numberStartStr=0,$numberEndStr=8){
return preg_match('/^[a-z0-9]{'.$numberStartStr.','.$numberEndStr.'}$/i', $no) ? TRUE : FALSE;
} 
function isEqual($x,$y,$strLen=0){
if(empty($x) || empty($y)){return false;}
if(strlen($x) < $strLen || strlen($y) < $strLen){return false;}
if(strcmp($x,$y) != 0){return false;}
return true;
}
function hashPwd($PwD, $salt = NULL){
if ($salt === null){
$salt = substr(md5(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".uniqid(rand(), true))), 0, 9);
}
else{
$salt = substr($salt, 0, 9);
}
return $salt . hash("SHA256",$salt . $PwD);
}
function randKey($ext){
$salt = substr(md5(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".uniqid(rand(), true))), 0, 9);
return $salt . hash("SHA256",$salt . $ext);
}

function cpTime($fTime,$fDate, $tFormat){
global $cTime;
$diff = $cTime - $fTime;
$ago = 'siden';

switch(true){
case($diff < 60):
$count = $diff;
if($count==0){
$ago = '';
$count = 'Lige nu';}
elseif($count==1){
$suffix = 'sekund';}
else{
$suffix = 'sekunder';}
break;
case($diff > 60 && $diff < 3600):
$count = floor($diff/60);
if($count==0){$count = 'Få minutter';}
if($count==1){
$suffix = 'minut';}
else{
$suffix = 'minutter';}
break;

case($diff > 3600 && $diff < 86400):
$count = floor($diff/3600);
if($count==0){$count = 'Få timer';}
if($count==1){
$suffix = 'time';}
else{
$suffix = 'timer';}
break;

case($diff > 86400):
$count = floor($diff/86400);
if($count==1){
$count = '';
$ago = '';
$suffix = 'Igår';}
else{
$count = '';
$ago = '';
$suffix = ucfirst(strftime($tFormat,strtotime($fDate)));}
break;
}
echo "$count $suffix $ago";
}
?>