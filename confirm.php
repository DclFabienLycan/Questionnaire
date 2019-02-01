<?php
// On récupère id et token présent dans l'url
$membre_id = $_GET['id'];
$token = $_GET['token'];

require 'php/pdo.php';

$req = $bdd->prepare("SELECT * FROM membre WHERE id_membre = ?");
$req->execute([$membre_id]);
$membre = $req->fetch();
session_start();

if ($membre && $membre->confirmation_token == $token) {
    $bdd->prepare("UPDATE membre SET confirmation_token = NULL, dateInscription_membre = NOW() WHERE id_membre = ?")->execute([$membre_id]);
    $_SESSION['flash']['success'] = 'Votre compte a bien été créé';
    $_SESSION['auth'] = $membre;
    header('location: connexion.php');
} else {
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('location: connexion.php');
}