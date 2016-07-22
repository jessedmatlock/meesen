<?php
/*********************
Start all the functions
at once for Reverie.
*********************/

// start all the functions
add_action('after_setup_theme','reverie_startup');

if( ! function_exists( 'reverie_startup ' ) ) {
	function reverie_startup() {

	    // launching operation cleanup
	    add_action('init', 'reverie_head_cleanup');
	    // remove WP version from RSS
	    add_filter('the_generator', 'reverie_rss_version');
	    // remove pesky injected css for recent comments widget
	    add_filter( 'wp_head', 'reverie_remove_wp_widget_recent_comments_style', 1 );
	    // clean up comment styles in the head
	    add_action('wp_head', 'reverie_remove_recent_comments_style', 1);
	    // clean up gallery output in wp
	    add_filter('gallery_style', 'reverie_gallery_style');

	    // enqueue base scripts and styles
	    add_action('wp_enqueue_scripts', 'reverie_scripts_and_styles', 999);
	    // ie conditional wrapper
	    add_filter( 'style_loader_tag', 'reverie_ie_conditional', 10, 2 );
	    
	    // additional post related cleaning
	    add_filter( 'img_caption_shortcode', 'reverie_cleaner_caption', 10, 3 );
	    add_filter('get_image_tag_class', 'reverie_image_tag_class', 0, 4);
	    add_filter('get_image_tag', 'reverie_image_editor', 0, 4);
	    add_filter( 'the_content', 'reverie_img_unautop', 30 );

	} /* end reverie_startup */
}


/**********************
WP_HEAD GOODNESS
The default WordPress head is
a mess. Let's clean it up.

Thanks for Bones
http://themble.com/bones/
**********************/

if( ! function_exists( 'reverie_head_cleanup ' ) ) {
	function reverie_head_cleanup() {
		// category feeds
		// remove_action( 'wp_head', 'feed_links_extra', 3 );
		// post and comment feeds
		// remove_action( 'wp_head', 'feed_links', 2 );
		// EditURI link
		remove_action( 'wp_head', 'rsd_link' );
		// windows live writer
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// index link
		remove_action( 'wp_head', 'index_rel_link' );
		// previous link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		// start link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		// links for adjacent posts
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		// WP version
		remove_action( 'wp_head', 'wp_generator' );
	  // remove WP version from css
	  add_filter( 'style_loader_src', 'reverie_remove_wp_ver_css_js', 9999 );
	  // remove Wp version from scripts
	  add_filter( 'script_loader_src', 'reverie_remove_wp_ver_css_js', 9999 );

	} /* end head cleanup */
}

// remove WP version from RSS
if( ! function_exists( 'reverie_rss_version ' ) ) {
	function reverie_rss_version() { return ''; }
}

// remove WP version from scripts
if( ! function_exists( 'reverie_remove_wp_ver_css_js ' ) ) {
	function reverie_remove_wp_ver_css_js( $src ) {
	    if ( strpos( $src, 'ver=' ) )
	        $src = remove_query_arg( 'ver', $src );
	    return $src;
	}
}

// remove injected CSS for recent comments widget
if( ! function_exists( 'reverie_remove_wp_widget_recent_comments_style ' ) ) {
	function reverie_remove_wp_widget_recent_comments_style() {
	   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
	      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
	   }
	}
}

// remove injected CSS from recent comments widget
if( ! function_exists( 'reverie_remove_recent_comments_style ' ) ) {
	function reverie_remove_recent_comments_style() {
	  global $wp_widget_factory;
	  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
	    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	  }
	}
}

// remove injected CSS from gallery
if( ! function_exists( 'reverie_gallery_style ' ) ) {
	function reverie_gallery_style($css) {
	  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
	}
}

/**********************
Enqueue CSS and Scripts
**********************/

