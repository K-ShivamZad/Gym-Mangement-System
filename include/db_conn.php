<?php
$host = "localhost";
$username = "root";
$password = ""; 
$db_name = "gymsysdb"; 

// The variable MUST be exactly $con
$con = mysqli_connect($host, $username, $password, $db_name);

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
?>