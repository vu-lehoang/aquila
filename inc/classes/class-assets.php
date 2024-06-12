<?php

/**
 * Class the theme
 * @package Aquila
 */

namespace AQUILA_THEME\Inc;

use AQUILA_THEME\Inc\Traits\Singleton;

class ASSETS
{
    use Singleton;
    // Phương thức này sẽ tự động gọi
    protected function __construct()
    {
        //load class

        $this->set_hooks();
    }
    protected function set_hooks()
    {
        // actions and filters

        // action css
        add_action('wp_enqueue_scripts', array($this, 'register_styles'));

        // action js
        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
    }


    public function register_styles()
    {
        // Register style boostrap
        $cssBsUrl = AQUILA_DIR_URI . '/assets/src/library/css/bootstrap.min.css';
        wp_register_style('style_boostrap', $cssBsUrl, [], false, 'all');
        // Enqueue style bootstrap
        wp_enqueue_style('style_boostrap');

        // Register style
        $archiveCssUrl  = AQUILA_DIR_URI . '/assets/style/archive.css';
        $archiveCssPath  = AQUILA_DIR_PATH . '/assets/style/archive.css';
        wp_register_style('aquila_archive', $archiveCssUrl, [], filemtime($archiveCssPath));
        $linkUrlStylePath = AQUILA_DIR_PATH . '/style.css';
        wp_register_style('aquila_style', get_stylesheet_uri(), [], filemtime($linkUrlStylePath), 'all');
        // Enqueue style
        if (is_archive()) {
            wp_enqueue_style('aquila_archive');
        } else {
            wp_enqueue_style('aquila_style');
        }
    }

    public function register_scripts()
    {
        // Register js
        $jsUrl = AQUILA_DIR_URI . '/assets/main.js';
        $jsPath = AQUILA_DIR_PATH . '/assets/main.js';
        wp_register_script('aquila_script', $jsUrl, [], filemtime($jsPath), true);
        // Enqueue js
        wp_enqueue_script('aquila_script');

        // Register js boostrap
        // Định nghĩa đường dẫn và URL của file JS
        $jsBLink = '/assets/src/library/js/bootstrap.min.js';
        $jsBUrl = AQUILA_DIR_URI . $jsBLink;
        $jsBPath = AQUILA_DIR_PATH . $jsBLink;

        // Đăng ký script với phiên bản dựa trên thời gian chỉnh sửa cuối cùng của file
        wp_register_script('js_bootstrap', $jsBUrl, ['jquery'], filemtime($jsBPath), false, true);

        // Enqueue script
        wp_enqueue_script('js_bootstrap');
    }
}
