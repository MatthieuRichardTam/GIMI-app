<?php
session_start();

// si vous n'êtes pas connecté, renvoie vers la page de connexion
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include "pdo_mySQL.php";
include "injection.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Préparation des données pour les envoyer au script Python
    $row_input = array();
    $row_input['id']=NULL;
    $row_input['bed'] = $_POST['bed'];
    $row_input['first_name'] = $_POST['first_name'];
    $row_input['last_name'] = $_POST['last_name'];
    $row_input['birthdate'] = $_POST['birthdate'];
    
    $conn = new PdoMySQL();
    $conn->add_patient($row_input);
    
    header("Location: ../dashboard.php");
    exit();
} ?>