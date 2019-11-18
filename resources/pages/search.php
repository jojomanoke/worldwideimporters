<?php
$connection = new mysqli('localhost', 'root', '', 'wideworldimporters');

if ( isset($_GET[ 'search' ]) ) {
    $q = $_GET[ 'search' ];
//    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);
    
    $sql = "SELECT * From stockitems where StockItemName like '%$q%' or SearchDetails like '%$q%' or StockItemID like '$q' ";     //zoek query //
    $result = $connection->query($sql);

    ?>
    <div class="row mb-5">

        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-4 my-3">
                <div class="card">
                    <img src="<?php if (isset($row['photo'])) {
                        echo $row['photo'];
                    } else {
                        echo 'https://via.placeholder.com/350x200';
                    } ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['StockItemName']; ?></h5>
                        <p class="card-text"><?php echo $row['SearchDetails']; ?></p>
                        <a href="#" class="btn btn-primary">Product bekijken</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <?php
    $result->free();
}
$connection->close();
?>