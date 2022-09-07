<?php 
// $user = wp_get_current_user();
$shop = array (
    'id'  => $current_user->id,
    'kk'  => get_the_author_meta( 'customer-key', $current_user->id ),
    'kp' => get_the_author_meta( 'private-key', $current_user->id ),
);

if($shop['kk'] && $shop['kp']){
echo "<h4> Klucze twojego sklepu WooCommerce</h4>";    
echo "ID sklepu: <strong>" . $shop['id'] . "</strong><br>";
echo "Klucz klienta: <strong> ***********" . substr($shop['kk'],-4) . "</strong><br>";
echo "Klucz prywatny: <strong> ***********" . substr($shop['kp'],-4) . "</strong><br>";
echo o_system_shope_api_delate();
echo "<h4>Edytuj klucze</h4>";
echo " <br>";

} else {

echo "<h4> Dodaj klucze REAST API Twojego sklepu WooCommerce</h4>";
echo '<p>Sprawdź gdzie znaleść swoje klucze - <a href="#">Czytaj więcej</a></p>';
echo " <br>";
}

echo o_system_add_api();