<?php

/**
 * Class the theme
 * @package Aquila
 */

namespace AQUILA_THEME\Inc;

use AQUILA_THEME\Inc\Traits\Singleton;

class MENUS
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
		// Register Menu
		add_action('init', [$this, 'register_my_menus']);
		// Handle Menu item
		// add_action('init', [$this, 'get_menu_id']);
	}

	public function register_my_menus()
	{
		register_nav_menus(
			array(
				'aquila-header-menu' => esc_html__('Header Menu', 'aquila'),
				'aquila-sub-menu' => esc_html__('Sub Menu', 'aquila'),
				'aquila-footer-menu'  => esc_html__('Footer Menu', 'aquila')
			)
		);
	}

	// handle get id menu
	public function get_menu_id($location)
	{
		// Nhận tất cả các vị trí của menu
		$locations = get_nav_menu_locations();

		// Lấy id của menu dựa trên vị trí
		$menu_id = $locations[$location];

		// trả về id hoặc null
		return !empty($menu_id) ? $menu_id : 'NULL';
	}

	// handle get item in child menu 
	public function get_child_menu_items($menu_array, $parent_id)
	{
		$child_menus = [];

		if (!empty($menu_array) && is_array($menu_array)) {
			foreach ($menu_array as $menu) {
				// Kiểm tra nếu mục menu có 'menu_item_parent' bằng với 'parent_id'
				if (intval($menu->menu_item_parent) === $parent_id) {
					// Lấy các mục menu con của mục menu hiện tại
					$menu->child_items = $this->get_child_menu_items($menu_array, $menu->ID);
					array_push($child_menus, $menu);
				}
			}
		}

		return $child_menus;
	}
}
