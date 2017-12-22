<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <link rel="stylesheet" href="./style/material.min.css">
    <script src="./style/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="./style/styles.css">
</head>
<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title android-title mdl-typography--text-uppercase"><a class="titre" href="index.php">PONOS</a></span>
            <div class="mdl-layout-spacer"></div>
            <nav class="mdl-navigation mdl-layout--fixed-header">
                <a class="mdl-navigation__link" href="index.php?"></a>
            </nav>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Menu</span>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="./index.php">Accueil</a>
        </nav>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content">
            <?php
            $filepath = File::build_path(array("view", static::$object, "$view.php"));
            require $filepath;
            ?>
        </div>
    </main>

    <footer class="mdl-mini-footer">
        <div class="mdl-mini-footer__left-section">
            <div class="mdl-logo">PONOS</div>
            <ul class="mdl-mini-footer__link-list">
                <li><a href="#">Help</a></li>
                <li><a href="#">Privacy & Terms</a></li>
            </ul>
        </div>
    </footer>

</div>

</body>
</html>