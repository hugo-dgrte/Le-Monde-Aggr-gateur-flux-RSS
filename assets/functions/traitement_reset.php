<?php
require 'mail_config.php';

// Affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$email = trim($_POST['email']);
$fichier_users = "../../data/users.csv";
$lignes = array_map('str_getcsv', file($fichier_users));
$trouve = false;

foreach ($lignes as $index => $ligne) {
    if ($index === 0) continue; // on saute la ligne d'en-tête
    if ($ligne[2] === $email) {
        // Génère un nouveau token de réinitialisation
        $new_token = bin2hex(random_bytes(16));
        // Mettre à jour le token dans le fichier CSV
        $lignes[$index][4] = $new_token;
        // Réécrire le fichier CSV avec les données mises à jour
        $infos = fopen($fichier_users, 'w');
        foreach ($lignes as $ligne) {
            fputcsv($infos, $ligne);
        }
        fclose($infos);
        $trouve = true;
        break;
    }
}

if ($trouve === false) {
    die("Aucun compte trouvé avec cet email.");
}

// Envoyer l'email de réinitialisation
$destinataire = $email;
$sujet = "Réinitialisation de votre mot de passe";
$message = "Bonjour,\n\nVous avez demandé une réinitialisation de votre mot de passe. Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe :\n\nhttp://http://localhost/PHP/Projet%20PHP/Le-Monde-Aggr%C3%A9gateur-flux-RSS/new_password.php?token=$new_token";

sendEmail($destinataire, $sujet, $message);

//  Rediriger l'utilisateur vers une page de confirmation
header("Location: ../../confirmation_reset.php");