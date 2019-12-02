<?php
$connection = \Classes\Database::getConnection();
$countries = \Classes\Query\Query::get('countries', 'CountryID, CountryName');
$genders = \Classes\Query\Query::get('genders');
if ( isset($_POST[ 'submit' ]) ) {
    \Classes\Password::verify();
}
?>
    <div class="container my-5">
        <?php if(isset($_SESSION['errors'])){ ?>
        <div class="alert alert-danger">
            <h2>U heeft fouten bij enkele velden:</h2>
            <?php foreach($_SESSION['errors'] as $error){ ?>
                <p><?=trans('register.'.$error)?></p>
            <?php } ?>
        </div>
        <?php } ?>
        
        <form action="/register" method="POST">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Registreren</h2>
                    <small class="card-subtitle text-muted">Velden met een <font color="black" size="4px">*</font> zijn verplicht!
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Persoonlijke Informatie</h6>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="gender">Geslacht*</label>
                            <select name="gender" id="gender" class="custom-select">
                                <option value="" selected>Geslacht</option>
                                <?php foreach($genders as $gender) {?>
                                <option
                                        <?= (old('gender') === $gender->GenderID) ? 'selected' : '' ?>
                                        value="<?=$gender->GenderID?>"><?= trans('genders.'.$gender->Name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5 col-lg-5">
                            <label for="firstName">Voornaam*</label>
                            <input type="text"
                                   id="firstName"
                                   name="firstName"
                                   placeholder="Victor"
                                   class="form-control"
                                   value="<?= old('firstName') ?>">
                        </div>
                        <div class="form-group col-md-3 col-lg-2">
                            <label for="appendix">Tussenvoegsel</label>
                            <input id="appendix"
                                   type="text"
                                   name="appendix"
                                   placeholder="Von"
                                   class="form-control"
                                   value="<?= old('appendix') ?>">
                        </div>
                        <div class="form-group col-md-4 col-lg-5">
                            <label for="lastName">Achternaam*</label>
                            <input id="lastName"
                                   type="text"
                                   placeholder="Doom"
                                   name="lastName"
                                   class="form-control"
                                   value="<?= old('lastName') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="email">E-mail*</label>
                            <input id="email" value="<?=old('email')?>" class="form-control" name="email" type="email" placeholder="E-mail">
                            <small id="emailHelp" class="form-text text-muted">We zullen uw e-mail nooit met anderen
                                delen.</small>
                        </div>
                        <div class="form-group col-12">
                            <label for="phone">Telefoonnummer*</label>
                            <input id="phone" value="<?=old('phoneNumber')?>" class="form-control" name="phoneNumber" type="tel" placeholder="0612345678">
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-subtitle my-2 text-muted">Adresgegevens*</h6>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="country">Land</label>
                            <select name="country" id="country" class="custom-select">
                                <option selected>Kies uw land</option>
                                <?php foreach ( $countries as $country ) { ?>
                                    <option <?= post('country') ? 'selected' : '' ?>
                                            <?= old('country') === $country->CountryID ? 'selected' : '' ?>
                                            value="<?= $country->CountryID ?>"><?= $country->CountryName ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city">Stad*</label>
                            <input type="text"
                                   class="form-control"
                                   id="city"
                                   name="city"
                                   placeholder="Stad"
                                   value="<?= old('city') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address">Adres*</label>
                            <input id="address"
                                   name="address"
                                   placeholder="Adres"
                                   class="form-control"
                                   value="<?= old('address') ?>">
                        </div>
                        <div class="form-group col-md-6 col-lg-2">
                            <label for="houseNumber">Huisnummer</label>
                            <input id="houseNumber"
                                   type="number"
                                   name="houseNumber"
                                   placeholder="Huisnummer"
                                   class="form-control"
                                   value="<?= old('houseNumber') ?>">
                        </div>
                        <div class="form-group col-md-6 col-lg-2">
                            <label for="addition">Toevoeging</label>
                            <input id="addition"
                                   name="addition"
                                   placeholder="Toevoeging"
                                   class="form-control"
                                   value="<?= old('addition') ?>">
                        </div>
                        <div class="form-group col-md-6 col-lg-2">
                            <label for="zipCode">Postcode*</label>
                            <input id="zipCode"
                                   name="zipCode"
                                   placeholder="Postcode"
                                   class="form-control"
                                   value="<?= old('zipCode') ?>">
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-subtitle my-2 text-muted">Wachtwoord*</h6>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="password">Wachtwoord</label>
                            <div class="input-group">
                                <input id="password" name="password" type="password" min="8" class="form-control">
                                <div class="input-group-append">
                                    <button id="showPasswordButton" class="btn btn-outline-secondary material-button"
                                            style="padding: 5px 10px 0 10px">
                                        <i class="material-icons">visibility</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="passwordConfirm">Wachtwoord bevestigen*</label>
                            <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-auto mr-auto">
                            <p>Al een account? <a href="/login" class="text-primary">Login</a>
                        </div>
                        <div class="col-auto ml-auto">
                            <button type="submit" name="submit" class="btn btn-success">Opslaan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(() => {
            $('#showPasswordButton').on('click', function (e) {
                e.preventDefault();
                let passwordField = $('#password');
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).find('i').text('visibility_off');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).find('i').text('visibility');
                }
            });
        })
    </script>


<?php
if ( isset($_SESSION[ 'errors' ]) ) {
    unset($_SESSION[ 'errors' ]);
}