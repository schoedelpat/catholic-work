<?php
/**
 * Theme functions and definitions
 *
 * @package CatholicWorkTheme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function catholic_work_theme_setup() {
    // Add theme support for various WordPress features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'catholic-work-theme'),
        'footer'  => __('Footer Menu', 'catholic-work-theme'),
    ));

    // Load text domain
    load_theme_textdomain('catholic-work-theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'catholic_work_theme_setup');

/**
 * Enqueue scripts and styles
 */
function catholic_work_theme_scripts() {
    // Enqueue theme stylesheet
    wp_enqueue_style(
        'catholic-work-theme-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // Enqueue theme JavaScript (if needed)
    wp_enqueue_script(
        'catholic-work-theme-script',
        get_template_directory_uri() . '/js/theme.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'catholic_work_theme_scripts');

/**
 * Register widget areas
 */
function catholic_work_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'catholic-work-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'catholic-work-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer', 'catholic-work-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'catholic-work-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'catholic_work_theme_widgets_init');