<?php
$task = $_POST['task'];

if ($task == ''){

    echo 'fill your task';
    exit();
};



require 'configDB.php';


//$conn = 'mysql:host=localhost;dbname=tasks';
//$pdo = new PDO($conn, 'root');

$sql = 'INSERT INTO `tasks`.taskstodo(taskNew) VALUES (:taskNew)';

$query = $conn->prepare($sql);
$query->execute(['taskNew' => $task]);

header('Location: index.php');


