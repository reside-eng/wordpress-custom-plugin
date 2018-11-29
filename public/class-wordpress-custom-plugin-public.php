<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://christophercasper.com/
 * @since      1.0.0
 *
 * @package    Wordpress_Custom_Plugin
 * @subpackage Wordpress_Custom_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wordpress_Custom_Plugin
 * @subpackage Wordpress_Custom_Plugin/public
 * @author     Christopher Casper <me@christophercasper.com>
 */
class Wordpress_Custom_Plugin_Public {

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
	 * Global array of vehicles.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $vehicles    Global array of vehicles.
	 */
	private $vehicles;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function get_vehicles()
	{	
		// Used https://www.mockaroo.com/ to build a json string of random vehicles for use in the plugin
		return json_decode(
			'[{"id":1,"vin":"2C3CCAST1CH352705","make":"Dodge","model":"Ram 1500","year":2006,"color":"Purple"},
			{"id":2,"vin":"2HNYD2H26DH118803","make":"Mitsubishi","model":"Diamante","year":1994,"color":"Red"},
			{"id":3,"vin":"2T1BPRHE9FC863757","make":"Toyota","model":"Corolla","year":2002,"color":"Crimson"},
			{"id":4,"vin":"WBSBL93483J217032","make":"Porsche","model":"Cayenne","year":2011,"color":"Violet"},
			{"id":5,"vin":"3N1AB6AP8AL250378","make":"Jaguar","model":"S-Type","year":2003,"color":"Purple"},
			{"id":6,"vin":"3GYFNCEY4BS504374","make":"Honda","model":"S2000","year":2008,"color":"Yellow"},
			{"id":7,"vin":"ZFBCFADH8FZ274524","make":"Ford","model":"Torino","year":1970,"color":"Green"},
			{"id":8,"vin":"5J8TB3H37GL512906","make":"Mitsubishi","model":"Galant","year":1996,"color":"Fuscia"},
			{"id":9,"vin":"WAUGGBFC5DN959648","make":"Honda","model":"Accord","year":1983,"color":"Purple"},
			{"id":10,"vin":"JH4KA96631C812221","make":"Buick","model":"Rendezvous","year":2002,"color":"Blue"},
			{"id":11,"vin":"1GD422CG9EF028816","make":"GMC","model":"Savana","year":2009,"color":"Fuscia"},
			{"id":12,"vin":"1N6AD0CW1EN981858","make":"Porsche","model":"Boxster","year":2012,"color":"Puce"},
			{"id":13,"vin":"WAURV78T59A395085","make":"GMC","model":"1500 Club Coupe","year":1997,"color":"Purple"},
			{"id":14,"vin":"JTHFE2C28A2311197","make":"Studebaker","model":"Avanti","year":1962,"color":"Green"},
			{"id":15,"vin":"1FTEW1CM5BK324090","make":"Nissan","model":"Pathfinder","year":1992,"color":"Puce"},
			{"id":16,"vin":"WUAAU34259N400838","make":"Toyota","model":"Land Cruiser","year":2002,"color":"Blue"},
			{"id":17,"vin":"2G61T5S31E9390283","make":"Cadillac","model":"Escalade EXT","year":2005,"color":"Pink"},
			{"id":18,"vin":"WAUDH94F48N932579","make":"Volkswagen","model":"Cabriolet","year":1991,"color":"Indigo"},
			{"id":19,"vin":"4T3BA3BB5AU190557","make":"Alfa Romeo","model":"Spider","year":1993,"color":"Red"},
			{"id":20,"vin":"WBAYF4C5XDD734849","make":"Audi","model":"TT","year":2005,"color":"Indigo"},
			{"id":21,"vin":"1VWAH7A39EC118646","make":"Mitsubishi","model":"Mirage","year":2001,"color":"Indigo"},
			{"id":22,"vin":"SCBCU8ZA3AC624809","make":"Pontiac","model":"Sunfire","year":2001,"color":"Khaki"},
			{"id":23,"vin":"1C3CDZAB4CN209517","make":"Ford","model":"Ranger","year":2006,"color":"Pink"},
			{"id":24,"vin":"2C3CDXJG3DH496391","make":"Mitsubishi","model":"GTO","year":1997,"color":"Crimson"},
			{"id":25,"vin":"WUARL48H74K497061","make":"Infiniti","model":"QX","year":2003,"color":"Teal"},
			{"id":26,"vin":"WA1WGAFP4EA488252","make":"Mitsubishi","model":"Galant","year":1997,"color":"Maroon"},
			{"id":27,"vin":"1G6KE54Y82U635697","make":"Volvo","model":"C70","year":2011,"color":"Turquoise"},
			{"id":28,"vin":"3C6TD5FT6CG977120","make":"Saturn","model":"Ion","year":2007,"color":"Yellow"},
			{"id":29,"vin":"1C6RD6JT7CS213647","make":"Audi","model":"100","year":1989,"color":"Orange"},
			{"id":30,"vin":"2G4GY5GV6B9007030","make":"Toyota","model":"FJ Cruiser","year":2010,"color":"Purple"},
			{"id":31,"vin":"WUARU98E77N020603","make":"Cadillac","model":"Eldorado","year":2002,"color":"Goldenrod"},
			{"id":32,"vin":"3D73Y3HL2BG073459","make":"Saturn","model":"L-Series","year":2004,"color":"Fuscia"},
			{"id":33,"vin":"WBADN63451G203203","make":"Ford","model":"LTD","year":1985,"color":"Yellow"},
			{"id":34,"vin":"1FTFW1E88AK732408","make":"Ford","model":"Escort","year":1992,"color":"Indigo"},
			{"id":35,"vin":"WBANN73547B901696","make":"Chevrolet","model":"Express 3500","year":1999,"color":"Crimson"},
			{"id":36,"vin":"JN1BY1AR9EM230076","make":"Lexus","model":"GX","year":2011,"color":"Mauv"},
			{"id":37,"vin":"5GALRBED2AJ695511","make":"Audi","model":"4000s","year":1986,"color":"Blue"},
			{"id":38,"vin":"2C3CK5CV2AH413521","make":"Volkswagen","model":"New Beetle","year":2012,"color":"Goldenrod"},
			{"id":39,"vin":"5TDBK3EH4CS925255","make":"Mazda","model":"MX-5","year":2000,"color":"Maroon"},
			{"id":40,"vin":"WBAFZ9C52DC971157","make":"Lotus","model":"Elise","year":2010,"color":"Maroon"},
			{"id":41,"vin":"2G4WF521341362017","make":"Eagle","model":"Vision","year":1995,"color":"Goldenrod"},
			{"id":42,"vin":"JN1CV6EK7CM931624","make":"Ford","model":"F150","year":2006,"color":"Indigo"},
			{"id":43,"vin":"YV1902FH0D2761583","make":"Acura","model":"RSX","year":2003,"color":"Maroon"},
			{"id":44,"vin":"1D7RV1CP3BS503722","make":"Eagle","model":"Vision","year":1997,"color":"Mauv"},
			{"id":45,"vin":"1GKS1KE06DR073521","make":"Kia","model":"Spectra","year":2005,"color":"Green"},
			{"id":46,"vin":"JTJBM7FX9C5564065","make":"Suzuki","model":"Equator","year":2009,"color":"Purple"},
			{"id":47,"vin":"WA1LGBFE3FD977989","make":"Mercedes-Benz","model":"CLK-Class","year":2007,"color":"Turquoise"},
			{"id":48,"vin":"JHMFA3F23AS794238","make":"Chrysler","model":"Cirrus","year":1995,"color":"Indigo"},
			{"id":49,"vin":"WAUGFBFC5EN179346","make":"Infiniti","model":"Q","year":1993,"color":"Yellow"},
			{"id":50,"vin":"1G6DJ5EG9A0018003","make":"Chevrolet","model":"G-Series 1500","year":1998,"color":"Puce"}]');
	}

