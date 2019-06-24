<?php
require 'configDB.php';

$id = $_GET['id'];

$sql = 'DELETE FROM `tasks`.taskstodo WHERE `id` = ? ';
$query = $conn->prepare($sql);
$query->execute([$id]);

header('Location: index.php');


?>