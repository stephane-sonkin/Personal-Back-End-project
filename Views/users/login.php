<?php if (!empty($_SESSION['erreur'])): ?>
    <div class="alert alert-danger">
        <strong>ATTENTION!</strong>
        <?php echo $_SESSION['erreur']; unset($_SESSION['erreur']) ?>
    </div>
<?php endif; ?>

<h1>CONNEXION</h1>
<?= $loginForm ?>