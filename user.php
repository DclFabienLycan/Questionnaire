<?php 
// session_start();

// String random pour token de confirmation
function str_random($lenght) {
    $alphaB = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphaB, $lenght)), 0, $lenght);
}

if(!empty($_POST)) {
    
    $errors = array();
    require_once 'pdo.php';
    
    // Vérification disponibilité pseudo et si il est correct
    if(empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['pseudo'])) {
        $errors['pseudo'] = "Vous pseudo n'est pas valide";
    } else {
        $req = $bdd->prepare("SELECT id_membre FROM membre WHERE pseudo_membre = ?");
        $req->execute([$_POST['pseudo']]);
        $membre = $req->fetch();
        if ($membre) {
            $errors['pseudo'] = "Ce pseudo est déjà pris !";
        }
    }
    // Vérification du mail
    if(empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $errors['mail'] = "Votre email n'est pas valide";
    } else {
        $req = $bdd->prepare("SELECT id_membre FROM membre WHERE email_membre = ?");
        $req->execute([$_POST['mail']]);
        $membre = $req->fetch();
        if ($membre) {
            $errors['mail'] = "Cet email est déjà utilisé pour un autre compte !";
        }
    }
    // Vérification du MDP, si les deux correspondent bien
    if(empty($_POST['pass']) || $_POST['pass'] != $_POST['passConf']) {
        $errors['pass'] = "Vous devez rentrer un mot de passe valide";
    }
    // Requête si pas d'erreurs, hashage du MDP et envoi d'un mail de validation de compte
    if (empty($errors)) {
        $req = $bdd->prepare("INSERT INTO membre SET pseudo_membre = ?, motDePasse_membre = ?, email_membre = ?, confirmation_token = ?");
        $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);
        $token = str_random(60);
        $req->execute([$_POST['pseudo'], $password, $_POST['mail'], $token]);
        $membre_id = $bdd->lastInsertId();
        mail($_POST['mail'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur le lien\n\nhttp://localhost/Dev/Questionnaire/confirm.php?id=$membre_id&token=$token");
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('Location: connexion.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.0/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Inscription</title>
</head>
<body>
    <?php include 'pdo.php';
          include 'header.php'; ?>

<!-- Vérification des données du formulaire -->
<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <p>Vous n'avez pas remplis le formulaire correctement</p>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php endif; ?>

    <main>
        <div class="card">
            <h5 class="card-header info-color white-text text-center py-4">
                <strong>Inscription</strong>
            </h5>
        </div>
        <div class="card-body px-lg-5">
            <form action="" method ="POST" class="text-center" style="color: #2F4C6C;">
                <div class="md-form mt-3">
                    <input type="text" id="materialSubscriptionForm" class="form-control" name="pseudo">
                    <label for="materialSubscriptionForm">Pseudo</label>
                </div>
                <div class="md-form">
                    <input type="email" id="materialSubscriptionFormEmail" class="form-control" name="mail">
                    <label for="materialSubscriptionFormEmail">Email</label>
                </div>
                <div class="md-form">
                    <input type="password" id="materialSubscriptionFormPasswords" class="form-control" name="pass">
                    <label for="materialSubscriptionFormPasswords">Mot de passe</label>
                </div>
                <div class="md-form">
                    <input type="password" id="materialSubscriptionFormPass" class="form-control" name="passConf">
                    <label for="materialSubscriptionFormPasswords">Confirmation mot de passe</label>
                </div>
                <button class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit" name="submit">S'enregistrer</button>
            </form>
            <div class="text-center" id="log">
                <p><strong>Ou si vous êtes déjà inscrit</strong> <a class="nav-link" href="connexion.php">Se connecter</a></p>
            </div>
        </div>

<?php require 'footer.php'; ?>