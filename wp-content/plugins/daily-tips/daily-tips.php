<?php
/*
Plugin Name: Daily Tips
Description: Display daily tips to users.
Version: 1.1
Author: depaksampath
*/

// Create the daily tips table on activation.
function daily_tips_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'daily_tips';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        tip_text text NOT NULL,
        date date NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'daily_tips_activate');

// Function to display the daily tip.
function display_daily_tip() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'daily_tips';
    $today = date('Y-m-d');

    $tip = $wpdb->get_var($wpdb->prepare("SELECT tip_text FROM $table_name WHERE date = %s", $today));

    if ($tip) {
        echo "<div class='daily-tip'>$tip</div>";
    }
}

// Add action to display the daily tip in the footer.
add_action('wp_footer', 'display_daily_tip');

// Widget to display the daily tip.
class Daily_Tip_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'daily_tip_widget',
            'Daily Tip Widget',
            array('description' => 'Display the daily tip.')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . 'Daily Tip' . $args['after_title'];
        display_daily_tip();
        echo $args['after_widget'];
    }

    public function form($instance) {
        // Widget settings form.
    }

    public function update($new_instance, $old_instance) {
        // Save widget settings.
    }
}

function register_daily_tip_widget() {
    register_widget('Daily_Tip_Widget');
}

add_action('widgets_init', 'register_daily_tip_widget');
?>
