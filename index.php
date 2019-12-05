<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['language'] = 'en';
}
include 'resources/config/autoload.php';

include('resources/helpers/functions.php');
include('resources/config/globals.php');
include('resources/includes/head.php');
$shoppingCart = $_SESSION['shoppingcart'] ?? [];

if ( isset($_GET[ 'action' ], $_POST[ 'product' ]) && $_GET[ 'action' ] === 'add' && !in_array($_POST[ 'product' ], array_column($shoppingCart, 'id'), false)) {
    $shoppingCart[] = [
        'id' => (int)$_POST['product'],
        'amount' => 1,
    ];
    $_SESSION['shoppingcart'] = array_merge($shoppingCart);
    echo '<script>window.location.href="/shoppingcart"</script>';
}

if ( isset($_POST[ 'product' ], $_GET['action']) && $_GET[ 'action' ] === 'delete' && getUrl() === '/shoppingcart/delete' && in_array((int)$_POST[ 'product' ], array_column($shoppingCart, 'id'), false) ) {
    foreach ($shoppingCart as $key => $item) {
        if ($item['id'] === (int)$_POST['product']) {
            unset($shoppingCart[$key]);
        }
    }
    $_SESSION['shoppingcart'] = array_merge($shoppingCart);
    echo '<script>window.location.href="/shoppingcart"</script>';
}

include('resources/includes/navbar.php');
?>
    <div class="container-fluid">
        <div class="row">
            <?php
            include('resources/includes/categoryBar.php');
            ?><?php
            switch ($_GET['page']) {
                default:
                case 'home':
                    include 'resources/pages/home.php';
                    break;

                case 'categories':
                    include 'resources/pages/categories/show.php';
                    break;

                case 'products':
                    include 'resources/pages/products/show.php';
                    break;

                case 'editProduct':
                    include 'resources/pages/products/edit.php';
                    break;

                case 'shoppingcart':
                    include 'resources/pages/shoppingcart.php';
                    break;

                case 'search':
                    include 'resources/pages/search.php';
                    break;

                case 'login':
                    include 'resources/pages/auth/login.php';
                    break;

                case 'register':
                    include 'resources/pages/auth/register.php';
                    break;

                case 'logout':
                    include 'resources/pages/auth/logout.php';
                    break;
            }
            ?></div>
    </div>
<?php
include('resources/includes/footer.php');

?>