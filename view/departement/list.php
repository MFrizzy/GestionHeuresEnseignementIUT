<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Details</th>
            <th class="mdl-data-table__cell--non-numeric">Departement</th>
            <th class="mdl-data-table__cell--non-numeric">Batiment</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <th><a href="index.php?controller=departement&action=read&codeDepartement=' . htmlspecialchars($value->getCodeDepartement()) . '">' . '<i class="material-icons">expand_more</i></a></th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomDepartement()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomBatiment()->getNomBatiment()).'</th>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>