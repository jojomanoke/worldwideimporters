<?php
include( 'resources/config/globals.php' );
include( 'resources/helpers/functions.php' );
include( 'resources/includes/head.php' );
include( 'resources/includes/navbar.php' );
include( 'resources/includes/searchbarTest.php');
include( 'resources/includes/categoryBar.php');

switch(activeUrl()){
    default:
    case '/home':
        include 'resources/pages/home.php';
        break;
}



include( 'resources/includes/footer.php' );