<?php 
// Add Custome fild for user
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>
<h3>Shop information</h3>
<table class="form-table">
    <tr>
        <td>
            <a href="<?php echo get_permalink( $user->ID ); ?>" target="_blank">Idź do podstrony sklepu użytkownika</a>
        </td>
    </tr>
    <tr>
        <th>
            <h3>REST API</h3>
            <label for="customer-key">Customer key</label>
        </th>
        <td>
            <input type="textarea" name="customer-key" id="customer-key" rows="5" cols="30" value="<?php echo esc_attr( get_the_author_meta( 'customer-key', $user->ID ) ); ?>" class="regular-text" /><br />
        </td>
    </tr>
    <tr>
        <th><label for="private-key">Private key</label></th>
        <td>
            <input type="textarea" name="private-key" id="private-key" rows="5" cols="30" value="<?php echo esc_attr( get_the_author_meta( 'private-key', $user->ID ) ); ?>" class="regular-text" /><br />
        </td>
    </tr>
</table>

<?php }
// save fields
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

    
    update_user_meta( $user_id, 'customer-key', $_POST['customer-key'] );
    update_user_meta( $user_id, 'private-key', $_POST['private-key'] );

    $_POST['action'] = 'wp_handle_upload';

}

add_action('user_edit_form_tag', 'make_form_accept_uploads');
function make_form_accept_uploads() {
    echo ' enctype="multipart/form-data"';
}
