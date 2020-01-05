<?php

use Classes\Auth;
use Classes\Login;
use Classes\Query\Query;

if(!Login::isLoggedIn()) {
    echo '<script>window.location.href = "/login";</script>';
    exit();
}
$user = Auth::user();
$gender = Query::get("SELECT * FROM genders WHERE GenderID = {$user->GenderID}")->first()->Name;
?>
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            Profiel
        </h2>
    </div>
    <div class="card-body">
        <strong>Naam: </strong><?= $user->FirstName ?> <?=$user->Infix?> <?=$user->LastName?><br>
        <strong>Email: </strong><?= $user->Email ?><br>
        <strong>Geslacht: </strong><?= trans('genders.'.$gender) ?><br>
        <strong>Telefoonnummer: </strong><?= $user->PhoneNumber ?><br>
        <strong>Adresgegevens: </strong><?= $user->Address ?> <?= $user->HouseNumber ?> <?= $user->Addition ?><br>
        <strong>Postcode en stad: </strong><?= $user->ZipCode ?> <?= $user->City ?><br>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <a href="<?=url('profile/edit')?>" class="btn btn-outline-success">Aanpassen</a>
        </div>
    </div>
</div>