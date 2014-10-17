<?php 
add_action( 'init', 'register_cpt_tlw_project' );

function register_cpt_tlw_project() {

    $labels = array( 
        'name' => _x( 'Projects', 'tlw_project' ),
        'singular_name' => _x( 'Project', 'tlw_project' ),
        'add_new' => _x( 'Add New', 'tlw_project' ),
        'add_new_item' => _x( 'Add New Project', 'tlw_project' ),
        'edit_item' => _x( 'Edit Project', 'tlw_project' ),
        'new_item' => _x( 'New Project', 'tlw_project' ),
        'view_item' => _x( 'View Project', 'tlw_project' ),
        'search_items' => _x( 'Search Projects', 'tlw_project' ),
        'not_found' => _x( 'No projects found', 'tlw_project' ),
        'not_found_in_trash' => _x( 'No projects found in Trash', 'tlw_project' ),
        'parent_item_colon' => _x( 'Parent Project:', 'tlw_project' ),
        'menu_name' => _x( 'Projects', 'tlw_project' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'TLW Projects custom post type.',
        'supports' => array( 'editor', 'comments' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-list-view',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => 'projects',
        'can_export' => true,
        'rewrite' => array( 
            'slug' => 'projects', 
            'with_front' => true,
            'feeds' => true,
            'pages' => true
        ),
        'capability_type' => 'post'
    );

    register_post_type( 'tlw_project', $args );
}
 ?>