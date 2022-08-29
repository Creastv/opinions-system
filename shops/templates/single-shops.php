<?php
get_header();
require_once plugin_dir_path( __FILE__ ) . 'fields.php'; 
while ( have_posts() ) : the_post();
   echo "<article>";
   echo '<br><br>';
    echo "Nazwa sklepu: <strong>" . $shop['name'] . "</strong><br>";
    echo "Opis sklepu: <strong>" . $shop['desc'] . "</strong><br>";
    echo "Nr telefonu: <strong>" . $shop['phone'] . "</strong><br>";
    echo "Adres email: <strong>" . $shop['email'] . "</strong><br>";
    echo "Link sklepu: <strong>" . $shop['url'] . "</strong><br>";
    echo "Adress: <strong>" . $shop['address'] . ', '. $shop['address2'] . "</strong><br>";
    echo "Miasto: <strong>" . $shop['city'] . "</strong><br>";
    echo "Kod pocztowy: <strong>" . $shop['zip'] . "</strong><br>";
   echo "</article>";
endwhile;
get_footer();