<?php

/**
 * Header Navigation Template
 * 
 * @package Aquila
 */

$menu_class = \AQUILA_THEME\Inc\MENUS::get_instance();
// Lấy id của menu aquila-header-menu
$header_menu_id = $menu_class->get_menu_id('aquila-header-menu');

// Lấy tất cả các mục  trong menu với id vừa lấy được
$header_menus = wp_get_nav_menu_items($header_menu_id);

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <?php if (function_exists('the_custom_logo')) {
    the_custom_logo();
  } ?>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php
    // Kiểm tra xem các mục menu có tồn tại và có phải mảng
    if (!empty($header_menus)  && is_array($header_menus)) {
    ?>
      <ul class="navbar-nav mr-auto">
        <?php
        // Lặp qua tất cả mục menu
        foreach ($header_menus as $menu_item) {
          // Xác định nếu mục menu không phải là children menu
          if (!$menu_item->menu_item_parent) {
            // Lấy các children menu của mục menu hiện tại
            $child_menu_items = $menu_class->get_child_menu_items($header_menus, $menu_item->ID);


            // Kiểm tra xem mục menu hiện tại có các mục menu con không
            $has_children = !empty($child_menu_items) && is_array($child_menu_items);
            // Nếu không phai children in ra các menu
            if (!$has_children) {
        ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo esc_url($menu_item->url); ?>"><?php echo esc_html($menu_item->title); ?></a>
              </li>
            <?php } else
            // ngược lại nếu là children menu thì in ra dưới dạng dropdown
            { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo esc_html($menu_item->title); ?>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php
                  foreach ($child_menu_items as $child_menu_item) {
                    // Kiểm tra nếu có mảng con
                    if (!empty($child_menu_item->child_items)) {
                  ?>
                      <a class="dropdown-item" href="<?= esc_url($child_menu_item->url) ?>"><?php echo esc_html($child_menu_item->title); ?></a>
                      <?php
                      echo '<ul>';
                      // Lặp qua các phần tử trong mảng con
                      foreach ($child_menu_item->child_items as $sub_menu_item) {
                        // In ra các thuộc tính của từng phần tử

                        echo '<a class="dropdown-item" href="' . esc_url($sub_menu_item->url) . '">' . esc_html($sub_menu_item->title) . '</a>';
                      }
                      echo '</ul>';
                    } else { ?>
                      <a class="dropdown-item" href="<?= esc_url($child_menu_item->url) ?>"><?php echo esc_html($child_menu_item->title); ?></a>
                  <?php }
                  } ?>
                </div>
              <?php } ?>
              </li>
          <?php
          }
        }
          ?>
      </ul>
    <?php
    }
    ?>

    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>