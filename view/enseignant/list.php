<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Recherche avec un code d'enseignant</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="<?php // TODO ?>">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="codeEnseignant" name="codeEnseignant">
                    <label class="mdl-textfield__label" for="codeEnseignant">Code Enseignant</label>
                </div>
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                    <i class="material-icons">send</i>
                </button>
            </form>
        </div>
    </div>

    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Recherche avec le nom ou prénom d'un enseignant</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="<?php // TODO ?>">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="npEnseignant" name="npEnseignant">
                    <label class="mdl-textfield__label" for="npEnseignant">Nom / Prenom Enseignant</label>
                </div>
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                    <i class="material-icons">send</i>
                </button>
            </form>
        </div>
    </div>

    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Recherche par Département</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="<?php // TODO ?>">
                <label class="select">Département</label>
                <select style="display: block;" required name="codeDepartement">
                    <?php foreach ($departements as $departement) {
                        echo '<option value"' . $departement->getCodeDepartement().'"';
                        echo '>' . $departement->getNomDepartement() . '</option>';
                    }
                    ?>
                </select>
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                    <i class="material-icons">send</i>
                </button>
            </form>
        </div>
    </div>

    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Recherche par statut</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="<?php // TODO ?>">
                <label class="select">Statut</label>
                <select style="display: block;" required name="codeStatut">
                    <?php
                    foreach ($statuts as $statut) {
                        echo '<option value="' . $statut->getCodeStatut() . '"' ;
                        echo '>'. $statut->getStatut() . " " . $statut->getTypeStatut() . '</option>';
                    }
                    ?>
                </select>
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                    <i class="material-icons">send</i>
                </button>
            </form>
        </div>
    </div>
</div>

<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
    <thead>
    <tr>
        <th>Details</th>
        <th class="mdl-data-table__cell--non-numeric">Code Enseignant</th>
        <th class="mdl-data-table__cell--non-numeric">Nom</th>
        <th class="mdl-data-table__cell--non-numeric">Prénom</th>
        <th class="mdl-data-table__cell--non-numeric">Département</th>
        <th class="mdl-data-table__cell--non-numeric">Statut 1</th>
        <th class="mdl-data-table__cell--non-numeric">Statut 2</th>
        <th class="mdl-data-table__cell--non-numeric">Etat service</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($tab as $value) {
        $statut = $value->getCodeStatut();
        echo '<tr>
                        <th><a href="index.php?controller=enseignant&action=read&codeEns=' . htmlspecialchars($value->getCodeEns()) . '">' . '<i class="material-icons">expand_more</i></a></th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getCodeEns()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomEns()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getPrenomEns()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getCodeDepartement()->getNomDepartement()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($statut->getStatut()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($statut->getTypeStatut()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getEtatService()) . '</th>
                    </tr>
            ';
    }
    ?>
    </tbody>
</table>

<a href="index.php?controller=enseignant&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>