<?php
// Authentification + vérification des données pour valider
if(!empty($_POST) && !empty($_POST['pseudo']) && !empty($_POST['pass'])) {
    require_once 'pdo.php';
    $req = $bdd->prepare("SELECT * FROM membre WHERE (pseudo_membre = :pseudo OR email_membre = :pseudo) AND dateInscription_membre IS NOT NULL");
    $req->execute(['pseudo' => $_POST['pseudo']]);
    $membre = $req->fetch();
    if(password_verify($_POST['pass'], $membre->motDePasse_membre)) {
        session_start();
        $_SESSION['auth'] = $membre;
        $_SESSION['flash']['success'] = "Vous êtes maintenant connecté";
        header('location: index.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrect";
    }
    // $req2 = $bdd->prepare("SELECT * FROM membre JOIN statut_membre ON membre.id_statut_membre = statut_membre.id_statut_membre WHERE pseudo_membre = ?");
    //     $req2->execute($_POST['pseudo'], $_POST['pass']);
    //     $_SESSION['pseudo'] = $pseudo;
    //     $_SESSION['statut'] = $statut;
    //     echo 'Bienvenue'.' '.$pseudo.' '.'votre rang est'.' '.$statut;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Questionnaire</title>
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <h1>Se connecter</h1>

        <form action="" method="POST">
            <div class="form-group">
                <label for="">Pseudo ou email</label>
                <input type="text" name="pseudo" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="">Mot de passe</label>
                <input type="password" name="pass" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>

        </form>
<?php require 'footer.php';