<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Types d'heures</th>
                    <th class="mdl-data-table__cell--non-numeric">Volume horaire</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">TD</td>
                    <td><?php echo htmlspecialchars($diplome->getHeuresTD()) ?></td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">TP</td>
                    <td><?php echo htmlspecialchars($diplome->getHeuresTP()) ?></td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">Cours Magistraux</td>
                    <td><?php echo htmlspecialchars($diplome->getHeuresCM()) ?></td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">Projet</td>
                    <td><?php echo htmlspecialchars($diplome->getHeuresProjet()) ?></td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">Stage</td>
                    <td><?php echo htmlspecialchars($diplome->getHeuresStage()) ?></td>
                </tr>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Total</th>
                    <th><?php echo htmlspecialchars($diplome->getVolumeHoraire()) ?></th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=diplome&action=update&codeDiplome=<?php echo htmlspecialchars($diplome->getCodeDiplome()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=diplome&action=delete&codeDiplome=<?php echo htmlspecialchars($diplome->getCodeDiplome()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
    </div>


    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th></th>
            <th class="mdl-data-table__cell--non-numeric">UE</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=uniteDEnseignement&action=read&nUE=' . htmlspecialchars($value->getNUE()) . '">' . '<i class="material-icons">expand_more</i></a></td>
                        <td>UE' . htmlspecialchars($value->nommer()) . '</td>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>

</div>
