<?php
/*
Plugin Name: Smart1Waze Floating Widget
Plugin URI: https://www.smart1ads.com/
Description: Display Waze Smart1Ads Floating Widget on Websites
Author: smart1lead
Author URI: https://profiles.wordpress.org/smart1lead
Version: 0.1
Text Domain: smart1waze-widget
*/


/*
* Define Smart1Waze Costants
*/
add_action( 'plugins_loaded', 'sm1waze_define' );
function sm1waze_define()
{
	if(!defined(SM1WAZE_BASE_DIR))
	{
		define( 'SM1WAZE_BASE_DIR', plugin_basename(__FILE__));
	}

	if(!defined(SM1WAZE_VIEWS_DIR))
	{
		define( 'SM1WAZE_VIEWS_DIR', plugin_dir_path(__FILE__) . 'views/' );
	}

	if(!defined(SM1WAZE_ASSETS_DIR))
	{
		define( 'SM1WAZE_ASSETS_DIR', plugin_dir_path(__FILE__) . 'assets/' );
	}

	if(!defined(SM1WAZE_ASSETS))
	{
		define( 'SM1WAZE_ASSETS', plugin_dir_url(__FILE__) . 'assets/' );
	}

	if(!defined(SM1WAZE_SRC))
	{
		define( 'SM1WAZE_SRC', plugin_dir_path(__FILE__) . 'src/' );
	}
}

/*
* Register Smart1Waze Classes
*/
add_action( 'plugins_loaded', 'sm1waze_load' );
function sm1waze_load()
{
	if(is_admin())
	{
		new Smart1Waze_Widget_Admin();	
	}
	else
	{
		new Smart1Waze_Widget_Frontend();
	}
}

/* 
* Auto Load Smart1Waze Classes & Include Class Files
*/
spl_autoload_register('sm1waze_autoload');
function sm1waze_autoload($class)
{	
	if (0 === strpos( $class, 'Smart1Waze_Widget_' ) )
	{
		$path = SM1WAZE_SRC.$class.'.php';
	}

	if ( $path && is_readable( $path ) )
	{
		require_once($path);
	}
}