<?php

use Classes\Query\Query;

$connection = Classes\Database::getConnection();

if(isset($_GET['search'])) {
    $q = $_GET['search'];
    if(isset($_GET['ARPP'])) {
        $resultsPerPage = $_GET['ARPP'];
        $currentPage = 1;
    } else {
        $resultsPerPage = 25;
    }
    $currentPage = $_GET['pagenumber'] ?? 1;
    $thisPageFirstResult = ($currentPage - 1) * $resultsPerPage;
    $allResults = Query::get('stockitems')->like(['StockItemName', 'SearchDetails'], $q);
    $totalResultCount = $allResults->count();
    
    $numberOfPages = ceil($totalResultCount / $resultsPerPage);
    if(!preg_match("/(^[a-z ]+$)/i", $q)) {
//        $sql = 'SELECT * From stockitems where StockItemID like ? LIMIT 1';
        $products = Query::get('stockitems')->where('StockItemID', $q);
    } else {
//        $sql = "SELECT * From stockitems where StockItemName LIKE CONCAT('%', ?, '%') OR SearchDetails LIKE CONCAT('%', ?, '%') LIMIT (int)$thisPageFirstResult, (int)$resultsPerPage;";
        $products = Query::get('stockitems')->like(['StockItemName', 'SearchDetails'], $q)->limit($thisPageFirstResult, $resultsPerPage);
    }
    
    
    ?>

    <form id="perPage" class="form-inline mt-5 pt-5" method="get">
        <select onchange="submit()" class="form-control w-auto" name="ARPP">
            <option <?php if(isset($_GET['ARPP']) && $_GET['ARPP'] == 25) {
                echo "selected";
            } ?> value=25>25
            </option>
            <option <?php if(isset($_GET['ARPP']) && $_GET['ARPP'] == 50) {
                echo "selected";
            } ?> value=50>50
            </option>
            <option <?php if(isset($_GET['ARPP']) && $_GET['ARPP'] == 100) {
                echo "selected";
            } ?> value=100>100
            </option>
        </select>
    </form>

    <div class="row mb-5">
        
        <?php foreach($products as $product) {
            include SERVER_ROOT . '/resources/includes/productCard.php';
        } ?>

    </div>
    
    <?php
    if(isset($resultsPerPage) && isset($currentPage) && isset($numberOfPages)) {
        ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center ">
                <?php if(!($currentPage <= 1)) { ?>
                    <li class="page-item"><a class="page-link"
                                             href="?pagenumber=<?php echo $currentPage - 1; ?>&ARPP=<?php echo $resultsPerPage; ?>">Previous</a>
                    </li>
                <?php } ?>
                <?php for($page = 1; $page <= $numberOfPages; $page++) { ?>
                    <li class="page-item<?php if($page == $currentPage) {
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
                <?php if(!($currentPage >= $numberOfPages)) { ?>
                    <li class="page-item"><a class="page-link"
                                             href="?pagenumber=<?php echo $currentPage + 1; ?>&ARPP=<?php echo $resultsPerPage; ?>">Next</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <?php
    }
}
?>