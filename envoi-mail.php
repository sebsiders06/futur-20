<?php
/**
 * Envoi du formulaire de devis vers philippe.clemente@orange.fr
 * À utiliser quand le site est hébergé sur un serveur PHP (Orange, OVH, etc.).
 */
header('Content-Type: text/html; charset=utf-8');

$destinataire = 'philippe.clemente@orange.fr';
$sujet = 'Demande de devis Formation SST - ' . (isset($_POST['nom']) ? strip_tags($_POST['nom']) : 'Site');

$nom    = isset($_POST['nom']) ? strip_tags(trim($_POST['nom'])) : '';
$email  = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';

$corps = "Nom : $nom\n";
$corps .= "Email : $email\n\n";
$corps .= "Message :\n$message\n";

$entetes = "From: $destinataire\r\n";
$entetes .= "Reply-To: $email\r\n";
$entetes .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$entetes .= "Content-Type: text/plain; charset=UTF-8\r\n";

$envoye = false;
if ($nom && $email && $message) {
    $envoye = @mail($destinataire, $sujet, $corps, $entetes);
}

if ($envoye) {
    header('Location: index.html?envoi=ok#contact');
    exit;
}

header('Location: index.html?envoi=erreur#contact');
exit;
