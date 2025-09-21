<?php
/**
 * Ecommerce Component Functions
 * Integrates WooCommerce for donation and product sales
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add WooCommerce support
function catholic_work_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'catholic_work_woocommerce_support');

// Custom donation shortcode
function catholic_work_donation_form_shortcode($atts) {
    $atts = shortcode_atts(array(
        'amounts' => '25,50,100,250',
        'default' => '50',
        'purpose' => 'General Fund',
    ), $atts);
    
    $amounts = explode(',', $atts['amounts']);
    
    ob_start();
    ?>
    <div class="donation-form">
        <h4><?php _e('Support Our Mission', 'catholic-work'); ?></h4>
        <p><?php printf(__('Your donation helps fund our %s.', 'catholic-work'), esc_html($atts['purpose'])); ?></p>
        
        <form class="donation-form-container" action="#" method="post">
            <div class="donation-amounts mb-3">
                <div class="row">
                    <?php foreach ($amounts as $amount) : ?>
                        <div class="col-6 col-md-3 mb-2">
                            <input type="radio" class="btn-check" name="donation_amount" id="amount_<?php echo $amount; ?>" 
                                   value="<?php echo $amount; ?>" <?php checked($atts['default'], $amount); ?>>
                            <label class="btn btn-outline-primary w-100" for="amount_<?php echo $amount; ?>">
                                $<?php echo $amount; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="custom-amount mb-3">
                <label for="custom_amount" class="form-label"><?php _e('Custom Amount', 'catholic-work'); ?></label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="custom_amount" name="custom_amount" 
                           placeholder="Enter amount" min="1">
                </div>
            </div>
            
            <div class="donation-frequency mb-3">
                <label class="form-label"><?php _e('Frequency', 'catholic-work'); ?></label>
                <div class="row">
                    <div class="col-6">
                        <input type="radio" class="btn-check" name="donation_frequency" id="one_time" value="one_time" checked>
                        <label class="btn btn-outline-secondary w-100" for="one_time">
                            <?php _e('One Time', 'catholic-work'); ?>
                        </label>
                    </div>
                    <div class="col-6">
                        <input type="radio" class="btn-check" name="donation_frequency" id="monthly" value="monthly">
                        <label class="btn btn-outline-secondary w-100" for="monthly">
                            <?php _e('Monthly', 'catholic-work'); ?>
                        </label>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="fas fa-heart"></i> <?php _e('Donate Now', 'catholic-work'); ?>
            </button>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('.donation-form input[name="donation_amount"]').change(function() {
            $('#custom_amount').val('');
        });
        
        $('#custom_amount').on('input', function() {
            $('.donation-form input[name="donation_amount"]').prop('checked', false);
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('donation_form', 'catholic_work_donation_form_shortcode');

// Featured products shortcode
function catholic_work_featured_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 4,
        'columns' => 4,
        'category' => '',
    ), $atts);
    
    if (!class_exists('WooCommerce')) {
        return '<p>' . __('WooCommerce is required for this feature.', 'catholic-work') . '</p>';
    }
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $atts['limit'],
        'meta_query' => array(
            array(
                'key' => '_featured',
                'value' => 'yes'
            )
        )
    );
    
    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $atts['category']
            )
        );
    }
    
    $products = new WP_Query($args);
    
    ob_start();
    
    if ($products->have_posts()) :
        ?>
        <div class="featured-products">
            <div class="row">
                <?php while ($products->have_posts()) : $products->the_post(); ?>
                    <div class="col-md-<?php echo 12 / $atts['columns']; ?> mb-4">
                        <div class="product-card card h-100">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-img-top">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                                <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                
                                <?php if (function_exists('wc_get_product')) : ?>
                                    <?php
                                    $product = wc_get_product(get_the_ID());
                                    if ($product) :
                                    ?>
                                        <div class="product-price">
                                            <span class="price"><?php echo $product->get_price_html(); ?></span>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
                                    <?php _e('View Product', 'catholic-work'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        wp_reset_postdata();
    else :
        echo '<p>' . __('No featured products found.', 'catholic-work') . '</p>';
    endif;
    
    return ob_get_clean();
}
add_shortcode('featured_products', 'catholic_work_featured_products_shortcode');

// Custom product types for Catholic Work
function catholic_work_add_product_types() {
    if (!class_exists('WC_Product_Simple')) {
        return;
    }
    
    // Register donation product type
    class WC_Product_Donation extends WC_Product_Simple {
        
        public function __construct($product = 0) {
            $this->product_type = 'donation';
            parent::__construct($product);
        }
        
        public function get_type() {
            return 'donation';
        }
        
        public function is_virtual() {
            return true;
        }
        
        public function is_downloadable() {
            return false;
        }
    }
}
add_action('init', 'catholic_work_add_product_types');

// Register donation product type
function catholic_work_register_donation_product_type($types) {
    $types['donation'] = __('Donation', 'catholic-work');
    return $types;
}
add_filter('product_type_selector', 'catholic_work_register_donation_product_type');

// WooCommerce customizations for Catholic Work
function catholic_work_woocommerce_customizations() {
    // Customize shop page title
    add_filter('woocommerce_page_title', function($title) {
        if (is_shop()) {
            return __('Catholic Work Store', 'catholic-work');
        }
        return $title;
    });
    
    // Add custom shop notice
    add_action('woocommerce_before_shop_loop', function() {
        echo '<div class="alert alert-info">';
        echo '<i class="fas fa-info-circle"></i> ';
        echo __('All proceeds support our mission to build Catholic community and advance social justice.', 'catholic-work');
        echo '</div>';
    }, 5);
}
add_action('init', 'catholic_work_woocommerce_customizations');

// Recent donations widget
class Catholic_Work_Recent_Donations_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'catholic_work_recent_donations',
            __('Recent Donations', 'catholic-work'),
            array('description' => __('Display recent donations (anonymous)', 'catholic-work'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // This would integrate with actual donation records
        // For now, showing placeholder data
        ?>
        <ul class="recent-donations-list list-unstyled">
            <li class="mb-2">
                <strong>$100</strong>
                <small class="d-block text-muted">
                    <i class="fas fa-heart text-danger"></i> 
                    <?php _e('Anonymous donor - 2 hours ago', 'catholic-work'); ?>
                </small>
            </li>
            <li class="mb-2">
                <strong>$50</strong>
                <small class="d-block text-muted">
                    <i class="fas fa-heart text-danger"></i> 
                    <?php _e('Anonymous donor - 1 day ago', 'catholic-work'); ?>
                </small>
            </li>
            <li class="mb-2">
                <strong>$25</strong>
                <small class="d-block text-muted">
                    <i class="fas fa-heart text-danger"></i> 
                    <?php _e('Anonymous donor - 2 days ago', 'catholic-work'); ?>
                </small>
            </li>
        </ul>
        
        <div class="mt-3">
            <a href="<?php echo esc_url(home_url('/donate')); ?>" class="btn btn-sm btn-primary">
                <?php _e('Make a Donation', 'catholic-work'); ?>
            </a>
        </div>
        <?php
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Donations', 'catholic-work');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'catholic-work'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

// Register ecommerce widgets
function catholic_work_register_ecommerce_widgets() {
    register_widget('Catholic_Work_Recent_Donations_Widget');
}
add_action('widgets_init', 'catholic_work_register_ecommerce_widgets');

// Custom checkout fields for donations
function catholic_work_custom_checkout_fields($fields) {
    // Add donation purpose field
    $fields['billing']['donation_purpose'] = array(
        'label' => __('Donation Purpose (Optional)', 'catholic-work'),
        'placeholder' => __('Specify how you\'d like your donation used', 'catholic-work'),
        'required' => false,
        'class' => array('form-row-wide'),
        'priority' => 25,
    );
    
    // Add anonymous donation option
    $fields['billing']['anonymous_donation'] = array(
        'type' => 'checkbox',
        'label' => __('Make this donation anonymous', 'catholic-work'),
        'required' => false,
        'class' => array('form-row-wide'),
        'priority' => 26,
    );
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'catholic_work_custom_checkout_fields');