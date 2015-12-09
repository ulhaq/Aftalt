<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title>Opret profil<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();

$name = mysql_real_escape_string($_POST['name']);
$username = mysql_real_escape_string($_POST['username']);
$email = mysql_real_escape_string($_POST['email']);
$password = mysql_real_escape_string($_POST['password']);
$rePassword = mysql_real_escape_string($_POST['rePassword']);
$aCode = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 15, 15);
$hashedPwd = hashPwd($password);
$userId = hashPwd(str_shuffle("1234567890qwertyuiopasdfghjkklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"));
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['register'])){
if(empty($name) || empty($username) || empty($email) || empty($password)){
$err[] = "Du skal udfylde alle felterne.";
}
else{
$uDup = mysql_query("SELECT COUNT(*) AS cU FROM users WHERE username='$username'") or die(mysql_error());
list($cU)=mysql_fetch_row($uDup);
if($cU>0){
$err[] = "Brugernavn eksisterer allerede.";
}
$eDup = mysql_query("SELECT COUNT(*) AS cE FROM users WHERE email='$email'") or die(mysql_error());
list($cE)=mysql_fetch_row($eDup);
if($cE>0){
$err[] = "Email eksisterer allerede.";
}

if(!isAlpha($username,5,25) && $cU==0 && $cE==0){
$err[] = "Du skal indtaste et brugernavn, på min. 5 tegn og max. 25. Brug venligst kun bogstaver (a-z), tal og perioder.";
}
if(!isEmail($email) && $cU==0 && $cE==0){
$err[] = "Du skal indtaste en gyldig email.";
}
if(!isEqual($password,$rePassword,7) && $cU==0 && $cE==0){
$err[] = "Du skal indtaste to ens passwords, på minimum 7 tegn.";
}
}

if(empty($err)) {
$apprVal = (isset($_POST['actAcc']) && $_POST['actAcc']==1) ? 1:0;
mysql_query("INSERT INTO users (name,username,password,email,a_userid,ip,register_date,actcode,approval)VALUES('$name','$username','$hashedPwd','$email','$userId','$ip','$cDate','$aCode','$apprVal')");

if($apprVal==0){
$message = "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<div><a href=\"http://aftalt.dk\" tilte=\"$company\" target=\"_blank\"><img src=\"http://aftalt.dk/styles/logo.png\" border=\"0\" alt=\"$company\" /></a></div>
<br /><br />Hej $name!<br /><br />

For at aktivere din konto, skal du klikke <a href=\"http://$host$path/active.php?usrid=".base64_encode($email)."&actc=$aCode\">her</a>.<br />

<p>Hvis linket ikke virker, kan du kopiere nedenstående link til adressefeltet:<br />
http://$host$path/active.php?usrid=".base64_encode($email)."&actc=$aCode</p><br />

<p>Dette er din midlertidig password: <b>$password</b><br />
Ændre denne password!</p><br />

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

mail($email, 'Ny profil', $message, $headers);
$msg[] = "Profilen er blevet oprettet og en aktiverings mail er blevet sendt!";
}
elseif($apprVal==1){
$message = "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<div><a href=\"http://aftalt.dk\" tilte=\"$company\" target=\"_blank\"><img src=\"http://aftalt.dk/styles/logo.png\" border=\"0\" alt=\"$company\" /></a></div>
<br /><br /><h1>Tillykke $name!<br /><br /></h1>

<p>Din konto er nu aktiveret, og du kan logge ind ved at klikke <a href=\"http://aftalt.dk/login.php\">her</a>.<br />
Brugernavn: <b>$username</b><br />
Password: </b>$password</b><br />
Ændre denne password</p><br />

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

mail($email, 'Ny profil', $message, $headers);
$msg[] = "Profilen er blevet oprettet og aktiveret!";
}
}
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
<td><label>Navn:</label></td><td><input type="text" id="name" name="name" size="35" value="<?php echo $name; ?>" /></td>
</tr>
<tr> 
<td><label>Brugernavn:</label></td><td><input type="text" id="username" name="username" size="35" value="<?php echo $username; ?>" /></td>
</tr>
<tr> 
<td><label>Email:</label></td><td><input type="text" id="email" name="email" size="35" value="<?php echo $email; ?>" /></td>
</tr>
<tr> 
<td><label>Password:</label></td><td><input type="text" id="password" name="password" size="35" value="<?php echo $password; ?>" /></td>
</tr>
<tr> 
<td><label>Gentag password:</label></td><td><input type="text" id="rePassword" name="rePassword" size="35" value="<?php echo $rePassword; ?>" /></td>
</tr>
<tr> 
<td>&nbsp;</td><td><input type="button" value="Generate password" onclick="genRand('password,rePassword');" /></td>
</tr>
<tr> 
<td><label>Aktiver konto:</label></td><td><input name="actAcc" type="checkbox" id="actAcc" value="1" /></td>
</tr>
<tr> 
<td colspan="2">&nbsp;</td>
</tr>
<tr> 
<td>&nbsp;</td><td><input type="submit" id="register" name="register" value="Opret ny profil" /></td>
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