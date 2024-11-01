<?php
include "scripts_php/pdo_mySQL.php";
include "scripts_php/task.php";
include "scripts_php/injection.php";
include "components/tasks_display.php";
include "components/head.php";
session_start();

// si vous n'êtes pas connecté, renvoie vers la page de connexion
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

generate_head("Notifications");
$injections = array();
$conn = new PdoMySQL();

$result_sql = $conn->get_injections();
while ($row = $result_sql->fetch_assoc()) {
    $injection = new Injection($row);
    array_push($injections, $injection);
}
create_tasks($injections);

$tasks = array();
$result_sql = $conn->get_tasks();
while ($row = $result_sql->fetch_assoc()) {
    $task = new Task($row);
    array_push($tasks, $task);
}
?>

<div class="h-full flex">
    <?php
    include "components/sidebar.php";
    generate_sidebar("notifications");
    ?>
    <div class='text-center text-xl overflow-y-scroll h-full w-full px-16 pt-8'>
        <div class="flex bg-gray-200 rounded-t-xl">
            <div class="p-4 flex-1 rounded font-semibold">
                Tâches non-traitées
            </div>

            <div class="p-4 flex-1 rounded font-semibold">
                Tâches prises en charges
            </div>
        </div>
        <div class="flex bg-gray-100 max-h-full rounded-b-xl divide-x">
            <div class="flex-1 p-4 space-y-2">
                <?php
                foreach ($tasks as $task) {
                    if ($task->user==''){
                        generate_task_display($task);
                    }
                    
                }
                ?>
            </div>
            <div class="flex-1 p-4 space-y-2">
                <?php
                foreach ($tasks as $task) {
                    if ($task->user!=''){
                        generate_task_display($task);
                    }
                }
                ?>
            </div>

        </div>


    </div>
    </html>