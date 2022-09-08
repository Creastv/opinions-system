<?php
get_header();
 if ( have_posts() ) :
    while ( have_posts() ) : the_post();
       $shop = [
        'permalink' =>   get_permalink( get_the_ID() ),
        'logo'      =>   get_the_post_thumbnail( get_the_ID() ),
        'name'       =>  get_the_title(get_the_ID()),
        'desc'       =>  get_post_meta( get_the_ID(), 'shop-desc', true ),
        'phone'      =>  get_post_meta( get_the_ID(), 'shop-phone', true ),
        'email'      =>  get_post_meta( get_the_ID(), 'shop-email', true ),
        'url'        =>  get_post_meta( get_the_ID(), 'shop-url', true ),
        'address'    =>  get_post_meta( get_the_ID(), 'shop-address', true ),
        'address2'   =>  get_post_meta( get_the_ID(), 'shop-address2', true ),
        'city'       =>  get_post_meta( get_the_ID(), 'shop-city', true ),
        'zip'        =>  get_post_meta( get_the_ID(), 'shop-zip-code', true ),
    ]; 
      echo "<article>";
        echo '<a href=" ' .$shop['permalink'] . ' " >';
        echo $shop['logo'];
        echo '</a>';
        echo "Nazwa sklepu: <strong>";
        echo '<a href=" ' .$shop['permalink'] . ' " >';
        echo $shop['name'];
        echo '</a>';
        echo  "</strong><br>";
        echo "Opis sklepu: <strong>" . $shop['desc'] . "</strong><br>";
        echo "Nr telefonu: <strong>" . $shop['phone'] . "</strong><br>";
        echo "Adres email: <strong>" . $shop['email'] . "</strong><br>";
        echo "Link sklepu: <strong>" . $shop['url'] . "</strong><br>";
        echo "Adress: <strong>" . $shop['address'] . ', '. $shop['address2'] . "</strong><br>";
        echo "Miasto: <strong>" . $shop['city'] . "</strong><br>";
        echo "Kod pocztowy: <strong>" . $shop['zip'] . "</strong><br>";
      echo "</article>";

    endwhile;
    else :
    echo "<h1 class='text-center'>Nic nie znaleziono</h1> ";
 endif;
get_footer();
