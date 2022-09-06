<?php 
function o_system_view_shop(){
  $user = wp_get_current_user();
  return '<a href=" ' . get_permalink( $user->id ) . ' " target="_blank" class="o-systm-btn">Idź do wizytówki sklepu</a> ';
}

add_action('wp', 'o_system_view_shop');