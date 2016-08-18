<?php

get_header(); ?>

    <div id="primary" class="content-area">

        <?php get_template_part('index', 'nav'); ?>

        <main id="main">

            <?php
                # remove this section if you dont want status post be excluded.
                if(is_home()) {
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $q_args = array(
                        'paged' => $paged,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'post_format',
                                'field' => 'slug',
                                'terms' => array( 'post-format-status' ),
                                'operator' => 'NOT IN'
                            )
                        )
                    );
                    query_posts( $q_args );
                }

                if (have_posts()) :

                // Start the loop.
                while (have_posts()) : the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part('content', get_post_format());

                    // End the loop.
                endwhile;

            // If no content, include the "No posts found" template.
            else :
                get_template_part('content', 'none');

            endif;

            $pagination_args = array(
                'prev_text' => '<span aria-hidden="true">&laquo;</span>',
                'next_text' => '<span aria-hidden="true">&raquo;</span>',
                'type'      => 'list',
            )
            ?>
            <nav class="wp-pagenavi">
                    <?php echo goule_paginate_links($pagination_args); ?>
            </nav>

        </main><!-- .site-main -->
    </div><!-- .content-area -->

<?php get_footer(); ?>