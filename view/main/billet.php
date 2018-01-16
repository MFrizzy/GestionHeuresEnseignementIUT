<?php if(!isset($envoye))echo
'<form method="post" action="index.php?controller=main&action=envoyer">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       type="text" id="sujet" name="sujet" required>
                <label class="mdl-textfield__label" for="sujet">Sujet</label>
            </div>

            <h6>Veuillez insérer un moyen de vous contacter dans le billet</h6>
            <div class="mdl-textfield mdl-js-textfield">
                <textarea class="mdl-textfield__input" type="text" rows= "8" id="billet" name="billet" required></textarea>
                <label class="mdl-textfield__label" for="billet">Billet</label>
            </div>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>
';
else echo '<h1>Votre billet a bien été envoyé</h1>';
