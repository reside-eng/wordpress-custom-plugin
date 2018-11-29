# Writing a WordPress Plugin
At Reside we focus on reliably growing our agent's business. Part of this growth strategy includes establishing a strong online presence. In comes WordPress. While working with and managing 30+ WordPress sites, we have used several great themes and plugins that allow us to quickly and easily roll out amazing sites to our agents. However, we've come to realize that themes and plugins are not one size fit all. We often run into complications when needing to start adding new functionality or modifying the way existing features work. Sometimes a minor tweak to a plugin template file will be enough, but sometimes we need access and modify 3rd party data. The easiest way to accomplish this is to incorporate 3rd party data into a new custom plugin.

## 6 Concepts I Learned About When Creating a WordPress Plugin
We had a case where we needed to access 3rd party data that was not offered within a current plugin and display it in a certain format. Since this was my first time rolling out a custom plugin for WordPress, there were a lot of concepts I had to figure out. I am hoping through my experience I can help other developers find their way to writing their first WordPress plugin. Here is an outline of key areas I had to figure out for my plugin. Note: you will be able to find a complete example plugin [here](https://github.com/chriscasper/wordpress-custom-plugin).

- Plugin Boilerplate
- WP Admin Dashboard Menu Items
- WP Admin Dashboard Settings Page for Plugin
- URL Rewrites for Custom Plugin URLs
- Displaying Custom Data on Plugin Pages
- Pagination for Custom Plugin Data

---
## Plugin Boilerplate
The first step in building a plugin is laying the foundation. The best approach for this is to rely on the groundwork laid down by seasoned developers who routinely build WordPress plugins. So we'll use the [Wordpress Plugin Boilerplate Generator](https://wppb.me/). This allows us to enter a few key configurations and it automatically builds out the scaffolding for your plugin with everything neatly organized.

![WordPress Plugin Boilerplate Generator](../assets/wppb.me_.png)

The generator just needs a few things filled out:
- Plugin Name: Name of the plugin.
- Plugin Slug: This is used internally within WordPress for the plugin. Make sure it's all lowercase
- Plugin URI - Website address of the plugin.
- Author Name: Author's Name
- Author Email: Author's email address.
- Author URI: Author's website address.

After you have everything filled out just click "Build Plugin". Once it is finished downloading just unzip it and move the folder into the `/wp-content/plugins` folder within your WordPress install.

## WP Admin Dashboard Menu Items
Now that we have the base scaffolding in place for the plugin, let's focus on giving the plugin an area to manage it's settings. For that we will add a need to add a menu item first so we can navigate to it.

For this there is a couple built in WordPress functions we need to utilize. First there is [`add_menu_page()`](https://developer.wordpress.org/reference/functions/add_menu_page/) and [`add_submenu_page()`](https://developer.wordpress.org/reference/functions/add_submenu_page/).

With these two functions we can add a main (parent) menu item along with two children items. In this case we are adding a settings page and a secondary page.

**Note:** A good rule of thumb is to make the parent menu item and the first child menu item go to the same page. if you are intending to have more than one page. In order to do this, both the parent and first child menu items need to have the same menu slug.

![WP Admin Menu](../assets/admin-menu.png)

From the image you can see how the following code will add a main menu item, then 2 additional sub menu items. Fist we will use `add_menu_page` to add the main menu item. Then we will use `add_submenu_page` to add each child menu item.

``` php
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
```

For this next bit we will need to work with WordPress actions to get the menu items to render out. You can read more on [WordPress Actions here](https://developer.wordpress.org/reference/functions/add_action/). They are pretty straightforward to work with. Basically we are just utilizing one of WordPress's hooks. We just need to tell WordPress which hook we want to have the function called and what the function name is.

In order to implement this in the plugin we will need to call the menu functions at the right time. To do that we will put these function calls into their own function which will be called via a WordPress action. So in the constructor we will add an `add_action` call.

``` php
public function __construct( $plugin_name, $version ) {
    // Let's add an action to setup the admin menu in the left nav
    add_action( 'admin_menu', array($this, 'add_admin_menu') );
}
```

When WordPress gets to the `admin_menu` hook, it will call the `add_admin_menu` function within the plugin. This will then render out the menu items.

## WP Admin Dashboard Settings Page for Plugin
Once we have the admin menu items in place. We can link these to some actual pages within the plugin. Within the [`add_menu_page()`](https://developer.wordpress.org/reference/functions/add_menu_page/) and [`add_submenu_page()`](https://developer.wordpress.org/reference/functions/add_submenu_page/) functions is a spot for a callback function. This tells WordPress which function to call when each menu item is clicked. When we added the main menu item with the `add_menu_page` function, we told it to call the `display_custom_plugin_admin_page` function. This in turn will display a template we have made already.

``` php
public function display_custom_plugin_admin_page(){
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/wordpress-custom-plugin-admin-display.php';
}
```

With the menu items now linking to actual pages, we can add some forms on the settings page so we can let users configure our plugin. Within the [custom plugin source code](https://github.com/chriscasper/wordpress-custom-plugin) there are examples of different input types and one of using images and WordPress's built in media library.

![WP Admin Plugin Settings](../assets/wp-admin-settings.png)

Setting up form fields is pretty straight forward. Within the template file (`admin/partials/wordpress-custom-plugin-admin-display.php`), we can echo out the forms and fields we want.

``` php
<div class="wrap">
  <h1>Wordpress Custom Plugin Settings</h1>
  <?php
  // Let see if we have a caching notice to show
  $admin_notice = get_option('custom_wordpress_plugin_admin_notice');
  if($admin_notice) {
    // We have the notice from the DB, let's remove it.
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
```

Within the form tags there are a couple functions we need to call. First is [`settings_fields()`](https://codex.wordpress.org/Function_Reference/settings_fields). This will output all of the fields that we add. Second is [`do_settings_sections()`](https://codex.wordpress.org/Function_Reference/do_settings_sections), this will output the section titles and any additional information we may have set. Thirdly, we setup the submit button for the form by calling `submit_button()`.

### Form Fields
For setting up the individual form fields for each section, there is some helper functions in the custom plugin source code that can easily help you setup the fields you need. There are 3 functions you need to use.

1. `setup_sections()`
    This function is used for configuring the different sections for your settings page. This function is calling [`add_settings_section()`](https://codex.wordpress.org/Function_Reference/add_settings_section) function for each section you want.
2. `section_callback()`
    Thus function is used as the callback for the `add_settings_section`. It tells WordPress what info to display for each section. You could used this to output a description of a particular settings section with some text to help guide the user in configuring the plugin.
3. `setup_fields()`
    This function has an array of all form fields we want on the page. There is an example of most types of user input including one that allows a user to upload an image with the built in Media Library within WordPress.

    At the very end of this function there is a loop where it runs through each setting you specify in the settings array. It uses two WordPress functions. [`add_settings_field`](https://codex.wordpress.org/Function_Reference/add_settings_field) and [`register_setting`](https://developer.wordpress.org/reference/functions/register_setting/).

    ``` php
    // Let's go through each field in the array and set it up
    foreach( $fields as $field ){
        add_settings_field( $field['uid'], $field['label'], array($this, 'field_callback'), 'wordpress-custom-plugin-options', $field['section'], $field );
        register_setting( 'wordpress-custom-plugin-options', $field['uid'] );
    }
    ```

    First it is adding the field to the chosen settings section, then it's registering this setting with WordPress.

4. `field_callback()`
    This function is called as a callback from the `setup_fields` function. It has logic in it on how to markup each input with the necessary markup.

This is a pretty general overview of setting up forms and form fields for the settings page, but its pretty straight forward. All of this code is contained in the `admin/class-wordpress-custom-plugin-admin.php` file.

## URL Rewrites for Custom Plugin URLs
With a custom plugin comes custom URLs for it. With the custom plugin sample, it is displaying custom data to a unique URL which also allows for pagination. The next section will cover the pagination part.

``` php
public function setup_rewrites() {
    // Slug we are using for URL
    $url_slug = 'custom-plugin';
    // Let's setup our rewrite rules
    add_rewrite_rule( $url_slug . '/?$', 'index.php?custom_plugin=index', 'top' );
    add_rewrite_rule( $url_slug . '/page/([0-9]{1,})/?$', 'index.php?custom_plugin=items&custom_plugin_paged=$matches[1]', 'top' );
    add_rewrite_rule( $url_slug . '/([a-zA-Z0-9\-]{1,})/?$', 'index.php?custom_plugin=detail&custom_plugin_vehicle=$matches[1]', 'top' );
    // Let's flush rewrite rules on activation
    flush_rewrite_rules();
}
```

Adding a rewrite rule is pretty easy for the most part. You need to call the WordPress function [`add_rewrite_rule`](https://codex.wordpress.org/Rewrite_API/add_rewrite_rule). In this example you need to pass the URL you want. In this case it's `/custom-plugin/`. If WordPress finds that URL being used, it maps it to `index.php?custom_plugin=index`. Doing pagination can get a little tricky as well. With the above example though you can see how it handle the pagination, showing different results for different page number numbers as well as a *detail* page for a single vehicle.

At the end of the rewrites we need to flush the rewrite rules so that WordPress will see the new rules. This is done using the [`flush_rewrite_rules()`](https://codex.wordpress.org/Function_Reference/flush_rewrite_rules) function. Once we have the new URL rewrites in place, we can add an action for setting the rewrites up.

``` php
$this->loader->add_action( 'init', $plugin_admin, 'setup_rewrites' );
```

This action is setup in the `includes/class-wordpress-custom-plugin.php` file. You find this line in the `define_admin_hooks()` function. The callback is the `setup_rewrites` function in the `admin/class-wordpress-custom-plugin-admin.php` file. This action is also setup for the `init` hook within WordPress. This way it gets setup before any URL processing is done.

Once we have the URL rewrites in place, we need a way to process those requests. You will also see that in the rewrites there are custom query variables as well. In the file `public/class-wordpress-custom-plugin-public.php` you will find two functions we use to display the appropriate template for each custom rewrite.

First we need to define the custom query parameters. If a query param is not register, it will not be process by WordPress.

``` php
public function register_query_values($vars)
{
    // Equivalent to array_push($vars, 'custom_plugin', ..)
    $vars[] = 'custom_plugin';
    $vars[] = 'custom_plugin_paged';
    $vars[] = 'custom_plugin_vehicle';

    return $vars;
}
```

Once the parameters are defined like the above code, we can then register them with Wordpress. The plugin uses the WordPress [`add_filter`](https://developer.wordpress.org/reference/functions/add_filter/) function for this. Now with the custom URL rewrites we can map those to URLs using custom query parameters.

``` php
$this->loader->add_filter( 'query_vars', $plugin_public, 'register_query_values' );
```

Now that WordPress knows our custom URLS and what custom query parameters those actually point to we can add logic for the plugin to know what page template to display for those URLS.

``` php
public function register_custom_plugin_redirect()
{
    // Check if we have the custom plugin query, if so let's display the page
    if (get_query_var('custom_plugin')) {
        add_filter('template_include', function () {
            return plugin_dir_path(__FILE__) . 'partials/wordpress-custom-plugin-public-index.php';
        });
    }
    // Check if its a detail page for a vehicle
    if (get_query_var('custom_plugin') && get_query_var('custom_plugin_vehicle')) {
        add_filter('template_include', function () {
            return plugin_dir_path(__FILE__) . 'partials/wordpress-custom-plugin-public-detail.php';
        });
    }
}
```

In the above code we are just doing a simple if check to see if the URL coming through contains our custom query parameters. If it matches then we can display the relevant template. In typical fashion, we need to notify WordPress that we have some logic that can choose a custom template based off of the query parameters. For this we will add another action. This is adding this check into the WordPress `template_redirect` hook.

``` php
$this->loader->add_action( 'template_redirect', $plugin_public, 'register_custom_plugin_redirect' );
```

Once that is setup WordPress can now listen for if there is a URL match to our rewrites, and if there is a match direct it to the proper page template.

## Displaying Custom Data on Plugin Pages
Now that we have WordPress displaying the proper template for the rewrite, let's show some custom data on these pages. For our main URL rewrite, which is if the URL is `/custom-plugin`, let's show some custom content. For this sample plugin there is an array of 50 vehicles with associated data. On our index template file `public/partials/wordpress-custom-plugin-public-index.php` we will call our plugins public class. This allows us to access our data within the class.

``` php
$custom_plugin_obj = new Wordpress_Custom_Plugin_Public('wordpress-custom-plugin', '1.0.0');
```

The above line allows us to instantiate our public class. Then we can access a function of that class to return the data we need to display. In this example we will will access the `get_vehicle_listings()` function which will return back a listing of vehicles from our example data that is stored within the plugin's public class. This could be any function and could return any type of data that you want.

``` php
$vehicle_listings = $custom_plugin_obj->get_vehicle_listings(10, $custom_plugin_current_page);
```

Then with the vehicle listings data that is returned, we can just loop through that and display it on the page.

## Pagination for Custom Plugin Data
Pagination is not too had to implement. We need to follow some of the same steps as listed above in the Displaying Custom Data on Plugin Pages. Along with instantiating our public class, we need to figure out some other variables for breaking all of the listings up in to manageable page sizes.

``` php
// Set our current page for pagination
$custom_plugin_current_page = get_query_var('custom_plugin_paged') > 0 ? get_query_var('custom_plugin_paged') : 1;
// Instatiate our Custom Plugin Public Class
$custom_plugin_obj = new Wordpress_Custom_Plugin_Public('wordpress-custom-plugin', '1.0.0');
// Let's get the listings needed for this "page"
$vehicle_listings = $custom_plugin_obj->get_vehicle_listings(10, $custom_plugin_current_page);
```

In the above code, first we are going to check a query parameter and see if it contains some data. In this case we are checking a custom parameter thats holding what page number we are on. Next we are setting up the public class for our plugin. Once that is done we can now access the function within the plugin, `get_vehicle_listings()`. With this call we can pass in how many vehicles we want to list and the current page we are on.

In the `get_vehicle_listings()` we can do some logic to return back 10 listings based on the page we are. The following logic will get all vehicles, then pull out the ones we need to display.

```php
public function get_vehicle_listings($page_count, $page_num)
{	
    // Get all listings of vehicles and let's store it for use
    $this->$vehicles = $this->get_vehicles();

    // Some vars for pagination
    $total_listings = count($this->$vehicles);
    $total_pages = ceil($total_listings / $page_count);
    $listings_offset = ($page_num - 1) * $page_count;
    $listings_length = $page_count;

    // Let's return our pagination and listings
    $page_setup = [];
    $page_setup['vehicles'] = array_slice($this->$vehicles, $listings_offset, $listings_length, true);
    $page_setup['page_count'] = $total_pages;
    $page_setup['page_current'] = $page_num;

    // Let's set our page title as well
    add_filter('wpseo_title', function ($title) use ($page_num) {
        return 'Custom Plugin - Page ' . $page_num;
    });
    // Let's return back our past sales listings
    return $page_setup;
}
```

After we loop through the returned vehicles, we will need to output some markup for showing which page we are on and also allow some basic navigation to other pages. In the template file we will call our special pagination function which will return back the desired markup.

```php
$custom_plugin_obj->generatePagination($vehicle_listings['page_count'], $custom_plugin_current_page);
```

The function `generatePagination()` that we call is pretty simple. It takes in how many pages total, and which page number it is on currently. The with that input it will return back the correct markup to be rendered with the correct links for navigating to the next page or previous page.

``` php
public function generatePagination($pages = '', $page_num = 1)
{
    // Let's store our pagination html some place
    $pagination_html = '';
    if (1 != $pages) {
        $pagination_html =  '<div><span>Page '.$page_num.' of '.$pages.'</span>'.paginate_links( array(
        'format' => 'page/%#%',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => $pages,
        'current' => $page_num
        )).'</div>';
    }
    // Let's return back our pagination html
    return $pagination_html;
}
```

## Conclusion
I hope that you can gain a lot of insight into building your own custom WordPress plugin from this post. I gave a brief overview on a lot of topics related to writing a plugin but hope with the sample code and sample plugin you can write your own with relative ease.

## Resources
I've compiled a couple resources that were extremely helpful for me when building my plugin.

- Lots of help, borrowed code, and inspiration from: [https://github.com/rayman813/smashing-custom-fields/](https://github.com/rayman813/smashing-custom-fields/)
- WordPress Developer Resources
[https://developer.wordpress.org/](https://developer.wordpress.org/)
- WordPress Plugin Boilerplate Generator [https://wppb.me/](https://wppb.me/)

## Example Custom Plugin Code
I have put all the example code from this article in a public GitHub repo. This is a full functioning custom WordPress Plugin. I welcome any comments or changes. [https://github.com/chriscasper/wordpress-custom-plugin](https://github.com/chriscasper/wordpress-custom-plugin)