<?php

use Classes\Auth;
use Classes\Database;
use Classes\Login;

if(!Login::isLoggedIn()) {
    redirect('/login');
}
if(isset($_POST) && count($_POST) > 0){
    $query = 'UPDATE users SET ';
    $index = 1;
    foreach($_POST as $key => $value){
        $query .= $key . ' = ' . (is_string($value) ? "'$value'" : $value) . ($index !== count($_POST) ? ', ' : '');
        $index++;
    }
    $query .= ' WHERE UserID = ' . Auth::id();
    $conn = Database::getConnection();
    $stmt = $conn->prepare($query);
    if($stmt === false){
        trigger_error($conn->error, E_USER_ERROR);
        exit();
    }
    $stmt->execute();
}
$user = Auth::user();
$genders = \Classes\Query\Query::get('genders');
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Profiel aanpassen</h2>
    </div>
    <div class="card-body">
        <form action="<?= activeUrl() ?>" method="post" id="profileEdit">
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="Email">E-mail</label>
                        <input required type="text" class="form-control" id="Email" name="Email"
                               value="<?= $user->Email ?>">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="FirstName">Voornaam</label>
                        <input required type="text" class="form-control" id="FirstName" name="FirstName"
                               value="<?= $user->FirstName ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="Infix">Tussenvoegsel</label>
                        <input type="text" class="form-control" id="Infix" name="Infix" value="<?= $user->Infix ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="LastName">Achternaam</label>
                        <input required type="text" class="form-control" id="LastName" name="LastName"
                               value="<?= $user->LastName ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="Gender">Geslacht</label>
                        <select required type="text" class="form-control" id="Gender" name="GenderID">
                            <?php foreach($genders as $gender) { ?>
                                <option <?php if($gender->GenderID === $user->GenderID) {
                                    echo 'selected';
                                } ?> value="<?= $gender->GenderID ?>">
                                    <?= trans("genders.$gender->Name") ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="Address">Straat</label>
                        <input required type="text" class="form-control" id="Address" name="Address"
                               value="<?= $user->Address ?>">
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="HouseNumber">Huisnummer</label>
                        <input required type="text" class="form-control" id="HouseNumber" name="HouseNumber"
                               value="<?= $user->HouseNumber ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="Addition">Toevoeging</label>
                        <input type="text" class="form-control" id="Addition" name="Addition"
                               value="<?= $user->Addition ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="ZipCode">Postcode</label>
                        <input type="text" class="form-control" id="ZipCode" name="ZipCode"
                               value="<?= $user->ZipCode ?>">
                    </div>
                </div>
            </div>
            <button class="d-none" type="submit"></button>
        </form>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button onclick="$('#profileEdit').submit()" class="btn btn-outline-success">Opslaan</button>
        </div>
    </div>
</div>
