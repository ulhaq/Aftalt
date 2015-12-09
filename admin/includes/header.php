<?php
echo '<noscript><div align="center" class="error" style="z-index:801;">Javascript understøttes ikke eller er deaktiveret på din browser, dette kan påvirke nogle funktioner på websitet.</div></noscript>';

if(!empty($err))  {
echo "<div class=\"error\">";
foreach ($err as $e) {
echo "$e<br />";
}
echo "</div>";	
}
if(!empty($msg))  {
echo "<div class=\"msg\">" . $msg[0] . "</div>";
}

if(isset($_COOKIE['a_userid'])){$_SESSION['a_userid']=$_COOKIE['a_userid'];}
list($dUserId)=mysql_fetch_row(mysql_query("SELECT a_userid FROM users WHERE a_userid='$_SESSION[a_userid]'"));
if(isset($_SESSION['a_userid']) && $_SESSION['a_userid']!=$dUserId || isset($_COOKIE['a_userid']) && $_COOKIE['a_userid']!=$dUserId){logout();}
if(logged()==true && userRole()!=5){
setcookie('a_userid',$_SESSION['a_userid'],time()-60*60*24*365);
unset($_SESSION['a_userid']);
session_destroy();
header("location:http://$host$path/index.php");
}

echo "<div id='linksTopRight'><ul>";
if(logged()==true){
echo "<li><a href='http://$host/'>Vist site</a></li>
<li><a href='http://$host$path/logout.php?cmd=logout&id=".md5($_SESSION['a_userid'])."'>Log ud</a></li>";
}

echo "
</ul>
</div>


<div id='globalContainer'>
<div id='globalLogoContainer'><a href='http://$host$path/' id='globalLogoContent' title='Hjem'></a></div>";

if(logged()==true){
echo "
<ul id='globalNav'>
<li><a href='http://$host$path/main.php'>Hjem</a></li>
<li><a href='http://$host$path/tasks.php'>Opgaver</a></li>
<li><a href='http://$host$path/freelancers.php'>Brugere</a></li>
<li><a href='http://$host$path/register.php'>Opret bruger</a></li>
</ul>";
}
?>
