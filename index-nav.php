<header id="masthead">
    <div class="row no-gutter">
        <div class="col-md-12 text-center">
            <div class="description">
                <?php bloginfo('description'); ?>
            </div>
        </div>
        <div class="col-md-12 site-nav-upper text-center">
            <h1>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?></a>
            </h1>
        </div>
        <div class="col-md-12 site-nav-lower text-center">
            <div class="navbar">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <?php esc_html_e('Toggle navigation', 'goule'); ?>
                            <span class="caret"></span>
                        </button>
                    </div>

                    <?php

                    wp_nav_menu(array(
                            'theme_location' => 'header-menu',
                            'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                            'depth' => 5,
                            'container' => 'div',
                            'menu_class' => 'nav navbar-nav',

                            'container_class' => 'collapse navbar-collapse',
                            'container_id' => 'bs-example-navbar-collapse-1',
                            //Process nav menu using our custom nav walker
                            'walker' => new wp_bootstrap_navwalker(),
                            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>' . get_search_form(false),
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>

</header><!-- .site-header -->