<?php

/**
 * Content template file
 * 
 * @package Aquila
 */

get_the_ID();
?>
<article id="post-<?php the_ID(); ?>" class="<?php post_class('mb-5'); ?>">
    <?php
    get_template_part('template-parts/components/blog/entry-header');
    get_template_part('template-parts/components/blog/entry-content');
    get_template_part('template-parts/components/blog/entry-meta');
    get_template_part('template-parts/components/blog/entry-footer');
    ?>
</article>