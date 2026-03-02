<?php
require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Charge une variable depuis le fichier .env (format KEY=VALUE, une par ligne).
 * Ignore les lignes vides et les commentaires (#).
 * Retourne null si la clé n'existe pas.
 */
function load_env(string $key): ?string {
    $env_file = __DIR__ . '/../../.env';
    if (!file_exists($env_file)) {
        return null;
    }
    foreach (file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) continue;          // ignorer les commentaires
        [$k, $v] = array_pad(explode('=', $line, 2), 2, null);   // sépare KEY=VALUE (max 2 parties)
        if (trim($k) === $key) return trim($v);
    }
    return null;
}

function sendEmail($destinataire, $sujet, $message) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    // afficher les détails de connexion au serveur Gmail
    // $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = load_env('email');
    $mail->Password = load_env('key_password');
    $mail->setFrom(load_env('email'), 'Le Monde');
    $mail->addAddress($destinataire);
    $mail->Subject = $sujet;
    $mail->Body = $message;
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}