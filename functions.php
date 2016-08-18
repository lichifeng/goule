<?php
// Register Custom Navigation Walker
// More detail about this project can be found here:
// https://github.com/twittem/wp-bootstrap-navwalker
require_once('wp_bootstrap_navwalker.php');

// Setup function
if (!function_exists('goule_setup')) :
    function goule_setup()
    {
        load_theme_textdomain('goule', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));
    }
endif;
add_action('after_setup_theme', 'goule_setup');

// Register navigation menu
// header-menu is located under your Blogname
if (!function_exists('goule_register_menus')) :

    function goule_register_menus()
    {
        register_nav_menus(
            array(
                'header-menu' => __('Header Menu', 'goule'),
            )
        );
    }
endif;
add_action('init', 'goule_register_menus');


if (!isset ($content_width)) {
    $content_width = 738;
}

// Add bootstrap style to default Readmore link
// Feel free to modify
add_filter('the_content_more_link', 'goule_modify_read_more_link');
if (!function_exists('goule_modify_read_more_link')) :

    function goule_modify_read_more_link()
    {
        return '<div class="text-center"><a class="more-link btn btn-default btn-sm" href="' . get_permalink() . '">' . esc_html__('Continue to read the full content',
            'goule') . '</a></div>';
    }
endif;

if (!function_exists('goule_scripts')) :

    function goule_scripts()
    {
        wp_enqueue_style('goule-style', get_stylesheet_uri());
        wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('title-font', 'http://fonts.googleapis.com/css?family=Milonga');
        wp_register_script( 'bootstrap-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'bootstrap-script' );
        //wp_enqueue_script('goule_script', get_template_directory_uri() . '/goule_script.js', array(), false, true);
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
endif;
add_action('wp_enqueue_scripts', 'goule_scripts');

/**
 * Registers an editor stylesheet for the theme.
 */
function goule_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'goule_add_editor_styles');

// Prints HTML with meta information for the categories, tags
if (!function_exists('goule_entry_meta')) :
    function goule_entry_meta()
    {
        $dateformatstring = get_option('date_format');
        $unixtimestamp = get_the_time('U');
        $date_string = date_i18n($dateformatstring, $unixtimestamp);
        $tag_list = get_the_tag_list('', _x(', ', 'Used between list items, there is a space after the comma.',
            'goule'));
        global $post;
        $cat_list = get_the_term_list($post->ID, 'category', '', ',');
        printf(
            __('Posted in: %4$s by <span class="author">%1$s</span> <span class="posted-on">%2$s</span> | Tags: %3$s',
                'goule'),
            get_the_author(),
            $date_string,
            $tag_list,
            $cat_list
        );
    }
endif;

// This filter will fix a overflow problem caused by embedded videos
add_filter('embed_oembed_html', 'goule_custom_oembed_filter', 10, 4);
if (!function_exists('goule_custom_oembed_filter')) :

    function goule_custom_oembed_filter($html, $url, $attr, $post_ID)
    {
        $return = '<div class="video-container">' . $html . '</div>';
        return $return;
    }
endif;

// Used for better integration with Bootstrap
if (!function_exists('goule_comment')) :
    function goule_comment(
        $comment,
        $args,
        $depth
    )
    {
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);

        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo $tag ?>

        <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
        <?php if ('div' != $args['style']) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body container-fluid">
    <?php endif; ?>


        <div class="row no-gutter">
            <div class="col-md-1 hidden-sm hidden-xs">
                <?php if ($args['avatar_size'] != 0) {
                    echo get_avatar($comment, $args['avatar_size'], null, null, array('class' => 'img-thumbnail'));
                } ?>
            </div>
            <div class="col-xs-12 col-md-11">
                <div class="row no-gutter">
                    <div class="comment-meta">
                        <?php printf('<span class="fn">%s</span>&nbsp;<span class="comment-author-bullet">&bull;</span>',
                            get_comment_author_link()); ?>

                        <?php
                        /* translators: 1: date, 2: time */
                        printf('%1$s at %2$s', get_comment_date(), get_comment_time()); ?>

                        <?php edit_comment_link(esc_html__('(Edit)', 'goule'), '  ', ''); ?>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.',
                                    'goule'); ?></em>
                        <?php endif; ?>

                        <?php comment_reply_link(array_merge($args, array(
                            'add_below' => $add_below,
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                        ))); ?>
                    </div>
                </div>
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
            </div>
        </div>

        <?php if ('div' != $args['style']) : ?>
        </div>
    <?php endif; ?>
        <?php
    }
endif;

// Used for better integration with Bootstrap
add_filter('the_password_form', 'goule_password_form');
if (!function_exists('goule_password_form')) :
    function goule_password_form()
    {
        global $post;
        $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
        $output = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form form-inline" method="post">
    ' . esc_html__('This content is password protected. To view it please enter your password below:', 'goule') . '
    <p class="form-group"><label class="sr-only" for="' . $label . '">' . esc_html__('Password:', 'goule') .
            '</label>
        <div class="input-group">
        <div class="input-group-addon">' . esc_html__('Password:', 'goule') .
            '</div> <input name="post_password" id="' . $label . '" type="password" size="20" class="form-control" />
        <div class="input-group-btn">
        <input type="submit" name="Submit" class="btn btn-default" value="' . esc_attr__('Submit', 'goule') .
            '" /></div></div></p></form>
    ';

        return $output;
    }
endif;

