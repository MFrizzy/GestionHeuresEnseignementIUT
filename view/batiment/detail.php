<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Batiment <?php echo $batiment->getNomBatiment(); ?></h2>
        </div>
    </div>


    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th></th>
            <th class="mdl-data-table__cell--non-numeric">N° Salle</th>
            <th class="mdl-data-table__cell--non-numeric">Capacité</th>
            <th class="mdl-data-table__cell--non-numeric">Type</th>
            <th class="mdl-data-table__cell--non-numeric">Taux d'occupation</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <th class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=salle&action=read&nomBatiment=' . htmlspecialchars($value->getNomBatiment()) . '&numSalle=' . htmlspecialchars($value->getNumSalle()) . '">' . '<i class="material-icons">expand_more</i></a></th>
                        <th>' . htmlspecialchars($value->getNumSalle()) . '</th>
                        <th>'.htmlspecialchars($value->getCapacite()).'</th>
                        <th class="mdl-data-table__cell--non-numeric"> '.htmlspecialchars($value->getTypeSalle()).'</th>
                        <th>'.htmlspecialchars($value->getTauxOccupation()).'</th>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>

</div>