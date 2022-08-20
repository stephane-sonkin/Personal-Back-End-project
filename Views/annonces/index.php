<h1>Page d'acceuil des annonces</h1>

<?php foreach($annonces as $annonce): ?>
    <article>
        <h2><a href="annonces/lire/<?= $annonce->Id ?>"><?= $annonce->titre ?>
        </a></h2>
        <div><?= $annonce->description?></div>
    </article>
<?php endforeach; ?>