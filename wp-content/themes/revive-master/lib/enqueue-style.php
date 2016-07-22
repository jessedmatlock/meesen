<?php
/*********************
Enqueue the proper CSS
if you use Sass.
*********************/
if( ! function_exists( 'reverie_enqueue_style' ) ) {
	function reverie_enqueue_style()
	{
		// foundation stylesheet
		//wp_register_style( 'reverie-foundation-stylesheet', get_stylesheet_directory_uri() . '/css/app.css', array(), '' );

		// Register the main style
		wp_register_style( 'foundation-stylesheet', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );
		
		// Font Awesome stylesheet
		wp_register_style( 'font-awesome-stylesheet', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '' );
		
		// Register animations
		wp_register_style( 'animate-stylesheet', get_stylesheet_directory_uri() . '/css/animate.css', array(), '', 'all' );
		
		// Register Owl css
		wp_register_style( 'owl-stylesheet', get_stylesheet_directory_uri() . '/css/owl.carousel.css', array(), '', 'all' );
		wp_register_style( 'owltheme-stylesheet', get_stylesheet_directory_uri() . '/css/owl.theme.css', array(), '', 'all' );
		wp_register_style( 'colorbox-stylesheet', get_stylesheet_directory_uri() . '/css/colorbox.css', array(), '', 'all' );
		
		
		//wp_enqueue_style( 'reverie-foundation-stylesheet' );
		wp_enqueue_style( 'foundation-stylesheet' );
		wp_enqueue_style( 'font-awesome-stylesheet' );		
		wp_enqueue_style( 'animate-stylesheet' );		
		wp_enqueue_style( 'owl-stylesheet' );		
		wp_enqueue_style( 'owltheme-stylesheet' );		
		wp_enqueue_style( 'colorbox-stylesheet' );		
		
	}
}
add_action( 'wp_enqueue_scripts', 'reverie_enqueue_style' );
?>
