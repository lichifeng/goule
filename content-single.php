<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header row no-gutter">
        <?php the_title('<h3 class="entry-title col-xs-9">', '</h3>'); ?>
        <h3 class="col-xs-1 col-xs-offset-2 text-right entry-title-buttons">
            <a class="col-xs-6 col-md-4 col-md-offset-4" href="<?php echo esc_url(home_url()); ?>"><span
                    class="glyphicon glyphicon-home"
                    aria-hidden="true"></span></a>
        </h3>
    </header><!-- .entry-header -->
    <?php if (!is_page()): ?>
    <footer class="entry-footer">
        <?php goule_entry_meta(); ?>
    </footer><!-- .entry-footer -->
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();
        ?>
        <div class="clearfix"></div>
        <?php
        $pagination_args = array(
            'before'           => '<nav class="wp-pagenavi"><ul class="pagination pagination-sm"><li>',
            'after'            => '</li></ul></nav>',
            'pagelink'         => '<span>%</span>',
            'nextpagelink'     => '<span aria-hidden="true">&raquo;</span>',
            'previouspagelink' => '<span aria-hidden="true">&raquo;</span>',
            'echo'             => 0,
            'separator'        => '</li><li>',
        );
        echo str_replace("<li> <span>", "<li class='active'><span>", wp_link_pages($pagination_args));
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->