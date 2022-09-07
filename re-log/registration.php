<?php
  add_shortcode('o-system-acount-form', 'o_system_register_form_callback');

function o_system_register_form_callback() {
    ob_start();
    echo '<div class="o-system-container">';
    echo '<div class="o-system-form">';
    if (!is_user_logged_in()) {
        global $registrationError, $registrationSuccess;

        if (!empty($registrationError)) { ?>
<div class="o-system-alert o-system--alert-danger">
    <?php echo $registrationError; ?>
</div>
<?php } ?>

<?php if (!empty($registrationSuccess)) { ?>
<br />
<div class="o-system-alert o-system--alert-success">
    <?php echo $registrationSuccess; ?>
</div>
<?php } ?>


<form method="post" class="row">
    <div class="form-group col col-1">
        <label for="user_name">Nazwa użytkownika</label>
        <?php $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>
        <input class="form-control" type="text" name="user_name" id="user_name" value="<?php echo $user_name; ?>" />
    </div>
    <div class="form-group col col-1">
        <label for="user_email">Adres email</label>
        <?php $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : ''; ?>
        <input class="form-control" type="email" name="user_email" id="user_email" value="<?php echo $user_email; ?>" />
    </div>

    <div class="form-group col col-1">
        <label for="user_password">Hasło</label>
        <input class="form-control" type="password" name="user_password" id="user_password" />
    </div>

    <div class="form-group col col-1">
        <label for="user_cpassword">Powtórz hasło</label>
        <input class="form-control" type="password" name="user_cpassword" id="user_cpassword" />
    </div>
 <div class="form-group col col-1">
                    <!-- <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div> -->
                    <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Le_WLwhAAAAAHilEH4trnb6OTffXBjb68BOeVtm"></div>
                </div>
    <div class="form-group col col-1">
        <?php
                        ob_start();
                        do_action('register_form');
                        echo ob_get_clean();
                    ?>
    </div>
    <div class="form-group col col-1">
        <?php wp_nonce_field('userRegister', 'formType'); ?>
        <button type="submit" class="o-systm-btn register_user">Zarejestruj się</button>
    </div>
    <div class="form-group col col-1">
        <p class="text-center">Posiadasz już konto? <a href="<?php echo esc_url( home_url( '/logowanie/' ) ); ?>"> Zaloguj się</a></p>
    </div>
</form>
<?php  } else {
          echo '<p>Jesteś już zalogowany</p>';
          // wp_redirect(site_url('/panel-uzytkownika/'));
          $url = site_url('/panel-uzytkownika/');
          echo("<script>location.href = '".$url."'</script>");
        
          }
        echo '</div>';
         echo '</div>';

        $register_form = ob_get_clean();
        return $register_form;
    }

  add_action('wp', 'wc_user_register_callback');

  function wc_user_register_callback() {
      if (isset($_POST['formType']) && wp_verify_nonce($_POST['formType'], 'userRegister')) {

          global $registrationError, $registrationSuccess, $err_name;

          $u_name = trim($_POST['user_name']);
          $u_email = trim($_POST['user_email']);
          $u_pwd = trim($_POST['user_password']);
          $u_cpwd = trim($_POST['user_cpassword']);
          $recaptcha = $_POST['g-recaptcha-response'];
          $res = reCaptcha($recaptcha);    

          if ($u_name == '') {
              $registrationError .= '<strong>Error! </strong> Wprowadź nazwę użytkownika.,';
          }

          if (username_exists($u_name)) {
               $registrationError .= '<strong>Error! </strong> Podana nazwa użytkownika jest już zajęta.,';
          }

          if ($u_email == '') {
              $registrationError .= '<strong>Error! </strong> Wprowadź poprawny adres email.,';
          }

          if ($u_pwd == '' || $u_cpwd == '') {
              $registrationError .= '<strong>Error! </strong> Wprowadź hasło.,';
          }

          if (strlen($u_pwd) < 7) {
              $registrationError .= '<strong>Error! </strong>Wprowadź co najmniej 7 znaków.,';
          }

          if ($u_pwd != $u_cpwd) {
              $registrationError .= '<strong>Error! </strong> Podane hadsła nie pasują do siebie.,';
          }

          if ($u_email != '' && !is_email($u_email)) {
              $registrationError .= '<strong>Error! </strong> Nie poprawny adres email.,';
          }

          if (email_exists($u_email) != false) {
              $registrationError .= '<strong>Error! </strong> Podany adres email już istnieje.,';
          }

           if ($res['success'] == false) {
               $registrationError .= '<strong>Error! </strong> reCaptcha.,';
		  } 

          $registrationError = trim($registrationError, ',');
          $registrationError = str_replace(",", "<br/>", $registrationError);

          if (empty($registrationError)) {

              $user_login = $u_name;
              $user_email = $u_email;

              $userdata = array(
                  'user_login' => $user_login,
                  'user_pass' => $u_pwd,
                  'user_email' => $user_email,
                  'show_admin_bar_front' => 'false',
                  'role' => 'seller',
              );

              $errors = wp_insert_user($userdata);

            // //   create post
            // Create post object
                // $my_post = array(
                // 'post_type'  => 'shops',
                // 'post_title'    => $u_name,
                // 'post_status'   => 'draft',
                // 'post_author'   => 1,
                // 'meta_input' => array(
                //     'shop-name' => 'test',
                // )
                // );
                // // update_post_meta( $post_id, 'shop-name', $_POST['shop-name'] );
                // // Insert the post into the database
                // wp_insert_post( $my_post );



              if (is_wp_error($errors)) {
                  $registrationError = $errors->get_error_message();
              } else {
                  $registrationSuccess = '<strong>Success! </strong> Application submitted. Please wait for user approval.';

                  wp_set_current_user($errors, $u_name);
                  wp_set_auth_cookie($errors);
                  do_action('wp_login', $u_name);

                  wp_redirect(site_url('/panel-uzytkownika/'));
                  exit;
              }
          }
      }
  }
