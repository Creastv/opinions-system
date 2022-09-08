<?php 
function o_system_draft_shop(){
   global $current_user;
   ob_start();
        $post = get_post( $current_user->ID );
        $stat =  get_post_status($post);
            if(isset($_POST['draft-shop'])) {
                $update_shop = array(
                    'post_type' => 'shops',
                    'ID' => $current_user->ID,
                    'post_status' => 'draft',
                );
                wp_update_post($update_shop);
                echo "<meta http-equiv='refresh' content='0'>";
            }
    ?>
    <form method="post">
            <input type="submit" name="draft-shop" class="o-systm-btn" value="Zapisz jako szkic"/>
    </form>
<?php 
   $draft = ob_get_clean();
   return $draft;
   
}