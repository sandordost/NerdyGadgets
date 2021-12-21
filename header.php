<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
include "database-changes.php";

$databaseConnection = connectToDatabase();
$currentUser = GetCurrentUserData();

$loggedIn = false;
if($currentUser != null){
    $loggedIn = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
    <link rel="stylesheet" href="Public/CSS/new-header.css">
    <link rel="stylesheet" href="Public/CSS/registratie-pagina.css">
    <link rel="icon" type="image/x-icon" href="Public/Img/NerdyGadgetsLogo.ico">
    <link rel="stylesheet" href="Public/CSS/nieuwe-aanpassingen.css">
</head>
<body>
    <div class="new-header">
        <div class="left-bar">
            <div class="logo">
                <a href="./">
                    <img src="Public/ProductIMGHighRes/NerdyGadgetsLogo.png" alt="">
                </a>
            </div>
            <div class="categories">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <div class="category">
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </div>
                    <?php
                }
                ?>
                <div class="category">
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </div>
            </div>
        </div>
        <div class="right-bar">
            <div class="search-bar">
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken</a>
            </div>
            <div id="account-container">
                <div id="profile-info">
                    <?php if($loggedIn){ ?>
                        <a id="account-naam" href=""><?=$currentUser[3]?></a>
                    <?php } else { ?>
                        <a id="account-naam" href="">Gast</a>
                    <?php } ?>
                    <div id="shopping-cart-container">
                        <a id="mijn-winkelmand" href="cart.php" id="winkelmand"><i class="fas fa-shopping-cart search"></i>Mijn winkelmand</a>
                    </div>
                </div>
                <div id="profile-image">
                    <i class="fas fa-user"></i>
                </div>
                </a>
            </div>
        </div>
    </div>
    <div id="info-row">
        <span id="info-row-text"><i class="fas fa-fire-alt fa-rotate-270"></i><i class="fas fa-sleigh"></i><b>Gratis verzendkosten</b> bij besteding van <u>minimaal 30 euro</u></span>
    </div>

<!-- Account popup -->
    <div id="account-popup" class="hidden">
        <?php if($loggedIn) { ?>
            <a href="login.php?action=logout" class="logout-button" id="logout-button">Uitloggen</a>
        <?php } else { ?>
            <div id="register-login-popup">
                <span id="title">Je bent nog niet ingelogd</span>
                <div class="login">
                    <span class="login-text">Ben je al <b>klant</b>, log dan hier in</span>
                    <div id="goto-login-button" class="login-button">
                        <a>Inloggen</a>
                    </div>
                </div>
                <div class="register">
                    <span class="register-text">Ben je nog <b>geen klant</b>, klik dan op registreren</span>
                    <div class="register-button">
                        <a href="registratie.php" class="register-button-text">Registreren</a>
                    </div>
                </div>
            </div>
            <div id="login-popup" class="hidden">
                <div class="login-popup-row">
                    <span class="login-popup-title">Inloggen</span>
                </div>
                <div class="login-popup-row">
                    <form action="login.php" method="post">
                        <div class="input-row">
                            <label for="login-email-input">Emailadres</label>
                            <input type="email" name="email" id="login-email-input">
                        </div>
                        <div class="input-row">
                            <label for="login-email-input">Wachtwoord</label>
                            <input type="password" name="wachtwoord" id="login-wachtwoord-input">
                        </div>
                        <div class="input-row">
                            <input type=submit value="Inloggen" id="login-button" class="login-button">
                            <div id="login-return-button"><</div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
<!-- Later scripts inladen -->
    <script src="Public/JS/account-popup.js"></script>
<!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div id="content-1th-child" class="col-12">
            <div id="SubContent">


