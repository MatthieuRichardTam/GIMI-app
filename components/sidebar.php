<?php
function generate_sidebar($active)
{
    ?>
    <script>
        function trySignOut() {
            $.ajax({
                type: "POST",
                url: "ajax/sign_out.php",
                success: function (response) {
                    window.location.replace("index.php");
                }
            });
        }
    </script>
    <div class="flex flex-col bg-secondary justify-between h-full w-50 items-start p-4">
        <div class="flex flex-col items-center space-y-4">
            <div class="w-full flex items-center space-x-4">
                <img src="assets/logo.ico" class="h-20" alt="logo CHU Lille">
                <div class="text-gray-800">
                    <p class="font-semibold">Secteur
                        <?php echo $_SESSION['sector'] ?>
                    </p>
                    <p>Aile
                        <?php echo $_SESSION['wing'] ?>
                    </p>
                </div>
            </div>
            <hr class="bg-blue-500 mb-4 w-full" />
            <a href="dashboard.php"
                class="w-full text-center rounded text-md p-2 transition-all duration-300 whitespace-nowrap <?php echo ($active == "dashboard" ? "bg-primary text-white" : "bg-white text-gray-800"); ?>">
                Tableau
                de bord</a>
            <a href="compatibility.php"
                class="w-full text-center rounded text-md p-2 transition-all duration-300 whitespace-nowrap <?php echo ($active == "compatibility" ? "bg-primary text-white" : "bg-white text-gray-800 hover:bg-secondary"); ?>">Compatibilité</a>
            <a href="add-patient.php"
                class="w-full text-center rounded text-md  py-2 px-8 hover:bg-primary transition-all duration-300 whitespace-nowrap <?php echo ($active == "add-patient" ? "bg-primary text-white" : "bg-white text-gray-800"); ?>">Ajouter
                un patient</a>
            <a href="add-injection.php"
                class="w-full text-center rounded text-md  py-2 px-8 hover:bg-primary transition-all duration-300 whitespace-nowrap <?php echo ($active == "add-injection" ? "bg-primary text-white" : "bg-white text-gray-800"); ?>">Ajouter
                une injection</a>
            <a href="tasks.php"
                class="w-full text-center rounded text-md  py-2 px-8 hover:bg-primary transition-all duration-300 whitespace-nowrap <?php echo ($active == "notifications" ? "bg-primary text-white" : "bg-white text-gray-800"); ?>">Tâches</a>
        </div>
        <button
            class="text-gray-500 flex w-full justify-between items-center text-lg bg-transparent hover:text-gray-800 transition-all duration-300  hover:bg-transparent flex"
            onclick="trySignOut()">
            <p>
                <?php echo ucfirst($_SESSION['firstname']) . ' ' . ucfirst($_SESSION['surname']); ?>
            </p>
            <div>

                <img class="h-6" src="assets/icons/sign_out.svg" />
            </div>
        </button>
    </div>
    <?php
}
