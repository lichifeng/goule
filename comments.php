<?php

if (post_password_required()) {
    return;
}

?>

<div class="content-area">
    <div id="comments" class="comments-area">
        <header class="comments-title">
        <?php if (have_comments()) {
            printf(_nx('One Comment',
                '%s Comments',
                get_comments_number(),
                'comments title',
                'goule'
            ),
                number_format_i18n(get_comments_number())
            );
        }else {
            esc_html_e('No comment yet', 'goule');
        }
                ?>
            </header>


            <?php
            $commenter = wp_get_current_commenter();
            $req = get_option('require_name_email');
            $aria_req = ($req ? " aria-required='true'" : '');
            $fields = array(
                'author' =>
                    ' <div class="col-md-5"> <p class="comment-form-author input-group"><label class="input-group-addon" for="author">'
                    . esc_html__('Name',
                                 'goule'
                    ) . '</label> ' . '<input class="form-control input-sm" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']
                    )
                    .
                    '" size="30"'
                    .
                    $aria_req
                    .
                    ' />'
                    .
                    ($req ? '<span class="required input-group-addon">*</span>' : '') .
                    '</p>',
                'email'  =>
                    '<p class="comment-form-email input-group"><label class="input-group-addon" for="email">' . esc_html__('Email',
                                                                                                                           'goule'
                    ) . '</label> ' .
                    '<input class="form-control input-sm" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']
                    ) .
                    '" size="30"' . $aria_req . ' />' .
                    ($req ? '<span class="required input-group-addon">*</span>' : '') . '</p>',

                'url' =>
                    '<p class="comment-form-url input-group"><label class="input-group-addon" for="url">' . esc_html__('Website',
                                                                                                                       'goule'
                    ) . '</label>' .
                    '<input class="form-control input-sm" id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']
                    ) .
                    '" size="30" /></p>',
            );
            $required_text = sprintf(' ' . __('Required fields are marked %s', 'goule'),
                                     '<span class="required">*</span>'
            );
            comment_form(array(
                             'format'               => 'html5',
                             'fields'               => $fields,
                             'submit_button'        => '<input class="btn btn-default btn-block" name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" /></div></div>',
                             'submit_field'         => '<p class="form-submit text-right">%1$s %2$s</p>',
                             'comment_field'        => '<div class="container-fluid"><div class="row no-gutter"> <div class="col-md-7"><p class="comment-form-comment"><label for="comment" class="sr-only">' . _x('Comment',
                                                                                                                                                                                                                   'noun',
                                                                                                                                                                                                                   'goule'
                                 ) .
                                 '</label><textarea id="comment" cols="45" rows="6" name="comment" aria-required="true" class="form-control">' .
                                 '</textarea></p></div>',
                             'title_reply_before'   => '<div class="container-fluid"><div class="row no-gutter"><div class="col-md-6"><header id="reply-title" class="comment-reply-title">',
                             'title_reply_after'    => '</header></div><div class="col-md-6 text-right"><p class="comment-notes">' . __('Your email address will not be published.',
                                                                                                                                        'goule'
                                 ) . ($req ? $required_text : '') . '</p></div></div></div>',
                             'comment_notes_before' => '',
                             'logged_in_as'            => '<p class="logged-in-as container-fluid">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'goule' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
                         )
            );
            ?>

            <ol class="comment-list">
                <?php
                wp_list_comments(array(
                                     'style'       => 'ol',
                                     'short_ping'  => true,
                                     'avatar_size' => 50,
                                     'callback'    => 'mytheme_comment',
                                 )
                );
                ?>
            </ol><!-- .comment-list -->

            <?php
            // Are there comments to navigate through?
            if (get_comment_pages_count() > 1 && get_option('page_comments')) :
                ?>
                <nav class="navigation comment-navigation wp-pagenavi"
                     role="navigation">
                    <?php
                    $pagination_args = array(
                        'prev_text' => '<span aria-hidden="true">&laquo;</span>',
                        'next_text' => '<span aria-hidden="true">&raquo;</span>',
                        'type'      => 'list',
                        'nav_size'  => 'small',
                    );
                    echo theme_paginate_comments_links($pagination_args);
                    ?>
                </nav><!-- .comment-navigation -->
            <?php endif; // Check for comment navigation ?>

            <?php if (!comments_open() && get_comments_number()) : ?>
                <p class="no-comments alert alert-warning text-center"><?php _e('Commenting on this post are closed',
                                                                                'goule'
                    ); ?></p>
            <?php endif; ?>

    </div><!-- #comments -->
</div>
