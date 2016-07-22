<?php
/*
Author: Zhen Huang
URL: http://themefortress.com/

This place is much cleaner. Put your theme specific codes here,
anything else you may want to use plugins to keep things tidy.

*/

/*
1. lib/clean.php
  - head cleanup
	- post and images related cleaning
*/
require_once('lib/clean.php'); // do all the cleaning and enqueue here

/*
2. lib/enqueue-style.php
    - enqueue Foundation and Reverie CSS
*/
require_once('lib/enqueue-style.php');

/*
3. lib/foundation.php
	- add pagination
*/
require_once('lib/foundation.php'); // load Foundation specific functions like top-bar
/*
4. lib/nav.php
	- custom walker for top-bar and related
*/
require_once('lib/nav.php'); // filter default wordpress menu classes and clean wp_nav_menu markup

/**********************
Add theme supports
 **********************/
if( ! function_exists( 'reverie_theme_support' ) ) {
    function reverie_theme_support() {
        // Add language supports.
        load_theme_textdomain('reverie', get_template_directory() . '/lang');

        // Add post thumbnail supports. http://codex.wordpress.org/Post_Thumbnails
		// if ( has_post_thumbnail() ) {the_post_thumbnail();}
		add_theme_support( 'post-thumbnails', array( 'post' ) ); 	// Posts only
        add_image_size('large-image', 1024, 99999); 				// full width page
        add_image_size('medium-image', 768, 99999); 				// page with sidebar
        add_image_size('small-image', 320, 9999); 					// blog index
        add_image_size('tiny-image', 150, 9999); 					// thumbnail


        // rss thingy
        add_theme_support('automatic-feed-links');

        // Add post formats support. http://codex.wordpress.org/Post_Formats
		// A function call of get_post_format($post->ID) can be used to determine the format, 
		// and post_class() will also create the "format-asides" class, for pure-css styling. 
		/*
		 * Pull in a different sub-template, depending on the Post Format.
		 * 
		 * Make sure that there is a default '<tt>format.php</tt>' file to fall back to
		 * as a default. Name templates '<tt>format-link.php</tt>', '<tt>format-aside.php</tt>', etc.
		 *
		 * You should use this in the loop.
		 */

		// $format = get_post_format();
		// get_template_part( 'format', $format );
		
        add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

        // Add menu support. http://codex.wordpress.org/Function_Reference/register_nav_menus
        add_theme_support('menus');
        register_nav_menus(array(
            'primary' => __('Primary Navigation', 'reverie'),
            'additional' => __('Additional Navigation', 'reverie'),
            'utility' => __('Utility Navigation', 'reverie')
        ));

        // Add custom background support
        add_theme_support( 'custom-background',
            array(
                'default-image' => '',  // background image default
                'default-color' => '', // background color default (dont add the #)
                'wp-head-callback' => '_custom_background_cb',
                'admin-head-callback' => '',
                'admin-preview-callback' => ''
            )
        );
    }
}
add_action('after_setup_theme', 'reverie_theme_support'); /* end Reverie theme support */

