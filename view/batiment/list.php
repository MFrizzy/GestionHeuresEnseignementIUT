<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th>Details</th>
            <th class="mdl-data-table__cell--non-numeric">Batiment</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <th><a href="index.php?controller=batiment&action=read&nomBatiment=' . htmlspecialchars($value->getNomBatiment()) . '">' . '<i class="material-icons">expand_more</i></a></th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomBatiment()) . '</th>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>