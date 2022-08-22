<?php
   add_shortcode('o-system-login-form', 'o_systemlogin_form_callback');

  function o_systemlogin_form_callback() {
    ob_start();
    echo '<div class="o-system-container">';
    echo '<div class="o-system-form">';
    if (!is_user_logged_in()) {
        global $errors_login;
        if (!empty($errors_login)) { ?>
            <div class="o-system-alert o-system--alert-danger">
                <?php echo $errors_login; ?>
            </div>
        <?php } ?>
        <form method="post" class="wc-login-form">
                <div class="form-group col col-1">
                    <label for="user_name">Nazwa urzytkownika</label>
                    <input class="form-control" name="log" type="text" id="user_name" value="<?php echo $_POST['log']; ?>">
                </div>
                <div class="form-group col col-1">
                    <label for="user_password">Hasło</label>
                    <input class="form-control" name="pwd" id="user_password" type="password">
                </div>
                <?php
                        ob_start();
                        do_action('login_form');
                        echo ob_get_clean();
                        ?>
                <?php wp_nonce_field('userLogin', 'formType'); ?>
                <div class="form-group col col-1">
                   <button class="o-systm-btn login_user" type="submit">Zaloguj</button>
                </div>
                  <div class="form-group col col-1">
                   <p class="text-center">Nie posiadasz jeszcze konta? <a href="<?php echo esc_url( home_url( '/rejestracja/' ) ); ?>">  Zarejestruj się</a></p>
                </div>
        </form>
<?php } else {
        echo '<p class="error-logged">Jesteś już zalogowany</p>';
          wp_redirect(site_url('/panel-uzytkownika/'));
    }

    echo '</div>';
    echo '</div>';

      $login_form = ob_get_clean();
      return $login_form;
  }

  add_action('wp', 'wc_user_login_callback');

  function wc_user_login_callback() {
      if (isset($_POST['formType']) && wp_verify_nonce($_POST['formType'], 'userLogin')) {

          global $errors_login;
          $uName = $_POST['log'];
          $uPassword = $_POST['pwd'];
          $redirect = $_POST['redirect'];

          if ($uName == '' && $uPassword != '') {
              $errors_login = '<strong>Error! </strong> Nazwa urzytkownika jest wymagana.';
          } elseif ($uName != '' && $uPassword == '') {
              $errors_login = '<strong>Error! </strong> Hało jest wymagane.';
          } elseif ($uName == '' && $uPassword == '') {
              $errors_login = '<strong>Error! </strong> Nazwa urzytkownika i hasło są wymagane.';
          } elseif ($uName != '' && $uPassword != '') {
              $creds = array();
              $creds['user_login'] = $uName;
              $creds['user_password'] = $uPassword;
              $creds['remember'] = false;
              $user = wp_signon($creds, true);
              if (is_wp_error($user)) {
                  $errors_login = $user->get_error_message();
              } else {
                    wp_redirect(site_url('/panel-uzytkownika/'));
                  exit;
              }
          }
      }
  }
