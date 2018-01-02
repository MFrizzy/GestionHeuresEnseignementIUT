<div class="detailBatiment1" style="justify-content: center;">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Recherche avec un code d'enseignant</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="index.php?controller=enseignant&action=searchByCode">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="codeEns" name="codeEns">
                    <label class="mdl-textfield__label" for="codeEns">Code Enseignant</label>
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
            <form method="post" action="index.php?controller=enseignant&action=searchByName">
                (renseigner un nom ou un prenom)
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="npEns" name="npEns">
                    <label class="mdl-textfield__label" for="npEns">Nom / Prenom Enseignant</label>
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
            <form method="post" action="index.php?controller=enseignant&action=searchByDep">
                <label class="select">Département</label>
                <select style="display: block;" required name="codeDepartement">
                    <?php foreach ($departements as $departement) {
                        echo '<option value="' . $departement->getCodeDepartement().'"';
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
            <form method="post" action="index.php?controller=enseignant&action=searchByStatut">
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

<?php require_once File::build_path(array('view','enseignant','list.php'))?>