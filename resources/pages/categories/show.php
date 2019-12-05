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
if(isset($_GET['colour'])){
    $query .= ' AND ColorID IN (';
    foreach($_GET['colour'] as $key => $color){
        $query .= $color;
        if($key !== (count($_GET['colour']) - 1)){
            $query .= ', ';
        }
    }
    $query .=')';
}

if(isset($_GET['priceFilter'])){
        $query .= ' ORDER BY UnitPrice';
    if($_GET['priceFilter'] === 'hooglaag'){
        $query .= ' DESC';
    }
}
$query .= " LIMIT $thisPageFirstResult, $resultsPerPage;";
$connection->prepare($query);
$results = $connection->query($query);

$queryTwo = "SELECT * FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM stockitemstockgroups WHERE StockGroupID = $category)";
$numberOfResults = $connection->query($queryTwo)->num_rows;

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
    <form id="perPage" class="form-inline mt-5 pt-5" method="get">
        <select onchange="submit()" class="form-control w-auto" name="ARPP">
            <option <?php if (isset($_GET['ARPP']) && $_GET['ARPP'] == 25) {
                echo "selected";
            } ?> value=25>25
            </option>
            <option <?php if (isset($_GET['ARPP']) && $_GET['ARPP'] == 50) {
                echo "selected";
            } ?> value=50>50
            </option>
            <option <?php if (isset($_GET['ARPP']) && $_GET['ARPP'] == 100) {
                echo "selected";
            } ?> value=100>100
            </option>
        </select>
    </form>

    <div class="row mb-5">


        <?php while ($product = $results->fetch_object()) {
            include SERVER_ROOT . '/resources/includes/productCard.php';
        }


        ?>
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