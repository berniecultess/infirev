<?php
/**
 * Functions - general template functions that are used throughout EvoLve
 *
 * @package evolve
 * @subpackage Functions
 */

add_action('wp_ajax_evolve_dynamic_css', 'evolve_dynamic_css');
add_action('wp_ajax_nopriv_evolve_dynamic_css', 'evolve_dynamic_css');

function evolve_dynamic_css() {
	global $wp_customize;  
	if ( method_exists($wp_customize,'is_preview') and ! is_admin() ) {} else {
		header('Content-type: text/css');  
	}
	
	require (get_template_directory().'/custom-css.php');
	exit;
}

function evolve_media() {
	global $evl_options;
	$template_url = get_template_directory_uri();
	
	$evolve_css_data = '';
  
	$evolve_pagination_type = evolve_get_option('evl_pagination_type', 'pagination');  
	$evolve_pos_button = evolve_get_option('evl_pos_button','right');                                                                       
	$evolve_carousel_slider = evolve_get_option('evl_carousel_slider', '1');
	$evolve_parallax_slider = evolve_get_option('evl_parallax_slider_support', '1');
	$evolve_status_gmap = evolve_get_option('evl_status_gmap','1');
	$evolve_recaptcha_public = evolve_get_option('evl_recaptcha_public','');
	$evolve_recaptcha_private = evolve_get_option('evl_recaptcha_private','');  
	$evolve_fontawesome = evolve_get_option('evl_fontawesome','0');
  
	if( is_admin() ) return;

  wp_enqueue_script( 'jquery' );
  wp_deregister_script( 'hoverIntent' );  
  
  $evolve_animatecss = evolve_get_option('evl_animatecss', '1');
  
  if ($evolve_animatecss == "1") {
  wp_enqueue_style( 'animatecss', EVOLVEJS . '/animate-css/animate-custom.css' );
  }

  if ($evolve_parallax_slider == "1") {   
  wp_enqueue_script( 'parallax', EVOLVEJS . '/parallax/parallax.js' );
  wp_enqueue_style( 'parallaxcss', EVOLVEJS . '/parallax/parallax.css' );
  wp_enqueue_script( 'modernizr', EVOLVEJS . '/parallax/modernizr.js' ); 
  }
  
  if ($evolve_carousel_slider == "1") { wp_enqueue_script( 'carousel', EVOLVEJS . '/carousel.js' ); }
  wp_enqueue_script( 'tipsy', EVOLVEJS . '/tipsy.js' );
  wp_enqueue_script( 'fields', EVOLVEJS . '/fields.js' );
  //if ($evolve_pagination_type == "infinite") {
  wp_enqueue_script( 'jscroll', EVOLVEJS . '/jquery.infinite-scroll.min.js' );
  //}  
   
  if ($evolve_pos_button == "disable" || $evolve_pos_button == "") {} else { wp_enqueue_script( 'jquery_scroll', EVOLVEJS . '/jquery.scroll.pack.js' ); }      
  wp_enqueue_script( 'supersubs', EVOLVEJS . '/supersubs.js' );
  wp_enqueue_script( 'superfish', EVOLVEJS . '/superfish.js' );
  wp_enqueue_script( 'hoverIntent', EVOLVEJS . '/hoverIntent.js' );
  wp_enqueue_script( 'buttons', EVOLVEJS . '/buttons.js' );
  wp_enqueue_script( 'ddslick', EVOLVEJS . '/ddslick.js' );
  wp_enqueue_script( 'flexslider', EVOLVEJS . '/jquery.flexslider.js' );
  wp_enqueue_script( 'flexslidermin', EVOLVEJS . '/jquery.flexslider-min.js' );
  wp_enqueue_script( 'prettyphoto', EVOLVEJS . '/jquery.prettyPhoto.js' );
  wp_enqueue_script( 'modernizr-2', EVOLVEJS . '/modernizr.js' );
  wp_enqueue_script( 'carouFredSel', EVOLVEJS . '/jquery.carouFredSel.js' );  
  wp_enqueue_script( 'main', EVOLVEJS . '/main.js', array(), '', true );
  //wp_enqueue_script( 'jquery.fitvids', EVOLVEJS . '/jquery.fitvids-min.js', array(), '', true );
  
  if ($evolve_status_gmap == "1") {   
  wp_enqueue_script( 'googlemaps', '//maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;language='.mb_substr(get_locale(), 0, 2) );        
  wp_enqueue_script( 'gmap', EVOLVEJS . '/gmap.js', array(), '', true);
  }
  
  if ($evolve_recaptcha_public && $evolve_recaptcha_private) {
  wp_enqueue_script( 'googlerecaptcha', 'https://www.google.com/recaptcha/api.js' );        
  }
 
  if ($evolve_fontawesome != "1") { 
  // FontAwesome 
  wp_enqueue_style( 'fontawesomecss', EVOLVEJS . '/fontawesome/css/font-awesome.css' ); 
  }
  
                   
  function evolve_woosliderfunc($term) {
	   global $slider_settings;    
    $term_details = get_term_by('slug', $term, 'slide-page');
    $slider_settings = get_option('taxonomy_' . $term_details->term_id);
	
	$slider_local_variables = array(
			'slide_show_speed' => $slider_settings['slideshow_speed'],
			'slide_animation' => $slider_settings['animation'],
			'slide_animation_speed' => $slider_settings['animation_speed'],
			'slide_auto_play' => ($slider_settings['autoplay'] == 1 ? true : false),
			'slide_nav_arrows' => ($slider_settings['nav_arrows'] == 1 ? true : false),
			'slide_pagination_circles' => ($slider_settings['pagination_circles'] == 1 ? true : false),
			'slide_loop' => ($slider_settings['loop'] == 1 ? true : false),
		);    	    

	wp_localize_script('main', 'js_local_vars', $slider_local_variables );  
	
  }

	// Main Stylesheet
	function evolve_styles() {
		global $wp_customize;

		wp_enqueue_style('maincss', get_stylesheet_uri(), false);
		if ( method_exists($wp_customize,'is_preview') and ! is_admin() ){
			// Custom CSS for Customizer
			require_once( get_template_directory() . '/custom-css.php' ); 
			wp_add_inline_style( 'maincss', $evolve_css_data ); 
		} else {
			// Custom CSS for Live website
			wp_enqueue_style( 'dynamic-css', esc_url(admin_url('admin-ajax.php').'?action=evolve_dynamic_css'));
		}
		// Shortcode.css
		wp_enqueue_style( 'shortcode', EVOLVEJS . '/css/shortcodes.css' );
		wp_enqueue_style( 'animations', EVOLVEJS . '/css/animations.css' ); 
	}
	add_action( 'wp_enqueue_scripts', 'evolve_styles' );  
 

if( defined('ICL_LANGUAGE_CODE') ) {
			$language_code = ICL_LANGUAGE_CODE;
		} else {
			$language_code = '';
		} 
		//$evl_portfolio_pagination_type = isset($evl_options['evl_portfolio_pagination_type']) ? $evl_options['evl_portfolio_pagination_type'] : '';
		$local_variables = array(
			'mobile_nav_cart' => __('Shopping Cart', 'evolve'),
			'language_flag' => $language_code,
			'testimonials_speed' => $evl_options['evl_shortcode_testimonial_speed'], 
			'infinite_blog_finished_msg' 	=> '<em>'.__('All posts displayed', 'evolve').'</em>',
			'infinite_blog_text' 			=> '<em>'. __('Loading the next set of posts...', 'evolve').'</em>',
			'portfolio_loading_text' 		=> '<em>'. __('Loading Portfolio Items...', 'evolve').'</em>',
			'theme_url' 					=> get_template_directory_uri(),			
			//'blog_pagination_type'			=> $evl_portfolio_pagination_type,			
			'order_actions' =>  __('Details', 'evolve') 
		);
    	    
    global $woocommerce;
    
		if( class_exists( 'Woocommerce' ) ) {
			if( version_compare( $woocommerce->version, '2.3', '>=' ) ) {
				$local_variables['woocommerce_23'] = true;
			}
		}

		wp_localize_script('main', 'js_local_vars', $local_variables );  

  // Media.css
  
  wp_enqueue_style( 'mediacss', get_bloginfo( 'template_directory' ). '/library/media/css/media.css', array('maincss'));
          

  
  // Bootstrap Elements        
  wp_enqueue_script( 'bootstrap', EVOLVEJS . '/bootstrap/js/bootstrap.js' ); 
  wp_enqueue_style( 'bootstrapcss', EVOLVEJS . '/bootstrap/css/bootstrap.css', array('maincss') );
  wp_enqueue_style( 'bootstrapcsstheme', EVOLVEJS . '/bootstrap/css/bootstrap-theme.css', array('bootstrapcss') ); 

	
}

