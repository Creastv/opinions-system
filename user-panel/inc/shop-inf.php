<?php
  add_shortcode('o-system-add-shop', 'o_system_add_shop');
  function o_system_add_shop() {
    ob_start();
    
   

    if ( is_user_logged_in() ) {
    $user = wp_get_current_user();
    global $registrationError, $registrationSuccess;     
    
    ?>
    
    <div class="o-system-container">
        <div class="o-system-form">

        <?php  if (!empty($registrationError)) { ?>
            <div class="o-system-alert o-system--alert-danger">
                <?php echo $registrationError; ?>
            </div>
        <?php } ?>

        <?php if (!empty($registrationSuccess)) { ?>
        <div class="o-system-alert o-system--alert-success">
            <?php echo $registrationSuccess; ?>
        </div>
        <?php } ?>

        <form method="post" class="row ">
            <div class="form-group col col-1">
                <label for="first_name">Nazwa sklepu</label>
                <input  class="form-control" type="text" name="shop-name" id="shop-name" value="<?php echo esc_attr( get_the_author_meta( 'shop-name', $user->ID ) ); ?>" class="regular-text" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-desc">Opis sklepu</label>
                <textarea class="form-control" type="textarea" name="shop-desc" id="shop-desc" rows="5" cols="30" class="regular-text"><?php echo esc_attr( get_the_author_meta( 'shop-desc', $user->ID ) ); ?></textarea>
            </div>
            <div class="form-group col col-1">
                <label for="shop-phone">Nr telefonu</label>
                <input  class="form-control" type="text" name="shop-phone" id="shop-phone" value="<?php echo esc_attr( get_the_author_meta( 'shop-phone', $user->ID ) ); ?>" class="regular-text" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-email">Adres email</label>
                <input  class="form-control" type="text" name="shop-email" id="shop-email" value="<?php echo esc_attr( get_the_author_meta( 'shop-email', $user->ID ) ); ?>" class="regular-text" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-email">Url sklepu</label>
                <input  class="form-control" type="url" name="shop-url" id="shop-url" value="<?php echo esc_attr( get_the_author_meta( 'shop-url', $user->ID ) ); ?>" class="regular-text" />
            </div>
            <div class="form-group col col-1">
                <p>Adres fizyczny sklepu:</p>
            </div>
            <div class="form-group col col-1">
                <label for="shop-address">Adres</label>
                 <input  class="form-control" type="text" name="shop-address" id="shop-address" value="<?php echo esc_attr( get_the_author_meta( 'shop-address', $user->ID ) ); ?>" class="regular-text" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-address2">Adres</label>
                <input  class="form-control" type="text" name="shop-address2" id="shop-address2" value="<?php echo esc_attr( get_the_author_meta( 'shop-address2', $user->ID ) ); ?>" class="regular-text" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-city">Miasto</label>
                <input  class="form-control" type="text" name="shop-city" id="shop-city" value="<?php echo esc_attr( get_the_author_meta( 'shop-city', $user->ID ) ); ?>" class="regular-text" />
            </div>
            <div class="form-group col col-1">
                <label for="shop-zip-code">Kod pocztowy</label>
                <input  class="form-control" type="text" name="shop-zip-code" id="shop-zip-code" value="<?php echo esc_attr( get_the_author_meta( 'shop-zip-code', $user->ID ) ); ?>" class="regular-text" />
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

    if (isset($_POST['shop']) && wp_verify_nonce($_POST['shop'], 'addShop')) {
        global $registrationError, $registrationSuccess;
    
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
            $registrationError .= '<strong>Error! </strong> <b>Nazwa sklepu</b> jest polem wymaganym ,';
        }
        if ($shop_des == '') {
            $registrationError .= '<strong>Error! </strong> <b>Opis sklepu</b> jest polem wymaganym ,';
        }

        if ($shop_url == '') {
            $registrationError .= '<strong>Error! </strong> <b>URL sklepu </b> jest polem wymaganym ,';
        }

        $registrationError = trim($registrationError, ',');
        $registrationError = str_replace(",", "<br/>", $registrationError);

        if (empty($registrationError)) {
            update_user_meta( $user->ID, 'shop-name',  $shop_name); 
            update_user_meta( $user->ID, 'shop-desc',  $shop_des); 
            update_user_meta( $user->ID, 'shop-phone',  $shop_phone); 
            update_user_meta( $user->ID, 'shop-email',  $shop_email); 
            update_user_meta( $user->ID, 'shop-url',  $shop_url); 

            update_user_meta( $user->ID, 'shop-address',  $shop_address); 
            update_user_meta( $user->ID, 'shop-address2',  $shop_address2); 
            update_user_meta( $user->ID, 'shop-city',  $shop_city); 
            update_user_meta( $user->ID, 'shop-zip-code',  $shop_zip); 
        
            $my_post = array(
                'ID' => $user->ID,
                'post_type'     => 'shops',
                'post_title'    => $shop_name,
                'post_status'   => 'draft',
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
        }
         if (is_wp_error($errors)) {
            $registrationError = $errors->get_error_message();
        } else {
            
            //   wp_set_password($u_pwd, $user->ID);
            //   wp_set_current_user($user->ID, $user->display_name);
            //   wp_set_auth_cookie($user->ID);
            //   do_action('wp_login', $user->display_name);
              $changePasswordSuccess = 'Password is successfully updated.';  
            

        }
        
        // Insert the post into the database
      	
wp_insert_post( $my_post );
    }
}


