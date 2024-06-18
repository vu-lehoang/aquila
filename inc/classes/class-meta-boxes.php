<?php

/**
 * Class the theme
 * @package Aquila
 */

namespace AQUILA_THEME\Inc;

use AQUILA_THEME\Inc\Traits\Singleton;

class Meta_Boxes
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
        // Thêm action để thêm meta box tùy chỉnh
        add_action('add_meta_boxes', [$this, 'add_custom_meta_box']);

        // Thêm action để lưu dữ liệu meta khi bài viết được lưu
        add_action('save_post', [$this, 'save_post_meta_data']);
    }

    /**
     * Thêm một meta box tùy chỉnh vào trang chỉnh sửa bài viết.
     */
    public function add_custom_meta_box()
    {
        // Chỉ định loại bài viết mà hộp meta sẽ được hiển thị
        $screens = ['post'];

        // Duyệt qua mỗi loại bài viết được chỉ định
        foreach ($screens as $screen) {
            // Thêm một hộp meta tùy chỉnh
            add_meta_box(
                'hide-page-title',                      // ID duy nhất của hộp meta
                __('Ẩn tiêu đề trang', 'aquila'),       // Tiêu đề của hộp meta
                [$this, 'custom_meta_box_html'],     // Hàm callback để hiển thị nội dung, phải là loại callable
                $screen,                             // Loại bài viết mà hộp meta sẽ được thêm vào
                'side'                               // Vị trí của hộp meta trên trang chỉnh sửa bài viết
            );
        }
    }

    /**
     * Hiển thị HTML meta box
     *
     * @param WP_Post $post Đối tượng bài viết hiện tại.
     */
    public function custom_meta_box_html($post)
    {
        // Lấy giá trị của trường meta '_hide_page_title' cho bài viết hiện tại
        $value = get_post_meta($post->ID, '_hide_page_title', true);

        /**
         * Sử dụng nonce để xác thực
         */
        wp_nonce_field(plugin_basename(__FILE__), 'hide_title_meta_box_nonce_name');
?>
        <!-- Nhãn cho trường select -->
        <label for="aquila-field"><?php esc_html_e('Ẩn tiêu đề trang', 'aquila'); ?></label>
        <!-- Trường select để chọn liệu có ẩn tiêu đề trang hay không -->
        <select name="aquila_hide_title_field" id="aquila-field" class="postbox">
            <!-- Tùy chọn mặc định -->
            <option value=""><?php esc_html_e('Chọn', 'aquila') ?></option>
            <!-- Tùy chọn để ẩn tiêu đề trang -->
            <option value="yes" <?php selected($value, 'yes'); ?>><?php esc_html_e('Có', 'aquila'); ?></option>
            <!-- Tùy chọn để không ẩn tiêu đề trang -->
            <option value="no" <?php selected($value, 'no'); ?>><?php esc_html_e('Không', 'aquila'); ?></option>
        </select>
<?php
    }


    /**
     * Lưu meta dữ liệu của bài viết vào cơ sở dữ liệu  khi bài viết được lưu.
     *
     * @param integer $post_id ID của bài viết.
     *
     * @return void
     */
    public function save_post_meta_data($post_id)
    {
        /**
         * Khi bài viết được cập nhật hoặc thêm mới, lấy biến $_POST
         * Kiểm tra xem người dùng hiện tại có quyền chỉnh sửa bài viết không.
         */
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        /**
         * Kiểm tra xem dữ liệu có nonce giống với nonce khởi tạo hay không.
         */
        if (
            !isset($_POST['hide_title_meta_box_nonce_name']) ||
            !wp_verify_nonce(plugin_basename(__FILE__), $_POST['hide_title_meta_box_nonce_name'])
        ) {
            return;
        }

        /**
         * Nếu tồn tại 'aquila_hide_title_field' trong $_POST, cập nhật meta dữ liệu.
         */
        if (array_key_exists('aquila_hide_title_field', $_POST)) {
            update_post_meta(
                $post_id,
                '_hide_page_title',
                $_POST['aquila_hide_title_field']
            );
        }
    }
}
