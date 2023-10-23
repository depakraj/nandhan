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

// Create an admin menu item for managing tips, including the edit option.
function add_daily_tips_menu() {
    add_menu_page('Daily Tips', 'Daily Tips', 'manage_options', 'daily-tips', 'daily_tips_admin_page');
    add_submenu_page('daily-tips', 'Edit Tip', 'Edit Tip', 'manage_options', 'daily-tips&edit_tip', 'daily_tips_admin_page');
}

add_action('admin_menu', 'add_daily_tips_menu');

// Admin Page Callback Function
function daily_tips_admin_page() {
    if (isset($_POST['submit_tip'])) {
        // Handle the form submission and save the tip to the database.
        global $wpdb;
        $table_name = $wpdb->prefix . 'daily_tips';

        $tip_text = sanitize_text_field($_POST['tip_text']);
        $date = date('Y-m-d');

        if (!empty($_POST['tip_id'])) {
            // Update the existing tip.
            $tip_id = intval($_POST['tip_id']);
            $wpdb->update($table_name, array('tip_text' => $tip_text), array('id' => $tip_id));
        } else {
            // Add a new tip.
            $wpdb->insert($table_name, array('tip_text' => $tip_text, 'date' => $date));
        }
    }

    // Check if an ID is passed to edit a tip.
    $edit_tip_id = isset($_GET['edit_tip']) ? intval($_GET['edit_tip']) : 0;
    $edit_tip = '';

    if ($edit_tip_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'daily_tips';
        $edit_tip = $wpdb->get_row($wpdb->prepare("SELECT id, tip_text FROM $table_name WHERE id = %d", $edit_tip_id));
    }
    ?>
    <div class="wrap">
        <h2><?php echo $edit_tip ? 'Edit' : 'Add'; ?> Daily Tip</h2>
        <form method="post" action="">
            <div class="daily-tip-form">
                <textarea name="tip_text" rows="4" cols="50" placeholder="Enter your daily tip here" required><?php echo $edit_tip ? esc_textarea($edit_tip->tip_text) : ''; ?></textarea>
                <input type="hidden" name="tip_id" value="<?php echo $edit_tip ? $edit_tip->id : ''; ?>">
                <p class="submit">
                    <input type="submit" name="submit_tip" class="button-primary" value="<?php echo $edit_tip ? 'Update' : 'Add'; ?> Tip">
                </p>
            </div>
        </form>
        <h2>Manage Daily Tips</h2>
        <!-- Display the tips table as before. -->
    </div>
    <?php
}
