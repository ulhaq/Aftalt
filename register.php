<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, freelancer, opgave, freelance opgave, profil, opret, opret profil, opret konto, registrere, registrere profil, registrere konto">
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title>Opret profil<?php echo "$webTitle";?></title>
</head>
<body>
<?php
$rName = mysql_real_escape_string($_POST['rName']);
$rUsername = mysql_real_escape_string($_POST['rUsername']);
$rEmail = mysql_real_escape_string($_POST['rEmail']);
$rPassword = mysql_real_escape_string($_POST['rPassword']);
$rPasswordRe = mysql_real_escape_string($_POST['rPasswordRe']);
$raCode = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 15, 15);
$hashedPwd = hashPwd($rPassword);
$rUserId = hashPwd(str_shuffle("1234567890qwertyuiopasdfghjkklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"));
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['rRegister'])){
if(empty($rName) || empty($rUsername) || empty($rEmail) || empty($rPassword) || empty($rPasswordRe)){
$err[] = "Du skal udfylde alle felterne.";
}
else{
$UDup = mysql_query("SELECT COUNT(*) AS cU FROM users WHERE username='$rUsername'") or die(mysql_error());
list($cU)=mysql_fetch_row($UDup);
if($cU>0){
$err[] = "Brugernavn eksisterer allerede.";
}
$EDup = mysql_query("SELECT COUNT(*) AS cE FROM users WHERE email='$rEmail'") or die(mysql_error());
list($cE)=mysql_fetch_row($EDup);
if($cE>0){
$err[] = "Email eksisterer allerede.";
}

if(!isAlpha($rUsername,5,25) && $cU==0 && $cE==0){
$err[] = "Du skal indtaste et brugernavn, på min. 5 tegn og max. 25. Brug venligst kun bogstaver (a-z), tal og perioder.";
}
if(!isEmail($rEmail) && $cU==0 && $cE==0){
$err[] = "Du skal indtaste en gyldig email.";
}
if(!isEqual($rPassword,$rPasswordRe,7) && $cU==0 && $cE==0){
$err[] = "Du skal indtaste to ens passwords, på minimum 7 tegn.";
}
}

if(empty($err)) {
mysql_query("INSERT INTO users (name,username,password,email,a_userid,ip,register_date,actcode)VALUES('$rName','$rUsername','$hashedPwd','$rEmail','$rUserId','$ip','$cDate','$raCode')");

$message = "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<div><a href=\"http://$host$path\" tilte=\"$company\" target=\"_blank\"><img src=\"http://$host$path/styles/logo.png\" border=\"0\" alt=\"$company\" /></a></div>
<br /><br />Hej $rName!<br /><br />

For at aktivere din konto, skal du klikke <a href=\"http://$host$path/active.php?usrid=".base64_encode($rEmail)."&actc=$raCode\">her</a>.<br />

<p>Hvis linket ikke virker, kan du kopiere nedenst�ende link til adressefeltet:<br />
http://$host$path/active.php?usrid=".base64_encode($rEmail)."&actc=$raCode</p><br />

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

mail($rEmail, 'Ny profil', $message, $headers);
$msg[] = "Tillykke! Din profil er oprettet, og en aktiverings mail er blevet sendt til din email!";
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
<span class="pTitle top">Opret profil</span>
<form action="" method="post">
<table border="0" align="center" cellpadding="2" cellspacing="0" class="formStyle">
<tr> 
<td><label>Navn:</label></td><td><input type="text" id="rName" name="rName" size="35" value="<?php echo $rName; ?>" /></td>
</tr>
<tr> 
<td><label>Brugernavn:</label></td><td><input type="text" id="rUsername" name="rUsername" size="35" value="<?php echo $rUsername; ?>" /></td>
</tr>
<tr> 
<td><label>Email:</label></td><td><input type="text" id="rEmail" name="rEmail" size="35" value="<?php echo $rEmail; ?>" /></td>
</tr>
<tr> 
<td><label>Password:</label></td><td><input type="password" id="rPassword" name="rPassword" size="35" /></td>
</tr>
<tr> 
<td><label>Gentag Password:</label></td><td><input type="password" id="rPasswordRe" name="rPasswordRe" size="35" /></td>
</tr>
<tr> 
<td>&nbsp;</td><td><input type="submit" id="rRegister" name="rRegister" value="Opret ny profil" /></td>
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
