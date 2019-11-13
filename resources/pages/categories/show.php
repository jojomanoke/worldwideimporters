<?php
$host = HOST;
$databasename = DATABASE;
$user = DATABASE_USER;
$pass = DATABASE_PASSWORD; //eigen password invullen
$port = DATABASE_PORT;


$connection = new mysqli($host, $user, $pass, $databasename, $port);
$category = $_GET[ 'category' ];
$query = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category);";
$results = $connection->query($query);
?>
    <div class="row">
        <?php while ( $row = $results->fetch_assoc() ) { ?>
            <div class="col-4 my-3">
                <div class="card">
                    <img src="<?php if(isset($row[ 'photo' ])) {echo $row['photo'];} else {echo 'https://via.placeholder.com/350x200';} ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row[ 'StockItemName' ]; ?></h5>
                        <p class="card-text"><?php echo $row[ 'SearchDetails' ]; ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
$results->free();
$connection->close();
?>