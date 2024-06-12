<?php

/**
 * Header file
 * @package Aquila
 */
?>
<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
    <?php
    if (function_exists('wp_body_open')) {
        wp_body_open();
    }
    ?>
    <div class="site" id="page">
        <header class="site-header" id="masthead" role="banner">
            <?php get_template_part('template-parts/header/nav');
            if (is_page()) {
                get_template_part('template-parts/content', 'page');
            } else {
                get_template_part('template-parts/content', 'post');
            }
            ?>

        </header>
        <div class="site-content" id="content">
            This is content
        </div>
    </div>