<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th>Details</th>
            <th class="mdl-data-table__cell--non-numeric">Mail</th>
            <th class="mdl-data-table__cell--non-numeric">Admin</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            if ($value->getAdmin() == 1) {
                $activated = '<i class="material-icons">supervisor_account</i>';
                $setAdmin = '';
            } else {
                $activated = '';
                $setAdmin = '<a href="index.php?controller=user&action=setAdmin&mailUser=' . htmlspecialchars($value->getMailUser()) . '"><i class="material-icons">person_add</i></a>';
            }
            echo '<tr>
                        <th><a href="index.php?controller=user&action=read&mailUser=' . htmlspecialchars($value->getMailUser()) . '">' . '<i class="material-icons">expand_more</i></a></th>
                        <th class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getMailUser()) . '</th>
                        <th class="mdl-data-table__cell--non-numeric">' . $activated . '</th>
                        <th class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=user&action=update&mailUser=' . htmlspecialchars($value->getMailUser()) . '"><i class="material-icons">mode_edit</i></a></th>
                        <th class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=user&action=delete&mailUser=' . htmlspecialchars($value->getMailUser()) . '"><i class="material-icons">delete</i></a></th>
                        <th class="mdl-data-table__cell--non-numeric">' . $setAdmin . '</th>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>

<a href="index.php?controller=user&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>