<?php
include '../scripts_php/pdo_mySQL.php';
session_start();
$conn = new PdoMySQL();

$result = $conn->change_task_user($_POST["id"],$_SESSION["username"]);
if (isset($result)) {
    echo json_encode(["code"=> 200]);
} else {
    echo json_encode(["code"=> 403]);
}