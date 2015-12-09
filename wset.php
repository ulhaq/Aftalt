<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, freelancer, opgave, freelance opgave, genveje, tastatur, tastaturgenveje, tastatur genveje">
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title>Tastaturgenveje<?php echo "$webTitle";?></title>
</head>
<body>
<?php
require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<span class="pTitle top">Tastaturgenveje</span>
<table border="0" width="100%" align="center" cellpadding="25" cellspacing="0" class="formStyle">
<tr>
<td style="border-bottom:2px dotted #CCC;">Ctrl + ?:</td><td style="border-bottom:2px dotted #CCC;">Omdirigerer til denne side.</td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Ctrl + enter:</td><td style="border-bottom:2px dotted #CCC;">Omdirigerer til forsiden.</td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Ctrl + S:</td><td style="border-bottom:2px dotted #CCC;"><table><tr><td>Omdirigerer til:</td><td><table><tr><td><input type="radio" name="rcs" id="rt" onchange="setCookie('rcs','tasks','365','TRUE');" <?php if($_COOKIE['rcs']=="tasks"){echo "checked='checked'";} ?> /> <label for="rt">Opgave siden</label></td></tr><tr><td><input type="radio" name="rcs" id="rf" onchange="setCookie('rcs','freelancers','365','TRUE');" <?php if($_COOKIE['rcs']=="freelancers"){echo "checked='checked'";} ?> /> <label for="rf">Freelancere siden</label></td></tr></table></td></tr></table></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Ctrl + mellemrum:</td><td style="border-bottom:2px dotted #CCC;">Ruller siden til toppen.</td>
</tr>
</table>

</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>
