<?php 
// https://tutorialeswp.com/crear-custom-post-types-y-custom-fields-en-wordpress/

function lr_register_meta_boxes() {
	add_meta_box( 'mi-meta-box-id', 'Ogólne informacje sklepu', 'lr_mi_display_callback', 'shops' );
}
add_action( 'add_meta_boxes', 'lr_register_meta_boxes' );

/*
**** Meta box display callback ****
*/
function lr_mi_display_callback( $post ) {
	
	$shop_name = get_post_meta( $post->ID, 'shop-name', true );
	$shop_desc = get_post_meta( $post->ID, 'shop-desc', true );
	$shop_phone = get_post_meta( $post->ID, 'shop-phone', true );
	$shop_email = get_post_meta( $post->ID, 'shop-email', true );
	$shop_url = get_post_meta( $post->ID, 'shop-url', true );

	$shop_address = get_post_meta( $post->ID, 'shop-address', true );
	$shop_address2 = get_post_meta( $post->ID, 'shop-address2', true );
	$shop_city = get_post_meta( $post->ID, 'shop-city', true );
	$shop_zip_code = get_post_meta( $post->ID, 'shop-zip-code', true );
	
	
	wp_nonce_field( 'mi_meta_box_nonce', 'meta_box_nonce' );
	
	echo '<p><label for="shop-name">Nazwa sklepu</label> <input type="text" name="shop-name" id="shop-name" value="'. $shop_name.'" /></p>';
	echo '<p><label for="shop-desc">Opis sklepu</label> <input type="text" name="shop-desc" id="shop-desc" value="'. $shop_desc .'" /></p>';
	echo '<p><label for="shop-phone">Nr telefonu</label> <input type="text" name="shop-phone" id="shop-phone" value="'. $shop_phone .'" /></p>';
	echo '<p><label for="shop-email">Adress email</label> <input type="text" name="shop-email" id="shop-email" value="'. $shop_email .'" /></p>';
	echo '<p><label for="shop-url">Url sklepu</label> <input type="text" name="shop-url" id="shop-url" value="'. $shop_url .'" /></p>';
    echo 'Adres sklepu fizycznego';
	echo '<p><label for="shop-address">Adres sklepu</label> <input type="text" name="shop-address" id="shop-address" value="'. $shop_address .'" /></p>';
	echo '<p><label for="shop-address2">Adress sklepu</label> <input type="text" name="shop-address2" id="shop-address2" value="'. $shop_address2 .'" /></p>';
	echo '<p><label for="shop-city">Miasto</label> <input type="text" name="shop-city" id="shop-city" value="'. $shop_city .'" /></p>';
	echo '<p><label for="shop-zip-code">Kod pocztowy</label> <input type="text" name="shop-zip-code" id="shop-zip-code" value="'. $shop_zip_code .'" /></p>';
}

/*
**** Save meta box content ****
*/
function lr_save_meta_box( $post_id ) {
	// Comprobamos si es auto guardado
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	// Comprobamos el valor nonce creado en lr_mi_display_callback()
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'mi_meta_box_nonce' ) ) return;
	// Comprobamos si el usuario actual no puede editar el post
	if( !current_user_can( 'edit_post' ) ) return;
	
	// Guardamos...
	if( isset( $_POST['shop-name'] ) )
	update_post_meta( $post_id, 'shop-name', $_POST['shop-name'] );
	if( isset( $_POST['shop-desc'] ) )
	update_post_meta( $post_id, 'shop-desc', $_POST['shop-desc'] );
	if( isset( $_POST['shop-phone'] ) )
	update_post_meta( $post_id, 'shop-phone', $_POST['shop-phone'] );
	if( isset( $_POST['shop-email'] ) )
	update_post_meta( $post_id, 'shop-email', $_POST['shop-email'] );
	if( isset( $_POST['shop-url'] ) )
	update_post_meta( $post_id, 'shop-url', $_POST['shop-url'] );

	if( isset( $_POST['shop-address'] ) )
	update_post_meta( $post_id, 'shop-address', $_POST['shop-address'] );
	if( isset( $_POST['shop-address2'] ) )
	update_post_meta( $post_id, 'shop-address2', $_POST['shop-address2'] );
	if( isset( $_POST['shop-city'] ) )
	update_post_meta( $post_id, 'shop-city', $_POST['shop-city'] );
	if( isset( $_POST['shop-zip-code'] ) )
	update_post_meta( $post_id, 'shop-zip-code', $_POST['shop-zip-code'] );
}
add_action( 'save_post', 'lr_save_meta_box' );