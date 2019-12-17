<?php

use Classes\Query\Query;

$connection = Classes\Database::getConnection();

$q = $_GET['search'] ?? ' ';
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
if(!preg_match('/(^[a-z ]+$)/i', $q)) {
//        $sql = 'SELECT * From stockitems where StockItemID like ? LIMIT 1';
    $products = Query::get('stockitems')->where('StockItemID', $q);
} else {
//        $sql = "SELECT * From stockitems where StockItemName LIKE CONCAT('%', ?, '%') OR SearchDetails LIKE CONCAT('%', ?, '%') LIMIT (int)$thisPageFirstResult, (int)$resultsPerPage;";
    $products = Query::get('stockitems')->like(['StockItemName', 'SearchDetails'], $q)->limit($thisPageFirstResult, $resultsPerPage);
}

if($products->count() > 0) {
    ?>

    <div class="row mb-5">
        
        <?php foreach($products as $product) {
            include SERVER_ROOT . '/resources/includes/productCard.php';
        } ?>

    </div>
    
    <?php
    if(isset($resultsPerPage, $currentPage, $numberOfPages)) {
        ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center ">
                <?php
                $paginationString = '';
                foreach($_GET as $key => $value) {
                    if(!in_array($key, ['ARPP', 'page', 'pagenumber', 'search'])) {
                        if(is_array($value)) {
                            foreach($value as $value2) {
                                $paginationString .= "&$key%5B%5D=$value2";
                            }
                        } else {
                            $paginationString .= "&$key=$value";
                        }
                    }
                }
                ?>
                <?php if(!($currentPage <= 1)) { ?>
                    <li class="page-item"><a class="page-link"
                                             href="?pagenumber=<?php echo($currentPage - 1);
                                             echo $paginationString; ?>&ARPP=<?php echo $resultsPerPage; ?>">Vorige</a>
                    </li>
                <?php } ?>
                <?php for($page = 1;
                          $page <= $numberOfPages;
                          $page++) { ?>
                    <li class="page-item<?php if($page === (int)$currentPage) {
                        echo ' active';
                    } else {
                        echo '';
                    } ?>">
                        <a class="page-link"
                           href="?pagenumber=<?php echo $page;
                           echo $paginationString; ?>&ARPP=<?php echo $resultsPerPage; ?>">
                            <?php echo $page; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(!($currentPage >= $numberOfPages)) { ?>
                    <li class="page-item"><a class="page-link"
                                             href="?pagenumber=<?php echo $currentPage + 1;
                                             echo $paginationString; ?>&ARPP=<?php echo $resultsPerPage; ?>">Volgende</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <?php
    }
} else {
    ?>
    <div class="mb-5">
        <h1><?php echo trans('general.noProducts') ?></h1>
        <!-- TODO: Plaatje naar een error plaatje veranderen i.p.v. een onderhoudsplaatje -->
        <img alt="" src="/images/wordpress-mixed-content-error.png">
    </div>
    <a href="<?= url('categories') ?>">
        Druk hier om naar de homepagina te gaan
    </a>
    <?php
}
?>