<?php
/**
 * Plugin Name: Catholic Work Custom Functionality
 * Plugin URI: https://catholic.work
 * Description: Custom functionality for the Catholic Work website.
 * Version: 1.0.0
 * Author: Catholic Work Team
 * Author URI: https://catholic.work
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: catholic-work-custom
 * Domain Path: /languages
 *
 * @package CatholicWorkCustom
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CWC_PLUGIN_VERSION', '1.0.0');
define('CWC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CWC_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Main plugin class
 */
class CatholicWorkCustom {
    
    /**
     * Initialize the plugin
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    /**
     * Initialize plugin functionality
     */
    public function init() {
        // Load text domain for translations
        load_plugin_textdomain('catholic-work-custom', false, dirname(plugin_basename(__FILE__)) . '/languages');
        
        // Add your custom functionality here
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    /**
     * Enqueue plugin scripts and styles
     */
    public function enqueue_scripts() {
        // Example: Enqueue custom CSS
        wp_enqueue_style(
            'catholic-work-custom-styles',
            CWC_PLUGIN_URL . 'assets/css/style.css',
            array(),
            CWC_PLUGIN_VERSION
        );
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Add activation code here
        flush_rewrite_rules();
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Add deactivation code here
        flush_rewrite_rules();
    }
}

// Initialize the plugin
new CatholicWorkCustom();