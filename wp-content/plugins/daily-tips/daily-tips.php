<?php
/*
Plugin Name: Daily Tip
Description: Display and manage daily tips.
Version: 2.0
Author: depaksampath
*/

global $wpdb;
$tablename = $wpdb->prefix . 'daily_tips';

// Create the custom database table for daily tips
function create_daily_tips_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'daily_tips';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        tip text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_daily_tips_table');

// Create the admin menu
function daily_tip_menu() {
    add_menu_page(
        'Daily Tip',
        'Daily Tip',
        'manage_options',
        'daily-tip',
        'daily_tip_management_page'
    );
}
add_action('admin_menu', 'daily_tip_menu');

// Display the management page
function daily_tip_management_page() {
    global $wpdb;

    if (isset($_POST['save_tip'])) {
        $tip = sanitize_text_field($_POST['daily_tip']);
        $wpdb->insert($wpdb->prefix . 'daily_tips', array('tip' => $tip));
        echo '<div class="updated"><p>Tip added successfully.</p></div>';
    }

    $tips = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}daily_tips");
    ?>
    <div class="wrap">
        <h2>Daily Tip Management</h2>
        <h3>Add a Tip</h3>
        <form method="post" action="">
            <label for="daily_tip">Daily Tip:</label><br>
            <textarea id="daily_tip" name="daily_tip" rows="5" cols="50"></textarea><br>
            <input type="submit" name="save_tip" class="button button-primary" value="Add Tip">
        </form>

        <h3>Manage Tips</h3>
        <table class="wp-list-table widefat fixed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tip</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($tips) {
                    foreach ($tips as $tip) {
                        ?>
                        <tr>
                            <td><?php echo $tip->id; ?></td>
                            <td><?php echo esc_html($tip->tip); ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="tip_id" value="<?php echo $tip->id; ?>">
                                    <input type="submit" name="edit_tip" class="button button-secondary" value="Edit">
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="3">No tips added yet.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Create a shortcode to display the daily tip
function daily_tip_shortcode() {
    global $wpdb;
    $tip = $wpdb->get_var("SELECT tip FROM {$wpdb->prefix}daily_tips ORDER BY RAND() LIMIT 1");
    if ($tip) {
        return '<div class="daily-tip">' . esc_html($tip) . '</div>';
    }
    return ''; // Return an empty string if there's no tip.
}
add_shortcode('daily_tip', 'daily_tip_shortcode');
