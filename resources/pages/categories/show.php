<?php

if (isset($_GET['ARPP'])) {
    $resultsPerPage = $_GET['ARPP'];
    $currentPage = 1;
} else {
    $resultsPerPage = 25;
}



$currentPage = isset($_GET['pagenumber']) ? $_GET['pagenumber'] : 1;
$thisPageFirstResult = ($currentPage - 1) * $resultsPerPage;
$connection = \Classes\Database::getConnection();
$category = $_GET['category'];
$query = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category)";

if ( isset($_GET['priceFilter']) ) {
    $f = $_GET['priceFilter'];
    $query.=" ORDER BY UnitPrice";
    if ($f === 'hooglaag') {
        $query.=" DESC";
    }
}

//TODO: afmaken
//$query = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category)";
//if ( isset($_GET['blue'])) {
//    $alles = $_GET['blue'];
//    $query.=" WHERE StockItemName LIKE '%Blue%'";
//    if ($alles === '')
//}


$query.= " LIMIT $thisPageFirstResult, $resultsPerPage;";
$connection->prepare($query);
$results = $connection->query($query);
$ids = [];
while($item = $results->fetch_object()){
    $ids[] = $item->StockItemID;
}
$totalProducts = \Classes\Query\Query::get('stockitems')->where('StockItemID', $ids);
$products = $totalProducts->limit($thisPageFirstResult, $resultsPerPage);

//$queryTwo = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category)";
$numberOfResults = $totalProducts->count();
$numberOfPages = ceil($numberOfResults / $resultsPerPage);
//for ($page = 1; $page <= $numberOfPages; $page++) {
//    echo '<a href="?pagenumber=' . $page . '">' . $page . '</a>';
//}


?>

<?php If (!$results->num_rows) {
    ?>
    <h1><?php echo trans("general.error404") ?></h1>
    <img alt="" src="C:\xampp\htdocs\worldwideimporters\images\wordpress-mixed-content-error.png">
    <br>
    <div>
        <p> <?php echo trans('general.error404paragraf'); ?> </p>
        <i class="material-icons Homebutton" onclick="window.location.href='/home'" id="homebutton1">house</i>
    </div>
    <?php
} else { ?>

    <div class="row mb-5">
        <?php foreach ( $products as $product ) {
            include SERVER_ROOT . '/resources/includes/productCard.php';
        } ?>
    </div>


    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center ">
            <?php if (!($currentPage <= 1)) { ?>
                <li class="page-item"><a class="page-link"
                                         href="?pagenumber=<?php echo $currentPage - 1; ?>&ARPP=<?php echo $resultsPerPage; ?>">Previous</a>
                </li>
            <?php } ?>
            <?php for ($page = 1;
                       $page <= $numberOfPages;
                       $page++) { ?>
                <li class="page-item<?php if ($page == $currentPage) {
                    echo ' active';
                } else {
                    echo '';
                } ?>">
                    <a class="page-link"
                       href="?pagenumber=<?php echo $page; ?>&ARPP=<?php echo $resultsPerPage; ?>">
                        <?php echo $page; ?>
                    </a>
                </li>
            <?php } ?>
            <?php if (!($currentPage >= $numberOfPages)) { ?>
                <li class="page-item"><a class="page-link"
                                         href="?pagenumber=<?php echo $currentPage + 1; ?>&ARPP=<?php echo $resultsPerPage; ?>">Next</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <?php
    function HomeBTTN()
    {
        header("Location: http://worldwideimporters.local/home");
    }
}
$results->free();
?>