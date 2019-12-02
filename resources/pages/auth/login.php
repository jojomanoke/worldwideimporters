<?php
// session_start();
$msg = "";
if ( isset($_POST[ 'submit' ]) ) {
    /** @var \mysqli $connection is the same as new mysqli($usern, $passw, $dbname, $port) */
    $connection = \Classes\Database::getConnection();
    $email = $connection->real_escape_string($_POST[ 'email' ]);
    $password = $connection->real_escape_string($_POST[ 'password' ]);
    /** @var $stmt //Prepares the sql statement with a question mark */
    $stmt = $connection->query("SELECT password FROM users WHERE email = '$email' LIMIT 1");
    if ( $stmt && $stmt->num_rows > 0 ) {
        /** @var \mysqli $data Fetch the results */
        $data = $stmt->fetch_array();
        if ( password_verify($password, $data[ 'password' ]) ) {
            /** @var $msg //TODO: Beveiligen */
            \Classes\Login::login();
            
            $msg = "Je bent ingelogd!";
        } else
            $msg = "Controleer uw gegevens!";
    } else
        $msg = "Controleer je gegevens!";
    
}

?>
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3 text-center"><br><br>
            <?php if ( $msg != "" ) echo $msg . "<br><br>"; ?>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Inloggen</h2>
                                    <br>
                    <div>
                        <div class="card-body">
                <form method="post" action="/login">
                    <div class="input-container">
                        <i class="material-icons">mail</i>
                        <input class="form-control" type="text" name="email" placeholder="E-mail..."><br>
                    </div>
                    <div class="input-container">
                        <i class="material-icons">lock</i>
                        <input class="form-control" type="password" name="password" placeholder="Wachtwoord..."><br>

                    </div>
                    <input type="submit" class="btn btn-primary" value="Log in!" name="submit"><br><br>
                    Bent u nieuw? <a href=/register>Registreren</a>
                </form>
            </div>
        </div>
    </div>
</div>