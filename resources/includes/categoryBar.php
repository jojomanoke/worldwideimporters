<?php
$connection = new mysqli(HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE, DATABASE_PORT);
$categories = $connection->query('SELECT * FROM stockgroups');
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
$connection->close();
?>