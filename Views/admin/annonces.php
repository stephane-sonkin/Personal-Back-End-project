<table class="table table-striped">
    <thead>
        <th>ID</th>
        <th>Titre</th>
        <th>Contenu</th>
        <th>Actif</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach ($annonces as $annonce) : ?>
            <tr>
                <td><?= $annonce->Id ?></td>
                <td><?= $annonce->titre ?></td>
                <td><?= $annonce->description ?></td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" 
                        id="mySwitch<?= $annonce->Id ?>" <?= $annonce->actif ? 
                        'checked' : '' ?> data-id="<?= $annonce->Id ?>">
                        <label class="form-check-label" for="mySwitch<?= $annonce->Id ?>"></label>
                    </div>
                </td>
                <td>
                    <a href="/POO_BD/Public/index.php/annonces/modifier/<?= $annonce->Id ?>" 
                    class="btn btn-warning">Modifier</a>
                    <a href="/POO_BD/Public/index.php/admin/supprimerAnnonce/<?= $annonce->Id ?>" 
                    class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
