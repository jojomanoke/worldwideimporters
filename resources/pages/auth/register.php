<?php
$host ="localhost";
$databasename = "wideworldimporters";
$databasename2 = "users";
$user = "root";
$pass = "";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);
$connection2 = mysqli_connect($host, $user, $pass, $databasename2, $port);
$sql = "SELECT CountryName FROM countries";
$result = mysqli_query($connection,$sql);


$msg = "";
if (isset($_POST['submit'])) {
    $connection = new mysqli("localhost", "root", "", "users", 3306);
    $aanhef = $connection2->real_escape_string($_POST['aanhef']);
    $voornaam = $connection2->real_escape_string($_POST['voornaam']);
    $tussenvoegsel = $connection2->real_escape_string($_POST['tussenvoegsel']);
    $achternaam = $connection2->real_escape_string($_POST['achternaam']);
    $land = $connection2->real_escape_string($_POST['land']);
    $telefoonnummer = $connection2->real_escape_string($_POST['telefoonnummer']);
    $stad = $connection2->real_escape_string($_POST['stad']);
    $adres = $connection2->real_escape_string($_POST['adres']);
    $huisnummer = $connection2->real_escape_string($_POST['huisnummer']);
    $toevoeging = $connection2->real_escape_string($_POST['toevoeging']);
    $postcode = $connection2->real_escape_string($_POST['postcode']);
    $email = $connection2->real_escape_string($_POST['email']);
    $wachtwoord = $connection2->real_escape_string($_POST['wachtwoord']);
    $bWachtwoord = $connection2->real_escape_string($_POST['bWachtwoord']);

    if ($wachtwoord != $bWachtwoord)
        $msg = "Controleer uw wachtwoord!";
    else {
            $hash = password_hash($wachtwoord, PASSWORD_BCRYPT);
            $connection2->query("INSERT INTO users (aanhef,voornaam, tussenvoegsel,
 achternaam, land, telefoonnummer, stad, adres, huisnummer, toevoeging, postcode, email, wachtwoord) 
 VALUES ('$aanhef','$voornaam','$tussenvoegsel', '$achternaam', '$land',
  '$telefoonnummer', '$stad', '$adres', '$huisnummer', '$toevoeging', '$postcode',
   '$email', '$hash')");
        }
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
<body style="background-color: white">
<div class="container" style="margin-top: 0px;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3" align="center">
            <?php if ($msg !="") echo $msg . "<br><br>"; ?>
            <form method="post" action="../../../KBS/real/register.php">
                <h1 class="one">Nieuw account aanmaken</h1><br>
                <h3 class="two"> Persoonlijke informatie</h3><br>
                <form method="get" action="../../../KBS/real/register.php">
                    <select class="custom-select mr-sm-2" name="aanhef" id="inlineFormCustomSelect" style="margin-bottom: 25px">
                        <option selected>Kies aanhef:</option>
                        <option value="Man">Man</option>
                        <option value="Vrouw">Vrouw</option>
                        <option value="Overig">Overig</option>
                    </select>
                <input class="form-control" name="voornaam" placeholder="Voornaam..." type="text" id="voornaam">
                        <br><input type="text" name="tussenvoegsel" placeholder="Tussenvoegsel..." class="form-control"><br>
                    <input class="form-control" name="achternaam" placeholder="Achternaam..." type="text"><br>
                    <select
                        class="custom-select mr-sm-2" id="inlineFormCustomSelect" style="margin-bottom: 25px" name="land">
                        <?php
                        print("<option selected>Kies uw land:</option>");
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $landen = $row["CountryName"];
                            print("<option value='$landen'> $landen </option> ");}?>
                    </select>
                    <input type="tel" name="telefoonnummer" placeholder="Telefoonnummer..." class="form-control"><br>
                    <input type="text" name="stad" placeholder="Stad..." class="form-control"><br>
                    <input type="text" name="adres" placeholder="Adres..." class="form-control"><br>
                    <input type="text" name="huisnummer" placeholder="Huisnummer..." class="form-control"><br>
                    <input type="text" name="toevoeging" placeholder="Toevoeging..." class="form-control"><br>
                    <input type="text" name="postcode" placeholder="Postcode..." class="form-control"><br>
                    <h3 class="two">Inloggegevens</h3><br>
                <input class="form-control"name="email" type="email" placeholder="E-mail...">
                <small id="emailHelp" class="form-text text-muted">We zullen uw e-mail nooit met anderen delen.</small><br>
                <input class="form-control" name="wachtwoord" type="password" placeholder="Wachtwoord..." id="Toon">
                <label>
                <input type="checkbox" onclick="myFunction('Toon')" class="">Wachtwoord tonen</label>
                <input class="form-control" name="bWachtwoord" type="password" placeholder="Bevestig wachtwoord..." id="Toon2"><br><br>
                <input class="btn btn-primary" name="submit" type="submit" value="Registreren" <a href="../../../KBS/internet/gelukt.php"></a> <br><br>
                    <h6>Heeft u al een account? <a href="login.php">Inloggen!</a></h6>

            </form>
        </div>
    </div>
</div>
</body>
</html>
            </label>
            <script>
                function myFunction(id) {
                    var x = document.getElementById(id);
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }
            </script>
        </label>
<style>
    h1.one {
        border-style: solid;
        border-color: deepskyblue;
        border-radius: 5px;
    }
    h3.two {
        border-color: gray;
        border-style: solid;
        border-radius: 12px;
        border-width: thin;
        height: 40px;

    }
</style>

