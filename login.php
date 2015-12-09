<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, freelancer, opgave, freelance opgave, profil, log ind, login, profil log ind, konto log ind">
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title>Log ind<?php echo "$webTitle";?></title>
</head>
<body>
<?php
$lUsername = mysql_real_escape_string($_POST['lUsername']);
$lPassword = mysql_real_escape_string($_POST['lPassword']);

$wUser = strpos($lUsername,'@')===false ? "username='$lUsername'" : "email='$lUsername'";


if(isset($_POST['login'])){
if(empty($lUsername) || empty($lPassword)){
$err[] = "Du skal udfylde begge felter";
}

$lRs=mysql_query("SELECT password,email,approval FROM users WHERE $wUser") or die(mysql_error());
$numrows = mysql_num_rows($lRs);
list($dbPwd, $rEmail,$rappr)=mysql_fetch_row($lRs);

if(empty($err) && $numrows>0 && $rappr=='0'){
$err[] = "Denne konto er ikke aktiveret endnu.";
}
if(empty($err) && $numrows>0 && $dbPwd === hashPwd($lPassword,$dbPwd) && $rappr=='1'){
session_regenerate_id(TRUE);
$a_userid= randKey();
$_SESSION['a_userid']=$a_userid;
if(isset($_POST['lRemember']) && $_POST['lRemember']=="1"){
setcookie('a_userid',$_SESSION['a_userid'],time()+60*60*24*365);
}
mysql_query("UPDATE users SET a_userid='$a_userid', time='$cTime', last_login='$cDate' WHERE email='$rEmail'");
header("location:index.php");
}
elseif($numrows==0 && !empty($lUsername) && !empty($lPassword)){
if(strpos($lUsername,'@')===false){
$err[] = "Den indtastede brugernavn, er ikke forbundet til nogen konto.";
}
else{
$err[] = "Den indtastede email, er ikke forbundet til nogen konto.";
}
}
elseif($dbPwd !== hashPwd($lPassword,$dbPwd) && !empty($lUsername) && !empty($lPassword) && $rappr=='1'){
$err[] = 'Den indtastede password er forkert.';
}
}
if(logged()==true){
header("location:http://$host$path/index.php");
}
require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<span class="pTitle top">Log ind</span>
<form action="" method="post">
<table border="0" align="center" cellpadding="2" cellspacing="0" class="formStyle">
<tr> 
<td><label for="lUsername">Brugernavn/email:</label></td><td><input type="text" id="lUsername" name="lUsername" size="35" value="<?php echo $lUsername; ?>" /></td>
</tr>
<tr> 
<td><label for="lPassword">Password:</label></td><td><input type="password" id="lPassword" name="lPassword" size="35" /></td>
</tr>
<tr> 
<td><label for="lRemember">Husk mig:</label></td><td class="tool"><input name="lRemember" type="checkbox" id="lRemember" value="1" /><span class='tip t l' style="left:3px;bottom:29px;">Brug kun hvis du stoler andre brugere af computeren.<span class='tarrow at l'></span></span></td>
</tr>
<tr> 
<td colspan="2"><div align="center"><input type="submit" id="login" name="login" value="Log ind" /></div></td>
</tr>
<tr> 
<td colspan="2">&nbsp;</td>
</tr>
<tr> 
<td><a href="<?php echo "http://$host$path/";?>active.php">Aktivere konto</a></td><td><a href="<?php echo "http://$host$path/forgot.php";?>">Glemt password</a></td>
</tr>
</table>
</form>
</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>
