<?php
$connection = new mysqli('localhost', 'root', '', 'wideworldimporters');

if ( isset($_GET[ 'search' ]) ) {
    $q = $_GET[ 'search' ];
//    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);
    if (isset($_GET['ARPP'])) {
        $resultsPerPage = $_GET['ARPP'];
        $currentPage = 1;
    } else {
        $resultsPerPage = 25;
    }

    $currentPage = isset($_GET['pagenumber']) ? $_GET['pagenumber'] : 1;
    $thisPageFirstResult = ($currentPage - 1) * $resultsPerPage;
    if(!preg_match("/(^[a-z ]+$)/i", $q)){
        $sql = "SELECT * From stockitems where StockItemID like '$q' LIMIT 1";




    } else {
        $sql = "SELECT * From stockitems where StockItemName LIKE '%$q%' OR SearchDetails LIKE '%$q%' LIMIT $thisPageFirstResult, $resultsPerPage;";
        $queryTwo = "SELECT * From stockitems where StockItemName LIKE '%$q%' OR SearchDetails LIKE '%$q%'";     //zoek query //
        $numberOfResults = $connection->query($queryTwo)->num_rows;
        $numberOfPages = ceil($numberOfResults / $resultsPerPage);
    };


    $result = $connection->query($sql);


    ?>

    <form id="perPage" class="form-inline mt-5 pt-5" method="get">
        <select onchange="submit()" class="form-control w-auto" name="ARPP">
            <option <?php if(isset($_GET['ARPP']) && $_GET['ARPP'] == 25){ echo "selected";} ?> value=25>25</option>
            <option <?php if(isset($_GET['ARPP']) && $_GET['ARPP'] == 50){ echo "selected";} ?> value=50>50</option>
            <option <?php if(isset($_GET['ARPP']) && $_GET['ARPP'] == 100){ echo "selected";} ?> value=100>100</option>
        </select>
    </form>

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
                        <small class="card-text">Artikelnummer: <?php echo $row['StockItemID']; ?></small><br><br>
                        <a href="#" class="btn btn-primary">Product bekijken</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php
    if(isset($resultsPerPage)){
    ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center ">
                <?php if(!($currentPage<=1)){?>
                    <li class="page-item"><a class="page-link" href="?pagenumber=<?php echo $currentPage-1;?>&ARPP=<?php echo $resultsPerPage;?>">Previous</a></li>
                <?php } ?>
                <?php for ($page = 1; $page <= $numberOfPages; $page++) { ?>
                    <li class="page-item<?php if ($page == $currentPage) {
                        echo ' active';
                    } else {
                        echo '';
                    } ?>">
                        <a class="page-link" href="?pagenumber=<?php echo $page; ?>&ARPP=<?php echo $resultsPerPage;?>">
                            <?php echo $page; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(!($currentPage>=$numberOfPages)){?>
                    <li class="page-item"><a class="page-link" href="?pagenumber=<?php echo $currentPage+1;?>&ARPP=<?php echo $resultsPerPage;?>">Next</a></li>
                <?php }?>
            </ul>
        </nav>
        <?php } ?>
    
    <?php
    $result->free();
}
$connection->close();
?>