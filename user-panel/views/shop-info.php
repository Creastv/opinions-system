<?php 
$post = get_post($current_user->ID);
$shop = [
    'logo'       =>  get_the_post_thumbnail( $current_user->id, 'thumbnail' ),
    'name'       =>  $post->post_title,
    'desc'       =>  get_post_meta( $current_user->id, 'shop-desc', true ),
    'phone'      =>  get_post_meta( $current_user->id, 'shop-phone', true ),
    'email'      =>  get_post_meta( $current_user->id, 'shop-email', true ),
    'url'        =>  get_post_meta( $current_user->id, 'shop-url', true ),
    'address'    =>  get_post_meta( $current_user->id, 'shop-address', true ),
    'address2'   =>  get_post_meta( $current_user->id, 'shop-address2', true ),
    'city'       =>  get_post_meta( $current_user->id, 'shop-city', true ),
    'zip'        =>  get_post_meta( $current_user->id, 'shop-zip-code', true ),
]; 

// echo o_system_control_shop();


if($shop['logo']){
 echo $shop['logo'];
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

