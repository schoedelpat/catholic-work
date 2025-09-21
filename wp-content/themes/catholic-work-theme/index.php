<?php
/**
 * Main template file for Catholic Work Theme
 *
 * @package CatholicWorkTheme
 */

get_header(); ?>

<main class="site-content">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php if (is_singular()) : ?>
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php else : ?>
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                    <?php endif; ?>
                </header>

                <div class="entry-content">
                    <?php
                    if (is_singular()) {
                        the_content();
                    } else {
                        the_excerpt();
                    }
                    ?>
                </div>

                <?php if (!is_singular()) : ?>
                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php _e('Read More', 'catholic-work-theme'); ?>
                        </a>
                    </footer>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>

        <?php
        // Pagination
        the_posts_pagination(array(
            'prev_text' => __('Previous', 'catholic-work-theme'),
            'next_text' => __('Next', 'catholic-work-theme'),
        ));
        ?>

    <?php else : ?>
        <article class="no-posts">
            <header class="entry-header">
                <h1 class="entry-title"><?php _e('Nothing Found', 'catholic-work-theme'); ?></h1>
            </header>
            <div class="entry-content">
                <p><?php _e('It looks like nothing was found at this location.', 'catholic-work-theme'); ?></p>
            </div>
        </article>
    <?php endif; ?>
</main>

<?php get_footer(); ?>