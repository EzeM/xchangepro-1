<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
session_start();
$_SESSION["userID"]="";
$_SESSION["userName"]="";
session_destroy();
header("Location:../php/index.php");
?>
