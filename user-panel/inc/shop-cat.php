<?php
function o_system_add_shop_cat_cat() { 
    ob_start();
    if ( is_user_logged_in() ) {
    global $addingShopCatError, $addingShopCatSuccess; 
    $user = wp_get_current_user();
    $post = get_post($user->ID);
?>
    <div class="o-system-container">
        <div class="o-system-form">
        <?php  if (!empty($addingShopCatError)) { ?>
            <div class="o-system-alert o-system--alert-danger">
                <?php echo $addingShopCatError; ?>
            </div>
        <?php } ?>

        <?php if (!empty($addingShopCatSuccess)) { ?>
        <div class="o-system-alert o-system--alert-success">
            <?php echo $addingShopCatSuccess; ?>
        </div>
        <?php } ?>

        <?php 
        $terms = wp_get_post_terms( $user->ID, 'shop-cat' );;
           echo "<h2>Kategorie</h2>";
            foreach( $terms as $category ) {
            echo '<li><a href="'. get_term_link($category->slug, 'shop-cat').'">'.$category->name.'</a></li>';
            }
            echo '<br>';
        ?>
        <form action="" method="post" enctype="multipart/form-data" class="row ">
            <?php
                $taxonomies = get_terms( array(
                    'taxonomy' => 'shop-cat',
                    'hide_empty' => false,
                ) );
                if ( !empty($taxonomies) ) :
                foreach( $taxonomies as $category ) {
                    
                    echo '<label>';
                    if( has_term( $category->name , 'shop-cat', $post ) ){
                       echo '<input type="checkbox" class="radio" value="' .$category->term_id. '" name="shopCategoris[]" checked/>'.$category->name;
                    } else {
                       echo '<input type="checkbox" class="radio" value="' .$category->term_id. '" name="shopCategoris[]" />'.$category->name;
                    }
                    echo '</label>';
                }
                endif; 
            ?>
            <?php
                ob_start();
                do_action('add_shop_cat');
                echo ob_get_clean();
            ?>
            <?php wp_nonce_field('addShopCat', 'shopCat'); ?>
            <div class="form-group col col-1">
                <button type="submit" class="o-systm-btn add_shop_cat">Zapisz kategorie</button>
            </div>
        </form>
        </div>
    </div>

<?php }
    $add_shop_cat= ob_get_clean();
    return $add_shop_cat;
} 

add_action('wp', 'o_system_add_shop_cat_cat_callback');


function o_system_add_shop_cat_cat_callback() {

    $user = wp_get_current_user();
    $post = get_post($user->ID);

    if (isset($_POST['shopCat']) && wp_verify_nonce($_POST['shopCat'], 'addShopCat')) {
        global $addingShopCatError, $addingShopCatSuccess;

        $shopCategoris = $_POST['shopCategoris'];

        // if (isset($_POST['shopCat'])) {
        //     $addingShopCatError .= '<strong>Error! </strong> <b>Nazwa sklepu</b> jest polem wymaganym ,';
        // }

        $addingShopCatError = trim($addingShopCatError, ',');
        $addingShopCatError = str_replace(",", "<br/>", $addingShopCatError);

        if (empty($addingShopCatError)) {
            $tag = $shopCategoris; 
            wp_set_post_terms( $user->ID, $tag, 'shop-cat' );
        }
        if (is_wp_error($errors)) {
            $addingShopCatError = $errors->get_error_message();
        } else {
            $addingShopCatSuccess = 'Kategorie sklepu zostały zaktualizowane.';  
        }
        
    }
}

