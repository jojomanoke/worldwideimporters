<?php
$connection = Database::getConnection();
$categories = $connection->query('SELECT * FROM stockgroups') or die($connection->error);
$cate = $_GET['category'];
?>


<ul class="nav nav-tabs justify-content-center">

    <?php while($category = $categories->fetch_assoc()){ ?>
        <li class="nav-item">
            <a class="nav-link <?php if ($cate == $category['StockGroupID']) echo 'active';?>" href="/categories/<?php echo $category[ 'StockGroupID' ]; ?>"><?php echo $category['StockGroupName']; ?></a>
        </li>
    <?php } ?>
</ul>

<?php
$categories->free();
?>