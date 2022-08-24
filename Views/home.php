<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php if (!empty($_SESSION['erreur'])) : ?>
        <div class="alert alert-danger">
            <strong>Danger!</strong>
            <?php echo $_SESSION['erreur']; unset($_SESSION['erreur']) ?>
        </div>
    <?php endif; ?>
        <?php if (!empty($_SESSION['message'])) : ?>
        <div class="alert alert-success">
            <strong>Danger!</strong>
            <?php echo $_SESSION['message']; unset($_SESSION['message']) ?>
        </div>
    <?php endif; ?>
        <?= $contenu ?>
    </div>
    <div class="text-center">
        <a href="/POO_BD/Public/index.php/annonces" class="btn btn-primary">Voir la liste des annonces</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>