<?php

$Host = "localhost";
$DBname = "peractice";
$username = "root";
$password = "";
$tblname = "cmsTbl";
$tblLogin = "login";
$setname = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

try {
    $connection = new PDO("mysql:host=$Host;dbname=$DBname;",$username,$password,$setname);
//    $connection->close();

}

catch (PDOException $err){
    echo "Connection failed" . $err->getMessage();
}