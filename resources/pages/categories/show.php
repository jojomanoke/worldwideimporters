<?php
$host = HOST;
$databasename = DATABASE;
$user = DATABASE_USER;
$pass = DATABASE_PASSWORD; //eigen password invullen
$port = DATABASE_PORT;


$connection = new mysqli($host, $user, $pass, $databasename, $port);
$category = $_GET['category'];
$query = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category);";
$results = $connection->query($query);
?>

<table>
    <tbody>
    <?php while($row = $results->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['StockItemName'] ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php
$results->free();
$connection->close();
?>