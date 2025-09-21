    </main><!-- #main -->

    <footer id="colophon" class="site-footer bg-dark text-light py-5">
        <div class="container">
            <?php if (is_active_sidebar('footer-widgets')) : ?>
                <div class="row">
                    <?php dynamic_sidebar('footer-widgets'); ?>
                </div>
                <hr class="my-4">
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <h5>Catholic.Work</h5>
                    <p class="mb-0">Building community through faith, learning, and service.</p>
                </div>
                <div class="col-md-6">
                    <div class="footer-menu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class' => 'list-inline',
                            'container' => false,
                            'fallback_cb' => false,
                        ));
                        ?>
                    </div>
                    <div class="social-links mt-3">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0">
                        &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                        <?php _e('All rights reserved.', 'catholic-work'); ?>
                        <?php if (function_exists('the_privacy_policy_link')) {
                            the_privacy_policy_link(' | ');
                        } ?>
                    </p>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>