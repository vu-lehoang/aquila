<?php

function get_the_post_custom_thumbnail($post_id, $size = 'featured-thumbnail', $additional_attributes = [])
{
    $custom_thumbnail = '';

    // Nếu không có ID bài viết được cung cấp, sử dụng ID của bài viết hiện tại.
    if (null === $post_id) {
        $post_id = get_the_ID();
    }

    // Kiểm tra xem bài viết có ảnh thu nhỏ hay không.
    if (has_post_thumbnail($post_id)) {
        // Định nghĩa các thuộc tính mặc định cho thẻ ảnh.
        $default_attributes = [
            'loading' => 'lazy' // Thuộc tính 'loading' để trì hoãn tải ảnh cho đến khi cần thiết.
        ];

        // Hợp nhất các thuộc tính mặc định với các thuộc tính bổ sung được cung cấp.
        $attributes = array_merge($additional_attributes, $default_attributes);

        // Lấy HTML cho ảnh thu nhỏ của bài viết với kích thước và thuộc tính đã chỉ định.
        $custom_thumbnail = wp_get_attachment_image(
            get_post_thumbnail_id($post_id), // Lấy ID ảnh thu nhỏ của bài viết.
            $size,                           // Kích thước của ảnh thu nhỏ.
            false,                           // Xác định xem ảnh có được coi là biểu tượng hay không.
            $attributes                      // Các thuộc tính HTML bổ sung cho thẻ ảnh.
        );
    }

    // Trả về HTML của ảnh thu nhỏ tùy chỉnh.
    return $custom_thumbnail;
}

function the_post_custom_thumbnail($post_id, $size = 'featured-thumbnail', $additional_attributes = [])
{
    // Xuất ra kết quả của hàm get_the_post_custom_thumbnail
    echo get_the_post_custom_thumbnail($post_id, $size, $additional_attributes);
}


/**
 * Hiển thị ngày đăng bài viết và ngày cập nhật bài viết (nếu có) trong một liên kết.
 * Sử dụng thẻ <time> để đảm bảo dữ liệu ngày tháng được đánh dấu đúng cách cho các công cụ tìm kiếm và trình duyệt.
 */
function aquila_posted_on()
{
    // Chuỗi thẻ <time> ban đầu chỉ hiển thị ngày đăng bài viết
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

    // Kiểm tra xem bài viết có được chỉnh sửa không, nếu có thì hiển thị thêm ngày cập nhật
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="update" datetime="%3$s">%4$s</time>';
    }

    // Định dạng các giá trị ngày tháng và thời gian để chèn vào chuỗi thẻ <time>
    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)), // Lấy ngày đăng bài viết và định dạng theo chuẩn W3C
        esc_attr(get_the_date()), // Lấy ngày đăng bài viết và thoát ký tự đặc biệt
        esc_attr(get_the_modified_date(DATE_W3C)), // Lấy ngày cập nhật bài viết (nếu có) và định dạng theo chuẩn W3C
        esc_attr(get_the_modified_date()) // Lấy ngày cập nhật bài viết (nếu có) và thoát ký tự đặc biệt
    );

    // Tạo chuỗi HTML cho phần ngày đăng bài viết, bao gồm liên kết đến bài viết và thẻ <time>
    $posted_on = sprintf(
        esc_html_x('Posted on %s', 'post date', 'aquila'), // Dịch chuỗi với nhãn 'post date' và thoát ký tự đặc biệt
        '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
    );

    // Hiển thị chuỗi HTML với lớp CSS 'posted-on'
    echo '<span class="posted-on text-secondary">' . $posted_on . '</span>';
}

/**
 * Hiển thị tác giả bài viết
 */

function aquila_posted_by()
{
    $byline = sprintf(
        esc_html_x('by %s', 'post author', 'aquila'),
        '<span class="author vcard"><a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
    );

    echo '<span class="byline text-secondary">' . $byline . '</span>';
}

/**
 * Hiển thị trích dẫn (excerpt) của bài viết với độ dài tối đa xác định.
 *
 * @param int $trim_character_count Độ dài tối đa của trích dẫn (số ký tự).
 */
function aquila_the_excerpt($trim_character_count = 0)
{
    // Kiểm tra nếu bài viết không có trích dẫn hoặc không yêu cầu cắt ngắn (trim_character_count = 0)
    // if (!has_excerpt() || $trim_character_count === 0) {
    //     the_excerpt(); // Sử dụng hàm mặc định để hiển thị trích dẫn
    //     return;
    // }

    // Lấy trích dẫn của bài viết và loại bỏ tất cả các thẻ HTML
    $excerpt = wp_strip_all_tags(get_the_excerpt());

    // Cắt ngắn trích dẫn đến số ký tự được chỉ định
    $excerpt = substr($excerpt, 0, $trim_character_count);

    // Cắt trích dẫn đến khoảng trắng cuối cùng để không làm đứt từ giữa chừng
    $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));

    // Hiển thị trích dẫn đã cắt ngắn với dấu "[...]"
    echo '<p class="mb-2">' . $excerpt . ' [...]</p> ';
}


function aquila_excerpt_more($more = '')
{
    if (!is_single()) {
        $more = sprintf(
            '<button class="mt-1 btn btn-info"><a class="aquila-read-more text-white" href="%1$s">%2$s</a></button>',
            get_permalink(get_the_ID()),
            __('Read more', 'aquila')
        );
    }

    return $more;
}

// 
function aquila_pagination()
{
    $allowed_tags = [
        'span' => [
            'class' => []
        ],
        'a' => [
            'class' => ['mt-2'],
            'href' => [],
        ]
    ];
    $argc = [
        'before_page_number' => '<span class="btn border border-secondary mr-1 mb-1 ml-1">',
        'after_page_number' => '</span>',

    ];
    printf('<nav class="aquila-pagination clearfix row justify-content-center m-0">%s </nav>', wp_kses(paginate_links($argc), $allowed_tags));
}
