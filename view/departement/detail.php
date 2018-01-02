<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo htmlspecialchars($dep->getNomDepartement()) ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Batiment : <?php echo $dep->getNomBatiment()->getNomBatiment() ?>
        </div>
        <div class="mdl-card__menu">
            <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                <a href="index.php?controller=departement&action=update&codeDepartement=<?php echo htmlspecialchars($dep->getCodeDepartement()) ?>"><i
                        class="material-icons">edit</i></button>
            </a>
        </div>
    </div>


    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th>Details</th>
            <th class="mdl-data-table__cell--non-numeric">Diplome</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <th class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=diplome&action=read&codeDiplome=' . htmlspecialchars($value->getCodeDiplome()) . '">' . '<i class="material-icons">expand_more</i></a></th>
                        <th>' . htmlspecialchars($value->getTypeDiplome()) . ' ' .htmlspecialchars($value->getNomDiplome()). '</th>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>

</div>
