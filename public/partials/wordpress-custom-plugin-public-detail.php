<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://christophercasper.com/
 * @since      1.0.0
 *
 * @package    Wordpress_Custom_Plugin
 * @subpackage Wordpress_Custom_Plugin/public/partials
 */

// These next two lines are all that I can find on the way to override the blog posts coming through with custom templates in a plugin.
global $wp_query;
$wp_query->is_home = false;
// Some place to store our markup
$html = '';
// Lets grab the vehicle we're trying to show
$vehicle_vin = get_query_var('custom_plugin_vehicle');
// Instatiate our Custom Plugin Public Class
$custom_plugin_obj = new Wordpress_Custom_Plugin_Public('wordpress-custom-plugin', '1.0.0');
// Lets get the listings needed for this "page"
$vehicle = $custom_plugin_obj->get_vehicle_by_vin($vehicle_vin);
// Lets load the header of the site
get_header();
// We'll buid out the markup for the custom page
$html .= '<h1>VIN: '.$vehicle->vin.'</h1>';
$html .= '
    <ul>
        <li>Year: '.$vehicle->year.'</li>
        <li>Make: '.$vehicle->make.'</li>
        <li>Model: '.$vehicle->model.'</li>
        <li>Color: '.$vehicle->color.'</li>
    </ul>
    <a href="/custom-plugin">&laquo; Back to VIN Listings</a>
';
// Lets render out our html
echo($html);
// Load the footer
get_footer();
