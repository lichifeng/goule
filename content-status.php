<?php
    $classes = array(
        'panel',
        'panel-default'
    )
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
    <div class="entry-content panel-body">
        <?php
        if (has_post_thumbnail()) {
            $status_content_class_l = "col-md-3 col-xs-12";
            $status_content_class_r = "col-md-9 col-xs-12";
        } else {
            $status_content_class_l = "hidden";
            $status_content_class_r = "col-md-12 col-xs-12";
        }

        $status_fixed = is_sticky() ? "status-fixed" : "";
        ?>
        <div class="<?php echo $status_content_class_l; ?>">
            <div class="thumbnail">
                <?php the_post_thumbnail($size = array( 500, 100)); ?>
            </div></div>
        <div class="<?php echo $status_content_class_r; ?>">
        <?php
        /* translators: %s: Name of current post */
        the_content();
        ?></div>
        <div class="clearfix"></div>
    </div><!-- .entry-content -->
    <header class="panel-footer">
        <?php
        $post_format = esc_html__('status', 'goule');
        $post_format_icon = 'comment';
        ?>
        <div class="status-footer"><a
                href="<?php echo esc_url(get_permalink()); ?>" class="<?php echo $status_fixed; ?>"><span
                        class="glyphicon glyphicon-<?php echo $post_format_icon; ?>"
                        aria-hidden="true"></span>
                    <?php echo is_sticky() ? esc_html__('Sticky ', 'goule') : "";echo $post_format; ?></a>

        <?php the_title(sprintf(' • <a href="%s" rel="bookmark">',
                                esc_url(get_permalink())
                        ),
                        '</a>'
        ); ?></div>
    </header><!-- .entry-header -->
</article><!-- #post-## -->
