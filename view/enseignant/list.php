<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th></th>
            <th class="mdl-data-table__cell--non-numeric">Code Enseignant</th>
            <th class="mdl-data-table__cell--non-numeric">Nom</th>
            <th class="mdl-data-table__cell--non-numeric">Prénom</th>
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
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($statut->getStatut()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($statut->getTypeStatut()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getEtatService()) . '</th>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>