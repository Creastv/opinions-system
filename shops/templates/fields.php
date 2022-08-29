<?php
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