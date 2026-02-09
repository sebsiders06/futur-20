<?php
/**
 * Envoi du formulaire de devis vers philippe.clemente@orange.fr
 * Utilisé uniquement si le site est hébergé sur un serveur PHP.
 * Par défaut le formulaire utilise mailto (aucune erreur sur hébergement statique).
 */
$destinataire = 'philippe.clemente@orange.fr';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#contact', true, 302);
    exit;
}

$nom    = isset($_POST['nom']) ? trim(strip_tags((string) $_POST['nom'])) : '';
$email  = isset($_POST['email']) ? trim(filter_var((string) $_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
$message = isset($_POST['message']) ? trim(strip_tags((string) $_POST['message'])) : '';

$envoye = false;
if ($nom !== '' && $email !== '' && $message !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $sujet = 'Demande de devis Formation SST - ' . $nom;
    $corps = "Nom : $nom\nEmail : $email\n\nMessage :\n$message\n";
    $entetes = "From: $destinataire\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8\r\n";
    $envoye = @mail($destinataire, $sujet, $corps, $entetes);
}

header('Content-Type: text/html; charset=utf-8');
header('Location: index.html?envoi=' . ($envoye ? 'ok' : 'erreur') . '#contact', true, 302);
exit;
