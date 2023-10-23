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
    $tip = get_option('daily_tip');
    if (!empty($tip)) {
        return '<div class="daily-tip">' . esc_html($tip) . '</div>';
    }
    return ''; // Return an empty string if there's no tip.
}
add_shortcode('daily_tip', 'daily_tip_shortcode');

<?php


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
            <input type="submit" name="delete_tip" class "button button-secondary" value="Delete Tip">
        </form>
    </div>
    <?php
}

// Create a shortcode to display the daily tip
function daily_tip_shortcode() {
    $tip = get_option('daily_tip');
    if (!empty($tip)) {
        return '<div class="daily-tip">' . esc_html($tip) . '</div>';
    }
    return ''; // Return an empty string if there's no tip.
}
add_shortcode('daily_tip', 'daily_tip_shortcode');

// Create a function to display the tips management page
function daily_tip_management_page() {
    ?>
    <div class="wrap">
        <h2>Daily Tip Management</h2>

        <?php
        if (isset($_GET['action']) && isset($_GET['tip_id'])) {
            // Handle actions for editing or deleting a specific tip.
            if ($_GET['action'] === 'edit') {
                // Load the tip for editing.
                $tip_id = sanitize_text_field($_GET['tip_id']);
                $tip = get_option('daily_tip_' . $tip_id);
                ?>
                <h3>Edit Tip</h3>
                <form method="post" action="">
                    <input type="hidden" name="tip_id" value="<?php echo $tip_id; ?>">
                    <label for="daily_tip">Daily Tip:</label><br>
                    <textarea id="daily_tip" name="daily_tip" rows="5" cols="50"><?php echo esc_textarea($tip); ?></textarea><br>
                    <input type="submit" name="save_edited_tip" class="button button-primary" value="Save Edited Tip">
                </form>
                <?php
            } elseif ($_GET['action'] === 'delete') {
                // Delete the selected tip.
                $tip_id = sanitize_text_field($_GET['tip_id']);
                delete_option('daily_tip_' . $tip_id);
                echo '<div class="updated"><p>Tip deleted successfully.</p></div>';
            }
        } elseif (isset($_POST['save_edited_tip']) && isset($_POST['tip_id'])) {
            // Save the edited tip.
            $tip_id = sanitize_text_field($_POST['tip_id']);
            update_option('daily_tip_' . $tip_id, sanitize_text_field($_POST['daily_tip']));
            echo '<div class="updated"><p>Tip edited and saved successfully.</p></div>';
        }

        // Display the list of tips for management.
        $tips = get_all_daily_tips();
        if (!empty($tips)) {
            ?>
            <h3>Manage Tips</h3>
            <table class="wp-list-table widefat fixed">
                <thead>
                    <tr>
                        <th>Tip</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tips as $tip_id => $tip) {
                        ?>
                        <tr>
                            <td><?php echo esc_html($tip); ?></td>
                            <td>
                                <a href="?page=daily-tip-management&action=edit&tip_id=<?php echo $tip_id; ?>">Edit</a> |
                                <a href="?page=daily-tip-management&action=delete&tip_id=<?php echo $tip_id; ?>" onclick="return confirm('Are you sure you want to delete this tip?')">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo '<p>No tips added yet.</p>';
        }
        ?>
    </div>
    <?php
}

// Create a function to retrieve all daily tips
function get_all_daily_tips() {
    $tips = array();
    $tip_id = 1;
    while ($tip = get_option('daily_tip_' . $tip_id)) {
        $tips[$tip_id] = $tip;
        $tip_id++;
    }
    return $tips;
}

// Add the management page to the admin menu
function add_daily_tip_management_menu() {
    add_submenu_page(
        'options-general.php',
        'Daily Tip Management',
        'Daily Tip Management',
        'manage_options',
        'daily-tip-management',
        'daily_tip_management_page'
    );
}
add_action('admin_menu', 'add_daily_tip_management_menu');
