<?php
require_once "config.php";
$q = trim($_GET['q']);
$limit = @$_GET['s'];
if(empty($limit) || $limit<10){
$limit = 10;
}
else{
$limit = ceil($limit/10)*10;
}

if(!empty($q)){
$rs = mysql_query("SELECT * FROM tasks WHERE name LIKE '%$q%' OR budget LIKE '%$q%' OR deadline LIKE '%$q%' OR location LIKE '%$q%' OR comp LIKE '%$q%' OR date LIKE '%$q%' ORDER BY time DESC LIMIT 0,$limit");
$numrowslimit = mysql_num_rows($rs);
$numrows = mysql_num_rows(mysql_query("SELECT * FROM tasks WHERE name LIKE '%$q%' OR budget LIKE '%$q%' OR deadline LIKE '%$q%' OR location LIKE '%$q%' OR comp LIKE '%$q%' OR date LIKE '%$q%'"));
if($numrows>0){
$a = $limit;
if ($a > $numrows){
$a = $numrows;
}
$b = 1 ;
$numbers = number_format($numrows);
if($numrows==1){
echo "<li class='searchMsg'>Der vises 1 opgave for søgningen <i>'$q'</i></li>";
}
elseif($numrows>1){
echo "<li class='searchMsg'>Der vises $b - $a ud af ca. $numbers opgaver for søgningen <i>'$q'</i></li>";
}
while($row=mysql_fetch_assoc($rs)){
$actStatus = $row['active']==0 ? 1 : 0;
$actTxtStatus = $actStatus==0 ? "Deaktiver" : "Aktiver";
echo "
<li class='rsListed' onclick='javascript:location.href=\"tdetails.php?id=$row[id]\"' onmouseover='javascript:this.style.cursor=\"pointer\"'>
<div class='rsTop'>
<a href='tdetails.php?id=$row[id]' class='rsTitle tool'>";
echo highlight($q,$row['name']);
echo "<span class='tip t l'>Opgavetitle<span class='tarrow at l'></span></span></a>
<span class='rsDate tool'>";
cpTime($row['time'],$row['date'],"%d-%m-%Y");
echo "<span class='tip t l'>Tid<span class='tarrow at l'></span></span></span>
</div>
<div class='rsDesc tool'>";
addDots($row['desc'],0,125);
echo "<span class='tip t l'>Beskrivelse<span class='tarrow at l'></span></span>
</div>
<div class='rsBottom'>
<span class='rsBudget tool'>";
echo highlight($q,$row['budget']);
echo "<span class='tip t l'>Budget<span class='tarrow at l'></span></span></span>
<span class='rsComp tool'>";
echo highlight($q,$row['comp']);
echo "<span class='tip t l'>Kompetencer<span class='tarrow at l'></span></span></span>
</div>
<a href='tasks.php?act=$actStatus&taskid=$row[id]' title='$actTxtStatus $row[name]' style='display:block;text-align:right;color:#FFFFFF;font-weight:bold;'>$actTxtStatus</a>
</li>";
}
}
else if($numrows==0){
echo "<li class='searchMsg'>Din søgning for <i>'$q'</i> gav intet resultat
<ul style='text-align:left;background:transparent;'><li>Forslag:</li><li>Sørg for at alle ord er stavet korrekt.</li><li>Prøv forskellige søgeord.</li><li>Prøv mere generelle søgeord.</li></ul>
</li>";
}
if($numrows>10 && $numrows!=$numrowslimit){
$limit += 10;
echo "<li class='showMore'><a href='?q=$q&s=$limit' id='showMore' onclick='loadRs(\"tq\",$limit); return false;'>Vis flere</a></li>";
}
elseif($numrows>0 && $numrows==$numrowslimit){
echo "<li class='searchMsg'>Der er ikke flere opgaver</li>";
}
}
else{
$aRs = mysql_query("SELECT * FROM tasks ORDER BY time DESC LIMIT 0,$limit");
$rsNumL= mysql_num_rows($aRs);
$rsNum = mysql_num_rows(mysql_query("SELECT * FROM tasks"));
if($rsNum>0){
$a = $limit;
if ($a > $rsNum){
$a = $rsNum;
}
$b = 1;
$aNumbers = number_format($rsNum);
if($rsNum==1){
echo "<li class='searchMsg'>Der vises $b opgave</li>";
}
elseif($rsNum>1){
echo "<li class='searchMsg'>Der vises $b - $a ud af ca. $aNumbers opgaver</li>";
}
while($row=mysql_fetch_assoc($aRs)){
$actStatus = $row['active']==0 ? 1 : 0;
$actTxtStatus = $actStatus==0 ? "Deaktiver" : "Aktiver";
echo "
<li class='rsListed' onclick='javascript:location.href=\"tdetails.php?id=$row[id]\"' onmouseover='javascript:this.style.cursor=\"pointer\"'>
<div class='rsTop'>
<a href='tdetails.php?id=$row[id]' class='rsTitle tool'>$row[name]<span class='tip t l'>Opgavetitle<span class='tarrow at l'></span></span></a>
<span class='rsDate tool'>";
cpTime($row['time'],$row['date'],"%d-%m-%Y");
echo "<span class='tip t l'>Tid<span class='tarrow at l'></span></span></span>
</div>
<div class='rsDesc tool'>";
addDots($row['desc'],0,125);
echo "<span class='tip t l'>Beskrivelse<span class='tarrow at l'></span></span>
</div>
<div class='rsBottom'>
<span class='rsBudget tool'>$row[budget]<span class='tip t l'>Budget<span class='tarrow at l'></span></span></span>
<span class='rsComp tool'>$row[comp]<span class='tip t l'>Kompetencer<span class='tarrow at l'></span></span></span>
</div>
<a href='tasks.php?act=$actStatus&taskid=$row[id]' title='$actTxtStatus $row[name]' style='display:block;text-align:right;color:#FFFFFF;font-weight:bold;'>$actTxtStatus</a>
</li>";
}
}
else if($rsNum==0){
echo "<li class='searchMsg'>Der er ingen opgaver</li>";
}
if($rsNum>10 && $rsNum!=$rsNumL){
$limit += 10;
echo "<li class='showMore'><a href='?s=$limit' id='showMore' onclick='loadRs(\"tq\",$limit); return false;'>Vis flere</a></li>";
}
elseif($rsNum>0 && $rsNum==$rsNumL){
echo "<li class='searchMsg'>Der er ikke flere opgaver</li>";
}
}
?>