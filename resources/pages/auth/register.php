<?php

use Classes\Database;
use Classes\Password;
use Classes\Query\Query;

$connection = Database::getConnection();
$countries = Query::get('countries', 'CountryID, CountryName');
$genders = Query::get('genders');
if(isset($_POST['submit'])) {
    Password::verify();
}
?>
    <div class="container my-5">
        <?php if(isset($_SESSION['errors'])) { ?>
            <div class="alert alert-danger">
                <h2><?=trans('register.errors.errors')?></h2>
                <?php foreach($_SESSION['errors'] as $error) { ?>
                    <p><?= trans('register.' . $error) ?></p>
                <?php } ?>
            </div>
        <?php } ?>

        <form action="<?=url('register')?>" method="POST">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><?=trans('auth.register')?></h2>
                    <small class="card-subtitle text-muted"><?=trans('register.requiredHelper')?>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted"><?=trans('register.personalInformation')?></h6>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="gender"><?=trans('register.gender')?>*</label>
                            <select name="gender" id="gender" class="custom-select">
                                <option value="" selected><?=trans('register.gender')?></option>
                                <?php foreach($genders as $gender) { ?>
                                    <option
                                        <?= (old('gender') === $gender->GenderID) ? 'selected' : '' ?>
                                        value="<?= $gender->GenderID ?>"><?= trans('genders.' . $gender->Name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5 col-lg-5">
                            <label for="firstName"><?=trans('register.firstName')?>*</label>
                            <input type="text"
                                   id="firstName"
                                   name="firstName"
                                   placeholder="<?=trans('register.firstName')?>"
                                   class="form-control"
                                   value="<?= old('firstName') ?>">
                        </div>
                        <div class="form-group col-md-3 col-lg-2">
                            <label for="appendix"><?=trans('register.infix')?></label>
                            <input id="appendix"
                                   type="text"
                                   name="appendix"
                                   placeholder="<?=trans('register.infix')?>"
                                   class="form-control"
                                   value="<?= old('infix') ?>">
                        </div>
                        <div class="form-group col-md-4 col-lg-5">
                            <label for="lastName"><?=trans('register.lastName')?>*</label>
                            <input id="lastName"
                                   type="text"
                                   placeholder="<?=trans('register.lastName')?>"
                                   name="lastName"
                                   class="form-control"
                                   value="<?= old('lastName') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="email"><?=trans('register.email')?>*</label>
                            <input id="email" value="<?= old('email') ?>" class="form-control" name="email" type="email"
                                   placeholder="<?=trans('register.email')?>">
                            <small id="emailHelp" class="form-text text-muted">
                                <?=trans('register.emailHelper')?>
                            </small>
                        </div>
                        <div class="form-group col-12">
                            <label for="phone"><?=trans('register.phoneNumber')?>*</label>
                            <input id="phone" value="<?= old('phoneNumber') ?>" class="form-control" name="phoneNumber"
                                   type="tel" placeholder="0612345678">
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-subtitle my-2 text-muted"><?=trans('register.addressInformation')?>*</h6>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="city"><?=trans('register.city')?>*</label>
                            <input type="text"
                                   class="form-control"
                                   id="city"
                                   name="city"
                                   placeholder="<?=trans('register.city')?>"
                                   value="<?= old('city') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address"><?=trans('register.address')?>*</label>
                            <input id="address"
                                   name="address"
                                   placeholder="<?=trans('register.address')?>"
                                   class="form-control"
                                   value="<?= old('address') ?>">
                        </div>
                        <div class="form-group col-md-6 col-lg-2">
                            <label for="houseNumber"><?=trans('register.houseNumber')?>*</label>
                            <input id="houseNumber"
                                   type="number"
                                   name="houseNumber"
                                   placeholder="<?=trans('register.houseNumber')?>"
                                   class="form-control"
                                   value="<?= old('houseNumber') ?>">
                        </div>
                        <div class="form-group col-md-6 col-lg-2">
                            <label for="addition"><?=trans('register.addition')?></label>
                            <input id="addition"
                                   name="addition"
                                   placeholder="<?=trans('register.addition')?>"
                                   class="form-control"
                                   value="<?= old('addition') ?>">
                        </div>
                        <div class="form-group col-md-6 col-lg-2">
                            <label for="zipCode"><?=trans('register.zipCode')?>*</label>
                            <input id="zipCode"
                                   name="zipCode"
                                   placeholder="<?=trans('register.zipCode')?>"
                                   class="form-control"
                                   value="<?= old('zipCode') ?>">
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-subtitle my-2 text-muted"><?=trans('register.password')?>*</h6>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="password"><?=trans('register.password')?></label>
                            <div class="input-group">
                                <input id="password" name="password" type="password" min="8" class="form-control">
                                <div class="input-group-append">
                                    <button tabindex="-1" data-toggle="tooltip" data-placement="top" title="WWWW" id="showPasswordButton" class="btn btn-outline-secondary material-button"
                                            style="padding: 5px 10px 0 10px">
                                        <i class="material-icons">visibility</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="passwordConfirm"><?=trans('register.passwordConfirm')?>*</label>
                            <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-auto mr-auto">
                            <p>
                                <?=trans('register.alreadyRegistered')?>
                                <a href="<?=url('login')?>" class="text-primary">
                                    <?=trans('auth.login')?>
                                </a>
                        </div>
                        <div class="col-auto ml-auto">
                            <button type="submit" name="submit" class="btn btn-success">
                                <?=trans('general.save')?>
                            </button>
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
if(isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}