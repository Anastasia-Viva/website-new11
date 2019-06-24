<?php


$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "tasks";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root");
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
};



