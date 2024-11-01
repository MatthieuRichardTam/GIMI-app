<?php
include "scripts_php/pdo_mySQL.php";
session_start();

// si vous n'êtes pas connecté, renvoie vers la page de connexion
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$warning = "";
include "components/head.php";
echo generate_head("Ajout d'une injection");
?>

<script>

    function checkCompatibility() {
        let select = document.getElementById('new-medication')
        let medication = { value: select.value, name: select.options[select.selectedIndex].text }

        let patient_id = document.getElementById('patient').value

        $.ajax({
            type: "POST",
            url: "ajax/get_compatibility_by_patient.php",
            data: { medication, patient_id },
            success: function (response) {
                response = JSON.parse(response);
                let errors = [];
                let warnings = [];

                response.incompatibilities.forEach((incompatibility) => {
                    if (incompatibility.value == 'U\r') {
                        warnings.push(incompatibility)
                    }
                    if (incompatibility.value == 'I\r') {
                        errors.push(incompatibility)
                    }
                })

                if (errors.length > 0) {
                    document.getElementById("submit-btn").disabled = true;
                    document.getElementById("submit-btn").classList.remove("bg-blue-800");
                    document.getElementById("submit-btn").classList.add("bg-red-500");
                    document.getElementById("submit-btn").value = "Ajout impossible"
                    document.getElementById("errors").innerHTML = "Incompatibles avec " + errors.map((error) => { return error.medic2.name }).join(", ")
                } else {
                    document.getElementById("submit-btn").disabled = false;
                    document.getElementById("submit-btn").classList.add("bg-blue-800");
                    document.getElementById("submit-btn").classList.remove("bg-red-500");
                    document.getElementById("submit-btn").value = "Ajouter"

                    document.getElementById("errors").innerHTML = ""
                }
                if (warnings.length > 0) {
                    document.getElementById("warnings").innerHTML = "Compatibilité non confirmé avec " + warnings.map((warning) => { return warning.medic2.name }).join(", ")
                } else {
                    document.getElementById("warnings").innerHTML = ""
                }

            },
            error: function (error) {
                console.log(error)
            }
        });
    }
</script>


<div class="h-full flex">
    <?php
    include "components/sidebar.php";
    echo generate_sidebar("add-injection");
    ?>
    <div class="p-10 bg-gray-200 rounded m-auto space-y-4">
        <div class="text-xl text-center font-bold ">Ajout d'injection</div>
        <form class="space-y-2 justify-center" action="scripts_php/process_injection_form.php" method="POST">
            <div>
                <label for="patient-id">Patient :</label>
                <select id="patient" class="px-2 py-1" name="patient-id">
                    <?php
                    $conn = new PdoMySQL();
                    $patients = $conn->get_patients();
                    foreach ($patients as $patient) {
                        echo "<option value=" . $patient['id'] . ">" . $patient['first_name'] . " " . $patient['last_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="medication">Médicament :</label>
                <select id="new-medication" class="px-2 py-1" name="medication" onchange="checkCompatibility()">
                    <?php
                    $medications = $conn->get_medications();
                    foreach ($medications as $medication) {
                        echo "<option value=" . $medication['id'] . ">" . $medication['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <p id="errors" class="text-red-800 font-bold"></p>
            <p id="warnings" class="text-orange-400 font-semibold"></p>
            <div>
                <label for="flow_rate">Débit :</label>
                <div class="flex space-x-2">
                    <input type="number" id="flow_rate" name="flow_rate" required>
                    <div>mL/h</div>
                </div>
            </div>
            <div>
                <label for="volume">Volume :</label>
                <div class="flex space-x-2">
                    <input type="number" id="volume" name="volume" required>
                    <div>mL</div>
                </div>
            </div>
            <div>
                <label for="concentration">Dosage : </label>
                <div class="flex space-x-2">
                    <input type="number" id="concentration" name="concentration" required>
                    <div>g/L</div>
                </div>
            </div>
            <div>
                <label for="hardware_id">Pompe : </label>
                <input type="text" id="hardware_id" name="hardware_id" required>
            </div>
            <div>
                <label for="starting_date">Heure d'ajout de l'injection :</label>
                <input type="datetime-local" id="starting_date" name="starting_date" required>
            </div>
            <input
                class="text-center w-full p-2 bg-blue-800 transition-all duration-300 text-white cursor-pointer rounded"
                id="submit-btn" type="submit" value="Ajouter">
        </form>
        <?php
        // Affichez le résultat ici
        if (!empty($warning)) {
            echo $warning;
        }
        ?>
    </div>
</div>
</body>

</html>