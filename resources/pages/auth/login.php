<?php
// session_start();
use Classes\Database;
use Classes\Login;

if(isset($_POST['submit'])) {
    /** @var \mysqli $connection is the same as new mysqli($usern, $passw, $dbname, $port) */
    $connection = Database::getConnection();
    $email = $connection->real_escape_string($_POST['email']);
    $password = $connection->real_escape_string($_POST['password']);
    /** @var $stmt //Prepares the sql statement with a question mark */
    $stmt = $connection->query("SELECT password FROM users WHERE email = '$email' LIMIT 1");
    if($stmt && $stmt->num_rows > 0) {
        /** @var \mysqli $data Fetch the results */
        $data = $stmt->fetch_array();
        if(password_verify($password, $data['password'])) {
            Login::login();
            
            $msg = 'Je bent ingelogd!';
        } else {
            $msg = 'Controleer uw gegevens!';
        }
    } else {
        $msg = 'Controleer je gegevens!';
    }
    
} ?>

<div class="row mt-2 mt-md-5 justify-content-center">
    <div class="col-md-6 col-md-offset-3 text-center">
        <?= $msg ?? '' ?>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Inloggen</h2>
            </div>
            <div class="card-body">
                <form method="post" action="/login">
                    <div class="form-row">
                        <div class="col-12">
                            <label for="email" class="sr-only">E-mail</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="material-icons">mail</i>
                                    </div>
                                </div>
                                <input id="email" class="form-control" type="text" name="email" placeholder="E-mail">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 my-5">
                            <label for="password" class="sr-only">Wachtwoord</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="material-icons">lock</i>
                                    </div>
                                </div>
                                <input id="password" class="form-control" type="password" name="password"
                                       placeholder="Wachtwoord...">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <input type="submit" class="btn btn-primary col-md-4 col-12" value="Log in!" name="submit">
                    </div>
                    <p class="text-muted mt-3 small">
                        Bent u nieuw? <a href='/register'>Registreren</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>