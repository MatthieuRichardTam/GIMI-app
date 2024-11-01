<?php
include '../scripts_php/pdo_mySQL.php';

$conn = new PdoMySQL();

$result = $conn->delete_injection($_POST["id"]);

if (isset($result)) {
    echo json_encode(["code"=> 200]);
} else {
    echo json_encode(["code"=> 403]);
}