<?php
require_once "includes/config.php";
if(isset($_GET['cmd']) && $_GET['cmd']=="logout" && isset($_GET['id']) && $_GET['id']==md5($_SESSION['a_userid'])){
logout();
}
else{
header("location:http://$host$path/index.php");
}
?>