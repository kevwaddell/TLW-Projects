<?php 
if ( !function_exists(core_mods) ) {
	function core_mods() {
		if ( !is_admin() ) {
			wp_register_style( 'font-awesome', 'http:////maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
			wp_register_style( 'styles', get_stylesheet_directory_uri().'/_/css/styles.css', null , filemtime( get_stylesheet_directory().'/_/css/styles.css' ));
			wp_register_style( 'datepicker', 'http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css', null );
			wp_register_script( 'bootstrap-datepicker', 'http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js', array('jquery', 'bootstrap-all-min'), '1.0.0', true );
			wp_register_script( 'bootstrap-tabs', 'http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/tab.min.js', array('jquery'), '1.0.0', true );
			wp_register_script( 'bootstrap-alerts', 'http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/alert.min.js', array('jquery'), '1.0.0', true );
			wp_register_script( 'functions', get_stylesheet_directory_uri() . '/_/js/functions.js', array('jquery', 'bootstrap-all-min', 'bootstrap-tabs'), '1.0.0', true );
			
			wp_enqueue_style('font-awesome');
			wp_enqueue_style('styles');
			wp_enqueue_style('datepicker');
			wp_enqueue_script('bootstrap-datepicker');
			wp_enqueue_script('bootstrap-tabs');
			wp_enqueue_script('bootstrap-alerts');
			wp_enqueue_script('functions');
		}
	}
	core_mods();
}

add_theme_support('html5', array('search-form'));
add_theme_support( 'post-thumbnails' );

add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
 
function my_deregister_styles() {
	wp_deregister_style( 'wp-admin' );
	wp_deregister_style( 'font-awesome-four' );
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function disable_scripts () {
	wp_dequeue_script('jquery-ui-core');
	wp_deregister_script('jquery-ui-core');
}
add_action('wp_enqueue_scripts','disable_scripts');


if ( function_exists( 'register_sidebar' ) ) {
	
	$login_sb_args = array(
	'name'          => "User actions",
	'id'            => "user-actions",
	'description'   => 'Area for logged in user widget',
	'class'         => 'user-links',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<div class="user-title">',
	'after_title'   => '</div>' 
	);
	
	register_sidebar( $login_sb_args );	
}

if( function_exists('add_term_ordering_support') ) {
add_term_ordering_support ('category');
add_term_ordering_support ('tlw_company_tax');

if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
			  'project_links_menu' => 'Project Links',
			  'company_links_menu' => 'Company Links'
			)
		);
}

}

/* CUSTOM POST TYPES */
require_once(STYLESHEETPATH . '/_/functions/projects-cpt.php');
require_once(STYLESHEETPATH . '/_/functions/tasks-cpt.php');

/* CUSTOM TAXONOMIES */
require_once(STYLESHEETPATH . '/_/functions/company-tax.php');
require_once(STYLESHEETPATH . '/_/functions/media-type-tax.php');

/* ACF FUNCTIONS */
require_once(STYLESHEETPATH . '/_/functions/acf-save-post-action.php');

/* COMMENTS */
require_once(STYLESHEETPATH . '/_/functions/project-comments.php');
/* Add a new meta box to the admin menu. */
	add_action( 'admin_menu', 'fm_create_meta_box' );
	
/*
function fm_create_meta_box() {
	add_meta_box( 'post-meta-boxes', __('Debug'), 'debug_meta_box', 'tlw_project', 'normal', 'high' );
}

function debug_meta_box() {
	global $post;
	echo '<pre>';print_r($post);echo '</pre>';
}
*/
if ( ! isset( $content_width ) ) { 
$content_width = 700; 
}

function custom_author_archive( &$query ) {
    if ($query->is_author)
        $query->set( 'post_type', array( 'tlw_project', 'tlw_task' ) );
}
add_action( 'pre_get_posts', 'custom_author_archive' );

?>