// loading modernizr and jquery, and reply script
if( ! function_exists( 'reverie_scripts_and_styles ' ) ) {
	function reverie_scripts_and_styles() {
	  if (!is_admin()) {

	    // modernizr (without media query polyfill)
	    wp_register_script( 'modernizr-js', get_template_directory_uri() . '/js/vendor/modernizr.js', array(), '2.6.2', false );

	    // register Google font
	    wp_register_style('google-font', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Lora:400,700|Droid+Sans+Mono');

	    // ie-only style sheet
	    wp_register_style( 'ie-css', get_template_directory_uri() . '/css/ie.css', array(), '' );

	    // comment reply script for threaded comments
	    if( get_option( 'thread_comments' ) )  { wp_enqueue_script( 'comment-reply' ); }
	    
	    // adding Foundation scripts file in the footer
		wp_register_script( 'colorbox-js', get_template_directory_uri() . '/js/vendor/jquery.colorbox.js', array( 'jquery' ), '', true );
		
		//
		// EITHER USE /js/foundation/foundation.js OR USE  
		//
		wp_register_script( 'foundation-js', get_template_directory_uri() . '/js/foundation/foundation.js', array( 'jquery' ), '', true );
		wp_register_script( 'topbar-js', get_template_directory_uri() . '/js/foundation/foundation.topbar.js', array( 'jquery' ), '', true );
		wp_register_script( 'reveal-js', get_template_directory_uri() . '/js/foundation/foundation.reveal.js', array( 'jquery' ), '', true );
		wp_register_script( 'tooltip-js', get_template_directory_uri() . '/js/foundation/foundation.tooltip.js', array( 'jquery' ), '', true );
		wp_register_script( 'dropdown-js', get_template_directory_uri() . '/js/foundation/foundation.dropdown.js', array( 'jquery' ), '', true );
		wp_register_script( 'alert-js', get_template_directory_uri() . '/js/foundation/foundation.alert.js', array( 'jquery' ), '', true );
			wp_register_script( 'orbit-js', get_template_directory_uri() . '/js/foundation/foundation.orbit.js', array( 'jquery' ), '', true );
			wp_register_script( 'slider-js', get_template_directory_uri() . '/js/foundation/foundation.slider.js', array( 'jquery' ), '', true );
			wp_register_script( 'tab-js', get_template_directory_uri() . '/js/foundation/foundation.tab.js', array( 'jquery' ), '', true );
			wp_register_script( 'accordion-js', get_template_directory_uri() . '/js/foundation/foundation.accordion.js', array( 'jquery' ), '', true );
			wp_register_script( 'abide-js', get_template_directory_uri() . '/js/foundation/foundation.abide.js', array( 'jquery' ), '', true );
			wp_register_script( 'clearing-js', get_template_directory_uri() . '/js/foundation/foundation.clearing.js', array( 'jquery' ), '', true );
			wp_register_script( 'equalizer-js', get_template_directory_uri() . '/js/foundation/foundation.equalizer.js', array( 'jquery' ), '', true );
			wp_register_script( 'interchange-js', get_template_directory_uri() . '/js/foundation/foundation.interchange.js', array( 'jquery' ), '', true );
			wp_register_script( 'joyride-js', get_template_directory_uri() . '/js/foundation/foundation.joyride.js', array( 'jquery' ), '', true );
			wp_register_script( 'magellan-js', get_template_directory_uri() . '/js/foundation/foundation.magellan.js', array( 'jquery' ), '', true );
			wp_register_script( 'offcanvas-js', get_template_directory_uri() . '/js/foundation/foundation.offcanvas.js', array( 'jquery' ), '', true );
		//
		// OR THIS /js/foundation.min.js for a combined file of all plugins
		//	wp_register_script( 'foundation-min-js', get_template_directory_uri() . '/js/foundation/foundation.js', array( 'jquery' ), '', true );		
		//

	    // adding easing scripts file in the footer
	    wp_register_script( 'easing-js', get_template_directory_uri() . '/js/vendor/jquery.easing.min.js', array( 'jquery' ), '', true );

	    // adding Wow scripts file in the footer
	    wp_register_script( 'wow-js', get_template_directory_uri() . '/js/vendor/wow.min.js', array( 'jquery' ), '', true );

	    // adding Wow scripts file in the footer
	    wp_register_script( 'owl-js', get_template_directory_uri() . '/js/vendor/owl.carousel.min.js', array( 'jquery' ), '', true );

		// load out app.js file to init our calls, functions, etc.
		wp_register_script( 'app-js', get_template_directory_uri() . '/js/app.js', array( 'jquery' ), '', true );
	
	    
	    global $is_IE;
	    if ($is_IE) {
	       wp_register_script ( 'html5shiv', "http://html5shiv.googlecode.com/svn/trunk/html5.js" , false, true);
	    }
	
	    wp_enqueue_style( 'google-font' );
	    wp_enqueue_style('ie-css');
	
	    // enqueue styles and scripts
	    wp_enqueue_script( 'modernizr-js' );
	
		// lets stop jQuery from loading out of the WP install and load our own, so we have the newest.
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', get_template_directory_uri() . "/js/vendor/jquery.js", false, null);
	   wp_enqueue_script('jquery');

	    wp_enqueue_script( 'html5shiv' );
	    
		// you'll need to compile the Foundation JS files into a min.js file first, then call it here.. and remove all other Foundation JS loads		
		
		wp_enqueue_script( 'foundation-js');
			wp_enqueue_script( 'topbar-js');
			wp_enqueue_script( 'reveal-js');
			wp_enqueue_script( 'tooltip-js');
			wp_enqueue_script( 'dropdown-js');
			wp_enqueue_script( 'alert-js');
			//wp_enqueue_script( 'orbit-js');
			//wp_enqueue_script( 'slider-js');
			//wp_enqueue_script( 'tab-js');
			//wp_enqueue_script( 'accordion-js');
			//wp_enqueue_script( 'abide-js');
			//wp_enqueue_script( 'clearing-js');
			//wp_enqueue_script( 'equalizer-js');
			//wp_enqueue_script( 'interchange-js');
			//wp_enqueue_script( 'joyride-js');
			//wp_enqueue_script( 'magellan-js');
			//wp_enqueue_script( 'offcanvas-js');			
			
		// OR
		// wp_enqueue_script( 'foundation-min-js');		
		
		wp_enqueue_script( 'colorbox-js');
	   	wp_enqueue_script( 'easing-js' );
	   	wp_enqueue_script( 'owl-js' );
	    wp_enqueue_script( 'wow-js' );
	   	
		// init custom app.js functions
		wp_enqueue_script( 'app-js');
	  }
	}
}

// adding the conditional wrapper around ie stylesheet
// source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
if( ! function_exists( 'reverie_ie_conditional ' ) ) {
	function reverie_ie_conditional( $tag, $handle ) {
		if ( 'reverie-ie-only' == $handle )
			$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
		return $tag;
	}
}

/*********************
Post related cleaning
*********************/
/* Customized the output of caption, you can remove the filter to restore back to the WP default output. Courtesy of DevPress. http://devpress.com/blog/captions-in-wordpress/ */
if( ! function_exists( 'reverie_cleaner_caption ' ) ) {
	function reverie_cleaner_caption( $output, $attr, $content ) {

		/* We're not worried abut captions in feeds, so just return the output here. */
		if ( is_feed() )
			return $output;

		/* Set up the default arguments. */
		$defaults = array(
			'id' => '',
			'align' => 'alignnone',
			'width' => '',
			'caption' => ''
		);

		/* Merge the defaults with user input. */
		$attr = shortcode_atts( $defaults, $attr );

		/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
		if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
			return $content;

		/* Set up the attributes for the caption <div>. */
		$attributes = ' class="figure ' . esc_attr( $attr['align'] ) . '"';

		/* Open the caption <div>. */
		$output = '<figure' . $attributes .'>';

		/* Allow shortcodes for the content the caption was created for. */
		$output .= do_shortcode( $content );

		/* Append the caption text. */
		$output .= '<figcaption>' . $attr['caption'] . '</figcaption>';

		/* Close the caption </div>. */
		$output .= '</figure>';

		/* Return the formatted, clean caption. */
		return $output;
		
	} /* end reverie_cleaner_caption */
}

// Clean the output of attributes of images in editor. Courtesy of SitePoint. http://www.sitepoint.com/wordpress-change-img-tag-html/
if( ! function_exists( 'reverie_image_tag_class ' ) ) {
	function reverie_image_tag_class($class, $id, $align, $size) {
		$align = 'align' . esc_attr($align);
		return $align;
	} /* end reverie_image_tag_class */
}

// Remove width and height in editor, for a better responsive world.
if( ! function_exists( 'reverie_image_editor ' ) ) {
	function reverie_image_editor($html, $id, $alt, $title) {
		return preg_replace(array(
				'/\s+width="\d+"/i',
				'/\s+height="\d+"/i',
				'/alt=""/i'
			),
			array(
				'',
				'',
				'',
				'alt="' . $title . '"'
			),
			$html);
	} /* end reverie_image_editor */
}

// Wrap images with figure tag. Courtesy of Interconnectit http://interconnectit.com/2175/how-to-remove-p-tags-from-images-in-wordpress/
if( ! function_exists( 'reverie_img_unautop ' ) ) {
	function reverie_img_unautop($pee) {
	    $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
	    return $pee;
	} /* end reverie_img_unautop */
} ?>