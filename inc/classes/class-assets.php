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
    /**
     * Phương thức khởi tạo sẽ tự động được gọi khi lớp được khởi tạo
     */
    protected function __construct()
    {
        // Gọi phương thức để thiết lập các hook
        $this->set_hooks();
    }
    /**
     * Thiết lập các hook (actions và filters)
     */
    protected function set_hooks()
    {
        // Thêm các actions và filters

        // Action để thêm CSS
        add_action('wp_enqueue_scripts', array($this, 'register_styles'));

        // Action để thêm JavaScript
        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
    }

    /**
     * Đăng ký và thêm các file CSS
     */
    public function register_styles()
    {
        // Đăng ký style Bootstrap
        $cssBsUrl = AQUILA_DIR_URI . '/assets/src/library/css/bootstrap.min.css';
        wp_register_style('style_boostrap', $cssBsUrl, [], false, 'all');
        // Thêm style Bootstrap vào trang
        wp_enqueue_style('style_boostrap');

        // Đăng ký style chính
        $linkUrlStylePath = AQUILA_DIR_PATH . '/style.css';
        wp_register_style('aquila_style', get_stylesheet_uri(), [], filemtime($linkUrlStylePath), 'all');

        // Thêm style dựa trên điều kiện
        wp_enqueue_style('aquila_style');
    }

    /**
     * Đăng ký và thêm các file JavaScript
     */
    public function register_scripts()
    {
        // Đăng ký script chính
        $jsUrl = AQUILA_DIR_URI . '/assets/main.js';
        $jsPath = AQUILA_DIR_PATH . '/assets/main.js';
        wp_register_script('aquila_script', $jsUrl, [], filemtime($jsPath), true);
        // Thêm script chính vào trang
        wp_enqueue_script('aquila_script');

        // Đăng ký script Bootstrap
        $jsBLink = '/assets/src/library/js/bootstrap.min.js';
        $jsBUrl = AQUILA_DIR_URI . $jsBLink;
        $jsBPath = AQUILA_DIR_PATH . $jsBLink;
        wp_register_script('js_bootstrap', $jsBUrl, ['jquery'], filemtime($jsBPath), true);

        // Thêm script Bootstrap vào trang
        wp_enqueue_script('js_bootstrap');
    }
}
