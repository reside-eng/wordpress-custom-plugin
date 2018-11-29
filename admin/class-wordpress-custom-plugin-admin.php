<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://christophercasper.com/
 * @since      1.0.0
 *
 * @package    Wordpress_Custom_Plugin
 * @subpackage Wordpress_Custom_Plugin/admin
 */

 // Lots of help, borrowed code from: https://github.com/rayman813/smashing-custom-fields/blob/master/smashing-fields-approach-1/smashing-fields.php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Custom_Plugin
 * @subpackage Wordpress_Custom_Plugin/admin
 * @author     Christopher Casper <me@christophercasper.com>
 */
class Wordpress_Custom_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Lets add an action to setup the admin menu in the left nav
		add_action( 'admin_menu', array($this, 'add_admin_menu') );
		// Add some actions to setup the settings we want on the wp admin page
		add_action('admin_init', array($this, 'setup_sections'));
		add_action('admin_init', array($this, 'setup_fields'));
	}

	/**
	 * Add the menu items to the admin menu
	 *
	 * @since    1.0.0
	 */
	public function add_admin_menu() {

		// Main Menu Item
	  	add_menu_page(
			'Custom Plugin',
			'Custom Plugin',
			'manage_options',
			'custom-plugin',
			array($this, 'display_custom_plugin_admin_page'),
			'dashicons-store',
			1);

		// Sub Menu Item One
		add_submenu_page(
			'custom-plugin',
			'Settings',
			'Settings',
			'manage_options',
			'custom-plugin',
			array($this, 'display_custom_plugin_admin_page')
		);
		// Sub Menu Item Two
		add_submenu_page(
			'custom-plugin',
			'Secondary Page',
			'Secondary Page',
			'manage_options',
			'custom-plugin/settings-page-two',
			array($this, 'display_custom_plugin_admin_page_two')
		);
	}

	/**
	 * Callback function for displaying the admin settings page.
	 *
	 * @since    1.0.0
	 */
	public function display_custom_plugin_admin_page(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/wordpress-custom-plugin-admin-display.php';
	}

	/**
	 * Callback function for displaying the second sub menu item page.
	 *
	 * @since    1.0.0
	 */
	public function display_custom_plugin_admin_page_two(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/wordpress-custom-plugin-admin-two-display.php';
	}

	/**
	 * Setup sections in the settings
	 *
	 * @since    1.0.0
	 */
	public function setup_sections() {
		add_settings_section( 'section_one', 'Section One', array($this, 'section_callback'), 'wordpress-custom-plugin-options' );
		add_settings_section( 'section_two', 'Section Two', array($this, 'section_callback'), 'wordpress-custom-plugin-options' );
	}

	/**
	 * Callback for each section
	 *
	 * @since    1.0.0
	 */
	public function section_callback( $arguments ) {
		switch( $arguments['id'] ){
			case 'section_one':
				echo '<p>This is settings for section one, you can put some more information here if needed.</p>';
				break;
			case 'section_two':
				echo '<p>Section two! More information on this section can go here.</p>';
				break;
		}
	}

	/**
	 * Field Configuration, each item in this array is one field/setting we want to capture
	 *
	 * @since    1.0.0
	 */
	public function setup_fields() {
		$fields = array(
			array(
				'uid' => 'custom_plugin_image_example',
				'label' => 'Image Example',
				'section' => 'section_one',
				'type' => 'image',
				'helper' => 'This is where some helper text could go for this image settings',
				'supplemental' => '',
				'default' => plugin_dir_url( dirname( __FILE__ )) . 'public/img/markus-spiske-109588-unsplash.jpg',
			),
			array(
				'uid' => 'custom_plugin_text_example',
				'label' => 'Text Example',
				'section' => 'section_one',
				'type' => 'text',
				'placeholder' => 'Example text placegolder',
				'helper' => 'You can enter some helper text here on what to do with this field.',
				'supplemental' => 'Here we can tell the user what format to enter if needed.',
				'default' => "DEFAULT PLACEHOLDER TEXT",
			),
			array(
				'uid' => 'custom_plugin_checkbox_example',
				'label' => 'Checkbox Example',
				'section' => 'section_one',
				'type' => 'checkbox',
				'helper' => 'Click this checkbox to select it.',
				'supplemental' => '',
				'options' => array(
					'selected' => 'Select this checkbox.',
				),
				'default' => array(),
			),
			array(
				'uid' => 'custom_plugin_password_example',
				'label' => 'Sample Password Field',
				'section' => 'section_one',
				'type' => 'password',
			),
			array(
				'uid' => 'custom_plugin_number_example',
				'label' => 'Sample Number Field',
				'section' => 'section_two',
				'type' => 'number',
			),
			array(
				'uid' => 'custom_plugin_textarea_example',
				'label' => 'Sample Text Area',
				'section' => 'section_two',
				'type' => 'textarea',
			),
			array(
				'uid' => 'custom_plugin_select_example',
				'label' => 'Sample Select Dropdown',
				'section' => 'section_two',
				'type' => 'select',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
				'uid' => 'custom_plugin_multiselect_example',
				'label' => 'Sample Multi Select',
				'section' => 'section_two',
				'type' => 'multiselect',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
				'uid' => 'custom_plugin_radio_example',
				'label' => 'Sample Radio Buttons',
				'section' => 'section_two',
				'type' => 'radio',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
			'uid' => 'custom_plugin_checkboxes_example',
			'label' => 'Sample Checkboxes',
			'section' => 'section_two',
			'type' => 'checkbox',
			'options' => array(
				'option1' => 'Option 1',
				'option2' => 'Option 2',
				'option3' => 'Option 3',
				'option4' => 'Option 4',
				'option5' => 'Option 5',
			),
			'default' => array()
			)
		);
		// Lets go through each field in the array and set it up
		foreach( $fields as $field ){
			add_settings_field( $field['uid'], $field['label'], array($this, 'field_callback'), 'wordpress-custom-plugin-options', $field['section'], $field );
			register_setting( 'wordpress-custom-plugin-options', $field['uid'] );
		}
	}

	/**
	 * This handles all types of fields for the settings
	 *
	 * @since    1.0.0
	 */
	public function field_callback($arguments) {
		// Set our $value to that of whats in the DB
		$value = get_option( $arguments['uid'] );
		// Only set it to default if we get no value from the DB and a default for the field has been set
		if(!$value) {
			$value = $arguments['default'];
		}
		// Lets do some setup based ont he type of element we are trying to display.
		switch( $arguments['type'] ){
			case 'text':
			case 'password':
			case 'number':
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
				break;
			case 'textarea':
				printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value );
				break;
			case 'select':
			case 'multiselect':
				if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
					$attributes = '';
					$options_markup = '';
					foreach( $arguments['options'] as $key => $label ){
						$options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
					}
					if( $arguments['type'] === 'multiselect' ){
						$attributes = ' multiple="multiple" ';
					}
					printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
				}
				break;
			case 'radio':
			case 'checkbox':
				if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
					$options_markup = '';
					$iterator = 0;
					foreach( $arguments['options'] as $key => $label ){
						$iterator++;
						$is_checked = '';
						// This case handles if there is only one checkbox and we don't have anything saved yet.
						if(isset($value[ array_search( $key, $value, true ) ])) {
							$is_checked = checked( $value[ array_search( $key, $value, true ) ], $key, false );
						} else {
							$is_checked = "";
						}
						// Lets build out the checkbox
						$options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, $is_checked, $label, $iterator );
					}
					printf( '<fieldset>%s</fieldset>', $options_markup );
				}
				break;
			case 'image':
				// Some code borrowed from: https://mycyberuniverse.com/integration-wordpress-media-uploader-plugin-options-page.html
				$options_markup = '';
				$image = [];
				$image['id'] = '';
				$image['src'] = '';

				// Setting the width and height of the header iamge here
				$width = '1800';
				$height = '1068';

				// Lets get the image src
				$image_attributes = wp_get_attachment_image_src( $value, array( $width, $height ) );
				// Lets check if we have a valid image
				if ( !empty( $image_attributes ) ) {
					// We have a valid option saved
					$image['id'] = $value;
					$image['src'] = $image_attributes[0];
				} else {
					// Default
					$image['id'] = '';
					$image['src'] = $value;
				}

				// Lets build our html for the image upload option
				$options_markup .= '
				<img data-src="' . $image['src'] . '" src="' . $image['src'] . '" width="180px" height="107px" />
				<div>
					<input type="hidden" name="' . $arguments['uid'] . '" id="' . $arguments['uid'] . '" value="' . $image['id'] . '" />
					<button type="submit" class="upload_image_button button">Upload</button>
					<button type="submit" class="remove_image_button button">&times; Delete</button>
				</div>';
				printf('<div class="upload">%s</div>',$options_markup);
				break;
		}
		// If there is helper text, lets show it.
		if( array_key_exists('helper',$arguments) && $helper = $arguments['helper']) {
			printf( '<span class="helper"> %s</span>', $helper );
		}
		// If there is supplemental text lets show it.
		if( array_key_exists('supplemental',$arguments) && $supplemental = $arguments['supplemental'] ){
			printf( '<p class="description">%s</p>', $supplemental );
		}
	}

	/**
	 * Admin Notice
	 * 
	 * This displays the notice in the admin page for the user
	 *
	 * @since    1.0.0
	 */
	public function admin_notice($message) { ?>
		<div class="notice notice-success is-dismissible">
			<p><?php echo($message); ?></p>
		</div><?php
	}

	/**
	 * This handles setting up the rewrite rules for Past Sales
	 *
	 * @since    1.0.0
	 */
	public function setup_rewrites() {
		//
		$url_slug = 'custom-plugin';
		// Lets setup our rewrite rules
		add_rewrite_rule( $url_slug . '/?$', 'index.php?custom_plugin=index', 'top' );
		add_rewrite_rule( $url_slug . '/page/([0-9]{1,})/?$', 'index.php?custom_plugin=items&custom_plugin_paged=$matches[1]', 'top' );
		add_rewrite_rule( $url_slug . '/([a-zA-Z0-9\-]{1,})/?$', 'index.php?custom_plugin=detail&custom_plugin_vehicle=$matches[1]', 'top' );


		// Lets flush rewrite rules on activation
		flush_rewrite_rules();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Custom_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Custom_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-custom-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Custom_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Custom_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-custom-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}

}
