<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo htmlspecialchars($ens->getNomEns() . ' ' . $ens->getPrenomEns()) ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Code Enseignant : <?php echo htmlspecialchars($ens->getCodeEns()) ?><br>
            Departement : <?php echo htmlspecialchars($ens->getCodeDepartement()->getNomDepartement()) ?><br>
            Statut v1 : <?php echo htmlspecialchars($ens->getCodeStatut()->getStatut()) ?><br>
            Statut v2 : <?php echo htmlspecialchars($ens->getCodeStatut()->getTypeStatut()) ?><br>
            Etat Service : <?php echo htmlspecialchars($ens->getEtatService()) ?><br>
            Nombre d'heures à faire : <?php echo htmlspecialchars($ens->getCodeStatut()->getNombresHeures()) ?><br>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=enseignant&action=update&codeEns=<?php echo htmlspecialchars($ens->getCodeEns()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
        </div>
    </div>

</div>