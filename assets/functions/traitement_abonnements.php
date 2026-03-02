<?php
session_start();
// Vérification de l'authentification
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

// Récupérer les nouvelles thématiques
$nouvelles_thematiques = $_POST['abonnements'] ?? [];

// Récupérer l'ID de l'utilisateur
$email = $_SESSION['email'];
$fichier_users = '../../data/users.csv';
$lignes = array_map('str_getcsv', file($fichier_users));

foreach ($lignes as $index => $ligne) {
    if ($index === 0) continue;
    if ($ligne[2] === $email) {
        $id = $ligne[0];
        break;
    }
}

// Lire tous les abonnements existants
$fichier_abonnements = '../../data/abonnements.csv';
$lignes_abonnements = array_map('str_getcsv', file($fichier_abonnements));

// Supprimer les anciennes lignes de cet utilisateur
$nouvelles_lignes = [];
foreach ($lignes_abonnements as $index => $ligne) {
    if ($index === 0) {
        // Garder l'en-tête
        $nouvelles_lignes[] = $ligne;
    } elseif ($ligne[0] != $id) {
        // Garder les lignes des autres utilisateurs
        $nouvelles_lignes[] = $ligne;
    }
}

// Ajouter les nouvelles thématiques
foreach ($nouvelles_thematiques as $thematique) {
    $nouvelles_lignes[] = [$id, $thematique];
}

// Réécrire tout le fichier CSV
$fichier = fopen($fichier_abonnements, 'w');
foreach ($nouvelles_lignes as $ligne) {
    fputcsv($fichier, $ligne);
}
fclose($fichier);

// Rediriger vers le dashboard
header("Location: ../../dashboard.php");
exit();