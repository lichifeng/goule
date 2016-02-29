</div><!-- main-container end -->

<footer id="colophon" class="site-footer">
    <div class="site-info text-center">
        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'goule' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'goule' ), 'WordPress' ); ?></a>
        •
        <a href="<?php echo esc_url( __( 'https://lichifeng.com/', 'goule' ) ); ?>"><?php printf( __( 'Using %s theme', 'goule' ), 'Goule' ); ?></a>
        •
        <?php wp_loginout(); ?>
    </div><!-- .site-info -->
</footer><!-- .site-footer -->

<?php wp_footer(); ?>
</body>
</html>
