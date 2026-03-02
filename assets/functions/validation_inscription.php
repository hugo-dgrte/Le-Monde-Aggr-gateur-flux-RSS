<?php
require 'mail_config.php';

// Affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$nom = trim($_POST['nom']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$thematiques = $_POST['thematiques'] ?? [];

$fichier_users = '../../data/users.csv';
$lignes = array_map('str_getcsv', file($fichier_users));
$fichier_abonnements = '../../data/abonnements.csv';
// Si le fichier abonnements.csv n'existe pas, on initialise un tableau vide pour éviter les erreurs
$lignes_abonnements = file_exists($fichier_abonnements) ? array_map('str_getcsv', file($fichier_abonnements)) : [];

foreach ($lignes as $index => $ligne) {
    if ($index === 0) continue; // on saute la ligne d'en-tête
    if ($ligne[2] === $email) {
        die("Cet email est déjà utilisé.");
    }
}

// Crypter le mot de passe et générer le token 
$password_crypte = password_hash($password, PASSWORD_DEFAULT);
$token = bin2hex(random_bytes(16));

// Générer un ID unique pour l'utilisateur
$id = count($lignes) - 1; // ID basé sur le nombre d'utilisateurs existants

// Vérifier si les fichiers CSV existent, sinon les créer avec les en-têtes
$enTete = ['id', 'nom', 'email', 'password', 'token', 'confirmé', 'date_inscription'];
if (count($lignes) === 0) {
    $infos = fopen($fichier_users, 'a');
    fputcsv($infos, $enTete);
    fclose($infos);
}
if (count($lignes_abonnements) === 0) {
    $infos = fopen($fichier_abonnements, 'a');
    fputcsv($infos, ['id', 'thematique']);
    fclose($infos);
}

// Ajouter le nouvel utilisateur au fichier CSV
$new_user = [$id, $nom, $email, $password_crypte, $token, 0, date('Y-m-d')];
$infos = fopen($fichier_users, 'a');
fputcsv($infos, $new_user);
fclose($infos);

// Écrire dans abonnements.csv les thématiques choisies par l'utilisateur
$fichier_abonnements_handle = fopen($fichier_abonnements, 'a');
foreach ($thematiques as $thematique) {
    fputcsv($fichier_abonnements_handle, [$id, $thematique]);
}
fclose($fichier_abonnements_handle);

//  Envoyer l'email de confirmation
$destinataire = $email;
$sujet = "Confirmation d'inscription - Le Monde RSS";
$message = "Bonjour $nom,

Merci pour votre inscription sur Le Monde - Aggrégateur de flux RSS.

Cliquez sur le lien ci-dessous pour valider votre compte :
http://localhost/PHP/Projet%20PHP/Le-Monde-Aggr%C3%A9gateur-flux-RSS/assets/functions/confirmation_inscription.php?token=$token

L'équipe Le Monde";

sendEmail($destinataire, $sujet, $message);

// Rediriger l'utilisateur vers une page de confirmation
header("Location: ../../confirmation_envoi.php");

exit();