<?php
  function o_system_add_shop() { 
    ob_start();
    if ( is_user_logged_in() ) {
    global $addingShopError, $addingShopSuccess; 

    $user = wp_get_current_user();
    $post = get_post($user->ID);
    $shop = [
        'logo'      =>  get_the_post_thumbnail( $user->id, 'thumbnail' ),
        'name'       =>  $post->post_title,
        'desc'       =>  get_post_meta( $user->id, 'shop-desc', true ),
        'phone'      =>  get_post_meta( $user->id, 'shop-phone', true ),
        'email'      =>  get_post_meta( $user->id, 'shop-email', true ),
        'url'        =>  get_post_meta( $user->id, 'shop-url', true ),
        'address'    =>  get_post_meta( $user->id, 'shop-address', true ),
        'address2'   =>  get_post_meta( $user->id, 'shop-address2', true ),
        'city'       =>  get_post_meta( $user->id, 'shop-city', true ),
        'zip'        =>  get_post_meta( $user->id, 'shop-zip-code', true ),
    ]; 
?>
    <div class="o-system-container">
        <div class="o-system-form">
        <?php  if (!empty($addingShopError)) { ?>
            <div class="o-system-alert o-system--alert-danger">
                <?php echo $addingShopError; ?>
            </div>
        <?php } ?>

        <?php if (!empty($addingShopSuccess)) { ?>
        <div class="o-system-alert o-system--alert-success">
            <?php echo $addingShopSuccess; ?>
        </div>
        <?php } ?>

        <form action="" method="post" enctype="multipart/form-data" class="row ">
            <div class="form-group col col-1">
                <label for="file">Logo sklepu</label>
                <input class="form-control" type="file" name="file" id="file"  >
                <?php if($shop['logo']){
                  echo $shop['logo'];
                } else {
                    echo 'Logo jest wymagane';
                } ?>
                
            </div>
            <div class="form-group col col-1">
                <label for="shop-name">Nazwa sklepu</label>
                <input  class="form-control" type="text" name="shop-name" id="shop-name" value="<?php echo $shop['name']; ?>" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-desc">Opis sklepu</label>
                <textarea class="form-control" type="textarea" name="shop-desc" id="shop-desc" rows="5" cols="30"><?php echo $shop['desc']; ?></textarea>
            </div>
            <div class="form-group col col-1">
                <label for="shop-phone">Nr telefonu</label>
                <input  class="form-control" type="text" name="shop-phone" id="shop-phone" value="<?php echo $shop['phone']; ?>" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-email">Adres email</label>
                <input  class="form-control" type="text" name="shop-email" id="shop-email" value="<?php echo $shop['email']; ?>" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-email">Url sklepu</label>
                <input  class="form-control" type="url" name="shop-url" id="shop-url" value="<?php echo $shop['url']; ?>" />
            </div>
            <div class="form-group col col-1">
                <p>Adres fizyczny sklepu:</p>
            </div>
            <div class="form-group col col-1">
                <label for="shop-address">Adres</label>
                 <input  class="form-control" type="text" name="shop-address" id="shop-address" value="<?php echo $shop['address']; ?>" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-address2">Adres</label>
                <input  class="form-control" type="text" name="shop-address2" id="shop-address2" value="<?php echo $shop['address2']; ?>" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-city">Miasto</label>
                <input  class="form-control" type="text" name="shop-city" id="shop-city" value="<?php echo $shop['city']; ?>" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-zip-code">Kod pocztowy</label>
                <input  class="form-control" type="text" name="shop-zip-code" id="shop-zip-code" value="<?php echo $shop['zip']; ?>" />
            </div>
          
            <?php
                ob_start();
                do_action('add_shop');
                echo ob_get_clean();
            ?>
            <?php wp_nonce_field('addShop', 'shop'); ?>
            <div class="form-group col col-1">
                <button type="submit" class="o-systm-btn add_shop">Zapisz</button>
            </div>
        </form>
        </div>
    </div>

<?php }
    $add_shop= ob_get_clean();
    return $add_shop;
} 

add_action('wp', 'o_system_add_shop_callback');


