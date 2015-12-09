<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, profil, activate, aktivere, aktivere konto">
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title>Aktivere konto<?php echo "$webTitle";?></title>
</head>
<body>
<?php
$aUsername = mysql_real_escape_string($_POST['aUsername']);
$aCode = mysql_real_escape_string($_POST['aCode']);

if(!empty($_GET['usrid']) && !empty($_GET['actc'])){
$mEmail= base64_decode($_GET['usrid']);
$mRs=mysql_query("SELECT name,username,email,actcode,approval FROM users WHERE email='$mEmail'") or die(mysql_error());
$mnum = mysql_num_rows($mRs);
list($mName,$mUser,$mEmail,$mCode,$map)=mysql_fetch_row($mRs);

if($mnum<= 0 && empty($aUsername) && empty($aCode)){
$err[] = "Kontoen blev ikke fundet.";
}
elseif($map=='1' && empty($aUsername) && empty($aCode)){
$err[] = "Denne konto er aktiveret i forvejen.";
}
else{
if($_GET['actc']==$mCode && $mnum > 0 && empty($aUsername) && empty($aCode)){
mysql_query("UPDATE users SET approval='1' WHERE email='$mEmail'");

$message = "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<div><a href=\"http://$host$path\" tilte=\"$company\" target=\"_blank\"><img src=\"http://$host$path/styles/logo.png\" border=\"0\" alt=\"$company\" /></a></div>
<br /><br /><h1>Tillykke $mName!<br /><br /></h1>

<p>Din konto er nu aktiveret, og du kan logge ind ved at klikke <a href=\"http://$host$path/login.php\">her</a>.<br />
Brugernavn: $mUser</p><br />

<br />
<p>
Hilsen<br />
<strong>$company-teamet</strong>
<br /><br />
Dette er en automatisk genererat mail, besvar venligst ikke.
</p>
</body>
</html>";


$headers = "From: $company <no-reply@aftalt.dk> \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($mEmail, 'Konto aktiveret', $message, $headers);
$msg[] = "Tillykke! Din konto er nu aktiveret.";
}
elseif($_GET['actc']!=$mCode && empty($aUsername) && empty($aCode)){
$err[] = "Aktiveringskoden er forkert.";
}
}
}

if(strpos($aUsername,'@')===false){
$wUser = "username='$aUsername'";
}
else{
$wUser = "email='$aUsername'";
}

if(isset($_POST['aActive'])){
$aaCode = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 15, 15);
$lRs=mysql_query("SELECT name,username,email,actcode,approval FROM users WHERE $wUser") or die(mysql_error());
$numrows = mysql_num_rows($lRs);
list($aName,$aUser,$aEmail,$actCode,$appr)=mysql_fetch_row($lRs);

if(empty($aUsername) || empty($aCode)){
$err[] = "Du skal udfylde begge felter";
}
else{
if(strpos($aUsername,'@')!==false && !isEmail($aUsername)){
$err[] = "Du skal indtaste en gyldig email.";
}
if(!empty($aCode) && !isAlpha($aCode,15,15) && $appr==0){
$err[] = "Du skal indtaste en aktiveringskode på 15 tegn.";
}
if($aCode=="AktiveringsKode" && $numrows>0 && $appr==0){
mysql_query("UPDATE users SET actcode='$aaCode' WHERE $wUser");

$message = "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<div><a href=\"http://$host$path\" tilte=\"$company\" target=\"_blank\"><img src=\"http://$host$path/styles/logo.png\" border=\"0\" alt=\"$company\" /></a></div>
<br /><br />Hej $aName!<br /><br />

For at aktivere din konto, skal du klikke <a href=\"http://$host$path/active.php?usrid=".base64_encode($aEmail)."&actc=$aaCode\">her</a>.<br />
<p>Eller kan du indtaste denne aktiveringskode <strong>$aaCode</strong> <a href=\"http://$host$path/active.php\">her</a>.</p><br />

<br />
<p>
Hilsen<br />
<strong>$company-teamet</strong>
<br /><br />
Dette er en automatisk genererat mail, besvar venligst ikke.
</p>
</body>
</html>";

$headers = "From: $company <no-reply@aftalt.dk> \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($aEmail, 'Ny aktiveringskode', $message, $headers);
$msg[] = "Der er blevet sendt en ny aktiverings mail til din email!";
}

if(empty($err) && $numrows <= 0){
if(strpos($aUsername,'@')===false){
$err[] = "Den indtastede brugernavn, er ikke forbundet til nogen konto.";
}
else{
$err[] = "Den indtastede email, er ikke forbundet til nogen konto.";
}
}
elseif($appr=='1'){
$err[] = "Denne konto er aktiveret i forvejen.";
}
else{
if($aCode==$actCode && $numrows>0){
mysql_query("UPDATE users SET approval='1' WHERE $wUser");

$message = "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<div><a href=\"http://$host$path\" tilte=\"$company\" target=\"_blank\"><img src=\"http://$host$path/styles/logo.png\" border=\"0\" alt=\"$company\" /></a></div>
<br /><br /><h1>Tillykke $aName!<br /><br /></h1>

<p>Din konto er nu aktiveret, og du kan logge ind ved at klikke <a href=\"http://$host$path/login.php\">her</a>.<br />
Brugernavn: $aUser</p><br />

<br />
<p>
Hilsen<br />
<strong>$company-teamet</strong>
<br /><br />
Dette er en automatisk genererat mail, besvar venligst ikke.
</p>
</body>
</html>";

$headers = "From: $company <no-reply@aftalt.dk> \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($aEmail, 'Konto aktiveret', $message, $headers);
$msg[] = "Tillykke! Din konto er nu aktiveret.";
}
elseif($aCode!="AktiveringsKode" && $aCode!=$actCode && isAlpha($aCode,15,15)){
$err[] = "Den indtastede aktiveringskode er ikke korrekt.";
}
}
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
<span class="pTitle top">Aktivere konto</span>
<form action="" method="post">
<table border="0" align="center" cellpadding="2" cellspacing="0" class="formStyle">
<tr> 
<td><label for="aUsername">Brugernavn/email:</label></td><td><input type="text" id="aUsername" name="aUsername" size="35" value="<?php echo $aUsername; ?>" /></td>
</tr>
<tr> 
<td><label for="aCode">Aktiveringskode:</label></td><td><input type="password" id="aCode" name="aCode" size="35" /></td>
</tr>
<tr> 
<td><label for="aCode">Skjul tegn:</label></td><td><input type="checkbox" checked="checked" id="togChar" onclick="document.getElementById('aCode').getAttribute('type')=='password'?document.getElementById('aCode').setAttribute('type','text'):document.getElementById('aCode').setAttribute('type','password');" /></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input type="submit" id="aActive" name="aActive" value="Aktivere konto" /></div></td>
</tr>
<tr> 
<td colspan="2">&nbsp;</td>
</tr>
<tr> 
<td colspan="2"><a href="javascript:void(0);" class="tool" onclick="document.getElementById('aCode').value='AktiveringsKode';document.getElementById('togChar').checked=false;document.getElementById('aCode').setAttribute('type','text');">Ny aktiveringskode?<span class="tip t l">Indtast dit brugernavn/email, og indtast <i>AktiveringsKode</i> i aktiveringskode feltet!<span class="tarrow at l"></span></span></a></td>
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
