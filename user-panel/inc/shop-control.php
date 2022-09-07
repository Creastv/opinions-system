<?php 
function o_system_control_shop(){
    ob_start();
  
    $post = get_post( $current_user->ID );
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
    $control_shop = ob_get_clean();
    return $control_shop;
}