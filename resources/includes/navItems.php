<a class="nav-item nav-link<?php if(activeUrl('/categories')) { ?> active<?php } ?>" href="/categories">
    <?php echo trans('general.allProducts') ?>
    <?php if(activeUrl('/categories')) { ?>
        <span class="sr-only">(current)</span>
    <?php } ?>
</a>