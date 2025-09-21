<?php
/**
 * Catholic Work Site Security
 * 
 * Must-use plugin for essential security functionality
 * 
 * @package CatholicWork
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Basic security enhancements for Catholic Work site
 */
class CW_Security {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
    }
    
    public function init() {
        // Remove WordPress version from head
        remove_action('wp_head', 'wp_generator');
        
        // Remove version from RSS feeds
        add_filter('the_generator', '__return_empty_string');
        
        // Hide login errors
        add_filter('login_errors', array($this, 'hide_login_errors'));
        
        // Disable XML-RPC if not needed
        add_filter('xmlrpc_enabled', '__return_false');
        
        // Remove WP version from scripts and styles
        add_filter('style_loader_src', array($this, 'remove_version_query'), 9999);
        add_filter('script_loader_src', array($this, 'remove_version_query'), 9999);
    }
    
    /**
     * Hide login error details
     */
    public function hide_login_errors() {
        return __('Login failed. Please check your credentials.', 'catholic-work');
    }
    
    /**
     * Remove version query string from static files
     */
    public function remove_version_query($src) {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
}

// Initialize security features
new CW_Security();