<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <!--Navbar-->
    <nav class="navbar navbar-light navbar-1 #DF2626">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="./index.php"><img src="./image/baseline-home-24px.svg" alt=""></a>
        <a class="log" href="./user.php"><img src="./image/baseline-account_circle-24px.svg" alt=""></a>
        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent15"
        aria-controls="navbarSupportedContent15" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            
        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent15">
            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <?php if (isset($_SESSION['auth'])): ?>
                    <li><a href="logout.php">Se déconnecter</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Catégories</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="user.php">S'inscrire</a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Se connecter</a>
                    </li>
                <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="">Créer un Questionnaire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Gérer les membres</a>
                    </li>
            </ul>
        </div>
    </nav>
    <!-- Message Erreur -->
    <?php if(isset($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
            <div class="alert alert-<?= $type; ?>">
                <?= $message; ?>
            </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
</header>