<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, kontakt, adresse, support">
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title>Kontakt<?php echo "$webTitle";?></title>
</head>
<body>
<?php
$cName = $_POST['cName'];
$cEmail = mysql_real_escape_string($_POST['cEmail']);
$cSubject = mysql_real_escape_string($_POST['cSubject']);
$cMessage = $_POST['cMessage'];
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['cSend'])){
if(empty($cName) || empty($cEmail) || empty($cSubject) || empty($cMessage)){
$err[] = "Du skal udfylde alle felterne.";
}
else{
if(!isEmail($cEmail)){
$err[] = "Du skal indtaste en gyldig email.";
}
if(!isLen($cSubject,3,50)){
$err[] = "Du skal indtaste et emne på min. 3 tegn og max. 50.";
}
if(!isLen($cMessage,10,2500)){
$err[] = "Du skal indtaste en besked på min. 10 tegn og max. 2500.";
}
}

if(empty($err)) {
$message = "
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>
<body>
<div><a href=\"http://$host$path\" tilte=\"$company\" target=\"_blank\"><img src=\"http://$host$path/styles/logo.png\" border=\"0\" alt=\"$company\" /></a></div>
<br /><br />Asalam U Alaik<br /><br />

Navn: $cName<br />
Email: $cEmail<br />
Emne: $cSubject<br />
Besked: ".nl2br($cMessage)."<br />

<br />
<p>
Hilsen<br />
<strong>$company-teamet</strong>
</p>
</body>
</html>";

$headers = "From: $company <no-reply@aftalt.dk> \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail('kontakt@aftalt.dk', $cSubject, $message, $headers);
$msg[] = "Tak. Vi behandler din henvendelse hurtigst muligt.";
}
}

require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<span class="pTitle top">Kontakt Os</span>

<table width="100%" class="formStyle">
<tr>
<td>Adresse:</td>
<td>Telefon:</td>
<td>Email:</td>
</tr>
<tr style="color:#404040">
<td>Aftalt</td>
<td rowspan="3">42 64 63 62</td>
<td rowspan="3">kontakt@aftalt.dk</td>
</tr>
<tr style="color:#404040">
<td>Gymnasievej 149 1TV</td>
</tr>
<tr style="color:#404040">
<td>DK-4600 Køge</td>
</tr>
</table>

<form action="" method="post">
<table cellspacing="7" class="formStyle">
<tr>
<td>Navn:</td><td><input type="text" id="cName" name="cName" size="75" maxlength="50" value="<?php echo $cName; ?>" /></td>
</tr>
<tr>
<td>Email:</td><td><input type="text" id="cEmail" name="cEmail" size="75" value="<?php echo $cEmail; ?>" /></td>
</tr>
<tr>
<td>Emne:</td><td><input type="text" id="cSubject" name="cSubject" size="75" maxlength="50" value="<?php echo $cSubject; ?>" /></td>
</tr>
<tr>
<td>Besked:</td><td><textarea id="cMessage" name="cMessage" cols="75" rows="15"><?php echo $cMessage; ?></textarea></td>
</tr>
<tr>
<td>&nbsp;</td><td><input type="submit" name="cSend" id="cSend" value="Send besked" /></td>
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
