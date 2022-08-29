<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/POO_BD/Public/index.php">Mes annonces</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" 
                        href="/POO_BD/Public/index.php">Acceuil du site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" 
                        href="/POO_BD/Public/index.php/admin">Acceuil de l'admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/POO_BD/Public/index.php/annonces">
                        Liste des annonces</a>
                    </li>
                </ul>
                
                <?php if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>

                    <ul class="navbar-nav justify-content-center mb-2 mb-lg-0"> 
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" 
                            href="/POO_BD/Public/index.php/users/login">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/POO_BD/Public/index.php/users/logout">
                            Déconnexion</a>
                        </li>
                    </ul>
                    <?php else: ?>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="/POO_BD/Public/index.php/users/login">
                            Connexion</a>
                        </li>
                    <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
    <?php if (!empty($_SESSION['erreur'])) : ?>
        <div class="alert alert-danger">
            <strong>ATTENTION!</strong>
            <?php echo $_SESSION['erreur']; unset($_SESSION['erreur']) ?>
        </div>
    <?php endif; ?>
        <?php if (!empty($_SESSION['message'])) : ?>
        <div class="alert alert-success">
            <strong>BIEN!</strong>
            <?php echo $_SESSION['message']; unset($_SESSION['message']) ?>
        </div>
    <?php endif; ?>
        <?= $contenu ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
    crossorigin="anonymous"></script>

    <script src="/js/scripts.js"></script>
</body>
</html>