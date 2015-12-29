<?php
/*
Plugin Name: Sermons
Description: A sermon post type for WordPress
Author: Marcus Battle
Version: 0.1.0
Author URI: http://marcusbattle.com
*/

class WP_Sermons {

	public function __construct() {

		require_once dirname( __FILE__ ) . '/includes/CMB2/init.php';

		add_action( 'init', array( $this, 'init_sermon_post_type' ) );
		add_action( 'cmb2_init', array( $this, 'sermon_metaboxes' ) );
		add_filter( 'wp_insert_post_data' , array( $this, 'filter_sermon_data' ) , '99', 2 );

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_styles' ) );

		add_shortcode( 'sermon', array( $this, 'sermon_shortcode' ) );

	}

	public function scripts_styles() {

		// if ( get_post_type() == 'sermon' ) {

			wp_enqueue_style( 'jPlayer-Blue', plugin_dir_url( __FILE__ ) . '/assets/js/jPlayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css' );
			wp_enqueue_script( 'jPlayer', plugin_dir_url( __FILE__ ) . '/assets/js/jPlayer/dist/jplayer/jquery.jplayer.min.js', array('jquery'), '2.9.2', true );

			wp_enqueue_style( 'sermon', plugin_dir_url( __FILE__ ) . '/assets/css/sermon.css' );
			wp_enqueue_script( 'sermon', plugin_dir_url( __FILE__ ) . '/assets/js/sermon.js', array('jPlayer'), '0.1.0', true );

			wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
		// }

	}

	public function init_sermon_post_type() {

		$labels = array(
			'name'               => _x( 'Sermons', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Sermon', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Sermons', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Sermon', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'sermon', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Sermon', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Sermon', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Sermon', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Sermon', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Sermons', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search Sermons', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent Sermons:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No sermons found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No sermons found in Trash.', 'your-plugin-textdomain' )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'sermons' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'thumbnail', 'comments' )
		);

		register_post_type( 'sermon', $args );

	}

	public function sermon_shortcode( $atts ) {

		include_once plugin_dir_path( __FILE__ ) . 'views/sermon-hero.php';

	}

	public function sermon_metaboxes() {

		$prefix = 'sermon_';

		$sermon_details = new_cmb2_box( array(
			'id'            => $prefix . 'details',
			'title'         => __( 'Sermon Details' ),
			'object_types'  => array( 'sermon' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
		) );

		$sermon_details ->add_field( array(
			'name' => __( 'Title' ),
			'id'   => $prefix . 'title',
			'type' => 'text',
		) );

		$sermon_details ->add_field( array(
			'name' => __( 'Scripture' ),
			'id'   => $prefix . 'scripture',
			'type' => 'text',
		) );

		$sermon_details ->add_field( array(
			'name' => __( 'Preacher' ),
			'id'   => $prefix . 'preacher',
			'type' => 'text',
		) );

		$sermon_details ->add_field( array(
			'name' => __( 'Date Preached' ),
			'id'   => $prefix . 'date',
			'type' => 'text_date',
		) );

		$sermon_details ->add_field( array(
			'name' => __( 'Description' ),
			'id'   => $prefix . 'description',
			'type'    => 'wysiwyg',
			'options' => array( 'textarea_rows' => 5 )
		) );

		$sermon_details->add_field( array(
			'name' => __( 'In Sermon Series' ),
			'desc' => __( 'Check this box if this sermon is apart of a series (optional)' ),
			'id'   => $prefix . 'in_series',
			'type' => 'checkbox',
		) );

		$sermon_details->add_field( array(
			'name' => __( 'Audio File/URL' ),
			'id'   => $prefix . 'audio',
			'type' => 'file',
		) );

		$sermon_details->add_field( array(
			'name' => __( 'Video File/URL' ),
			'id'   => $prefix . 'video',
			'type' => 'file',
		) );

	}

	public function filter_sermon_data( $data , $postarr ) {

		// Sets the post title
		if ( ! empty( $postarr['sermon_title'] ) ) {
			$data['post_title'] = $postarr['sermon_title'];
		}

		// Sets the post date to the sermon date
		if ( ! empty( $postarr['sermon_date'] ) ) {
			$data['post_date'] = date('Y-m-d H:i:s', strtotime( $postarr['sermon_date'] ) );
		}

		return $data;

	}

}

$WP_Sermons = new WP_Sermons();