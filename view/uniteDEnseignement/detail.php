<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Diplome : <?php echo $ue->getCodeDiplome()->nommer() ?><br>
            Semestre : <?php echo $ue->getSemestre() ?>
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
                    <td><?php echo htmlspecialchars($ue->getHeuresTD()) ?></td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">TP</td>
                    <td><?php echo htmlspecialchars($ue->getHeuresTP()) ?></td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">Cours Magistraux</td>
                    <td><?php echo htmlspecialchars($ue->getHeuresCM()) ?></td>
                </tr>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Total</th>
                    <th><?php echo htmlspecialchars($ue->getVolumeHoraire()) ?></th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="mdl-card__menu">
            <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                <a href="index.php?controller=diplome&action=update&codeDiplome=<?php echo htmlspecialchars($ue->getCodeDiplome()) ?>"><i
                            class="material-icons">edit</i></button>
            </a>
        </div>
    </div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th>Details</th>
            <th class="mdl-data-table__cell--non-numeric">Code du module</th>
            <th class="mdl-data-table__cell--non-numeric">Nom du module</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($modules as $module) {
            echo '    <tr>
                        <th class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=module&action=read&codeModule='.$module->getCodeModule().'"><i class="material-icons">expand_more</i></a></th>
                        <th class="mdl-data-table__cell--non-numeric">'.$module->getCodeModule().'</th>
                        <th class="mdl-data-table__cell--non-numeric">'.$module->getNomModule().'</th>
                  </tr>';
        }
        ?>
        </tbody>
    </table>

</div>
