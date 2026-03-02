<?php
$token = $_POST['token'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

if ($password !== $confirmPassword) {
    die("Les mots de passe ne correspondent pas.");
}

$fichier_users = '../../data/users.csv';
$lignes = array_map('str_getcsv', file($fichier_users));

$trouve = false;

foreach ($lignes as $index => $ligne) {
    if ($index === 0) continue; // on suate la première ligne d'en tête 
    if ($ligne[4]===$token) {
        $lignes[$index][3] = password_hash($password, PASSWORD_DEFAULT);
        $trouve = true;
        break;
    }
}

if ($trouve === true) {
    $infos = fopen($fichier_users, 'w');
    foreach ($lignes as $ligne) {
        fputcsv($infos, $ligne);
    }
    fclose($infos);
    header("Location: ../../index.php");
    exit();
} else {
    die("Token invalide ou expiré.");
}