function o_system_add_shop_callback() {

    $user = wp_get_current_user();
    $post = get_post($user->ID);

    if (isset($_POST['shop']) && wp_verify_nonce($_POST['shop'], 'addShop')) {
        global $addingShopError, $addingShopSuccess;

        $shop_logo= trim($_POST['file']);
        $shop_name = trim($_POST['shop-name']);
        $shop_des = trim($_POST['shop-desc']);
        $shop_phone = trim($_POST['shop-phone']);
        $shop_email = trim($_POST['shop-email']);
        $shop_url = trim($_POST['shop-url']);

        $shop_address = trim($_POST['shop-address']);
        $shop_address2 = trim($_POST['shop-address2']);
        $shop_city = trim($_POST['shop-city']);
        $shop_zip = trim($_POST['shop-zip-code']);

        if ($shop_name == '') {
            $addingShopError .= '<strong>Error! </strong> <b>Nazwa sklepu</b> jest polem wymaganym ,';
        }

        if ($shop_des == '') {
            $addingShopError .= '<strong>Error! </strong> <b>Opis sklepu</b> jest polem wymaganym ,';
        }

        if ($shop_url == '') {
            $addingShopError .= '<strong>Error! </strong> <b>URL sklepu </b> jest polem wymaganym ,';
        }
        if ($shop_logo == '' && $_FILES['file']['size'] == 0 && !has_post_thumbnail( $user->ID ) ) {
               $addingShopError .= '<strong>Error! </strong> <b>LOgo </b> jest polem wymaganym ,';
        }
     if ($_FILES['file']['size'] !== 0 ){
                
                require_once( ABSPATH . 'wp-admin/includes/post.php' );
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
                require_once( ABSPATH . 'wp-admin/includes/media.php' );
                $attachment_id = media_handle_upload( 'file', $user->ID );
                set_post_thumbnail( $user->ID, $attachment_id );
        
        } 

        $addingShopError = trim($addingShopError, ',');
        $addingShopError = str_replace(",", "<br/>", $addingShopError);

        if (empty($addingShopError)) {
            if (get_post_status($user->ID) ) {

                $post = get_post( $user->ID );
                $stat =  get_post_status($post);

                $my_post = array(
                        'ID' => $user->ID,
                        'post_type'     => 'shops',
                        'post_title'    => $shop_name,
                        'post_status'   => $stat,
                        'meta_input' => array(
                            'shop-name' =>  $shop_name,
                            'shop-desc' =>  $shop_des,
                            'shop-phone' =>  $shop_phone,
                            'shop-email' =>  $shop_email,
                            'shop-url' =>  $shop_url,
                            'shop-address' =>  $shop_address,
                            'shop-address2' =>  $shop_address2,
                            'shop-city' =>  $shop_city,
                            'shop-zip-code' =>  $shop_zip
                        )
                );
                $my_post= wp_insert_post($my_post);
                wp_update_term( 1, 'category', array(
                    'name' => 'Non Catégorisé',
                    'slug' => 'non-categorise'
                ) );
                $tag = '4'; // Wrong. This will add the tag with the *name* '5'.
                $tag = 4; // Wrong. This will also add the tag with the name '5'.
                $tag = array( '4', 6 ); // Wrong. Again, this will be interpreted as a term name rather than an id.

                $tag = array(4, 6 ); // Correct. This will add the tag with the id 5.
                wp_set_post_terms( $user->ID, $tag, 'shop-cat' );
            } else {
                $my_post = array(
                        'import_id' => $user->ID,
                        'post_type'     => 'shops',
                        'post_title'    => $shop_name,
                        'meta_input' => array(
                            'shop-name' =>  $shop_name,
                            'shop-desc' =>  $shop_des,
                            'shop-phone' =>  $shop_phone,
                            'shop-email' =>  $shop_email,
                            'shop-url' =>  $shop_url,
                            'shop-address' =>  $shop_address,
                            'shop-address2' =>  $shop_address2,
                            'shop-city' =>  $shop_city,
                            'shop-zip-code' =>  $shop_zip
                        )
                    );
                $my_post= wp_insert_post($my_post);
            }
        }
        if (is_wp_error($errors)) {
            $addingShopError = $errors->get_error_message();
        } else {
            $addingShopSuccess = 'Wizytówka została zaktualizowana.';  
        }
        
    }
}

