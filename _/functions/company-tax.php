<?php

add_action( 'init', 'register_taxonomy_tlw_company_tax' );

function register_taxonomy_tlw_company_tax() {

    $labels = array( 
        'name' => _x( 'Companies', 'tlw_company_tax' ),
        'singular_name' => _x( 'Company', 'tlw_company_tax' ),
        'search_items' => _x( 'Search Companies', 'tlw_company_tax' ),
        'popular_items' => _x( 'Popular Companies', 'tlw_company_tax' ),
        'all_items' => _x( 'All Companies', 'tlw_company_tax' ),
        'parent_item' => _x( 'Parent Company', 'tlw_company_tax' ),
        'parent_item_colon' => _x( 'Parent Company:', 'tlw_company_tax' ),
        'edit_item' => _x( 'Edit Company', 'tlw_company_tax' ),
        'update_item' => _x( 'Update Company', 'tlw_company_tax' ),
        'add_new_item' => _x( 'Add New Company', 'tlw_company_tax' ),
        'new_item_name' => _x( 'New Company', 'tlw_company_tax' ),
        'separate_items_with_commas' => _x( 'Separate companies with commas', 'tlw_company_tax' ),
        'add_or_remove_items' => _x( 'Add or remove companies', 'tlw_company_tax' ),
        'choose_from_most_used' => _x( 'Choose from the most used companies', 'tlw_company_tax' ),
        'menu_name' => _x( 'Companies', 'tlw_company_tax' ),
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
            'slug' => 'company', 
            'with_front' => true,
            'hierarchical' => true
        ),
        'query_var' => 'company'
    );

    register_taxonomy( 'tlw_company_tax', array('tlw_project'), $args );
}
	
?>