<?php

if ( !isset($_SESSION) ) {
    session_start();
}
include 'resources/config/autoload.php';

include( 'resources/helpers/functions.php' );
include( 'resources/config/globals.php' );
include( 'resources/includes/head.php' );
include( 'resources/includes/navbar.php' );
?>
    <div class="container-fluid">
        <div class="row">
            <?php
            include( 'resources/includes/scripts.php' );
            include( 'resources/includes/categoryBar.php' );
            ?><?php
            switch ( $_GET[ 'page' ] ) {
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
            }
            ?></div>
    </div>
    </div>
<?php
include( 'resources/includes/footer.php' );

?>