<?php
date_default_timezone_set('America/Bogota');
$servername = "localhost";
$username = "id15526869_club";
$password = "R9JQwMQ8BRnjDX<J";
$dbname = "id15526869_bdorigen";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    	echo "Connection failed: " . $e->getMessage();
    }

?>