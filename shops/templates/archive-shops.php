<?php
get_header();
 if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      require_once plugin_dir_path( __FILE__ ) . '/content-shop.php';
    endwhile;
    else :
    echo "<h1 class='text-center'>Nic nie znaleziono</h1> ";
 endif;
get_footer();