/**
 * evolve_menu - adds css class to the <ul> tag in wp_page_menu.
 *
 * @since 0.3
 * @filter evolve_menu_ulclass
 * @needsdoc
 */
function evolve_menu_ulclass( $ulclass ) {
	$classes = apply_filters( 'evolve_menu_ulclass', (string) 'nav-menu' ); // Available filter: evolve_menu_ulclass
	return preg_replace( '/<ul>/', '<ul class="'. $classes .'">', $ulclass, 1 );
}

/**
 * evolve_get_terms() Returns other terms except the current one (redundant)
 *
 * @since 0.2.3
 * @usedby evolve_entry_footer()
 */
function evolve_get_terms( $term = NULL, $glue = ', ' ) {
	if ( !$term ) return;
	
	$separator = "\n";
	switch ( $term ):
		case 'cats':
			$current = single_cat_title( '', false );
			$terms = get_the_category_list( $separator );
			break;
		case 'tags':
			$current = single_tag_title( '', '',  false );
			$terms = get_the_tag_list( '', "$separator", '' );
			break;
	endswitch;
	if ( empty($terms) ) return;
	
	$thing = explode( $separator, $terms );
	foreach ( $thing as $i => $str ) {
		if ( strstr( $str, ">$current<" ) ) {
			unset( $thing[$i] );
			break;
		}
	}
	if ( empty( $thing ) )
		return false;

	return trim( join( $glue, $thing ) );
}

