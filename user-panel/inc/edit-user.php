<?php

   add_shortcode('o-system-edit-profil', 'o_system_edit_profil_user');
  function o_system_edit_profil_user() {
    ob_start();
    $user = wp_get_current_user();
    if ( is_user_logged_in() ) {
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
                <label for="first_name">Imię</label>
                <?php $user_firstname = isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>
                <input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo $user_firstname; ?>"  />
            </div>
            <div class="form-group col col-1">
                <label for="last_name">Nazwisko</label>
                <?php $user_lastname = isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>
                <input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo $user_lastname; ?>"  />
            </div>
            <div class="form-group col col-1">
                <label for="user_email">Adres email</label>
                <?php $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : ''; ?>
                <input class="form-control" type="email" name="user_email" id="user_email" value="<?php echo $user_email; ?>" />
            </div>
            <?php
                ob_start();
                do_action('update_profil');
                echo ob_get_clean();
            ?>
            <?php wp_nonce_field('updateProfil', 'formType'); ?>
            <div class="form-group col col-1">
                <button type="submit" class="o-systm-btn update_user">Zapisz</button>
            </div>
        </form>
        </div>
    </div>
    <?php }
    $update_profil= ob_get_clean();
    return $update_profil;
  } 

add_action('wp', 'wc_user_update_callback');

  function wc_user_update_callback() {

    $user = wp_get_current_user();

    if (isset($_POST['formType']) && wp_verify_nonce($_POST['formType'], 'updateProfil')) {

        global $registrationError, $registrationSuccess;

        $u_firstname = trim($_POST['first_name']);
        $u_lastname = trim($_POST['last_name']);
        $u_email = trim($_POST['user_email']);

        if ($u_firstname == '') {
            $registrationError .= '<strong>Error! </strong> Wprowadź poprawne imię.,';
        }
        if ($u_lastname == '') {
            $registrationError .= '<strong>Error! </strong> Wprowadź poprawne nazwisko.,';
        }


        if ($u_email == '') {
            $registrationError .= '<strong>Error! </strong> Wprowadź poprawny adres email.,';
        }

        $registrationError = trim($registrationError, ',');
        $registrationError = str_replace(",", "<br/>", $registrationError);

        if (empty($registrationError)) {

            $user_id = $user->id;
            $user_email = $u_email;
            $user_firstname = $u_firstname;
            $user_lastname = $u_lastname;

            $userdata = array(
                  'ID' => $user_id,
                  'first_name' => $user_firstname,
                  'last_name' => $user_lastname,
                  'user_email' => $user_email,
            );
            $errors = wp_update_user($userdata);
        }
        if (is_wp_error($errors)) {
            $registrationError = $errors->get_error_message();
        } else {
            
              wp_set_password($u_pwd, $user->ID);
              wp_set_current_user($user->ID, $user->user_login);
              wp_set_auth_cookie($user->ID);
            //   do_action('wp_login', $user->user_login);
            //   $changePasswordSuccess = 'Password is successfully updated.';  
            

        }
    }
  }

