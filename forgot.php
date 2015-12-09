<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, profil, forgot, forgot password, glemt, glemt password, glemt kodeord">
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title>Nulstil password<?php echo "$webTitle";?></title>
</head>
<body>
<?php
$fUsername = mysql_real_escape_string($_POST['fUsername']);
$rNo = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 5, 15);
$fHashed = hashPwd($rNo);

if(strpos($fUsername,'@')===false){
$wUser = "username='$fUsername'";
}
else{
$wUser = "email='$fUsername'";
}

if(isset($_POST['fReset'])){
if(empty($fUsername)){
$err[] = "Du skal indtaste en brugernavn/email.";
}
else{
$lRs=mysql_query("SELECT name,email,approval FROM users WHERE $wUser") or die(mysql_error());
$numrows = mysql_num_rows($lRs);
list($fName,$fEmail,$appr)=mysql_fetch_row($lRs);

if(empty($err) && $numrows <= 0){
if(strpos($fUsername,'@')===false){
$err[] = "Den indtastede brugernavn, er ikke forbundet til nogen konto.";
}
else{
$err[] = "Den indtastede email, er ikke forbundet til nogen konto.";
}
}
elseif(empty($err) && $appr==0){
$err[] = "Denne konto er ikke aktiveret endnu. <a href='http://$host$path/active.php'>Aktivere her</a>";
}
else{
mysql_query("UPDATE users SET password='$fHashed' WHERE $wUser");

$message = "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<div><a href=\"http://$host$path\" tilte=\"$company\" target=\"_blank\"><img src=\"http://$host$path/styles/logo.png\" border=\"0\" alt=\"$company\" /></a></div>
<br /><br />Hej $fName!<br /><br />
Her er din nye password...
<p>
Email: $fEmail<br />
Password: $rNo<br /><br />
</p>

<p>Klik <a href=\"http://$host$path/login.php\">her</a> for at logge ind</p><br />

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

mail($fEmail, 'Password Nulstilling', $message, $headers);
$msg[] = "Vi har sendt dig en email med din nye password.";
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
<span class="pTitle top">Nulstil password</span>
<form action="" method="post">
<table border="0" align="center" cellpadding="2" cellspacing="0" class="formStyle">
<tr> 
<td><label for="fUsername">Brugernavn/email:</label></td><td><input type="text" id="fUsername" name="fUsername" size="35" value="<?php echo $fUsername; ?>" /></td>
</tr>
<tr> 
<td colspan="2"><div align="center"><input type="submit" id="fReset" name="fReset" value="Nulstil" /></div></td>
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
