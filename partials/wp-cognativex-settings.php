<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       plugin_name.com/team
 * @since      1.0.0
 *
 * @package    PluginName
 * @subpackage PluginName/admin/partials
 */
?>
<?php
if (get_option('wp_cognativex_plugin_notice')) {

    $message = explode('-', get_option('wp_cognativex_plugin_notice'), 2);
    $message_type = $message[0];
    $message_content = $message[1];
    ?>
    <div class="notice notice-<?php echo $message_type; ?>">
        <p>
            <?php echo $message_content; ?>
        </p>
    </div>
    <?php
    delete_option('wp_cognativex_plugin_notice');

}
?>
<div class="wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2>CognativeX Settings</h2>
    <!--NEED THE settings_errors below so that the errors/success messages are shown after submission - wasn't working once we started using add_menu_page and stopped using add_options_page so needed this-->
    <form method="POST" action="options.php">
        <?php
        settings_fields('wp_cognativex_general_settings');
        do_settings_sections('wp_cognativex_general_settings');
        ?>
        <?php submit_button(); ?>
    </form>
</div>