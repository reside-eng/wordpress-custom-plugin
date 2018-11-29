<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://christophercasper.com/
 * @since      1.0.0
 *
 * @package    Wordpress_Custom_Plugin
 * @subpackage Wordpress_Custom_Plugin/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
  <h1>Wordpress Custom Plugin Settings</h1>
  <?php
  // Let see if we have a caching notice to show
  $admin_notice = get_option('custom_wordpress_plugin_admin_notice');
  if($admin_notice) {
    // We have the notice from the DB, lets remove it.
    delete_option( 'custom_wordpress_plugin_admin_notice' );
    // Call the notice message
    $this->admin_notice($admin_notice);
  }
  if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ){
    $this->admin_notice("Your settings have been updated!");
  }
  ?>
  <form method="POST" action="options.php">
  <?php
    settings_fields('wordpress-custom-plugin-options');
    do_settings_sections('wordpress-custom-plugin-options');
    submit_button();
  ?>
  </form>
</div>