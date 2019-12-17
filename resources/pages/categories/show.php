<?php

use Classes\Database;
use Classes\Query\Query;

if(isset($_GET['ARPP'])) {
    $resultsPerPage = $_GET['ARPP'];
    $currentPage = 1;
} else {
    $resultsPerPage = 25;
}
$currentPage = $_GET['pagenumber'] ?? 1;
$thisPageFirstResult = ($currentPage - 1) * $resultsPerPage;
$connection = Database::getConnection();
$category = $_GET['category'] ?? null;

$query = 'SELECT * FROM stockitems';

if(isset($category)){
    $query .= " WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category)";
}

$query = filterQuery($query);
$allProductsWithoutPagination = Query::get($query);
$query .= " LIMIT $thisPageFirstResult, $resultsPerPage;";
$products = Query::get($query);

$connection->prepare($query);
$results = $connection->query($query);

$numberOfPages = ceil($allProductsWithoutPagination->count() / $resultsPerPage);

?>

<?php If(!$results->num_rows) {
    ?>
    <h1><?php echo trans('general.noProducts') ?></h1>
    <!-- TODO: Plaatje naar een error plaatje veranderen i.p.v. een onderhoudsplaatje -->
    <img alt="" src="/images/wordpress-mixed-content-error.png">
    <br>
    <a href="<?= url('categories') ?>">
        Druk hier om naar de homepagina te gaan
    </a>
    <?php
} else { ?>
    <div class="row mb-5">
        <?php foreach($products as $product) {
            include SERVER_ROOT . '/resources/includes/productCard.php';
        }
        ?>
    </div>


    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center ">
            <?php
            $paginationString = '';
            foreach($_GET as $key => $value) {
                if(!in_array($key, ['ARPP', 'page', 'pagenumber', 'category'])) {
                    if(is_array($value)){
                        foreach($value as $value2){
                            $paginationString .= "&$key%5B%5D=$value2";
                        }
                    }
                    else {
                        $paginationString .= "&$key=$value";
                    }
                }
            }
            ?>
            <?php if(!($currentPage <= 1)) { ?>
                <li class="page-item"><a class="page-link"
                                         href="?pagenumber=<?php echo ($currentPage - 1); echo $paginationString;?>&ARPP=<?php echo $resultsPerPage; ?>">Vorige</a>
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
                       href="?pagenumber=<?php echo $page; echo $paginationString;?>&ARPP=<?php echo $resultsPerPage; ?>">
                        <?php echo $page; ?>
                    </a>
                </li>
            <?php } ?>
            <?php if(!($currentPage >= $numberOfPages)) { ?>
                <li class="page-item"><a class="page-link"
                                         href="?pagenumber=<?php echo $currentPage + 1; echo $paginationString;?>&ARPP=<?php echo $resultsPerPage; ?>">Volgende</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <?php
}
$results->free();
?>