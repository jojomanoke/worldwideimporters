<?php
$shoppingCart = $_SESSION['shoppingcart'] ?? [];
if (isset($_POST['product']) && $_GET['action'] === 'add') {
    if (!in_array($_POST['product'], $shoppingCart)) {
        $shoppingCart[] = $_POST['product'];
        $_SESSION['shoppingcart'] = $shoppingCart;
    }
}
$conn = \Classes\Database::getConnection();

$query = "SELECT * FROM stockitems WHERE StockItemID IN (" .implode(', ', $shoppingCart). ')';
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->get_result();
while($product = $results->fetch_object()){ ?>
    <p><?= $product->StockItemName ?></p>
    <?php } ?>

<?php
dd(\Classes\Auth::user());
?>