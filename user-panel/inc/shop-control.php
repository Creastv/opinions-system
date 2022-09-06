<?php 
 require_once plugin_dir_path( __FILE__ ) . '/controls-shop/shop-publish.php'; 
 require_once plugin_dir_path( __FILE__ ) . '/controls-shop/shop-view.php'; 
 require_once plugin_dir_path( __FILE__ ) . '/controls-shop/shop-draft.php';

function o_system_control_shop(){
    $user = wp_get_current_user();
    $post = get_post( $user->ID );
    $stat =  get_post_status($post);

    if ( $stat == 'pending' ) { 
            echo 'Weryfikacja wizytówki sklepu przez administratora';
    } elseif ( $stat == 'publish' ) {
            echo 'Wizytówka opublikowana';
   } elseif ( $stat == 'draft' ) {
         echo 'Wizytówka w wersji roboczej';
    }

    if($stat == 'publish') {
        echo o_system_view_shop();
        echo o_system_draft_shop();
    } elseif($stat == 'pending') {
        echo o_system_view_shop();
    } else {
        echo o_system_publish_shop();
       echo o_system_view_shop();

    } 
}