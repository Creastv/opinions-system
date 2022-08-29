<?php 
// //////////////////////////////////////////////////////////////Case study
function o_system_post_types() {

	$labels = array(
		'name'               => 'Shops',
		'singular_name'      => 'Shops',
		'menu_name'          => 'Shops',
		'name_admin_bar'     => 'Shops',
		'add_new'            => 'Add',
		'add_new_item'       => 'Add ',
		'new_item'           => 'New',
		'edit_item'          => 'Edit ',
		'view_item'          => 'View ',
		'all_items'          => 'Shops',
		'search_items'       => 'Search',
		'parent_item_colon'  => 'Parent :',
		'not_found'          => 'Not found',
		'not_found_in_trash' => 'Not found',
		
	);
	$args = array( 
	    'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'hierarchical'      => true,
		'menu_icon'     => get_template_directory_uri().'/src/img/admin-crown.png',
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'publicly_queryable' => true,
		'show_in_rest' => true,
		"rewrite"             => array( "slug" => "shops", "with_front" => true ),
		'supports'      => array( 'title' ),
		// , 'editor' 
	);
    	register_post_type( 'shops', $args );

}
add_action( 'init', 'o_system_post_types' );

require_once plugin_dir_path( __FILE__ ) . '/custom-fields.php';


add_filter( 'single_template', 'o_system_single_shop_template' );
function o_system_single_shop_template( $single_template ){
    global $post;
    $file = dirname(__FILE__) .'/templates/single-'. $post->post_type .'.php';
    if( file_exists( $file ) ) $single_template = $file;
    return $single_template;
}

add_filter( 'archive_template', 'o_system_archive_shop_template' );
function o_system_archive_shop_template( $archive_template ){
    global $post;
    $archive = dirname(__FILE__) .'/templates/archive-'. $post->post_type .'.php';
    if( file_exists( $archive ) ) $archive_template = $archive;
    return $archive_template;
}