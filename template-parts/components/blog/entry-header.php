<?php

/**
 * Template for post entry header
 * 
 * @package aquila
 */
$the_post_id = get_the_ID();
$hide_title = get_post_meta($the_post_id, '_hide_page_title', true);
$heading_class = !empty($hide_title) && 'yes' === $hide_title ? 'hide' : '';
$has_post_thumbnail = get_the_post_thumbnail($the_post_id);
?>
<header class="entry-header">
    <?php
    // Featured Image
    if ($has_post_thumbnail) {

    ?>
        <div class="entry-image mb-3">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <?php
                the_post_custom_thumbnail(
                    $the_post_id,
                    'featured-thumbnail',
                    [
                        'sizes' => '(max-width: 350px) 350px, 233px',
                        'class' => 'attachment-featured-large size-featured-image'
                    ]
                )
                ?>
            </a>
        </div>
    <?php
    } else {
        // Kiểm tra xem trang hiện tại có phải là trang blog
        if (is_home() || !is_front_page()) {
            // Lấy đường dẫn đến thư mục uploads của WordPress
            $upload_dir = wp_get_upload_dir();

            // Đường dẫn tuyệt đối của hình ảnh mặc định (ví dụ: no-thumbnail.png)
            $default_image_url = $upload_dir['baseurl'] . '/2024/06/no-thumbnail.png';

            // Kiểm tra xem hình ảnh mặc định có tồn tại không
            if (file_exists($upload_dir['basedir'] . '/2024/06/no-thumbnail.png')) {
                // Hiển thị hình ảnh mặc định
                echo '<div class="entry-image mb-3"><img width="278px" height="233px" class="attachment-featured-large size-featured-image" src="' . esc_url($default_image_url) . '" alt="No Thumbnail" sizes="(max-width: 350px) 350px, 233px" loading="lazy" decoding="async"></div>';
            }
        }
    }

    // Title
    // Kiểm tra nếu đang hiển thị một bài đăng đơn lẻ hoặc một trang đơn lẻ
    if (is_single() || is_page()) {
        // Nếu là một bài đăng đơn lẻ hoặc một trang đơn lẻ, in ra tiêu đề với thẻ h1
        printf(
            '<h1 class="page-title text-dark %s">%s</h1>', // Định dạng chuỗi HTML với tiêu đề và các lớp CSS
            esc_attr($heading_class), // Chuẩn hóa và thoát ký tự đặc biệt trong class CSS
            wp_kses_post(get_the_title()) // Lấy tiêu đề của bài đăng và loại bỏ các thẻ HTML không an toàn
        );
    } else {
        // Nếu không phải là một bài đăng đơn lẻ hoặc một trang đơn lẻ, in ra tiêu đề với thẻ h6 và liên kết
        printf(
            '<h5 class="entry-title mb-3"><a class="text-dark" href="%s">%s</a></h5>', // Định dạng chuỗi HTML với tiêu đề là liên kết và các lớp CSS
            esc_url(get_the_permalink()), // Chuẩn hóa và thoát ký tự đặc biệt trong URL của liên kết
            wp_kses_post(get_the_title()) // Lấy tiêu đề của bài đăng và loại bỏ các thẻ HTML không an toàn
        );
    }

    ?>

</header>