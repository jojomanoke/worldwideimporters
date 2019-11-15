<?php
$connection = DB::conn();
$productId = $_GET[ 'product' ];
$query = 'SELECT * FROM stockitems WHERE StockItemID = ? LIMIT 1';
$statement = $connection->prepare($query);
$statement->bind_param('i', $productId);
$statement->execute();
$product = $statement->get_result()->fetch_object();
?>
    <h1 class="h1"><?php echo $product->StockItemName; ?></h1>
    <small class="text-muted"><?php echo $product->MarketingComments; ?></small>
    <br>
    <small>
        <?php trans('products.CustomFields.Tags') ?>
        <?php foreach ( json_decode($product->CustomFields, true) as $key => $customField ) { ?>
            <b><?php echo trans('products.CustomFields.' . $key); ?></b>: <?php echo trans('products.CustomFields.' . $customField); ?> ||
        <?php } ?>
    </small>

<?php
$statement->free_result();
$connection->close();
?>