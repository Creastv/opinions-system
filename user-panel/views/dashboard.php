<?php 
global $current_user;
wp_get_current_user();
?>
<h4><strong>Witam <?php echo $current_user->user_login; ?></strong></h4>
<p><a href="<?php echo wp_logout_url( home_url() ); ?>">Wyloguj</a></p>