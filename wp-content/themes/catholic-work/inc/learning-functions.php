<?php
/**
 * Learning Component Functions
 * Integrates LearnDash and educational features
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add LearnDash support
function catholic_work_learndash_support() {
    add_theme_support('learndash');
}
add_action('after_setup_theme', 'catholic_work_learndash_support');

// Learning progress shortcode
function catholic_work_learning_progress_shortcode($atts) {
    $atts = shortcode_atts(array(
        'user_id' => get_current_user_id(),
    ), $atts);
    
    if (!is_user_logged_in()) {
        return '<p>' . __('Please log in to view your learning progress.', 'catholic-work') . '</p>';
    }
    
    ob_start();
    ?>
    <div class="learning-progress">
        <h4><?php _e('Your Learning Progress', 'catholic-work'); ?></h4>
        
        <?php
        // Check if LearnDash is active
        if (function_exists('learndash_user_get_enrolled_courses')) {
            $user_courses = learndash_user_get_enrolled_courses($atts['user_id']);
            
            if (!empty($user_courses)) :
                foreach ($user_courses as $course_id) :
                    $course_progress = learndash_user_get_course_progress($atts['user_id'], $course_id);
                    $progress_percentage = ($course_progress['completed'] / $course_progress['total']) * 100;
                    ?>
                    <div class="course-progress mb-3">
                        <h6><a href="<?php echo get_permalink($course_id); ?>"><?php echo get_the_title($course_id); ?></a></h6>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $progress_percentage; ?>%" 
                                 aria-valuenow="<?php echo $progress_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo round($progress_percentage); ?>%
                            </div>
                        </div>
                        <small class="text-muted">
                            <?php echo $course_progress['completed']; ?> of <?php echo $course_progress['total']; ?> lessons completed
                        </small>
                    </div>
                    <?php
                endforeach;
            else :
                echo '<p>' . __('You are not enrolled in any courses yet.', 'catholic-work') . '</p>';
            endif;
        } else {
            // Fallback for when LearnDash is not active
            ?>
            <div class="course-progress mb-3">
                <h6>Catholic Social Teaching Fundamentals</h6>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        75%
                    </div>
                </div>
                <small class="text-muted">6 of 8 lessons completed</small>
            </div>
            
            <div class="course-progress mb-3">
                <h6>Community Organizing Basics</h6>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                        45%
                    </div>
                </div>
                <small class="text-muted">3 of 6 lessons completed</small>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('learning_progress', 'catholic_work_learning_progress_shortcode');

// Featured courses shortcode
function catholic_work_featured_courses_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 6,
        'columns' => 3,
    ), $atts);
    
    ob_start();
    ?>
    <div class="featured-courses">
        <div class="row">
            <?php
            // Query for courses (LearnDash post type is 'sfwd-courses')
            $courses_query = new WP_Query(array(
                'post_type' => function_exists('learndash_get_post_type_slug') ? learndash_get_post_type_slug('course') : 'learning_resource',
                'posts_per_page' => $atts['limit'],
                'meta_key' => 'featured_course',
                'meta_value' => '1',
            ));
            
            if ($courses_query->have_posts()) :
                while ($courses_query->have_posts()) : $courses_query->the_post();
                    ?>
                    <div class="col-md-<?php echo 12 / $atts['columns']; ?> mb-4">
                        <div class="course-card card h-100">
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
                                
                                <?php
                                // Course meta information
                                $course_duration = get_post_meta(get_the_ID(), 'course_duration', true);
                                $course_level = get_post_meta(get_the_ID(), 'course_level', true);
                                ?>
                                
                                <div class="course-meta mb-3">
                                    <?php if ($course_duration) : ?>
                                        <small class="text-muted me-3">
                                            <i class="fas fa-clock"></i> <?php echo esc_html($course_duration); ?>
                                        </small>
                                    <?php endif; ?>
                                    <?php if ($course_level) : ?>
                                        <small class="text-muted">
                                            <i class="fas fa-signal"></i> <?php echo esc_html($course_level); ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
                                    <?php _e('Learn More', 'catholic-work'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback courses if none exist
                for ($i = 1; $i <= 3; $i++) :
                    ?>
                    <div class="col-md-<?php echo 12 / $atts['columns']; ?> mb-4">
                        <div class="course-card card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Sample Course <?php echo $i; ?></h5>
                                <p class="card-text">This is a sample course description to demonstrate the layout.</p>
                                <div class="course-meta mb-3">
                                    <small class="text-muted me-3">
                                        <i class="fas fa-clock"></i> 4 weeks
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-signal"></i> Beginner
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <?php
                endfor;
            endif;
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('featured_courses', 'catholic_work_featured_courses_shortcode');

// Learning resources widget
class Catholic_Work_Learning_Resources_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'catholic_work_learning_resources',
            __('Learning Resources', 'catholic-work'),
            array('description' => __('Display featured learning resources', 'catholic-work'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $resources = new WP_Query(array(
            'post_type' => 'learning_resource',
            'posts_per_page' => 5,
            'meta_key' => 'featured_resource',
            'meta_value' => '1',
        ));
        
        if ($resources->have_posts()) :
            echo '<ul class="learning-resources-list list-unstyled">';
            while ($resources->have_posts()) : $resources->the_post();
                ?>
                <li class="mb-2">
                    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                        <strong><?php the_title(); ?></strong>
                    </a>
                    <small class="d-block text-muted">
                        <?php echo wp_trim_words(get_the_excerpt(), 10); ?>
                    </small>
                </li>
                <?php
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        else :
            echo '<p>' . __('No learning resources available.', 'catholic-work') . '</p>';
        endif;
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Featured Resources', 'catholic-work');
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

// Register learning widgets
function catholic_work_register_learning_widgets() {
    register_widget('Catholic_Work_Learning_Resources_Widget');
}
add_action('widgets_init', 'catholic_work_register_learning_widgets');

// Add learning-specific meta boxes
function catholic_work_learning_meta_boxes() {
    add_meta_box(
        'learning_resource_details',
        __('Resource Details', 'catholic-work'),
        'catholic_work_learning_resource_meta_box_callback',
        'learning_resource',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'catholic_work_learning_meta_boxes');

function catholic_work_learning_resource_meta_box_callback($post) {
    wp_nonce_field('catholic_work_learning_resource_meta_box', 'catholic_work_learning_resource_meta_box_nonce');
    
    $course_duration = get_post_meta($post->ID, 'course_duration', true);
    $course_level = get_post_meta($post->ID, 'course_level', true);
    $featured_resource = get_post_meta($post->ID, 'featured_resource', true);
    ?>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="course_duration"><?php _e('Course Duration', 'catholic-work'); ?></label></th>
            <td><input type="text" id="course_duration" name="course_duration" value="<?php echo esc_attr($course_duration); ?>" placeholder="e.g., 4 weeks, 2 hours" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="course_level"><?php _e('Course Level', 'catholic-work'); ?></label></th>
            <td>
                <select id="course_level" name="course_level">
                    <option value=""><?php _e('Select Level', 'catholic-work'); ?></option>
                    <option value="Beginner" <?php selected($course_level, 'Beginner'); ?>><?php _e('Beginner', 'catholic-work'); ?></option>
                    <option value="Intermediate" <?php selected($course_level, 'Intermediate'); ?>><?php _e('Intermediate', 'catholic-work'); ?></option>
                    <option value="Advanced" <?php selected($course_level, 'Advanced'); ?>><?php _e('Advanced', 'catholic-work'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="featured_resource"><?php _e('Featured Resource', 'catholic-work'); ?></label></th>
            <td>
                <input type="checkbox" id="featured_resource" name="featured_resource" value="1" <?php checked($featured_resource, '1'); ?> />
                <label for="featured_resource"><?php _e('Mark as featured', 'catholic-work'); ?></label>
            </td>
        </tr>
    </table>
    <?php
}

// Save learning resource meta data
function catholic_work_save_learning_resource_meta($post_id) {
    if (!isset($_POST['catholic_work_learning_resource_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['catholic_work_learning_resource_meta_box_nonce'], 'catholic_work_learning_resource_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (isset($_POST['post_type']) && 'learning_resource' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }
    
    if (isset($_POST['course_duration'])) {
        update_post_meta($post_id, 'course_duration', sanitize_text_field($_POST['course_duration']));
    }
    
    if (isset($_POST['course_level'])) {
        update_post_meta($post_id, 'course_level', sanitize_text_field($_POST['course_level']));
    }
    
    $featured = isset($_POST['featured_resource']) ? '1' : '0';
    update_post_meta($post_id, 'featured_resource', $featured);
}
add_action('save_post', 'catholic_work_save_learning_resource_meta');