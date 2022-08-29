<?php 
$user = wp_get_current_user();
$shop = array (
    'id'  => $current_user->id,
    'kk'  => get_the_author_meta( 'customer-key', $current_user->id ),
    'kp' => get_the_author_meta( 'private-key', $current_user->id ),
);

if($shop['kk'] && $shop['kp']){
echo "<h4> Klucze twojego sklepu WooCommerce</h4>";    
echo "ID sklepu: <strong>" . $shop['id'] . "</strong><br>";
echo "Klucz klienta: <strong>" . $shop['kk'] . "</strong><br>";
echo "Klucz prywatny: <strong>" . $shop['kp'] . "</strong><br>";
}

echo "<h4> Zmień lub dodaj klucze REAST API Twojego sklepu WooCommerce</h4>";
echo '<p>Sprawdź gdzie znaleść swoje klucze - <a href="#">Czytaj więcej</a></p>';
echo " <br>";

echo do_shortcode('[o-system-add-api]');

?>
