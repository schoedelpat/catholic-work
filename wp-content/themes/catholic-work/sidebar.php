<?php
/**
 * The sidebar containing the main widget area.
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php
    // Determine which sidebar to show based on page context
    $sidebar_id = 'sidebar-1'; // default
    
    if (is_page() || is_single()) {
        $post_type = get_post_type();
        
        switch ($post_type) {
            case 'community_event':
                $sidebar_id = 'community-sidebar';
                break;
            case 'learning_resource':
                $sidebar_id = 'learning-sidebar';
                break;
            case 'product':
                $sidebar_id = 'shop-sidebar';
                break;
        }
        
        // Check if we're on specific pages
        if (is_page()) {
            $page_slug = get_post_field('post_name');
            
            switch ($page_slug) {
                case 'community':
                    $sidebar_id = 'community-sidebar';
                    break;
                case 'learning':
                case 'courses':
                    $sidebar_id = 'learning-sidebar';
                    break;
                case 'shop':
                case 'store':
                    $sidebar_id = 'shop-sidebar';
                    break;
            }
        }
    }
    
    // Check if WooCommerce pages
    if (function_exists('is_woocommerce') && is_woocommerce()) {
        $sidebar_id = 'shop-sidebar';
    }
    
    // Use the determined sidebar, fallback to main if not active
    if (is_active_sidebar($sidebar_id)) {
        dynamic_sidebar($sidebar_id);
    } else {
        dynamic_sidebar('sidebar-1');
    }
    ?>
</aside><!-- #secondary -->