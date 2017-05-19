<?php
/**
 * Camden_Custom_Post_Type
 *
 * @package   Camden_Custom_Post_Type
 * @author    Population2 <populationtwo@gmail.com>
 * @license   GPL-2.0+
 * @link      http://population-2.com
 * @copyright 2014 Population2
 */

/**
 * Camden_Custom_Post_Type class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-camden-custom-post-type-admin.php`
 *
 * @package Camden_Custom_Post_Type
 * @author  Population2 <populationtwo@gmail.com>
 */
class Camden_Custom_Post_Type {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '0.0.1';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'camden-custom-post-type';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'init', array( $this, 'camden_register_post_type_ministry' ) );
		add_action( 'init', array( $this, 'camden_ministry_group_taxonomy' ) );
		add_action( 'init', array( $this, 'camden_register_post_type_slides' ) );
		add_filter( 'post_updated_messages', array( $this, 'camden_ministry_updated_messages' ) );
		add_filter( 'post_updated_messages', array( $this, 'camden_slide_updated_messages' ) );


	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	public function camden_register_post_type_ministry() {

		$labels = array(
			'name'               => _x( 'Ministries', 'Post Type General Name', 'camden' ),
			'singular_name'      => _x( 'Ministry', 'Post Type Singular Name', 'camden' ),
			'menu_name'          => __( 'Ministry', 'camden' ),
			'parent_item_colon'  => __( 'Parent Ministry:', 'camden' ),
			'all_items'          => __( 'All Ministries:', 'camden' ),
			'view_item'          => __( 'View Ministry', 'camden' ),
			'add_new_item'       => __( 'Add New Ministry', 'camden' ),
			'add_new'            => __( 'New Ministry', 'camden' ),
			'edit_item'          => __( 'Edit Ministry', 'camden' ),
			'update_item'        => __( 'Update Ministry', 'camden' ),
			'search_items'       => __( 'Search ministries', 'camden' ),
			'not_found'          => __( 'No ministries found', 'camden' ),
			'not_found_in_trash' => __( 'No ministries found in Trash', 'camden' ),
		);
		$args   = array(
			'label'              => __( 'ministry', 'camden' ),
			'description'        => __( 'Ministry information pages', 'camden' ),
			'labels'             => $labels,
			'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', ),
			'taxonomies'         => array( 'group' ),
			'has_archive'        => true,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => 'ministries',
			),
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-awards'
		);
		register_post_type( __( 'ministry', 'camden' ), $args );

	}

	public function camden_ministry_group_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Groups', 'Taxonomy General Name', 'camden' ),
			'singular_name'              => _x( 'Group', 'Taxonomy Singular Name', 'camden' ),
			'menu_name'                  => __( 'Group', 'camden' ),
			'all_items'                  => __( 'All Groups', 'camden' ),
			'parent_item'                => __( 'Parent Group', 'camden' ),
			'parent_item_colon'          => __( 'Parent Group:', 'camden' ),
			'new_item_name'              => __( 'New Group Name', 'camden' ),
			'add_new_item'               => __( 'Add New Group', 'camden' ),
			'edit_item'                  => __( 'Edit Group', 'camden' ),
			'update_item'                => __( 'Update Group', 'camden' ),
			'separate_items_with_commas' => __( 'Separate groups with commas', 'camden' ),
			'search_items'               => __( 'Search groups', 'camden' ),
			'add_or_remove_items'        => __( 'Add or remove groups', 'camden' ),
			'choose_from_most_used'      => __( 'Choose from the most used groups', 'camden' ),
			'not_found'                  => __( 'Not Found', 'camden' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);
		register_taxonomy( __( 'ministry-group', 'camden' ), array( __( 'ministry', 'camden' ) ), $args );
	}

	public function camden_ministry_updated_messages() {

		global $post;

		$messages[ __( 'ministry', 'camden' ) ] =
			array(
				0  => '', // Unused. Messages start at index 1.
				1  => sprintf( __( 'Ministry updated. <a href="%s">View ministry</a>', 'camden' ), esc_url( get_permalink() ) ),
				2  => __( 'Custom field updated.', 'camden' ),
				3  => __( 'Custom field deleted.', 'camden' ),
				4  => __( 'Ministry updated.', 'camden' ),
				/* translators: %s: date and time of the revision */
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'Ministry restored to revision from %s', 'camden' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6  => sprintf( __( 'Ministry published. <a href="%s">View ministry</a>', 'camden' ), esc_url( get_permalink() ) ),
				7  => __( 'Ministry saved.', 'camden' ),
				8  => sprintf( __( 'Ministry submitted. <a target="_blank" href="%s">Preview ministry</a>', 'camden' ), esc_url( add_query_arg( 'preview', 'true', get_permalink() ) ) ),
				9  => sprintf(
					__( 'Ministry scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview ministry</a>', 'camden' ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i', 'camden' ), strtotime( $post->post_date ) ), esc_url( get_permalink() )
				),
				10 => sprintf( __( 'Ministry draft updated. <a target="_blank" href="%s">Preview ministry</a>', 'camden' ), esc_url( add_query_arg( 'preview', 'true', get_permalink() ) ) ),
			);

		return $messages;


	}

	public function camden_register_post_type_slides() {

		$labels = array(
			'name'               => _x( 'Slides', 'Post Type General Name', 'camden' ),
			'singular_name'      => _x( 'Slide', 'Post Type Singular Name', 'camden' ),
			'menu_name'          => __( 'Slide', 'camden' ),
			'parent_item_colon'  => __( 'Parent Slide:', 'camden' ),
			'all_items'          => __( 'All Slides:', 'camden' ),
			'view_item'          => __( 'Slide', 'camden' ),
			'add_new_item'       => __( 'Add New Slide', 'camden' ),
			'add_new'            => __( 'New Slide', 'camden' ),
			'edit_item'          => __( 'Edit Slide', 'camden' ),
			'update_item'        => __( 'Update Slide', 'camden' ),
			'search_items'       => __( 'Search slides', 'camden' ),
			'not_found'          => __( 'No slides found', 'camden' ),
			'not_found_in_trash' => __( 'No slides found in Trash', 'camden' ),
		);

		$args = array(
			'label'              => __( 'slide', 'camden' ),
			'description'        => __( 'Slide information pages', 'camden' ),
			'labels'             => $labels,
			'supports'           => array( 'title', 'thumbnail', 'custom-fields' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-format-image'

		);

		register_post_type( __( 'slide', 'camden' ), $args );


	}

	public function camden_slide_updated_messages() {

		global $post;

		$messages[ __( 'slide' ) ] =
			array(
				0  => '', // Unused. Messages start at index 1.
				1  => sprintf( __( 'Slide updated. <a href="%s">View slide</a>', 'camden' ), esc_url( get_permalink() ) ),
				2  => __( 'Custom field updated.', 'camden' ),
				3  => __( 'Custom field deleted.', 'camden' ),
				4  => __( 'Slide updated.', 'camden' ),
				/* translators: %s: date and time of the revision */
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'Slide restored to revision from %s', 'camden' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6  => sprintf( __( 'Slide published. <a href="%s">View slide</a>', 'camden' ), esc_url( get_permalink() ) ),
				7  => __( 'Slide saved.', 'camden' ),
				8  => sprintf( __( 'Slide submitted. <a target="_blank" href="%s">Preview slide</a>', 'camden' ), esc_url( add_query_arg( 'preview', 'true', get_permalink() ) ) ),
				9  => sprintf(
					__( 'Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview slide</a>', 'camden' ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i', 'camden' ), strtotime( $post->post_date ) ), esc_url( get_permalink() )
				),
				10 => sprintf( __( 'Slide draft updated. <a target="_blank" href="%s">Preview slide</a>', 'camden' ), esc_url( add_query_arg( 'preview', 'true', get_permalink() ) ) ),
			);

		return $messages;


	}
}
