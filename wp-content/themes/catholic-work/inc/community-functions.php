<?php
/**
 * Community Component Functions
 * Integrates BuddyPress and social features
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add BuddyPress support
function catholic_work_buddypress_support() {
    add_theme_support('buddypress');
}
add_action('after_setup_theme', 'catholic_work_buddypress_support');

// Custom community member directory
function catholic_work_community_directory_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 12,
        'columns' => 3,
    ), $atts);
    
    ob_start();
    ?>
    <div class="community-directory">
        <div class="row">
            <?php
            // This would integrate with BuddyPress or custom member system
            // For now, showing placeholder structure
            for ($i = 1; $i <= $atts['limit']; $i++) :
            ?>
                <div class="col-md-<?php echo 12 / $atts['columns']; ?> mb-4">
                    <div class="member-card card h-100">
                        <div class="card-body text-center">
                            <div class="member-avatar mb-3">
                                <img src="https://via.placeholder.com/80x80" class="rounded-circle" alt="Member Avatar">
                            </div>
                            <h5 class="member-name">Community Member <?php echo $i; ?></h5>
                            <p class="member-role text-muted">Volunteer</p>
                            <a href="#" class="btn btn-sm btn-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('community_directory', 'catholic_work_community_directory_shortcode');

// Community events widget
class Catholic_Work_Community_Events_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'catholic_work_community_events',
            __('Community Events', 'catholic-work'),
            array('description' => __('Display upcoming community events', 'catholic-work'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // Query community events
        $events = new WP_Query(array(
            'post_type' => 'community_event',
            'posts_per_page' => 5,
            'meta_key' => 'event_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'value' => date('Y-m-d'),
                    'compare' => '>='
                )
            )
        ));
        
        if ($events->have_posts()) :
            echo '<ul class="community-events-list list-unstyled">';
            while ($events->have_posts()) : $events->the_post();
                $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                ?>
                <li class="mb-2">
                    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                        <strong><?php the_title(); ?></strong>
                    </a>
                    <?php if ($event_date) : ?>
                        <small class="d-block text-muted">
                            <i class="fas fa-calendar"></i> <?php echo date('M j, Y', strtotime($event_date)); ?>
                        </small>
                    <?php endif; ?>
                </li>
                <?php
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        else :
            echo '<p>' . __('No upcoming events.', 'catholic-work') . '</p>';
        endif;
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Upcoming Events', 'catholic-work');
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

// Register community widgets
function catholic_work_register_community_widgets() {
    register_widget('Catholic_Work_Community_Events_Widget');
}
add_action('widgets_init', 'catholic_work_register_community_widgets');

// Add community-specific meta boxes
function catholic_work_community_meta_boxes() {
    add_meta_box(
        'community_event_details',
        __('Event Details', 'catholic-work'),
        'catholic_work_community_event_meta_box_callback',
        'community_event',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'catholic_work_community_meta_boxes');

function catholic_work_community_event_meta_box_callback($post) {
    wp_nonce_field('catholic_work_community_event_meta_box', 'catholic_work_community_event_meta_box_nonce');
    
    $event_date = get_post_meta($post->ID, 'event_date', true);
    $event_time = get_post_meta($post->ID, 'event_time', true);
    $event_location = get_post_meta($post->ID, 'event_location', true);
    ?>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="event_date"><?php _e('Event Date', 'catholic-work'); ?></label></th>
            <td><input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="event_time"><?php _e('Event Time', 'catholic-work'); ?></label></th>
            <td><input type="time" id="event_time" name="event_time" value="<?php echo esc_attr($event_time); ?>" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="event_location"><?php _e('Event Location', 'catholic-work'); ?></label></th>
            <td><input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>" size="50" /></td>
        </tr>
    </table>
    <?php
}

// Save community event meta data
function catholic_work_save_community_event_meta($post_id) {
    if (!isset($_POST['catholic_work_community_event_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['catholic_work_community_event_meta_box_nonce'], 'catholic_work_community_event_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (isset($_POST['post_type']) && 'community_event' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }
    
    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
    }
    
    if (isset($_POST['event_time'])) {
        update_post_meta($post_id, 'event_time', sanitize_text_field($_POST['event_time']));
    }
    
    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, 'event_location', sanitize_text_field($_POST['event_location']));
    }
}
add_action('save_post', 'catholic_work_save_community_event_meta');