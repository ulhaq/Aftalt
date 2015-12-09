<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, hjem, forside, freelancer, opgave, freelance opgave, profil, opret, opret freelancer, opret opgave, opret gratis, gratis opgave, gratis freelancer, opret gratis opgave, opret gratis freelancer">
<meta name="description" content="Aftalt er punktet, hvor kontakten mellem freelancere og opgaveudbydere etableres." /> 
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title><?php echo $company; ?> - Get the task agreed</title>
</head>
<body>
<?php
require_once "includes/header.php";
?>
<div id="globalIntroContainer">
<div id="globalIntroContent">
<div id="clintro"><a href="<?php echo "http://$host$path/";?>freelancers.php"><img alt="Opgaveudbyder" src="<?php echo "http://$host$path/";?>styles/clintro.png" border="0" /></a></div>
<div id="allinc"><img src="<?php echo "http://$host$path/";?>styles/allinc.png" border="0" alt="Nemt og enkelt" /></div>
<div id="frintro"><a href="<?php echo "http://$host$path/";?>tasks.php"><img alt="Freelancere" src="<?php echo "http://$host$path/";?>styles/frintro.png" border="0" /></a></div>
</div>
</div>

<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<ul id="globalListContentRs">
<?php
$lRs = mysql_query("SELECT * FROM tasks WHERE active='1' ORDER BY time DESC LIMIT 0,5");
$ddn = mysql_num_rows($lRs);
if(mysql_num_rows($lRs)==0){
echo "<li class='searchMsg'>Der er ingen opgaver</li>";
}
else{
echo "<li class='searchMsg'>Der vises $ddn seneste opgaver</li>";
while($row=mysql_fetch_assoc($lRs)){
echo "
<li class='rsListed' onclick='javascript:location.href=\"http://$host$path/tasks/$row[tname]\"' onmouseover='javascript:this.style.cursor=\"pointer\"'>
<div class='rsTop'>
<a href='http://$host$path/tasks/$row[tname]' class='rsTitle tool'>$row[name]<span class='tip t l'>Opgavetitle<span class='tarrow at l'></span></span></a>
<span class='rsDate tool'>";
cpTime($row['time'],$row['date'], "%d-%m-%Y");
echo "<span class='tip t l'>Tid<span class='tarrow at l'></span></span>
</span>
</div>
<div class='rsDesc tool'>";
addDots($row['desc'],0,125);
echo "<span class='tip t l'>Beskrivelse<span class='tarrow at l'></span></span>
</div>
<div class='rsBottom'>
<span class='rsBudget tool'>$row[budget]<span class='tip t l'>Budget<span class='tarrow at l'></span></span></span>
<span class='rsComp tool'>$row[comp]<span class='tip t l'>Kompetencer<span class='tarrow at l'></span></span></span>
</div>
</li>
";}
if(mysql_num_rows(mysql_query("SELECT * FROM tasks WHERE active='1'"))>5){
echo "<li class='showMore'><a href='http://$host$path/tasks.php'>Vis flere</a></li>";
}
}
?>
</ul>
</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>
