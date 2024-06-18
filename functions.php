<?php

/**
 * Functions file
 * @package Aquila
 */

if (!defined('AQUILA_DIR_PATH')) {
    define('AQUILA_DIR_PATH', untrailingslashit(get_template_directory()));
}

if (!defined('AQUILA_DIR_URI')) {
    define('AQUILA_DIR_URI', untrailingslashit(get_template_directory_uri()));
}
require_once AQUILA_DIR_PATH . '/inc/helpers/autoloader.php';
require_once AQUILA_DIR_PATH . '/inc/helpers/template-tags.php';


// trả về một instance của class AQUILATHEME trong file class-aquila-theme
function aquila_get_theme_instace()
{
    \AQUILA_THEME\Inc\AQUILA_THEME::get_instance();
    // \AQUILA_THEME\Inc\ASSETS::get_instance();
}

aquila_get_theme_instace();
