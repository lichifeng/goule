<?php
get_header(); ?>

<div id="primary" class="content-area">
    <?php if (is_page() && is_front_page()): ?>
        <?php get_template_part('index', 'nav'); ?>
    <?php endif; ?>

    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while (have_posts()) : the_post();

            // Include the single post content template.
            get_template_part('content', 'single');

            // End of the loop.
        endwhile;
        ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->


<?php
if ((comments_open() || get_comments_number()) && !is_front_page()) :
    comments_template();
endif;
?>

<?php get_footer(); ?>
