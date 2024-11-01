<script>
    function displayPopup() {
        document.getElementById("popupOverlay").classList.remove("hidden");
    }

    function closePopup() {
        document.getElementById("popupOverlay").classList.add("hidden");
    }

    function deleteInjection(injection_id) {
        console.log(injection_id);
        $.ajax({
            type: "POST",
            url: "ajax/delete_injection.php",
            data: {
                id: injection_id
            },
            success: function (response) {
                closePopup();
                location.reload()
                console.log(response)
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    function cancel() {
        closePopup();
    }

    function updateTimeVariables(time) {
        injections.forEach((injection) => {

            let rawTimeLeft = Math.floor((injection.date_end - new Date()) / 1000);
            let timeLeftRatio = rawTimeLeft / injection.time_length;
            let timeLeft = {
                rawTimeLeft: rawTimeLeft,
                hoursLeft: Math.abs(Math.floor((rawTimeLeft / 3600) < 0 ? (rawTimeLeft / 3600) +1 : (rawTimeLeft / 3600) )),
                minutesLeft: Math.abs(Math.floor((rawTimeLeft % 3600) / 60)),
                secondsLeft: Math.abs(rawTimeLeft % 60)
            };
            document.getElementById('volume-' + injection.id).innerHTML = injection.volume * timeLeftRatio < 0 ? 0 : Math.round(injection.volume * timeLeftRatio);
            document.getElementById('chrono-' + injection.id).innerHTML = formatTime(timeLeft);
            document.getElementById('progress-bar-' + injection.id).style.width = ((timeLeftRatio > 0 && timeLeftRatio <= 1) ? 100 * timeLeftRatio : 100) + "%";
        })
        setTimeout(function () {
            updateTimeVariables(time);
        }, time)
    }

    let injections = [];
    let injection = null;
    updateTimeVariables(1000);

    function formatTime(timeLeft) {
        return ("Temps restant: " + (timeLeft.hoursLeft > 0 ? (timeLeft.hoursLeft + "h ") : "") + " " + (timeLeft.minutesLeft > 0 ? (timeLeft.minutesLeft + "m ") : "") + " " + (timeLeft.secondsLeft > 0 ? (timeLeft.secondsLeft + "s ") : "0s"));
    }
</script>

<?php
function generate_injections_display($injections)
{
    ?>

    <div class="w-full flex flex-col space-y-2 items-center">
        <?php
        $background_colors = array(
            "not-started" => "blue-100",
            "minor-priority" => "green-500",
            "moderate-priority" => "yellow-500",
            "severe-priority" => "red-500",
            "empty" => "gray-50"
        );
        foreach ($injections as $injection) {
            $injection->set_status(); ?>

            <div class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 hidden"
                id="popupOverlay">
                <div class="bg-white p-8 rounded shadow-lg text-center">
                    <p class="mb-4">Êtes-vous sûr de vouloir supprimer cette injection?</p>
                    <button class="bg-red-500 text-white px-4 py-2 rounded mr-2"
                        onclick="deleteInjection(<?php echo $injection->id ?>)">Supprimer</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="cancel()">Annuler</button>
                </div>
            </div>

            <div class="w-full flex flex-col w-full justify-around align-center bg-gray-200 space-x-1 space-y-1"
                id="injection-container-<?php echo $injection->id ?>">
                <script>
                    injection = {
                        time_left_ratio: <?php echo $injection->time_left_ratio ?>,
                        time_length: <?php echo $injection->time_length ?>,
                        volume: <?php echo $injection->volume ?>,
                        date_end: new Date('<?php echo date("Y-m-d\TH:i:s", $injection->date_end) ?>'),
                        id: <?php echo $injection->id ?>
                    }
                    injections.push(injection);
                </script>

                <div class="flex w-full justify-between">
                    <div class="items-center flex text-sm space-x-4" style="color: rgb(0, 72, 153);">
                        <p class="text-base font-semibold">Pompe n°
                            <?php echo $injection->hardware_id ?>
                            <span class="text-sm font-normal">(
                                <?php echo $injection->medication_name ?>)
                            </span>
                        </p>
                        <p>Volume restant: <span id='volume-<?php echo $injection->id ?>'>
                                <?php echo round($injection->volume * $injection->time_left_ratio) ?>
                            </span> mL</p>
                        <p>Débit:
                            <?php echo round($injection->flow_rate, 2) ?> mL/h
                        </p>
                    </div>
                    <div class="flex items-center text-sm space-x-4">
                        <div id='chrono-<?php echo $injection->id ?>' class="text-sm whitespace-nowrap">
                            <?php $injection->display_time(); ?>
                        </div>
                        <button class="w-full h-full p-2 text-white rounded align-middle bg-red-500 transition-all duration-300"
                            id="delete-button-<?php echo $injection->id ?>" onclick="displayPopup()"> Supprimer </button>
                    </div>
                </div>
                <div class="w-full flex align-center bg-gray-200 rounded">
                    <div class="bg-gray-200 flex flex-col w-full">

                        <div class="w-full bg-gray-50 h-8 rounded-full flex flex-col items-starting_date">
                            <!-- Jauge de progression evolutive -->
                            <div id="progress-bar-<?php echo $injection->id ?>"
                                class="h-full rounded-full bg-<?php echo $background_colors[$injection->status]; ?>"
                                style="width: <?php echo ($injection->time_left_ratio > 0 && $injection->time_left_ratio <= 1) ? 100 * $injection->time_left_ratio : 100; ?>%">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php
        }
        ?>
    </div>
    <?php
}
