<?php

if ( isset($_GET[ 'ARPP' ]) ) {
    $resultsPerPage = $_GET[ 'ARPP' ];
    $currentPage = 1;
} else {
    $resultsPerPage = 25;
}

$currentPage = isset($_GET[ 'pagenumber' ]) ? $_GET[ 'pagenumber' ] : 1;
$thisPageFirstResult = ( $currentPage - 1 ) * $resultsPerPage;
$connection = \Classes\Database::getConnection();
$category = $_GET[ 'category' ];
$query = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category) LIMIT $thisPageFirstResult, $resultsPerPage;";
$connection->prepare($query);
$results = $connection->query($query);

$queryTwo = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category)";
$numberOfResults = $connection->query($queryTwo)->num_rows;

$numberOfPages = ceil($numberOfResults / $resultsPerPage);
//for ($page = 1; $page <= $numberOfPages; $page++) {
//    echo '<a href="?pagenumber=' . $page . '">' . $page . '</a>';
//}

?>
    <form id="perPage" class="form-inline mt-5 pt-5" method="get">
        <select onchange="submit()" class="form-control w-auto" name="ARPP">
            <option <?php if ( isset($_GET[ 'ARPP' ]) && $_GET[ 'ARPP' ] == 25 ) {
                echo "selected";
            } ?> value=25>25
            </option>
            <option <?php if ( isset($_GET[ 'ARPP' ]) && $_GET[ 'ARPP' ] == 50 ) {
                echo "selected";
            } ?> value=50>50
            </option>
            <option <?php if ( isset($_GET[ 'ARPP' ]) && $_GET[ 'ARPP' ] == 100 ) {
                echo "selected";
            } ?> value=100>100
            </option>
        </select>
    </form>


    <div class="row mb-5">
        
        <?php while ( $row = $results->fetch_assoc() ) {
            include SERVER_ROOT . '/resources/includes/productCard.php';
        } ?>
    </div>


    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center ">
            <?php if ( !( $currentPage <= 1 ) ) { ?>
                <li class="page-item"><a class="page-link"
                                         href="?pagenumber=<?php echo $currentPage - 1; ?>&ARPP=<?php echo $resultsPerPage; ?>">Previous</a>
                </li>
            <?php } ?>
            <?php for ( $page = 1; $page <= $numberOfPages; $page++ ) { ?>
                <li class="page-item<?php if ( $page == $currentPage ) {
                    echo ' active';
                } else {
                    echo '';
                } ?>">
                    <a class="page-link" href="?pagenumber=<?php echo $page; ?>&ARPP=<?php echo $resultsPerPage; ?>">
                        <?php echo $page; ?>
                    </a>
                </li>
            <?php } ?>
            <?php if ( !( $currentPage >= $numberOfPages ) ) { ?>
                <li class="page-item"><a class="page-link"
                                         href="?pagenumber=<?php echo $currentPage + 1; ?>&ARPP=<?php echo $resultsPerPage; ?>">Next</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php
$results->free();
?>