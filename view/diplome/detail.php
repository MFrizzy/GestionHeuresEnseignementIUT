<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp detaildiplome">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Volume horaire total : <?php echo $diplome->getVolumeHoraire() ?>
        </div>
        <div class="mdl-card__menu">
            <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                <a href="index.php?controller=diplome&action=update&codeDiplome=<?php echo htmlspecialchars($diplome->getCodeDiplome()) ?>"><i
                            class="material-icons">edit</i></button>
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
                        <th class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=uniteDEnseignement&action=read&nUE=' . htmlspecialchars($value->getNUE()) . '">' . '<i class="material-icons">expand_more</i></a></th>
                        <th>' . htmlspecialchars($value->getNUE()) . '</th>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>

</div>
