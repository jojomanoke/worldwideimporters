<?php
// session_start();
$msg = "";

if (isset($_POST['submit'])) {
    $connection = \Classes\Database::getConnection();
    $email = $connection->real_escape_string($_POST['email']);
    $password = $connection->real_escape_string($_POST['wachtwoord']);

    $sql = $connection->query("SELECT wachtwoord FROM users WHERE email='$email'");
    if ($sql->num_rows > 0) {
        $data = $sql->fetch_array();
        if (password_verify($password, $data['wachtwoord'])) {
            // $_SESSION['userSession'] = $data['email'];
            $msg = "Je bent ingelogd!";
        } else
            $msg = "Controleer uw gegevens!";
    } else
        $msg = "Controleer je gegevens!";

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compitable" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3" align="center"><br><br>
            <?php if ($msg !="") echo $msg . "<br><br>"; ?>
            <h1>Inloggen</h1>
            <i class="material-icons">lock</i>
            <br>
            <div>

            <form method="post" action="login.php">
            <input class="form-control" type="text" name="email" placeholder="E-mail..."><br>
            <input class="form-control" type="password" name="wachtwoord" placeholder="Wachtwoord..."><br>
            <input type="submit" class="btn btn-primary" value="Log in!" name="submit">
            </form>
            </div>