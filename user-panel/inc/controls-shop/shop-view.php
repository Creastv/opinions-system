<?php 
function o_system_view_shop(){
  ob_start();
  echo '<a href=" ' . get_permalink( $current_user->id ) . ' " target="_blank" class="o-systm-btn">Idź do wizytówki sklepu</a> ';
  $view_shop = ob_get_clean();
  return $view_shop;
}

add_action('wp', 'o_system_view_shop');