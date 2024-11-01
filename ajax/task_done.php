<?php
include '../scripts_php/pdo_mySQL.php';

$conn = new PdoMySQL();

$result = $conn->task_done($_POST["id"]);

if (isset($result)) {
    echo json_encode(["code"=> 200]);
} else {
    echo json_encode(["code"=> 403]);
}