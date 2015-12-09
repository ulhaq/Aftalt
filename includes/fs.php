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
$sUE="";
if(logged()==true){
$sUE = "OR username LIKE '%$q%' OR email LIKE '%$q%'";
}

if(!empty($q)){
$rs = mysql_query("SELECT * FROM users WHERE (name LIKE '%$q%' $sUE OR phone LIKE '%$q%' OR website LIKE '%$q%' OR postal LIKE '%$q%' OR city LIKE '%$q%' OR address LIKE '%$q%' OR competencies LIKE '%$q%') AND level!='5' ORDER BY time DESC LIMIT 0,$limit");
$numrowslimit = mysql_num_rows($rs);
$numrows = mysql_num_rows(mysql_query("SELECT * FROM users WHERE (name LIKE '%$q%' $sUE OR phone LIKE '%$q%' OR website LIKE '%$q%' OR postal LIKE '%$q%' OR city LIKE '%$q%' OR address LIKE '%$q%' OR competencies LIKE '%$q%') AND level!='5'"));
if($numrows>0){
$a = $limit;
if ($a > $numrows){
$a = $numrows;
}
$b = 1 ;
$numbers = number_format($numrows);
if($numrows==1){
echo "<li class='searchMsg'>Der vises 1 freelancer for søgningen <i>'$q'</i></li>";
}
elseif($numrows>1){
echo "<li class='searchMsg'>Der vises $b - $a ud af ca. $numbers freelancere for søgningen <i>'$q'</i></li>";
}
while($row=mysql_fetch_assoc($rs)){
echo "
<li class='rsListed' onclick='javascript:location.href=\"freelancers/$row[username]\"' onmouseover='javascript:this.style.cursor=\"pointer\"'>
<div class='rsTop'>
<a href='freelancers/$row[username]' class='rsTitle tool'>";
echo highlight($q,$row['name']);
echo "<span class='tip t l'>Navn<span class='tarrow at l'></span></span></a>
<span class='rsDate tool'>";
if($row['last_login']=="" || $row['time']==""){echo "Aldrig";}else{cpTime($row['time'],$row['last_login'],"%d-%m-%Y");}
echo "<span class='tip t l'>Seneste log ind<span class='tarrow at l'></span></span>
</span></div>
<div class='rsDesc tool'>";
if($row['phone']!=""){echo highlight($q,$row['phone'])."<span class='tip t l'>Telefon nummer<span class='tarrow at l'></span></span>";}
echo "</div>
<div class='rsBottom'>";
if($row['postal']!="" || $row['city']!="") {?>
<span class="rsBudget tool"><?php echo highlight($q,"$row[postal] $row[city]"); ?><span class="tip t l">Geografi<span class="tarrow at l"></span></span></span>
<? }
echo "<span class='rsComp tool'>";
echo highlight($q,$row[competencies]);
echo "<span class='tip t l'>Kompetencer<span class='tarrow at l'></span></span></span>
</div>
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
echo "<li class='showMore'><a href='?q=$q&s=$limit' id='showMore' onclick='loadRs(\"fq\",$limit); return false;'>Vis flere</a></li>";
}
elseif($numrows>0 && $numrows==$numrowslimit){
echo "<li class='searchMsg'>Der er ikke flere freelancere</li>";
}
}
else{
$aRs = mysql_query("SELECT * FROM users WHERE level!='5' ORDER BY time DESC LIMIT 0,$limit");
$rsNumL= mysql_num_rows($aRs);
$rsNum = mysql_num_rows(mysql_query("SELECT * FROM users WHERE level!='5' ORDER BY time DESC"));
if($rsNum>0){
$a = $limit;
if ($a > $rsNum){
$a = $rsNum;
}
$b = 1;
$aNumbers = number_format($rsNum);
if($rsNum==1){
echo "<li class='searchMsg'>Der vises 1 freelancer</li>";
}
elseif($rsNum>1){
echo "<li class='searchMsg'>Der vises $b - $a ud af ca. $aNumbers freelancere</li>";
}
while($row=mysql_fetch_assoc($aRs)){
echo "
<li class='rsListed' onclick='javascript:location.href=\"freelancers/$row[username]\"' onmouseover='javascript:this.style.cursor=\"pointer\"'>
<div class='rsTop'>
<a href='freelancers/$row[username]' class='rsTitle tool'>$row[name]<span class='tip t l'>Navn<span class='tarrow at l'></span></span></a>
<span class='rsDate tool'>";
if($row['last_login']=="" || $row['time']==""){echo "Aldrig";}else{cpTime($row['time'],$row['last_login'],"%d-%m-%Y");}
echo "<span class='tip t l'>Seneste log ind<span class='tarrow at l'></span></span>
</span></div>
<div class='rsDesc tool'>";
if($row['phone']!=""){echo "$row[phone]<span class='tip t l'>Telefon nummer<span class='tarrow at l'></span></span>";}
echo "</div>
<div class='rsBottom'>";
if($row['postal']!="" || $row['city']!="") {?>
<span class="rsBudget tool"><?php echo "$row[postal] $row[city]"; ?><span class="tip t l">Geografi<span class="tarrow at l"></span></span></span>
<? }
echo "<span class='rsComp tool'>$row[competencies]<span class='tip t l'>Kompetencer<span class='tarrow at l'></span></span></span>
</div>
</li>";
}
}
else if($rsNum==0){
echo "<li class='searchMsg'>Der er ingen freelancere</li>";
}
if($rsNum>10 && $rsNum!=$rsNumL){
$limit += 10;
echo "<li class='showMore'><a href='?s=$limit' id='showMore' onclick='loadRs(\"fq\",$limit); return false;'>Vis flere</a></li>";
}
elseif($rsNum>0 && $rsNum==$rsNumL){
echo "<li class='searchMsg'>Der er ikke flere freelancere</li>";
}
}
?>
