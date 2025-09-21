<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <?php
                // Site logo/branding
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a class="navbar-brand" href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
                }
                ?>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'navbar-nav ms-auto',
                        'container' => false,
                        'fallback_cb' => false,
                        'walker' => new Catholic_Work_Bootstrap_Walker_Nav_Menu(),
                    ));
                    ?>
                    
                    <!-- Component Quick Access -->
                    <div class="navbar-nav ms-3">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="componentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-th"></i> Components
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="componentsDropdown">
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('/community')); ?>"><i class="fas fa-users"></i> Community</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('/learning')); ?>"><i class="fas fa-graduation-cap"></i> Learning</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('/shop')); ?>"><i class="fas fa-shopping-cart"></i> Shop</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('/communications')); ?>"><i class="fas fa-comments"></i> Communications</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header><!-- #masthead -->

    <main id="primary" class="site-main"><?php
// Custom Bootstrap Nav Walker for WordPress menus
class Catholic_Work_Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        
        if ($depth === 0) {
            $class_names = $class_names ? ' class="nav-item ' . esc_attr($class_names) . '"' : ' class="nav-item"';
        } else {
            $class_names = $class_names ? ' class="dropdown-item ' . esc_attr($class_names) . '"' : ' class="dropdown-item"';
        }
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url) ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        if ($depth === 0) {
            $attributes .= ' class="nav-link"';
        }
        
        $item_output = isset($args->before) ? $args->before ?? '' : '';
        $item_output .= '<a' . $attributes .'>';
        $item_output .= (isset($args->link_before) ? $args->link_before ?? '' : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after ?? '' : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after ?? '' : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}