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
<title>Log ind<?php echo "$webTitle";?></title>
</head>
<body>
<?php
$username = mysql_real_escape_string($_POST['username']);
$password = mysql_real_escape_string($_POST['password']);

$wUser = strpos($username,'@')===false ? "username='$username'" : "email='$username'";

if(isset($_POST['login'])){
if(empty($username) || empty($password)){
$err[] = "Du skal udfylde begge felter";
}

$lRs=mysql_query("SELECT password,email,level,approval FROM users WHERE $wUser") or die(mysql_error());
$numrows = mysql_num_rows($lRs);
list($dbPwd, $email,$level,$rappr)=mysql_fetch_row($lRs);

if(empty($err) && $numrows>0 && $rappr=='0'){
$err[] = "Denne konto er ikke aktiveret endnu.";
}
elseif(empty($err) && $numrows>0 && $level!='5' && $rappr=='1'){
$err[] = 'Du har ikke administrator rettigheder.';
}
if(empty($err) && $numrows>0 && $dbPwd === hashPwd($password,$dbPwd) && $level=='5' && $rappr=='1'){
session_regenerate_id(TRUE);
$a_userid= randKey();
$_SESSION['a_userid']=$a_userid;

mysql_query("UPDATE users SET a_userid='$a_userid', time='$cTime', last_login='$cDate' WHERE email='$email'");
header("location:main.php");
}
elseif($numrows==0 && !empty($username) && !empty($password)){
if(strpos($username,'@')===false){
$err[] = "Den indtastede brugernavn, er ikke forbundet til nogen konto.";
}
else{
$err[] = "Den indtastede email, er ikke forbundet til nogen konto.";
}
}
elseif($dbPwd !== hashPwd($password,$dbPwd) && !empty($username) && !empty($password) && $level=='5' && $rappr=='1'){
$err[] = 'Den indtastede password er forkert.';
}
}
if(logged()==true){
header("location:main.php");
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
<td><label for="username">Brugernavn/email:</label></td><td><input type="text" id="username" name="username" size="35" value="<?php echo $username; ?>" /></td>
</tr>
<tr> 
<td><label for="password">Password:</label></td><td><input type="password" id="password" name="password" size="35" /></td>
</tr>
<tr> 
<td colspan="2">&nbsp;</td>
</tr>
<tr> 
<td colspan="2"><div align="center"><input type="submit" id="login" name="login" value="Log ind" /></div></td>
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