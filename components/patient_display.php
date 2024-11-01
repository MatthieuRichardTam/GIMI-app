<?php
include "injections_display.php";

function generate_patient_display($patient)
{
?>
    <!-- Container d'un patient -->
    <div class="w-full rounded bg-gray-200 grid grid-cols-8 gap-x-4 justify-between px-4 py-2 items-center">
        
        <!-- Informations générales du patient  -->
        <div class="" style="color: rgb(0, 72, 153);">
            <h2 class="text-lg font-bold truncate"><?php echo ucfirst($patient->first_name) . " " . ucfirst($patient->last_name) ?></h2>
            <p>Chambre <?php echo $patient->room ?> </p>
            <p>Lit <?php echo $patient->bed ?></p>
        </div>
        <!-- Affichage réduit de toutes les perfusions en cours sur le patient -->
        <div class="h-20 col-span-6 justify-center h-full flex flex-col space-y-1 rounded" id="condensed-injections-<?php echo $patient->id ?>">

            <?php
            // Ensemble des couleurs associées au statut d'une injection, dans la syntaxe tailwind
            $background_colors = array(
                "not-started" => "blue-500",
                "minor-priority" => "green-500",
                "moderate-priority" => "yellow-500",
                "severe-priority" => "red-500",
                "empty" => "gray-50"
            );
            foreach ($patient->injections as $injection) {
                $injection->set_status();
            ?>
                <!-- Container d'une jauge de progression -->
                <div class="w-full h-<?php echo intval(16/$patient->nb_injections); ?> bg-gray-50 max-h-6 rounded-full flex flex-col items-starting_date">
                    <!-- Jauge de progression evolutive -->
                    <div class="rounded-full h-full bg-<?php echo $background_colors[$injection->status]; ?>" style="width: <?php echo ($injection->time_left_ratio > 0 and $injection->time_left_ratio<=1) ? 100*$injection->time_left_ratio : 100; ?>%">
                    </div>
                    <?php
                    ?>
                </div>
            <?php
            }
            ?>
        </div>

        <div class="h-full bg-gray-200 col-span-6 hidden" id="injections-container-<?php echo $patient->id ?>">
            <?php generate_injections_display($patient->injections); ?>
        </div>

        <div class="bg-gray-200 flex place-items-center col-starting_date-8">
            <button class="w-full h-full py-2 rounded align-middle bttn-details-inactive transition-all duration-300" id="details-button-<?php echo $patient->id ?>" onclick="switchStatus(<?php echo $patient->id ?>)"> Détails </button>
        </div>
    </div>
<?php
}
