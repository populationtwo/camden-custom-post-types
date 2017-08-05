<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://population-2.com
 * @since      1.0.0
 *
 * @package    Camden_Custom_Post_Types
 * @subpackage Camden_Custom_Post_Types/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Camden_Custom_Post_Types
 * @subpackage Camden_Custom_Post_Types/public
 * @author     Population2 <info@population-2.com>
 */
class Camden_Custom_Post_Types_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'init', array( $this, 'camden_register_post_type_ministry' ) );
		add_action( 'init', array( $this, 'camden_ministry_group_taxonomy' ) );
		add_action( 'init', array( $this, 'camden_register_post_type_slides' ) );
		add_filter( 'post_updated_messages', array( $this, 'camden_ministry_updated_messages' ) );
		add_filter( 'post_updated_messages', array( $this, 'camden_slide_updated_messages' ) );

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
