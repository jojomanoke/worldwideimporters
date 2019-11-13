<?php
$host = HOST;
$databasename = DATABASE;
$user = DATABASE_USER;
$pass = DATABASE_PASSWORD; //eigen password invullen
$port = DATABASE_PORT;


$connection = new mysqli($host, $user, $pass, $databasename, $port);
if ( isset($_GET[ 'search' ]) ) {
    $q = $_GET[ 'search' ];
//    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);
    
    $sql = "SELECT * From stockitems where StockItemName like '%$q%' or SearchDetails like '%$q%' ";     //zoek query //
    $result = $connection->query($sql);
    
    while ( $row = $result->fetch_assoc() ) {
        $naam = $row[ "StockItemName" ];
        $stockitemid = $row[ "StockItemID" ];
        $recretailprice = $row[ "RecommendedRetailPrice" ];
        echo $stockitemid . " " . $naam . " " . $recretailprice . '<br />';
    }
    ?>
    
    
    <?php
    $result->free();
}
$connection->close();
?>