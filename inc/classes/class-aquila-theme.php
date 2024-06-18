<?php

/**
 * Class the theme
 * @package Aquila
 */

namespace AQUILA_THEME\Inc;

use AQUILA_THEME\Inc\Traits\Singleton;

// use function PHPSTORM_META\map;

class AQUILA_THEME
{
    use Singleton;
    // Phương thức này sẽ tự động gọi
    protected function __construct()
    {

        // load file class-assets.php
        ASSETS::get_instance();
        MENUS::get_instance();
        Meta_Boxes::get_instance();
        //load class
        $this->set_hooks();
    }
    protected function set_hooks()
    {
        // actions and filters

        // add class in body
        add_filter('body_class', array($this, 'my_custom_body_class'));

        // add theme support
        add_action('after_setup_theme', [$this, 'setup_theme']);
    }

    // handle setup theme
    public function setup_theme()
    {
        // add title tag
        add_theme_support('title-tag');

        // custom logo
        add_theme_support('custom-logo', [
            'height'               => 100,
            'width'                => 400,
            'flex-height'          => true,
            'flex-width'           => true,
            'header-text'          => array('site-title', 'site-description'),
            'unlink-homepage-logo' => true,
        ]);

        add_theme_support('custom-background', [
            'default-color' => '0000ff',
            'default-image' => '',
            'default-repeat' => 'no-repeat'
        ]);

        // custom thumbnail post
        add_theme_support('post-thumbnails');

        // Selective Refresh cho các widget
        add_theme_support('customize-selective-refesh-widget');

        // Tự tạo các liên kết RSS
        add_theme_support('automatic-feed-links');

        // hỗ trợ các phần tử của html5
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style'
        ]);

        // Thêm tùy chỉnh css vào trình soạn thảo 
        add_editor_style();

        // Hỗ trợ kiểu khối của trình soạn thảo Gutenberg
        add_theme_support('wp-block-style');

        // hỗ trợ căn chỉnh mở rộng cho các khối trong trình soạn thảo Gutenberg
        add_theme_support('align-wide');

        // Register image sizes

        add_image_size('featured-thumbnail', 350, 233, true);

        global $content_width;
        if (!isset($content_width)) {
            $content_width = 1240;
        }
    }

    public function my_custom_body_class($class)
    {
        if (is_home()) {
            $class[] = 'aqua-home-class';
        }
        if (is_single()) {
            $class[] = 'aqua-single';
        }
        return $class;
    }
}
