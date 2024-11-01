<?php
include 'scripts_php/patient.php';
include "components/head.php";
include "scripts_php/pdo_mySQL.php";
include "components/patient_display.php";
include "components/sidebar.php";

session_start();

// si vous n'êtes pas connecté, renvoie vers la page de connexion
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

generate_head("Tableau de bord");
$conn = new PdOMySQL();
?>

<script>
    let addPatientWindow;
    function switchStatus(patientId) { //
        if (document.getElementById("injections-container-" + patientId).classList.contains("hidden")) {
            document.getElementById("details-button-" + patientId).classList.replace("bttn-details-inactive", "bttn-details-active");
            document.getElementById("details-button-" + patientId).classList.add("text-white");
            document.getElementById("injections-container-" + patientId).classList.remove("hidden");
            document.getElementById("condensed-injections-" + patientId).classList.add("hidden");
        } else {
            document.getElementById("injections-container-" + patientId).classList.add("hidden");
            document.getElementById("details-button-" + patientId).classList.replace("bttn-details-active", "bttn-details-inactive");
            document.getElementById("details-button-" + patientId).classList.remove("text-white");
            document.getElementById("condensed-injections-" + patientId).classList.remove("hidden");
        }
    }
</script>

<div class="h-full flex">
    <?php
    generate_sidebar("dashboard");
    ?>
    <div class="w-full h-full p-6 bg-gray-50 overflow-x-hidden overflow-y-scroll flex flex-col items-center space-y-2"> 
        
            <?php
            $patients_id = $conn->get_patients_id();
            while ($row = $patients_id->fetch_assoc()) {
                $patient = new Patient($row["id"], $conn);
                if ($patient->nb_injections > 0) {
                    generate_patient_display($patient);
                }
            }
            ?>
            <a class="w-3/5 bttn-add-patient h-12 m-4 p-1 bg-white text-center text-xl" href="add-patient.php" target="">Ajouter un patient</a>
    </div>
</div>
</body>

</html>