if (!function_exists('goule_paginate_links')) :
    function goule_paginate_links($args = '')
    {
        global $wp_query, $wp_rewrite;

        // Setting up default values based on the current URL.
        //$pagenum_link = html_entity_decode(get_pagenum_link());
        $pagenum_link = wp_kses_post(get_pagenum_link());
        $url_parts = explode('?', $pagenum_link);

        // Get max pages and current page out of the current query, if available.
        $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

        // URL base depends on permalink settings.
        $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%',
            'paged') : '?paged=%#%';

        $defaults = array(
            'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
            'format' => $format, // ?page=%#% : %#% is replaced by the page number
            'total' => $total,
            'current' => $current,
            'show_all' => false,
            'prev_next' => true,
            'prev_text' => esc_html__('&laquo; Previous', 'goule'),
            'next_text' => esc_html__('Next &raquo;', 'goule'),
            'end_size' => 1,
            'mid_size' => 2,
            'type' => 'plain',
            'add_args' => array(), // array of query args to add
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number' => '',
            'nav_size' => 'normal',
        );

        $args = wp_parse_args($args, $defaults);

        if (!is_array($args['add_args'])) {
            $args['add_args'] = array();
        }

        // Merge additional query vars found in the original URL into 'add_args' array.
        if (isset($url_parts[1])) {
            // Find the format argument.
            $format = explode('?', str_replace('%_%', $args['format'], $args['base']));
            $format_query = isset($format[1]) ? $format[1] : '';
            wp_parse_str($format_query, $format_args);

            // Find the query args of the requested URL.
            wp_parse_str($url_parts[1], $url_query_args);

            // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
            foreach (
                $format_args
                as
                $format_arg
            =>
                $format_arg_value
            ) {
                unset($url_query_args[$format_arg]);
            }

            $args['add_args'] = array_merge($args['add_args'], urlencode_deep($url_query_args));
        }

        // Who knows what else people pass in $args
        $total = (int)$args['total'];
        if ($total < 2) {
            return false;
        }
        $current = (int)$args['current'];
        $end_size = (int)$args['end_size']; // Out of bounds?  Make it the default.
        if ($end_size < 1) {
            $end_size = 1;
        }
        $mid_size = (int)$args['mid_size'];
        if ($mid_size < 0) {
            $mid_size = 2;
        }
        $add_args = $args['add_args'];
        $r = '';
        $page_links = array();
        $dots = false;

        if ($args['prev_next'] && $current && 1 < $current) :
            $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
            $link = str_replace('%#%', $current - 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            /**
             * Filter the paginated links for the given archive pages.
             *
             * @since 3.0.0
             *
             * @param string $link The paginated link URL.
             */
            $page_links[] = '<a class="prev page-numbers" href="' . esc_url(apply_filters('paginate_links',
                    $link)) . '">' . $args['prev_text'] . '</a>';
        endif;
        for (
            $n = 1;
            $n <= $total;
            $n++
        )
            :
            if ($n == $current) :
                $page_links[] = "<span class='page-numbers current'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "<span class=\"sr-only\">" . esc_html__('(current)',
                        'goule') . "</span></span>";
                $dots = true;
            else :
                if ($args['show_all'] || ($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size)) :
                    $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
                    $link = str_replace('%#%', $n, $link);
                    if ($add_args) {
                        $link = add_query_arg($add_args, $link);
                    }
                    $link .= $args['add_fragment'];

                    /** This filter is documented in wp-includes/general-template.php */
                    $page_links[] = "<a class='page-numbers' href='" . esc_url(apply_filters('paginate_links',
                            $link)) . "'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "</a>";
                    $dots = true;
                elseif ($dots && !$args['show_all']) :
                    $page_links[] = '<span class="page-numbers dots">' . '&hellip;' . '</span>';
                    $dots = false;
                endif;
            endif;
        endfor;
        if ($args['prev_next'] && $current && ($current < $total || -1 == $total)) :
            $link = str_replace('%_%', $args['format'], $args['base']);
            $link = str_replace('%#%', $current + 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            /** This filter is documented in wp-includes/general-template.php */
            $page_links[] = '<a class="next page-numbers" href="' . esc_url(apply_filters('paginate_links',
                    $link)) . '">' . $args['next_text'] . '</a>';
        endif;
        switch ($args['type']) {
            case 'array' :
                return $page_links;

            case 'list' :
                switch ($args['nav_size']) {
                    case 'small':
                        $nav_size_class = 'pagination-sm';
                        break;
                    case 'large':
                        $nav_size_class = 'pagination-lg';
                        break;
                    default:
                        $nav_size_class = '';
                }
                $r .= "<ul class='page-numbers pagination " . $nav_size_class . "'>\n\t<li>";
                $r .= join("</li>\n\t<li>", $page_links);
                $r .= "</li>\n</ul>\n";
                $r = str_replace("<li><span class='page-numbers current'>",
                    "<li class='active'><span class='page-numbers current'>", $r);
                break;

            default :
                $r = join("\n", $page_links);
                break;
        }

        return $r;
    }
endif;

if (!function_exists('goule_paginate_comments_links')) :
    function goule_paginate_comments_links($args = array())
    {
        global $wp_rewrite;

        if (!is_singular()) {
            return false;
        }

        $page = get_query_var('cpage');
        if (!$page) {
            $page = 1;
        }
        $max_page = get_comment_pages_count();
        $defaults = array(
            'base' => add_query_arg('cpage', '%#%'),
            'format' => '',
            'total' => $max_page,
            'current' => $page,
            'echo' => true,
            'add_fragment' => '#comments',
        );
        if ($wp_rewrite->using_permalinks()) {
            $defaults['base'] = user_trailingslashit(trailingslashit(get_permalink()) . $wp_rewrite->comments_pagination_base . '-%#%',
                'commentpaged');
        }

        $args = wp_parse_args($args, $defaults);
        $page_links = goule_paginate_links($args);

        if ($args['echo']) {
            echo $page_links;
        } else {
            return $page_links;
        }

        return false;
    }
endif;