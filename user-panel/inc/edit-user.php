<?php

   add_shortcode('o-system-edit-profil', 'o_system_edit_profil_user');
  function o_system_edit_profil_user() {
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
                <label for="first_name">Imię</label>
                <?php $user_firstname = isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>
                <input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo $user->first_name; ?>"  />
            </div>
            <div class="form-group col col-1">
                <label for="last_name">Nazwisko</label>
                <?php $user_lastname = isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>
                <input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo $user->last_name; ?>"  />
            </div>
            <div class="form-group col col-1">
                <label for="user_email">Adres email</label>
                <?php $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : ''; ?>
                <input class="form-control" type="email" name="user_email" id="user_email" value="<?php echo $user->user_email; ?>" />
            </div>
            <?php
                ob_start();
                do_action('update_profil');
                echo ob_get_clean();
            ?>
            <?php wp_nonce_field('updateProfil', 'profil-edit'); ?>
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

    if (isset($_POST['profil-edit']) && wp_verify_nonce($_POST['profil-edit'], 'updateProfil')) {

        global $registrationError, $registrationSuccess;
        
        $u_name = trim($_POST['display_name']);
        $u_firstname = trim($_POST['first_name']);
        $u_lastname = trim($_POST['last_name']);
        $u_email = trim($_POST['user_email']);

        // if ($u_name == '') {
        //       $registrationError .= '<strong>Error! </strong> Wprowadź nazwę użytkownika.,';
        // }

        // if (username_exists($u_name)) {
        //        $registrationError .= '<strong>Error! </strong> Podana nazwa użytkownika jest już zajęta.,';
        // }

        // if ($u_firstname == '') {
        //     $registrationError .= '<strong>Error! </strong> Wprowadź poprawne imię.,';
        // }

        // if ($u_firstname == '') {
        //     $registrationError .= '<strong>Error! </strong> Wprowadź poprawne imię.,';
        // }
        // if ($u_lastname == '') {
        //     $registrationError .= '<strong>Error! </strong> Wprowadź poprawne nazwisko.,';
        // }


        // if ($u_email == '') {
        //     $registrationError .= '<strong>Error! </strong> Wprowadź poprawny adres email.,';
        // }

        $registrationError = trim($registrationError, ',');
        $registrationError = str_replace(",", "<br/>", $registrationError);

        if (empty($registrationError)) {
            
            $display_name = $display_name;
            $user_id = $user->id;
            $user_email = $u_email;
            $user_firstname = $u_firstname;
            $user_lastname = $u_lastname;

            $userdata = array(
                  'ID' => $user_id,
                  'display_name' => $display_name,
                  'first_name' => $user_firstname,
                  'last_name' => $user_lastname,
                  'user_email' => $user_email,
            );
            $errors = wp_update_user($userdata);
        }
        if (is_wp_error($errors)) {
            $registrationError = $errors->get_error_message();
        } else {
            
            //   wp_set_password($u_pwd, $user->ID);
            //   wp_set_current_user($user->ID, $user->display_name);
            //   wp_set_auth_cookie($user->ID);
            //   do_action('wp_login', $user->display_name);
            //   $changePasswordSuccess = 'Password is successfully updated.';  
            

        }
    }
  }

