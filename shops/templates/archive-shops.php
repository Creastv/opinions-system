<?php
get_header();
 if ( have_posts() ) :
    while ( have_posts() ) : the_post();
    global $post;
    $shop = [
        // 'logo'  => get_the_author_meta( 'picture', $current_user->id ),
        'name' => get_the_author_meta( 'shop-name', $post->id ),
        'desc'  => get_the_author_meta( 'shop-desc', $post->id ),
        'phone'  => get_the_author_meta( 'shop-phone', $post->id ),
        'email'  => get_the_author_meta( 'shop-email', $post->id ),
        'url'  => get_the_author_meta( 'shop-url', $post->id ),

        'address'  => get_the_author_meta( 'shop-address', $post->id ),
        'address2'  => get_the_author_meta( 'shop-address2', $post->id ),
        'city'  => get_the_author_meta( 'shop-city', $post->id ),
        'zip'  => get_the_author_meta( 'shop-zip-code', $post->id ),
    ];
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
    else :
    echo "<h1 class='text-center'>Nic nie znaleziono</h1> ";
 endif;
get_footer();
