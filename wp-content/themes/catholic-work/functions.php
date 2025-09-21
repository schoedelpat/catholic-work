<?php
/*
Theme Name: Catholic Work
Description: Custom WordPress theme for Catholic.Work nonprofit organization featuring community, learning, ecommerce, and communications components.
Version: 1.0.0
Author: Catholic.Work
Author URI: https://catholic.work
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: catholic-work
Tags: nonprofit, community, learning, ecommerce, social, responsive
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function catholic_work_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('custom-header');
    add_theme_support('custom-background');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ));
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for full and wide align images
    add_theme_support('align-wide');
    
    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'catholic-work'),
        'footer' => __('Footer Menu', 'catholic-work'),
        'community' => __('Community Menu', 'catholic-work'),
        'learning' => __('Learning Menu', 'catholic-work'),
    ));
}
add_action('after_setup_theme', 'catholic_work_setup');

// Enqueue styles and scripts
function catholic_work_scripts() {
    // Main stylesheet
    wp_enqueue_style('catholic-work-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Custom theme styles
    wp_enqueue_style('catholic-work-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), '1.0.0');
    
    // Bootstrap CSS for responsive design
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0');
    
    // Font Awesome for icons
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // jQuery (included with WordPress)
    wp_enqueue_script('jquery');
    
    // Bootstrap JS
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
    
    // Custom theme scripts
    wp_enqueue_script('catholic-work-script', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('catholic-work-script', 'catholic_work_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('catholic_work_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'catholic_work_scripts');

// Register widget areas
function catholic_work_widgets_init() {
    register_sidebar(array(
        'name' => __('Main Sidebar', 'catholic-work'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'catholic-work'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Community Sidebar', 'catholic-work'),
        'id' => 'community-sidebar',
        'description' => __('Widgets for community pages.', 'catholic-work'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Learning Sidebar', 'catholic-work'),
        'id' => 'learning-sidebar',
        'description' => __('Widgets for learning/courses pages.', 'catholic-work'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Shop Sidebar', 'catholic-work'),
        'id' => 'shop-sidebar',
        'description' => __('Widgets for shop/ecommerce pages.', 'catholic-work'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'catholic-work'),
        'id' => 'footer-widgets',
        'description' => __('Widgets for footer area.', 'catholic-work'),
        'before_widget' => '<div class="col-md-3"><section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section></div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'catholic_work_widgets_init');

// Custom post types for different components
function catholic_work_custom_post_types() {
    // Community Events
    register_post_type('community_event', array(
        'labels' => array(
            'name' => __('Community Events', 'catholic-work'),
            'singular_name' => __('Community Event', 'catholic-work'),
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-calendar-alt',
        'has_archive' => true,
        'rewrite' => array('slug' => 'community/events'),
    ));
    
    // Learning Resources
    register_post_type('learning_resource', array(
        'labels' => array(
            'name' => __('Learning Resources', 'catholic-work'),
            'singular_name' => __('Learning Resource', 'catholic-work'),
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-book',
        'has_archive' => true,
        'rewrite' => array('slug' => 'learning/resources'),
    ));
    
    // Communications/Announcements
    register_post_type('announcement', array(
        'labels' => array(
            'name' => __('Announcements', 'catholic-work'),
            'singular_name' => __('Announcement', 'catholic-work'),
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-megaphone',
        'has_archive' => true,
        'rewrite' => array('slug' => 'announcements'),
    ));
}
add_action('init', 'catholic_work_custom_post_types');

// Include component-specific functions
require_once get_template_directory() . '/inc/community-functions.php';
require_once get_template_directory() . '/inc/learning-functions.php';
require_once get_template_directory() . '/inc/ecommerce-functions.php';
require_once get_template_directory() . '/inc/communications-functions.php';