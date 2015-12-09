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
<script>
if($("#showMore")){$(window).scroll(function(){if($(window).scrollTop()>=$(document).height()-$(window).height()-300){$("#showMore").click();}});}
</script>
<title><?php if(isset($_GET['q']) && $_GET['q']!=""){echo $_GET['q']." - Søgning af ";}else{echo "";} ?>Opgaver<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();

if(isset($_GET['act']) && !empty($_GET['taskid'])){
mysql_query("UPDATE tasks SET active='$_GET[act]' WHERE id='$_GET[taskid]'") or die(mysql_error());
$msg[] = $_GET[act] == 0 ? "Opgaven er deaktiveret." : "Opgaven er aktiveret.";
}

require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalSearch">
<form action="" method="get">
<div id="globalSearchContainer">
<input type="text" id="q" class="tq" name="q" autocomplete="off" spellcheck="false" onkeyup="getInstant(this);" value="<?php echo $_GET['q'];  ?>" />
<input type="submit" id="search" name="search" value="" title="Søg" />
<div id="qReset"></div>
</div>
<div align="left" style="font-weight:normal;font-size:9px;">Søg på: Navn, budget, <span class="tool" style="font-weight:normal;font-size:9px;">deadline<span style="font-weight:normal;font-size:9px;top:25px;" class="tip b l">Fx: 21-05-2012 13:24:01<span class="tarrow ab l"></span></span></span>, geografi, kompetencer eller <span class="tool" style="font-weight:normal;font-size:9px;">oprettelses dato<span style="font-weight:normal;font-size:9px;top:25px;" class="tip b l">Fx: 21-05-2012 13:24:01<span class="tarrow ab l"></span></span></span></div>
</form>
</div>
<div id="globalRsList">
<div class="globalListContent">
<ul id="globalListContentRs">
<?php include "includes/ts.php";?>
</ul>
</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>