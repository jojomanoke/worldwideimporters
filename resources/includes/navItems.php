<?php
/**
 * The default links to add to the navbar
 */
$links = [
    'home',
];


?>


    <!-- Dynamically creates navbar-links from the array above -->
<?php
foreach($links as $index => $link) {
    ?>
    <a class="nav-item nav-link<?php if(activeUrl("/$link")) { ?> active<?php } ?>" href="/<?php echo $link ?>">
        <?php echo trans($link) ?>
        <?php if(activeUrl("/$link")) { ?>
            <span class="sr-only">(current)</span>
        <?php } ?>
    </a>
    <?php
}
?>