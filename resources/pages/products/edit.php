<?php
$conn = Database::getConnection();
$stockItemID = $_GET[ 'product' ];
$queryProduct = 'SELECT * FROM stockitems WHERE StockItemID = ? LIMIT 1';
$stmtProduct = $conn->prepare($queryProduct);
$stmtProduct->bind_param('i', $stockItemID);
$stmtProduct->execute();
$product = $stmtProduct->get_result()->fetch_object();

$suppliers = getResults('suppliers', 'SupplierID, SupplierName');
$colors = getResults('colors', 'ColorID, ColorName');
$packageTypes = getResults('packagetypes', 'PackageTypeID, PackageTypeName');

?>

<div class="card">
    <div class="card-header">
        <h2 class="h2"><?= trans('products.edit') ?></h2>
    </div>

    <div class="card-body">
        <form action="/products/<?= $product->StockItemID ?>/edit" method="POST">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="StockItemName"><?= trans('products.name') ?></label>
                        <input id="StockItemName" name="StockItemName" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="SupplierID"><?= trans('products.supplier') ?></label>
                        <select id="SupplierID" name="SupplierID" class="form-control">
                            <?php while ( $supplier = $suppliers->fetch_object() ) { ?>
                                <option value="<?=$supplier->SupplierID?>"><?=$supplier->SupplierName?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

