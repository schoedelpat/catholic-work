<?php
/**
 * Communications Component Functions
 * Integrates messaging, forums, and communication features
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Communications dashboard shortcode
function catholic_work_communications_dashboard_shortcode($atts) {
    if (!is_user_logged_in()) {
        return '<p>' . __('Please log in to access communications features.', 'catholic-work') . '</p>';
    }
    
    $atts = shortcode_atts(array(
        'show_messages' => 'true',
        'show_forums' => 'true',
        'show_announcements' => 'true',
    ), $atts);
    
    ob_start();
    ?>
    <div class="communications-dashboard">
        <div class="row">
            
            <?php if ($atts['show_messages'] === 'true') : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-envelope"></i> <?php _e('Messages', 'catholic-work'); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php echo catholic_work_get_recent_messages(); ?>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo esc_url(home_url('/messages')); ?>" class="btn btn-sm btn-primary">
                                <?php _e('View All Messages', 'catholic-work'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($atts['show_forums'] === 'true') : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-comments"></i> <?php _e('Forum Activity', 'catholic-work'); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php echo catholic_work_get_recent_forum_activity(); ?>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo esc_url(home_url('/forums')); ?>" class="btn btn-sm btn-primary">
                                <?php _e('Visit Forums', 'catholic-work'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($atts['show_announcements'] === 'true') : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-bullhorn"></i> <?php _e('Announcements', 'catholic-work'); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php echo catholic_work_get_recent_announcements(); ?>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo esc_url(home_url('/announcements')); ?>" class="btn btn-sm btn-primary">
                                <?php _e('All Announcements', 'catholic-work'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('communications_dashboard', 'catholic_work_communications_dashboard_shortcode');

// Get recent messages (placeholder function)
function catholic_work_get_recent_messages() {
    // This would integrate with BuddyPress messages or custom messaging system
    ob_start();
    ?>
    <ul class="list-unstyled">
        <li class="mb-2">
            <strong><?php _e('Welcome Message', 'catholic-work'); ?></strong>
            <small class="d-block text-muted">
                <?php _e('From: Admin - 1 hour ago', 'catholic-work'); ?>
            </small>
        </li>
        <li class="mb-2">
            <strong><?php _e('Event Reminder', 'catholic-work'); ?></strong>
            <small class="d-block text-muted">
                <?php _e('From: Events Team - 2 days ago', 'catholic-work'); ?>
            </small>
        </li>
    </ul>
    <small class="text-muted">
        <a href="#" class="text-decoration-none"><?php _e('Compose new message', 'catholic-work'); ?></a>
    </small>
    <?php
    return ob_get_clean();
}

// Get recent forum activity (placeholder function)
function catholic_work_get_recent_forum_activity() {
    // This would integrate with bbPress or custom forum system
    ob_start();
    ?>
    <ul class="list-unstyled">
        <li class="mb-2">
            <a href="#" class="text-decoration-none">
                <strong><?php _e('Catholic Social Teaching Discussion', 'catholic-work'); ?></strong>
            </a>
            <small class="d-block text-muted">
                <?php _e('3 new replies - 30 minutes ago', 'catholic-work'); ?>
            </small>
        </li>
        <li class="mb-2">
            <a href="#" class="text-decoration-none">
                <strong><?php _e('Community Garden Project', 'catholic-work'); ?></strong>
            </a>
            <small class="d-block text-muted">
                <?php _e('1 new reply - 2 hours ago', 'catholic-work'); ?>
            </small>
        </li>
    </ul>
    <?php
    return ob_get_clean();
}

// Get recent announcements
function catholic_work_get_recent_announcements() {
    $announcements = new WP_Query(array(
        'post_type' => 'announcement',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
    ));
    
    ob_start();
    
    if ($announcements->have_posts()) :
        echo '<ul class="list-unstyled">';
        while ($announcements->have_posts()) : $announcements->the_post();
            ?>
            <li class="mb-2">
                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                    <strong><?php the_title(); ?></strong>
                </a>
                <small class="d-block text-muted">
                    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                </small>
            </li>
            <?php
        endwhile;
        echo '</ul>';
        wp_reset_postdata();
    else :
        echo '<p class="text-muted">' . __('No recent announcements.', 'catholic-work') . '</p>';
    endif;
    
    return ob_get_clean();
}

// Newsletter signup form shortcode
function catholic_work_newsletter_signup_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => __('Stay Connected', 'catholic-work'),
        'description' => __('Subscribe to our newsletter for updates on community events, learning opportunities, and ways to get involved.', 'catholic-work'),
        'button_text' => __('Subscribe', 'catholic-work'),
    ), $atts);
    
    ob_start();
    ?>
    <div class="newsletter-signup">
        <h4><?php echo esc_html($atts['title']); ?></h4>
        <p><?php echo esc_html($atts['description']); ?></p>
        
        <form class="newsletter-form" action="#" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" name="first_name" placeholder="<?php _e('First Name', 'catholic-work'); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="email" class="form-control" name="email" placeholder="<?php _e('Email Address', 'catholic-work'); ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label"><?php _e('Interests (select all that apply):', 'catholic-work'); ?></label>
                <div class="row">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interests[]" value="community" id="interest_community">
                            <label class="form-check-label" for="interest_community">
                                <?php _e('Community Events', 'catholic-work'); ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interests[]" value="learning" id="interest_learning">
                            <label class="form-check-label" for="interest_learning">
                                <?php _e('Learning Opportunities', 'catholic-work'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interests[]" value="volunteer" id="interest_volunteer">
                            <label class="form-check-label" for="interest_volunteer">
                                <?php _e('Volunteer Opportunities', 'catholic-work'); ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interests[]" value="advocacy" id="interest_advocacy">
                            <label class="form-check-label" for="interest_advocacy">
                                <?php _e('Advocacy & Action', 'catholic-work'); ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> <?php echo esc_html($atts['button_text']); ?>
            </button>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('newsletter_signup', 'catholic_work_newsletter_signup_shortcode');

// Contact form shortcode
function catholic_work_contact_form_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => __('Get in Touch', 'catholic-work'),
        'recipient' => get_option('admin_email'),
    ), $atts);
    
    ob_start();
    ?>
    <div class="contact-form">
        <h4><?php echo esc_html($atts['title']); ?></h4>
        
        <form class="contact-form-container" action="#" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="contact_name" class="form-label"><?php _e('Name', 'catholic-work'); ?> *</label>
                    <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact_email" class="form-label"><?php _e('Email', 'catholic-work'); ?> *</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="contact_subject" class="form-label"><?php _e('Subject', 'catholic-work'); ?></label>
                <select class="form-select" id="contact_subject" name="contact_subject">
                    <option value=""><?php _e('Select a topic', 'catholic-work'); ?></option>
                    <option value="general"><?php _e('General Inquiry', 'catholic-work'); ?></option>
                    <option value="volunteer"><?php _e('Volunteer Opportunities', 'catholic-work'); ?></option>
                    <option value="events"><?php _e('Community Events', 'catholic-work'); ?></option>
                    <option value="learning"><?php _e('Learning Programs', 'catholic-work'); ?></option>
                    <option value="donation"><?php _e('Donations & Support', 'catholic-work'); ?></option>
                    <option value="media"><?php _e('Media Inquiry', 'catholic-work'); ?></option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="contact_message" class="form-label"><?php _e('Message', 'catholic-work'); ?> *</label>
                <textarea class="form-control" id="contact_message" name="contact_message" rows="5" required></textarea>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="contact_newsletter" name="contact_newsletter">
                    <label class="form-check-label" for="contact_newsletter">
                        <?php _e('I would like to receive newsletter updates', 'catholic-work'); ?>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> <?php _e('Send Message', 'catholic-work'); ?>
            </button>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('contact_form', 'catholic_work_contact_form_shortcode');

// Communications widget for announcements
class Catholic_Work_Announcements_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'catholic_work_announcements',
            __('Recent Announcements', 'catholic-work'),
            array('description' => __('Display recent announcements', 'catholic-work'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $limit = !empty($instance['limit']) ? $instance['limit'] : 5;
        
        $announcements = new WP_Query(array(
            'post_type' => 'announcement',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        if ($announcements->have_posts()) :
            echo '<ul class="announcements-list list-unstyled">';
            while ($announcements->have_posts()) : $announcements->the_post();
                ?>
                <li class="mb-3">
                    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                        <strong><?php the_title(); ?></strong>
                    </a>
                    <small class="d-block text-muted mb-1">
                        <i class="fas fa-clock"></i> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                    </small>
                    <p class="mb-0 small"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                </li>
                <?php
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        else :
            echo '<p>' . __('No announcements available.', 'catholic-work') . '</p>';
        endif;
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Announcements', 'catholic-work');
        $limit = !empty($instance['limit']) ? $instance['limit'] : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'catholic-work'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php _e('Number of announcements:', 'catholic-work'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('limit')); ?>" name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="number" value="<?php echo esc_attr($limit); ?>" min="1" max="10">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit'])) ? absint($new_instance['limit']) : 5;
        return $instance;
    }
}

// Register communications widgets
function catholic_work_register_communications_widgets() {
    register_widget('Catholic_Work_Announcements_Widget');
}
add_action('widgets_init', 'catholic_work_register_communications_widgets');

// Add bbPress support for forums
function catholic_work_bbpress_support() {
    add_theme_support('bbpress');
}
add_action('after_setup_theme', 'catholic_work_bbpress_support');