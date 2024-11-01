<?php
include "scripts_php/pdo_mySQL.php";
session_start();
$conn = new PdoMySQL();
// si vous n'êtes pas connecté, renvoie vers la page de connexion
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$warning = "";

?>

<!DOCTYPE html>
<html lang="fr">

<?php
include "components/head.php";
echo generate_head("Ajout d'une injection");
?>

<div class="h-full flex">
    <?php
    include "components/sidebar.php";
    echo generate_sidebar("add-patient");
    ?>
    <div class="p-8 bg-gray-200 rounded m-auto space-y-4">
        <div class="text-xl text-center font-bold ">Ajout de patient</div>
        <form class="space-y-4 justify-center" action="scripts_php/process_patient_form.php" method="POST">
            <div>
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div>
                <label for="last_name">Nom de famille :</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div>
                <label for="birthdate">Date de naissance :</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
            <div>
                <label for="bed">Lit :</label>
                <select class="px-2 py-1" name="bed">
                    <?php
                    $beds = $conn->get_empty_beds();
                    foreach ($beds as $bed) {
                        echo "<option value=". $bed['id'] .">" ."Lit ". $bed['id'] .", Chambre ". $bed['room'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button class="text-center w-1/2 m-12 p-2 bg-white rounded hover:bg-blue-300">
                <input type="submit" value="Ajouter">
            </button>
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