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
// Set our current page for pagination
$custom_plugin_current_page = get_query_var('custom_plugin_paged') > 0 ? get_query_var('custom_plugin_paged') : 1;
// Instatiate our Custom Plugin Public Class
$custom_plugin_obj = new Wordpress_Custom_Plugin_Public('wordpress-custom-plugin', '1.0.0');
// Lets get the listings needed for this "page"
$vehicle_listings = $custom_plugin_obj->get_vehicle_listings(10, $custom_plugin_current_page);
// Lets load the header of the site
get_header();
$html .= '
    <h1>WordPress Custom Plugin</h1>
    <p>This will show off pagination.</p>
';
$html .= '<ul>';
// Lets loop through and list all the vehicles for this page
foreach ($vehicle_listings['vehicles'] as $vehicle) {
    $html .= '<li><a href="/custom-plugin/'.$vehicle->vin.'">'.$vehicle->year.' '.$vehicle->make.' '.$vehicle->model.'</a></li>';
}// END foreach
$html .= '</ul>';
$html .= $custom_plugin_obj->generatePagination($vehicle_listings['page_count'], $custom_plugin_current_page);
// Lets render out our html
echo($html);
// Load the footer
get_footer();
