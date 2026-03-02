<?php
// Affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$email = trim($_POST['email']);
$password = $_POST['password'];

$fichier_users = '../../data/users.csv';
// Vérifier si le fichier users.csv existe avant de tenter de le lire
$lignes = array_map('str_getcsv', file($fichier_users));

foreach ($lignes as $index => $ligne) {
    if ($index === 0) continue; // on saute la ligne d'en-tête
    if ($ligne[2] === $email && password_verify($password, $ligne[3]) && $ligne[5] == 1) {
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['nom'] = $ligne[1];
        header("Location: ../../dashboard.php");
        exit();
    }
}

header("Location: ../../index.php?error=invalid");

exit();