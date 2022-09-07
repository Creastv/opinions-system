<?php
  function o_system_add_api() {
    ob_start();

    if ( is_user_logged_in() ) {
    $user = wp_get_current_user();
    global $registrationErrorAPI;
    ?>
    <div class="o-system-container">
        <div class="o-system-form">

        <?php  if (!empty($registrationErrorAPI)) { ?>
            <div class="o-system-alert o-system--alert-danger">
                <?php echo $registrationErrorAPI; ?>
            </div>
        <?php } ?>

        <?php if (!empty($registrationSuccess)) { ?>
        <div class="o-system-alert o-system--alert-success">
            <?php echo $registrationSuccess; ?>
        </div>
        <?php } ?>

        <form method="post" class="row ">
            <div class="form-group col col-1">
                <label for="customer-key">Klucz klienta</label>
                <input  class="form-control" type="textarea" name="customer-key" id="customer-key" rows="5" cols="30" value="" class="regular-text" />
            </div>
            <div class="form-group col col-1">
                <label for="private-key">Klucz prywatny</label>
                <input  class="form-control" type="textarea" name="private-key" id="private-key" rows="5" cols="30" value="" class="regular-text" />
            </div>
            <?php
                ob_start();
                do_action('add_shop_api');
                echo ob_get_clean();
            ?>
            <?php wp_nonce_field('addShopIp', 'shopIp'); ?>
            <div class="form-group col col-1">
                <button type="submit" class="o-systm-btn add_shop_api">Zapisz</button>
            </div>
        </form>
        </div>
    </div>
    <?php }
    $add_shop_api= ob_get_clean();
    return $add_shop_api;
  } 

add_action('wp', 'o_system_add_api_callback');

function o_system_add_api_callback() {

    $user = wp_get_current_user();

    if (isset($_POST['shopIp']) && wp_verify_nonce($_POST['shopIp'], 'addShopIp')) {
        global $registrationErrorAPI;
    
        $shop_ck = trim($_POST['customer-key']);
        $shop_pk = trim($_POST['private-key']);
         if ( $shop_ck == '') {
              $registrationErrorAPI .= '<strong>Error! </strong> Wprowadź <b>Klucz klienta</b><br>';
        }
        if ( $shop_pk == '') {
              $registrationErrorAPI .= '<strong>Error! </strong> Wprowadź <b> Klucz Prywatny</b><br>';
        }
        if (empty($registrationErrorAPI)) {
        update_user_meta( $user->ID, 'customer-key',  $shop_ck); 
        update_user_meta( $user->ID, 'private-key',  $shop_pk); 
        }


    }
}


