<?php
function o_system_shope_api_delate(){
    global $current_user;
    ob_start();
    $post = get_post( $current_user->ID );
    ?>
    <form method="post">
            <input type="submit" name="shopAPIDelete" class="o-systm-btn" value="Usuń klucze"/>
    </form>

    <?php
    if (isset($_POST['shopAPIDelete'])) {
    
        $shop_ck = '';
        $shop_pk = '';
        
        update_user_meta( $current_user->ID, 'customer-key',  $shop_ck); 
        update_user_meta( $current_user->ID, 'private-key',  $shop_pk); 
        echo "<meta http-equiv='refresh' content='0'>";
    } ?>
<?php 
   $delete_shop_api = ob_get_clean();
   return $delete_shop_api;
}