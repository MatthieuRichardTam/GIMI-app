<?php
include 'scripts_php/pdo_mySQL.php';
include 'components/head.php';

session_start();

try {
    $conn = new PdoMySQL();

    if (isset($_SESSION['username'])) {
        header("Location: dashboard.php"); #si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}

echo generate_head("Connexion")
    ?>
<script>
    function trySignIn() { //cette fonction permet de lancer verifier si les identifiants sont les bons grâce à une demande javascript asynchrone
        $.ajax({
            type: "POST",
            url: "ajax/sign_in.php",
            data: { username: document.getElementById("username").value, password: document.getElementById("password").value },
            success: function (response) {
                response = JSON.parse(response);
                console.log(response)
                if (response.code == 403) {
                    document.getElementById("error").innerHTML = "Mauvais identifiants"
                } else {
                    window.location.replace("dashboard.php");
                }

            },
            error: function (error) {
                document.getElementById("error").innerHTML = error
            }
        });
    }

</script>


<div class="bg-secondary w-full h-screen flex justify-center">
    <div class="flex space-x-10 items-center">
        <div class="p-6 flex space-y-4 flex-col rounded items-starting_date bg-white w-96">
            <div class="flex justify-between w-full">
                <div class="flex flex-col items-starting_date">
                    <h1 class="text-3xl font-semibold">GIMI</h1>
                    <h3 class="text-lg text-gray-700">Authentification</h3>
                </div>
                <div class="flex flex-col items-starting_date">
                    <img class="h-16" src="assets/img/logo.png" />
                </div>
            </div>
            <div class="w-full space-y-2">
                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Username</label>
                <input type="text" id="username"
                    class="bg-gray-50 w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="John" required>
                <label for="password"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" id="password"
                    class="bg-gray-50 w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="*********" required>
            </div>
            <p id="error" class="text-red-700">
                <?php
                if (isset($error)) {
                    echo $error;
                }
                ?>
            </p>

            <button onclick="trySignIn()" class="bg-primary h-10 text-white text-md p-2">
                SIGN IN
            </button>
        </div>

        <img class="h-64" src="assets/img/auth.svg" />
    </div>
</div>