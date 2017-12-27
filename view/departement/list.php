<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th></th>
            <th class="mdl-data-table__cell--non-numeric">Departement</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                        <th><a href="index.php?controller=departement&action=read&codeDepartement=' . htmlspecialchars($value->getCodeDepartement()) . '">' . '<i class="material-icons">expand_more</i></a></th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomDepartement()) . '</th>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>