	/**
     * Get Vehicle Listings
     *
     * @since    1.0.0
     */
	public function get_vehicle_listings($page_count, $page_num)
	{	
		// Get all listings of vehicles and lets store it for use
		$this->$vehicles = $this->get_vehicles();

		// Some vars for pagination
        $total_listings = count($this->$vehicles);
        $total_pages = ceil($total_listings / $page_count);
        $listings_offset = ($page_num - 1) * $page_count;
        $listings_length = $page_count;

        // Lets return our pagination and listings
        $page_setup = [];
        $page_setup['vehicles'] = array_slice($this->$vehicles, $listings_offset, $listings_length, true);
        $page_setup['page_count'] = $total_pages;
        $page_setup['page_current'] = $page_num;

        // Lets set our page title as well
        add_filter('wpseo_title', function ($title) use ($page_num) {
            return 'Custom Plugin - Page ' . $page_num;
        });
        // Lets return back our past sales listings
        return $page_setup;
	}

	/**
     * Get Vehicle By VIN
     *
     * @since    1.0.0
     */
	public function get_vehicle_by_vin($vin)
	{	
		// Get all of our vehicles for 
		$vehicles = $this->get_vehicles();
		// lets search for a vehicle based on VIN
		$vehicle = array_values(array_filter($vehicles, function ($vehicle) use ($vin) {
            // Here is where the magic happens. We'll compare the vin to the URI Slug
            return $vehicle->vin === $vin;
		}))[0];
		// Lets see if we have a match, otherise we'll show a 404.
		if($vehicle) {
			return $vehicle;
		} else {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			get_template_part( 404 ); exit();
		}
	}

	/**
     * Custom Plugin Rewrites
     *
     * @since    1.0.0
     */
    public function register_custom_plugin_redirect()
    {
        // Check if we have the custom plugin query, if so lets display the page
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

	/**
     * Register Query Values for Custom Plugin
     *
     * Filters that are needed for rendering the custom plugin page
     *
     * @since    1.0.0
     */
    public function register_query_values($vars)
    {
        // Equivalent to array_push($vars, 'custom_plugin', ..)
		$vars[] = 'custom_plugin';
		$vars[] = 'custom_plugin_paged';
        $vars[] = 'custom_plugin_vehicle';

        return $vars;
	}
	
	/**
     * Pagination! 
	 * 
     * @since    1.0.0
     */
    public function generatePagination($pages = '', $page_num = 1)
    {
        // Lets store our pagination html some place
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
        // Lets return back our pagination html
        return $pagination_html;
    }
	
	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-custom-plugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-custom-plugin-public.js', array( 'jquery' ), $this->version, false );

	}

}
