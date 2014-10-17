<?php 
add_action( 'init', 'register_cpt_tlw_task' );

function register_cpt_tlw_task() {

    $labels = array( 
        'name' => _x( 'Tasks', 'tlw_task' ),
        'singular_name' => _x( 'Task', 'tlw_task' ),
        'add_new' => _x( 'Add New', 'tlw_task' ),
        'add_new_item' => _x( 'Add New Task', 'tlw_task' ),
        'edit_item' => _x( 'Edit Task', 'tlw_task' ),
        'new_item' => _x( 'New Task', 'tlw_task' ),
        'view_item' => _x( 'View Task', 'tlw_task' ),
        'search_items' => _x( 'Search Tasks', 'tlw_task' ),
        'not_found' => _x( 'No tasks found', 'tlw_task' ),
        'not_found_in_trash' => _x( 'No tasks found in Trash', 'tlw_task' ),
        'parent_item_colon' => _x( 'Parent Task:', 'tlw_task' ),
        'menu_name' => _x( 'Tasks', 'tlw_task' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'TLW Tasks custom post type.',
        'supports' => array( 'editor' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-yes',
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => 'task',
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'tlw_task', $args );
} 
?>