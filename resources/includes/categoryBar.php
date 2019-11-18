<?php
$connection = Database::getConnection();
$categories = $connection->query('SELECT * FROM stockgroups') or die($connection->error);
?>


<ul class="nav justify-content-center">

    <?php while($category = $categories->fetch_assoc()){ ?>
        <li class="nav-item">
            <a class="nav-link" href="/categories/<?php echo $category[ 'StockGroupID' ]; ?>"><?php echo $category['StockGroupName']; ?></a>
        </li>
    <?php } ?>
</ul>

<?php
$categories->free();
?>