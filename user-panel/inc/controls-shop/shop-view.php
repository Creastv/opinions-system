<?php 
function o_system_view_shop(){
  return '<a href=" ' . get_permalink( $current_user->id ) . ' " target="_blank" class="o-systm-btn">Idź do wizytówki sklepu</a> ';
}

add_action('wp', 'o_system_view_shop');