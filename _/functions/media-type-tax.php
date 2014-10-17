<?php

add_action( 'init', 'register_taxonomy_tlw_media_types' );

function register_taxonomy_tlw_media_types() {

    $labels = array( 
        'name' => _x( 'Media types', 'tlw_media_types' ),
        'singular_name' => _x( 'Media type', 'tlw_media_types' ),
        'search_items' => _x( 'Search Media types', 'tlw_media_types' ),
        'popular_items' => _x( 'Popular Media types', 'tlw_media_types' ),
        'all_items' => _x( 'All Media types', 'tlw_media_types' ),
        'parent_item' => _x( 'Parent Media type', 'tlw_media_types' ),
        'parent_item_colon' => _x( 'Parent Media type:', 'tlw_media_types' ),
        'edit_item' => _x( 'Edit Media type', 'tlw_media_types' ),
        'update_item' => _x( 'Update Media type', 'tlw_media_types' ),
        'add_new_item' => _x( 'Add New Media type', 'tlw_media_types' ),
        'new_item_name' => _x( 'New Media type', 'tlw_media_types' ),
        'separate_items_with_commas' => _x( 'Separate media types with commas', 'tlw_media_types' ),
        'add_or_remove_items' => _x( 'Add or remove media types', 'tlw_media_types' ),
        'choose_from_most_used' => _x( 'Choose from the most used media types', 'tlw_media_types' ),
        'menu_name' => _x( 'Media types', 'tlw_media_types' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,
        'rewrite' => array( 
            'slug' => 'media-type', 
            'with_front' => true,
            'hierarchical' => true
        ),
        'query_var' => 'media-type'
    );

    register_taxonomy( 'tlw_media_types', array('tlw_project'), $args );
}
	
?>