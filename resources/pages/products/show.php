<?php
$connection = new mysqli('localhost', 'root', 'root', 'wideworldimporters');
$productId = $_GET[ 'product' ];
$query = 'SELECT * FROM stockitems WHERE StockItemID = ? LIMIT 1';
$statement = $connection->prepare($query);
$statement->bind_param('i', $productId);
$statement->execute();
$product = $statement->get_result()->fetch_object();
?>
    <h1 class="h1"><?php echo $product->StockItemName; ?></h1>
<body
<img

<?php
$statement->free_result();
$connection->close();
?>