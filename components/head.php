<?php
function generate_head($title)
{
?>
    <!DOCTYPE html>
    <html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="icon" href="assets/logo.ico" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Import de la police choisie pour l'applicaiton -->
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
        <!-- Framework CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Pour importer une police-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    </head>

    <body class="h-screen bg-white">

    <?php
}
