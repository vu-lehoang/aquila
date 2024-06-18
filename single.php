<?php

/**
 * Main template file
 * @package aquila
 */
?>
<?php get_header(); ?>
<div id="primary">
    <main id="main" class="site-main mt-5" role="main">
        <?php if (have_posts()) : ?>
            <div class="container">
                <?php if (is_home() && !is_front_page()) : ?>
                    <header class="mb-5">
                        <h1 class="page-title screen reader-text">
                            <?php single_post_title(); ?>
                        </h1>
                    </header>
                <?php endif; ?>
                <!-- Start custom layout -->
                <?php
                while (have_posts()) : the_post();
                    // Display post content
                ?>
                    <div class="">
                        <?php get_template_part('template-parts/blog-content') ?>
                    </div>
                <?php
                endwhile;
                ?>
                <!-- End custom layout -->
            </div>
        <?php else : get_template_part('template-parts/blog-content-none'); ?>
        <?php endif; ?>
        <div class="container mb-5 pb-5">

            <?php
            aquila_pagination();
            ?>
        </div>

    </main>
</div>

<?php get_footer(); ?>