<?php
/*
Plugin Name: Daily Tip
Description: Display and manage daily tips.
Version: 1.1
Author: depaksampath
*/

// Create the admin menu
function daily_tip_menu() {
    add_submenu_page(
        'options-general.php',
        'Daily Tip Settings',
        'Daily Tip',
        'manage_options',
        'daily-tip-settings',
        'daily_tip_settings_page'
    );
}
add_action('admin_menu', 'daily_tip_menu');

// Create the settings page
function daily_tip_settings_page() {
    if (isset($_POST['save_tip'])) {
        // Save or update the daily tip.
        update_option('daily_tip', sanitize_text_field($_POST['daily_tip']));
    }

    if (isset($_POST['delete_tip'])) {
        // Delete the daily tip.
        delete_option('daily_tip');
    }

    $tip = get_option('daily_tip');
    ?>
    <div class="wrap">
        <h2>Daily Tip Settings</h2>
        <form method="post">
            <label for="daily_tip">Daily Tip:</label><br>
            <textarea id="daily_tip" name="daily_tip" rows="5" cols="50"><?php echo esc_textarea($tip); ?></textarea><br>
            <input type="submit" name="save_tip" class="button button-primary" value="Save Tip">
            <input type="submit" name="delete_tip" class="button button-secondary" value="Delete Tip">
        </form>
    </div>
    <?php
}

// Create a shortcode to display the daily tip
function daily_tip_shortcode($atts) {
    $atts = shortcode_atts(array(
        'show_in_footer' => 'false',
    ), $atts);

    $show_in_footer = filter_var($atts['show_in_footer'], FILTER_VALIDATE_BOOLEAN);

    if ($show_in_footer) {
        $tip = get_option('daily_tip');
        if (!empty($tip)) {
            return '<div class="daily-tip">' . esc_html($tip) . '</div>';
        }
    }

    return ''; // Return an empty string if not showing in the footer.
}
add_shortcode('daily_tip', 'daily_tip_shortcode');
