<?php 
$user = wp_get_current_user();
$shop = [
    // 'logo'  => get_the_author_meta( 'picture', $current_user->id ),
    'name' => get_the_author_meta( 'shop-name', $current_user->id ),
    'desc'  => get_the_author_meta( 'shop-desc', $current_user->id ),
    'phone'  => get_the_author_meta( 'shop-phone', $current_user->id ),
    'email'  => get_the_author_meta( 'shop-email', $current_user->id ),
    'url'  => get_the_author_meta( 'shop-url', $current_user->id ),

    'address'  => get_the_author_meta( 'shop-address', $current_user->id ),
    'address2'  => get_the_author_meta( 'shop-address2', $current_user->id ),
    'city'  => get_the_author_meta( 'shop-city', $current_user->id ),
    'zip'  => get_the_author_meta( 'shop-zip-code', $current_user->id ),
];


if($shop['name'] ) {
echo '<br><br>';
echo '<a href=" ' . get_permalink( $current_user->id ) . ' " target="_blank">Podgląd profilu sklepu</a> ';
}

if($shop['name']) {
echo '<br><br>';
echo "ID sklepu: <strong>" . $current_user->id . "</strong><br>";


echo "Nazwa sklepu: <strong>" . $shop['name'] . "</strong><br>";
}
if($shop['desc']) {
echo "Opis sklepu: <strong>" . $shop['desc'] . "</strong><br>";
}
if($shop['phone']) {
echo "Nr telefonu: <strong>" . $shop['phone'] . "</strong><br>";
}
if($shop['email']) {
echo "Adres email: <strong>" . $shop['email'] . "</strong><br>";
}
if($shop['url']) {
echo "Link sklepu: <strong>" . $shop['url'] . "</strong><br>";
}
if($shop['address']) {
echo "Adress: <strong>" . $shop['address'] . ', '. $shop['address2'] . "</strong><br>";
}
if($shop['city']) {
echo "Miasto: <strong>" . $shop['city'] . "</strong><br>";
}
if($shop['zip']) {
echo "Kod pocztowy: <strong>" . $shop['zip'] . "</strong><br>";
}

if(!$shop['name'] && !$shop['desc'] && !$shop['url']) {
    echo 'Dodaj swój sklep  w zakładce <b>Ustawienia sklepu</b>';
}

