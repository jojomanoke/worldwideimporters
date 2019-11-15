<?php

if (isset($_POST['ARPP'])) {
    $resultsPerPage = $_POST['ARPP'];
    $currentPage = 1;
    $_GET['pagenumber']=1;
} else {
    $resultsPerPage = 25;
}

$currentPage = isset($_GET['pagenumber']) ? $_GET['pagenumber'] : 1;
$thisPageFirstResult = ($currentPage - 1) * $resultsPerPage;
$connection = new mysqli('localhost', 'root', 'root', 'wideworldimporters');
$category = $_GET['category'];
$query = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category) LIMIT $thisPageFirstResult, $resultsPerPage;";
$results = $connection->query($query);

$queryTwo = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category)";
$numberOfResults = $connection->query($queryTwo)->num_rows;

$numberOfPages = ceil($numberOfResults / $resultsPerPage);
//for ($page = 1; $page <= $numberOfPages; $page++) {
//    echo '<a href="?pagenumber=' . $page . '">' . $page . '</a>';
//}

?>
    <form id="perPage" class="form-inline mt-5 pt-5" method="post">
        <select onchange="submit()" class="form-control w-auto" name="ARPP">
            <option <?php if(isset($_POST['ARPP']) && $_POST['ARPP'] == 25){ echo "selected";} ?> value=25>25</option>
            <option <?php if(isset($_POST['ARPP']) && $_POST['ARPP'] == 50){ echo "selected";} ?> value=50>50</option>
            <option <?php if(isset($_POST['ARPP']) && $_POST['ARPP'] == 100){ echo "selected";} ?> value=100>100</option>
        </select>
    </form>


    <div class="row mb-5">

        <?php while ($row = $results->fetch_assoc()) { ?>
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
                        <a href="/products/<?php echo $row['StockItemID']; ?>" class="btn btn-primary">Bekijk product</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center ">
                        <?php if(!($currentPage<=1)){?>
                        <li class="page-item"><a class="page-link" href="<?php echo $currentPage-1;?>">Previous</a></li>
                        <?php } ?>
                        <?php for ($page = 1; $page <= $numberOfPages; $page++) { ?>
                            <li class="page-item<?php if ($page == $currentPage) {
                                echo ' active';
                            } else {
                                echo '';
                            } ?>">
                                <a class="page-link" href="?pagenumber=<?php echo $page; ?>">
                                    <?php echo $page; ?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if(!($currentPage>=$numberOfPages)){?>
                        <li class="page-item"><a class="page-link" href="?pagenumber=<?php echo $currentPage+1;?>">Next</a></li>
                        <?php }?>
                    </ul>
                </nav>
<?php
$results->free();
$connection->close();
?>