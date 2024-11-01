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
    $row_input['patient-id'] = $_POST['patient-id'];
    $row_input['hardware_id'] = $_POST['hardware_id'];
    $row_input['concentration'] = $_POST['concentration'];
    $row_input['medication_id'] = $_POST['medication'];
    $row_input['flow_rate'] = $_POST['flow_rate'];
    $row_input['volume'] = $_POST['volume'];
    $row_input['starting_date'] = $_POST['starting_date'];
    $row_input['moderate_threshold'] = NULL;

    $conn = new PdoMySQL();


    $injection = new Injection($row_input);
    $conn->add_injection($injection,$row_input['patient-id'],$_SESSION['username']);
    
    header("Location: ../dashboard.php");
    exit();
}?>