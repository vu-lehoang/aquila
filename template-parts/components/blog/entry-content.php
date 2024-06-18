<?php

/**
 * Template for entry content
 * 
 * To be used inside WordPress The Loop
 * 
 * @package Aquila
 */
?>
<div class="entry-content">
    <?php
    if (is_single()) {
        // Nếu đây là trang đơn bài viết
        the_content(
            sprintf(
                wp_kses(
                    __('Continue Reading %s <span class="meta-nav">&arr;</span>', 'aquila'),
                    [
                        'span' => [
                            'class' => []
                        ]
                    ]
                ),
                the_title('<span class="screen-reader-text">"', '"</span>', false)
            )
        );

        wp_link_pages([
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'aquila'),
            'after' => '</div>',
        ]);
    } else {
        // Nếu không phải là trang đơn bài viết
        aquila_the_excerpt(150) . '<br>';
        echo '<span>' . aquila_excerpt_more() . '</span>';
    }



    ?>
</div>