/**
 * evolve_get Gets template files
 *
 * @since 0.2.3
 * @needsdoc
 * @action evolve_get
 * @todo test this on child themes
 */
function evolve_get( $file = NULL ) {
	do_action( 'evolve_get' ); // Available action: evolve_get
	$error = "Sorry, but <code>{$file}</code> does <em>not</em> seem to exist. Please make sure this file exist in <strong>" . get_stylesheet_directory() . "</strong>\n";
	$error = apply_filters( 'evolve_get_error', (string) $error ); // Available filter: evolve_get_error
	if ( isset( $file ) && file_exists( get_stylesheet_directory() . "/{$file}.php" ) )
		locate_template( get_stylesheet_directory() . "/{$file}.php" );
	else
        echo $error;
}

/**
 * evolve_include_all() A function to include all files from a directory path
 *
 * @since 0.2.3
 * @credits k2
 */
function evolve_include_all( $path, $ignore = false ) {

	/* Open the directory */
	$dir = @dir( $path ) or die( 'Could not open required directory ' . $path );
	
	/* Get all the files from the directory */
	while ( ( $file = $dir->read() ) !== false ) {
		/* Check the file is a file, and is a PHP file */
		if ( is_file( $path . $file ) and ( !$ignore or !in_array( $file, $ignore ) ) and preg_match( '/\.php$/i', $file ) ) {
			require_once( $path . $file );
		}
	}		
	$dir->close(); // Close the directory, we're done.
}


/**
 * reCaptcha Class
 *
 * @recaptcha 2
 * @since 1.7.9
 */
class evolve_GoogleRecaptcha {

    /* Google recaptcha API url */    
 
    public function VerifyCaptcha($response) {		

		$response = isset( $_POST['g-recaptcha-response'] ) ? esc_attr( $_POST['g-recaptcha-response'] ) : '';
		$remote_ip = $_SERVER["REMOTE_ADDR"];
		$secret = evolve_get_option('evl_recaptcha_private','');
		$request = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response . '&remoteip=' . $remote_ip );	
        $response_body = wp_remote_retrieve_body($request);  
        $res = json_decode($response_body, TRUE);
        if($res['success'] == 'true') 
            return TRUE;
        else
            return FALSE;
    } 
} 