<?php
$classes = array(
    'panel',
    'panel-default'
)
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
    <header class="panel-heading">
        <?php if (is_sticky() && is_home() && !is_paged()) {
            $post_format_label = 'primary';
            $post_format_icon = 'pushpin';
            $post_format = esc_html_x('Featured',
                                      'used before post titles',
                                      'goule'
            );
        } elseif (post_password_required()) {
            $post_format_label = 'danger';
            $post_format_icon = 'ban-circle';
            $post_format = esc_html_x('Protected',
                                      'used before post titles',
                                      'goule'
            );
        } else {
            $post_format = get_post_format() == '' ? esc_html_x('Standard', 'used before post titles',
                                                                'goule') : get_post_format();
            $post_format_label = 'default';
            switch ($post_format) {
                case 'aside':
                    $post_format = esc_html__('aside', 'goule');
                    $post_format_icon = 'pencil';
                    break;
                case 'gallery':
                    $post_format = esc_html__('gallery', 'goule');
                    $post_format_icon = 'th-large';
                    break;
                case 'link':
                    $post_format = esc_html__('link', 'goule');
                    $post_format_icon = 'link';
                    break;
                case 'image':
                    $post_format = esc_html__('image', 'goule');
                    $post_format_icon = 'picture';
                    break;
                case 'quote':
                    $post_format = esc_html__('quote', 'goule');
                    $post_format_icon = 'scissors';
                    break;
                case 'status':
                    $post_format = esc_html__('status', 'goule');
                    $post_format_icon = 'comment';
                    break;
                case 'video':
                    $post_format = esc_html__('video', 'goule');
                    $post_format_icon = 'film';
                    break;
                case 'audio':
                    $post_format = esc_html__('audio', 'goule');
                    $post_format_icon = 'headphones';
                    break;
                case 'chat':
                    $post_format = esc_html__('chat', 'goule');
                    $post_format_icon = 'user';
                    break;
                default:
                    $post_format_icon = 'file';
                    break;
            }
        } ?>
        <div class="sticky-post"><a
                href="<?php echo esc_url(get_permalink()); ?>"><span
                    class="label label-<?php echo $post_format_label; ?> pull-left"><span
                        class="glyphicon glyphicon-<?php echo $post_format_icon; ?>"
                        aria-hidden="true"></span>
                    <?php echo $post_format; ?></span></a></div>

        <?php the_title(sprintf('<div class="entry-title"><a href="%s" rel="bookmark">',
                                esc_url(get_permalink())
                        ),
                        '</a></div>'
        ); ?>
    </header><!-- .entry-header -->
    <?php if( !(is_sticky() && is_home() && !is_paged() )): ?>
    <div class="entry-content panel-body">

        <?php
        if (has_post_thumbnail()) {
            ?>
            <div class="post-thumbnail-wrap">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php }
        /* translators: %s: Name of current post */
        the_content();
        ?>
        <div class="clearfix"></div>
    </div><!-- .entry-content -->
    <?php endif; ?>
</article><!-- #post-## -->
