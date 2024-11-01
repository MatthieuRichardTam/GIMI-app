<script>
    function changeTaskUser(task_id) {
        $.ajax({
            type: "POST",
            url: "ajax/change_task_user.php",
            data: {
                id: task_id
            },
            success: function (response) {
                location.reload();
                console.log(response);
            },
            error: function (error) {
                console.log(error)
            }
        });

    }

    function deleteTask(task_id) {
        console.log(task_id);
        $.ajax({
            type: "POST",
            url: "ajax/delete_task.php",
            data: {
                id: task_id
            },
            success: function (response) {
                location.reload();
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });

    }

    function taskDone(task_id) {
        console.log(task_id);
        $.ajax({
            type: "POST",
            url: "ajax/task_done.php",
            data: {
                id: task_id
            },
            success: function (response) {
                location.reload();
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });

    }
</script>
<?php

function generate_task_display($task)
{
    ?>

    <div class="w-full justify-between p-2 bg-white rounded-xl" id="task-card-<?php echo $task->id ?>">
        <div class="text-left w-full p-2">
            <div class="pb-4 text-left w-full p-2" style="color: rgb(0, 72, 153);">
                <p class="font-semibold text-lg">
                    <?php echo $task->first_name; ?>
                    <?php echo $task->last_name ?>
                    <span class="font-normal text-base">
                        Chambre
                        <?php echo $task->room ?> (Lit
                        <?php echo $task->bed ?>)
                    </span>
                </p>
                <?php

                if ($task->user != "") { ?>
                    <p class="text-sm">Traitée par 
                        <?php echo $task->caregiver_first_name; ?>
                        <?php echo $task->caregiver_last_name ?>
                    </p>

                <?php } ?>
                <p><?php echo $task->injection->medication_name; ?></p>
                <p><?php echo $task->injection->display_time(); ?></p>
            </div>
            <div class="w-full flex space-x-4">
                <?php
                if ($task->user == "") {
                    ?>
                    <button class="bg-blue-800 text-white rounded py-2 w-full"
                        onclick="changeTaskUser(<?php echo $task->id ?>)"> Traiter la tâche </button>
                    <button class="bg-red-600 text-white rounded py-2 w-full" onclick="deleteTask(<?php echo $task->id ?>)">
                        Supprimer la tâche </button>
                    <?php
                } else {
                    ?>
                    <button class="bg-blue-800 text-white rounded py-2 w-full" onclick="taskDone(<?php echo $task->id ?>)">
                        Finaliser le traitement </button>
                    <button class="bg-red-600 text-white rounded py-2 w-full" onclick="changeTaskUser(<?php echo $task->id ?>)">
                        Arreter le traitement</button>
                    <?php
                }
                ?>

            </div>

        </div>
    </div>
    <?php
}
