<?php
include "header.php";
$userInfo = GetCurrentUserData();
if($userInfo == null){
    echo "Log eerst in om je gegevens te bekijken";
    die();
}


?>
</div>
</div>
</div>


<div class="view-profile-content-container">
    <div id="gegevens-container">
        <div class="gegevens-row">
            <h1 class="title">Jouw gegevens</h1>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Email</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['email']?></span>
            </div>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Voornaam</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['voornaam']?></span>
            </div>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Tussenvoegsel</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['tussenvoegsel']?></span>
            </div>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Achternaam</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['achternaam']?></span>
            </div>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Adres</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['adres']?></span>
            </div>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Postcode</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['postcode']?></span>
            </div>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Woonplaats</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['woonplaats']?></span>
            </div>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Land</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['land']?></span>
            </div>
        </div>
        <div class="gegevens-row">
            <div class="gegevens-title">
                <span class="g-title">Telefoonnummer</span>
            </div>
            <div class="gegevens-weergave">
                <span class="g-view"><?= $userInfo['telefoon']?></span>
            </div>
        </div>
    </div>
</div>