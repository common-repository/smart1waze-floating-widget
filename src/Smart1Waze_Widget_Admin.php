<?php

class Smart1Waze_Widget_Admin
{
	public function __construct()
	{
		/*
		* Actions
		*/
		add_action( 'admin_init', array($this,'register_setting'));
		add_action( 'admin_init', array($this, 'add_taxonomy_metadata'));
		add_action( 'admin_enqueue_scripts', array($this,'enqeue_scripts'));
		add_action( 'admin_menu', array($this,'admin_menu'));
		add_action( 'add_meta_boxes', array($this,'add_metabox'));
		add_action( 'save_post', array( $this, 'save_post_meta' ));
		add_action( 'show_user_profile', array( $this, 'add_user_profile_fields' ));
		add_action( 'edit_user_profile', array( $this, 'add_user_profile_fields' ));
		add_action( 'user_new_form', array( $this, 'add_user_profile_fields' ));
	    add_action('personal_options_update', array($this, 'update_profile_fields'));
	    add_action( 'edit_user_profile_update', array($this, 'update_profile_fields'));
	    add_action('user_register', array($this, 'update_profile_fields'));

		/*
		* Filters
		*/
		add_filter( 'plugin_action_links_'.SM1WAZE_BASE_DIR, array($this,'settings_link'));
	}

	public function enqeue_scripts()
	{
		wp_register_style( 'jquery-ui',  SM1WAZE_ASSETS.'css/jquery-ui.css' );
		wp_enqueue_style('jquery-ui');

		wp_register_style( 'sm1waze-admin-style',  SM1WAZE_ASSETS. 'css/admin-style.css' );
		wp_enqueue_style('sm1waze-admin-style');
		
		wp_register_script('sm1waze-admin-js',  SM1WAZE_ASSETS.'js/admin-script.js',array('jquery'));
		wp_enqueue_script ('sm1waze-admin-js');
	}

	public function settings_link( $links )
	{
		$links[] = '<a href="' . admin_url( 'admin.php?page=sm1waze-settings' ) . '">' . ( 'Settings' ) . '</a>';
		return $links;
	}

	public function admin_menu()
	{
		add_menu_page(
						__( 'Smart1Waze', 'sm1waze' ),
						__( 'Smart1Waze', 'sm1waze' ),
						'administrator',
						'sm1waze-settings',
						array($this,'view')
					);
	}

	public function register_setting()
	{
		register_setting(
							'sm1waze_settings',
							'sm1waze_settings'		
						);
	}

	public function view()
	{
		$sm1waze_registered_post_types = apply_filters('smart1waze_registerd_post_types',get_post_types());
		$sm1waze_registered_taxonomies = apply_filters('smart1waze_registered_taxonomies',get_taxonomies());
		$sm1waze_setting_values = get_option( 'sm1waze_settings' );
		$sm1waze_setting_show_on_front = get_option( 'show_on_front' );
		
		include(SM1WAZE_VIEWS_DIR.'admin-settings.php');
	}

	/** Adds the meta box*/
    public function add_metabox()
    {
        add_meta_box(
           				 'sm1waze-widget',
            			__( 'Smart1Waze Widget Settings', 'sm1waze' ),
            			array( $this, 'render_metabox' ),
            			'',
            			'advanced',
            			'default'
        			);
 
    }

    public function render_metabox($post)
    {

    	$enable_sm1waze_widget = get_post_meta($post->ID, 'enable_sm1waze_widget',true);
		$sm1waze_checked = isset( $enable_sm1waze_widget ) ? esc_attr( $enable_sm1waze_widget ) : '';
		
		include(SM1WAZE_VIEWS_DIR.'admin-post-metabox.php');

	}

    public function save_post_meta($post_id)
    {
    	$enable_sm1waze_widget = isset($_POST['enable_sm1waze_widget']) && $_POST['enable_sm1waze_widget'] ? '1' : '';
    	update_post_meta($post_id,'enable_sm1waze_widget',$enable_sm1waze_widget);
    }


    /********Add metabox to taxonomies*******/
    public function add_taxonomy_metadata()
    {

    	if( !function_exists('update_term_meta') || !function_exists('get_term_meta') ) return false;

		// Get a list of all public custom taxonomies
	  	$taxonomies = apply_filters('smart1waze_registered_taxonomies',get_taxonomies());
	  	
		if ( $taxonomies ) {
		  	foreach ( $taxonomies  as $taxonomy ) {
		  		
		      	add_action("{$taxonomy}_add_form_fields", array($this,'add_taxonomy_metadata_field'));
		      	add_action("{$taxonomy}_edit_form_fields", array($this,'edit_taxonomy_metadata_field'));
		      
		      	add_action("created_{$taxonomy}", array($this,'save_taxonomy_metadata'));
		      	add_action("edited_{$taxonomy}", array($this,'save_taxonomy_metadata'));
		    }
		}
    }

    /** Add additional fields to the taxonomy add view **/
	public function add_taxonomy_metadata_field( $tag )
	{	
		if ( current_user_can( 'publish_posts' ) )
		{
			include(SM1WAZE_VIEWS_DIR.'admin-add-taxonomy-metabox.php');
		}
	}

	public function edit_taxonomy_metadata_field( $tag )
	{
		$enable_sm1waze_widget = get_term_meta($tag->term_id, 'enable_sm1waze_widget', true );

		if ( current_user_can( 'publish_posts' ) )
		{
			include(SM1WAZE_VIEWS_DIR.'admin-edit-taxonomy-metabox.php');
		}
	}

	public function save_taxonomy_metadata($term_id)
	{	
			
		$enable_sm1waze_widget = isset( $_POST['enable_sm1waze_widget'] ) ? esc_attr( $_POST['enable_sm1waze_widget'] ) : '';
    	update_term_meta( $term_id, 'enable_sm1waze_widget', $enable_sm1waze_widget );
	    
	}

	public function add_user_profile_fields($user)
	{

		$enable_sm1waze_widget = get_user_meta($user->ID, 'enable_sm1waze_widget', true );
		include(SM1WAZE_VIEWS_DIR.'admin-edit-profile.php');
	}

	public function update_profile_fields($user_id){

		if ( !current_user_can( 'edit_user', $user_id ) ) { 
	        return false; 
	    }
	    
	    update_user_meta( $user_id, 'enable_sm1waze_widget', $_POST['enable_sm1waze_widget'] );

	}
}