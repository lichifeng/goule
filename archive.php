<?php
/*
Template Name: Archives
*/
get_header();
?>

    <div id="primary" class="content-area">

        <?php get_template_part('index',
                                'nav'
        ); ?>
        <?php if (is_page()): ?>
            <main id="main" class="container-fluid">
                <div class="archive-row">
                    <div class="row no-gutter">
                        <div class="col-xs-12 archive-title">
                            <span class="glyphicon glyphicon-tag"
                                  aria-hidden="true"></span>
                            <?php esc_html_e("Browse by Tags",
                                             'goule'
                            ); ?>
                        </div>
                    </div>
                    <div class="row no-gutter tag-cloud">
                        <ul class="pager">
                            <li>
                                <?php
                                $t_cloud = wp_tag_cloud(array(
                                                            'smallest' => 0.8,
                                                            'largest'  => 2,
                                                            'unit'     => 'em',
                                                            'format'   => 'array',
                                                            'number'   => 100,
                                                        )
                                );
                                echo join("</li><li>",
                                          $t_cloud
                                );
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="archive-row">
                    <div class="row no-gutter">
                        <div class="col-xs-12 archive-title">
                            <span class="glyphicon glyphicon-list"
                                  aria-hidden="true"></span>
                            <?php esc_html_e("Browse by Categorys",
                                             'goule'
                            ); ?>
                        </div>
                    </div>
                    <div class="row no-gutter archive-list">
                        <?php
                        $categories = get_categories(array(
                                                         'orderby' => 'name',
                                                         'order'   => 'ASC',
                                                     )
                        );

                        foreach (
                            $categories
                            as
                            $category
                        )
                        {
                            $category_link = sprintf('<a href="%1$s" title="%2$s">%3$s</a>',
                                                     esc_url(get_category_link($category->term_id
                                                             )
                                                     ),
                                                     esc_attr(sprintf(__('View all posts in %s',
                                                                         'goule'
                                                                      ),
                                                                      $category->name
                                                              )
                                                     ),
                                                     esc_html($category->name)
                            );

                            echo '<div class="col-md-4 text-center">' . $category_link . ' (' . $category->count . ')</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="archive-row">
                    <div class="row no-gutter">
                        <div class="col-xs-12 archive-title">
                            <span class="glyphicon glyphicon-calendar"
                                  aria-hidden="true"></span>
                            <?php esc_html_e("Browse by Date",
                                             'goule'
                            ); ?>
                        </div>
                    </div>
                    <div class="row no-gutter archive-list">
                        <?php
                        $args = array(
                            'type'            => 'monthly',
                            'show_post_count' => 1,
                            'format'          => 'custom',
                            'before'          => '<div class="col-md-3 text-center">',
                            'after'           => '</div>',
                        );
                        wp_get_archives($args);
                        ?>
                    </div>
                </div>

                <div class="archive-row">
                    <div class="row no-gutter">
                        <div class="col-xs-12 archive-title">
                            <span class="glyphicon glyphicon-duplicate"
                                  aria-hidden="true"></span>
                            <?php _e("Page list",
                                     'goule'
                            ); ?>
                        </div>
                    </div>
                    <div class="row no-gutter archive-list">
                        <?php
                        $pages = get_pages();
                        foreach (
                            $pages
                            as
                            $page
                        )
                        {
                            $option = '<div class="col-md-6"><a href="' . get_page_link($page->ID
                                ) . '">';
                            $option .= $page->post_title;
                            $option .= '</a></div>';
                            echo $option;
                        }
                        ?>
                    </div>
                </div>

                <div class="archive-row">
                    <div class="row no-gutter">
                        <div class="col-xs-12 archive-title">
                            <span class="glyphicon glyphicon-picture"
                                  aria-hidden="true"></span>
                            <?php esc_html_e("Attachment list",
                                             'goule'
                            ); ?>
                        </div>
                    </div>
                    <div class="row no-gutter archive-list">
                        <?php
                        $attachments = get_posts(array(
                                                     'post_type' => 'attachment',
                                                     'orderby'   => 'post__in',
                                                 )
                        );
                        if ($attachments) {
                            foreach (
                                $attachments
                                as
                                $attachment
                            )
                            {
                                $attachment_page = get_attachment_link($attachment->ID
                                );
                                ?>
                                <div class="col-xs-4">
                                    <a href="<?php echo $attachment_page; ?>"><?php echo get_the_title($attachment->ID
                                        ); ?></a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>


            </main><!-- .site-main -->
        <?php else: ?>
            <main id="main">

                <?php if (have_posts()) :

                    // Start the loop.
                    while (have_posts()) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part('content',
                                          get_post_format()
                        );

                        // End the loop.
                    endwhile;

                // If no content, include the "No posts found" template.
                else :
                    get_template_part('content',
                                      'none'
                    );

                endif;
                $pagination_args = array(
                'prev_text' => '<span aria-hidden="true">&laquo;</span>',
                'next_text' => '<span aria-hidden="true">&raquo;</span>',
                'type'      => 'list',
                )
                ?>
                <nav class="wp-pagenavi">
                        <?php echo theme_paginate_links($pagination_args); ?>
                </nav>

            </main><!-- .site-main -->
        <?php endif; ?>
    </div><!-- .content-area -->

<?php get_footer(); ?>