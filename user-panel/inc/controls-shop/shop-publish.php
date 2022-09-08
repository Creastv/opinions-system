<?php 
function o_system_publish_shop(){
    global $current_user;
    ob_start();
        $post = get_post( $current_user->ID );
            if(isset($_POST['publish-shop'])) {
                $update_shop = array(
                    'post_type' => 'shops',
                    'ID' => $current_user->ID,
                    'post_status' => 'pending',
                    'edit_date' => true,
                    'post_date' => $_POST['post_date']
                );
                wp_update_post($update_shop);
                echo "<meta http-equiv='refresh' content='0'>";
            }
    ?>
    <form method="post">
        <input type="submit" name="publish-shop" class="o-systm-btn" value="Opublikuj sklep"/>
    </form>
<?php 
   $publish= ob_get_clean();
   return $publish;
}
