<?php
$stockItemID = $_GET[ 'product' ];
use Classes\Query\Query;
$product = Query::get('stockitems')->where('StockItemID', $stockItemID)->first();
$suppliers = Query::get('suppliers', 'SupplierID, SupplierName');
$colors = Query::get('colors', 'ColorID, ColorName');
$packageTypes = Query::get('packagetypes', 'PackageTypeID, PackageTypeName');

?>

<div class="card my-5">
    <div class="card-header">
        <h2 class="h2"><?= trans('products.edit') ?></h2>
    </div>

    <div class="card-body">
        <form action="/products/<?= $product->StockItemID ?>/edit" method="POST">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="StockItemName"><?= trans('products.name') ?></label>
                        <input id="StockItemName" value="<?= $product->StockItemName ?>" name="StockItemName"
                               class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="SupplierID"><?= trans('products.supplier') ?></label>
                        <select id="SupplierID" name="SupplierID" class="form-control">
                            <?php foreach ( $suppliers as $supplier ) { ?>
                                <option
                                    <?php if ( $supplier->SupplierID === $product->SupplierID ) echo 'selected'; ?>
                                        value="<?= $supplier->SupplierID ?>"><?= $supplier->SupplierName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="UnitPackageID"><?= trans('products.supplier') ?></label>
                        <select id="UnitPackageID" name="UnitPackageID" class="form-control">
                            <?php foreach ( $packageTypes as $packageType ) { ?>
                                <option
                                    <?php if ( $packageType->PackageTypeID === $product->OuterPackageID ) {
                                        echo 'selected';
                                    } ?>
                                        value="<?= $packageType->PackageTypeID ?>"
                                >
                                    <?= $packageType->PackageTypeName ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="OuterPackageID"><?= trans('products.supplier') ?></label>
                        <select id="OuterPackageID" name="OuterPackageID" class="form-control">
                            <?php foreach ( $packageTypes as $packageType ) { ?>
                                <option
                                        value="<?= $packageType->PackageTypeID ?>"
                                    <?php if ( $packageType->PackageTypeID === $product->OuterPackageID ) {
                                        echo 'selected';
                                    } ?>
                                >
                                    <?= $packageType->PackageTypeName ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>