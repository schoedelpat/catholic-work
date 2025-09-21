<?php get_header(); ?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <?php if (have_posts()) : ?>
                
                <?php if (is_home() && !is_front_page()) : ?>
                    <header class="page-header mb-4">
                        <h1 class="page-title"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>
                
                <div class="posts-container">
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>
                            <header class="entry-header mb-3">
                                <?php
                                if (is_singular()) :
                                    the_title('<h1 class="entry-title">', '</h1>');
                                else :
                                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                endif;
                                ?>
                                
                                <?php if ('post' === get_post_type()) : ?>
                                    <div class="entry-meta text-muted mb-2">
                                        <span class="posted-on">
                                            <i class="fas fa-calendar"></i>
                                            <a href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark">
                                                <?php echo get_the_date(); ?>
                                            </a>
                                        </span>
                                        <span class="byline ms-3">
                                            <i class="fas fa-user"></i>
                                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                <?php echo get_the_author(); ?>
                                            </a>
                                        </span>
                                        <?php if (has_category()) : ?>
                                            <span class="cat-links ms-3">
                                                <i class="fas fa-folder"></i>
                                                <?php the_category(', '); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </header><!-- .entry-header -->
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="entry-thumbnail mb-3">
                                    <?php
                                    if (is_singular()) :
                                        the_post_thumbnail('large', array('class' => 'img-fluid'));
                                    else :
                                        echo '<a href="' . esc_url(get_permalink()) . '">';
                                        the_post_thumbnail('medium', array('class' => 'img-fluid'));
                                        echo '</a>';
                                    endif;
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="entry-content">
                                <?php
                                if (is_singular() || is_home()) :
                                    the_content(__('Continue reading', 'catholic-work'));
                                else :
                                    the_excerpt();
                                endif;
                                
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . __('Pages:', 'catholic-work'),
                                    'after'  => '</div>',
                                ));
                                ?>
                            </div><!-- .entry-content -->
                            
                            <?php if (!is_singular()) : ?>
                                <footer class="entry-footer mt-3">
                                    <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-primary">
                                        <?php _e('Read More', 'catholic-work'); ?>
                                    </a>
                                </footer>
                            <?php endif; ?>
                        </article><!-- #post-<?php the_ID(); ?> -->
                        
                    <?php endwhile; ?>
                    
                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'prev_text' => __('Previous', 'catholic-work'),
                        'next_text' => __('Next', 'catholic-work'),
                        'class' => 'pagination-wrapper mt-4',
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                
                <section class="no-results not-found">
                    <header class="page-header">
                        <h1 class="page-title"><?php _e('Nothing here', 'catholic-work'); ?></h1>
                    </header><!-- .page-header -->
                    
                    <div class="page-content">
                        <?php if (is_home() && current_user_can('publish_posts')) : ?>
                            
                            <p><?php printf(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'catholic-work'), esc_url(admin_url('post-new.php'))); ?></p>
                            
                        <?php elseif (is_search()) : ?>
                            
                            <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'catholic-work'); ?></p>
                            <?php get_search_form(); ?>
                            
                        <?php else : ?>
                            
                            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'catholic-work'); ?></p>
                            <?php get_search_form(); ?>
                            
                        <?php endif; ?>
                    </div><!-- .page-content -->
                </section><!-- .no-results -->
                
            <?php endif; ?>
        </div>
        
        <div class="col-lg-4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>