// create widget areas: sidebar, footer
$sidebars = array('Sidebar');
foreach ($sidebars as $sidebar) {
    register_sidebar(array('name'=> $sidebar,
    	'id' => 'Sidebar',
        'before_widget' => '<article id="%1$s" class="panel widget %2$s">',
        'after_widget' => '</article>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
}
$sidebars = array('Footer');
foreach ($sidebars as $sidebar) {
    register_sidebar(array('name'=> $sidebar,
    	'id' => 'Footer',
        'before_widget' => '<div class="large-3 columns"><article id="%1$s" class="panel widget %2$s">',
        'after_widget' => '</article></div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
}

// Customize Admin Menu Visibility
function remove_admin_menu_links(){
		global $submenu;
		unset($submenu['themes.php'][6]); // remove customize link
	
	$user = wp_get_current_user();
	if( $user && $user->ID !== 2) { // if the user ID it not first admin's
		//remove_menu_page('edit.php'); // Posts
		//remove_menu_page('upload.php'); // Media
		//remove_menu_page('link-manager.php'); // Links
		//remove_menu_page('edit-comments.php'); // Comments
		//remove_menu_page('edit.php?post_type=page'); // Pages
		//remove_submenu_page('plugins.php'); // All Plugins
		remove_submenu_page('plugins.php','plugin-editor.php'); // Plugins Editor
		remove_menu_page('plugin-editor.php'); // Plugin Editor
		remove_submenu_page('themes.php','widgets.php'); // Widgets	
		//remove_submenu_page('themes.php','themes.php'); // Themes
		//remove_submenu_page('themes.php','custom-background'); // custom Background
		//remove_submenu_page('themes.php','theme-editor.php'); // Theme Editor
		//remove_menu_page('customize.php');
		
		remove_menu_page('users.php'); // Users
		remove_menu_page('tools.php'); // Tools
		remove_menu_page('options-general.php'); // Settings
		
		remove_submenu_page('gf_edit_forms','gf_settings');
		remove_submenu_page('gf_edit_forms','gf_export');
		remove_submenu_page('gf_edit_forms','gf_update');
		remove_submenu_page('gf_edit_forms','gf_addons');
		remove_submenu_page('gf_edit_forms','gf_help');

		remove_submenu_page('themes.php','customize.php?return=%2Fwp-admin%2Fpost.php%3Fpost%3D2%26action%3Dedit%26message%3D1');
			
		remove_menu_page('edit.php?post_type=acf-field-group');
		remove_submenu_page('acf-field-group','acf-settings-export');
		remove_submenu_page('acf-field-group','acf-settings-updates');
	}
}
add_action('admin_menu', 'remove_admin_menu_links', 999);


// return entry meta information for posts, used by multiple loops, you can override this function by defining them first in your child theme's functions.php file
if ( ! function_exists( 'reverie_entry_meta' ) ) {
    function reverie_entry_meta() {
        echo '<span class="byline author">'. __('Written by', 'reverie') .' <a href="'. get_author_posts_url(get_the_author_meta('ID')) .'" rel="author" class="fn">'. get_the_author() .', </a></span>';
        echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. get_the_time('F jS, Y') .'</time>';
    }
};

// Customize Gravoty Forms Submit Button
function update_submit_button( $button, $form ){
  return '<button type="submit" id="gform_submit_button_'.$form["id"].'" class="button radius orange tiny"><i class="fa fa-paper-plane"></i> '. $form["button"]["text"] .'</button>';
}
add_filter( 'gform_submit_button', 'update_submit_button', 10, 2 );

// add an Options page for ACF
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Global Fields',
		'menu_title'	=> 'Global Fields',
		'menu_slug' 	=> 'global-fields',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));	
}

// add custom button(s) defined in register-button.js
function register_add_buttons($plugin_array) {
	$plugin_array['revive'] = get_template_directory_uri() . '/js/register-button.js';
	return $plugin_array;
}
function register_register_buttons($buttons) {
	array_push( $buttons, 'bluebutton, greenbutton, orangebutton' );
	return $buttons;
}
function register_buttons() {
	add_filter("mce_external_plugins", "register_add_buttons");
    add_filter('mce_buttons', 'register_register_buttons');
}	
add_action( 'init', 'register_buttons' );

// Custom Admin CSS for styling ACF Message headings
function custom_css() {
   echo '<style type="text/css">
	.acf-field-message {background: #333 !important; border-top: 1px solid #111 !important;}
		.acf-field-message .acf-label,
		.acf-field-message .acf-label label { color: #eee; }
	 </style>';
}
add_action('admin_head', 'custom_css');

// load fontawesome for admin
function load_admin_style() {
	wp_register_style('font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', false, '1.0.0');
	wp_enqueue_style( 'font-awesome' );
}
add_action( 'admin_enqueue_scripts', 'load_admin_style' );

// trims content length to 100 chars, eg trimmed_content(100)
function trimmed_content($value){
	if(get_the_content()){
		$html_excerpt = get_the_content();
		$echo_excerpt = substr($html_excerpt, 0, $value);
		$echo_excerpt .= '...';
		$echo_excerpt .= ' &nbsp;&nbsp;<a href="' . get_permalink() . '">Read More <i class="fa fa-angle-double-right"></i></a>';
		echo  $echo_excerpt;
	}
}

// remove the [...] from posts
function new_excerpt_more( $more ) {
	// return ''; // to remove it
	return ' &nbsp;&nbsp;<a href="' . get_permalink() . '">Read More <i class="fa fa-angle-double-right"></i></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

// shorten excerpt length
function custom_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');


// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		// MORE INFO HERE
		// http://www.tinymce.com/wiki.php/Configuration:formats
		// AND HERE
		// http://www.wpexplorer.com/wordpress-tinymce-tweaks/
		array(  
			'title' => 'Orange Button',  
			'classes' => 'button orange small',
			'selector' => 'a',
		),
		array(  
			'title' => 'Green Button',  
			'classes' => 'button success small',
			'selector' => 'a',
		),
		array(  
			'title' => 'Blue Button',  
			'classes' => 'button small blue',
			'selector' => 'a',
		),
		
		array(  
			'title' => 'Brown Text',  
			'classes' => 'brown-text',
			//'selector' => 'p,h1,h2,h3,h4,h5,h6,a,span,div',
			'inline' => 'span',
			
		),  
		array(  
			'title' => 'Brown Text Light',  
			'classes' => 'brown-text-light',
			//'selector' => 'p,h1,h2,h3,h4,h5,h6,a,span,div',
			'inline' => 'span',
		),
		array(  
			'title' => 'Orange Text',  
			'classes' => 'orange-text',
			//'selector' => 'p,h1,h2,h3,h4,h5,h6,a,span,div',
			'inline' => 'span',
		),
		array(  
			'title' => 'Green Text',  
			'classes' => 'green-text',
		//	'selector' => 'p,h1,h2,h3,h4,h5,h6,a,span,div',
			'inline' => 'span',
		),
		array(  
			'title' => 'Blue Text',  
			'classes' => 'blue-text',
		//	'selector' => 'p,h1,h2,h3,h4,h5,h6,a,span,div',
			'inline' => 'span',
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
} 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

// Custom WYSIWYG Editor CSS
function my_theme_add_editor_styles() {
    add_editor_style( 'css/editor-style.css' );
}
add_action( 'admin_init', 'my_theme_add_editor_styles' );

// fix the tab index of the Gravoty forms, due to multiple per page
function gform_tabindexer( $tab_index, $form = false ) {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    if( $form )
        add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}
add_filter( 'gform_tabindex', 'gform_tabindexer');
// adds ability to name a single categories post page, eg. single-3.php
add_filter('single_template', 
	create_function('$t', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->term_id}.php") ) return TEMPLATEPATH . "/single-{$cat->term_id}.php"; } return $t;' ));

?>