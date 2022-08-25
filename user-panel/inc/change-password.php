<?php
   add_shortcode('o-system-change-pwd-form', 'o_system_change_pwd_form_callback');

  function o_system_change_pwd_form_callback() {
      ob_start();

      if (is_user_logged_in()) {
          global $changePasswordError, $changePasswordSuccess; ?>
          <div class="o-system-container">
          <div class="o-system-form">
          <?php if (!empty($changePasswordError)) { ?>
              <div class="o-system-alert o-system--alert-danger">
                  <?php echo $changePasswordError; ?>
              </div>
          <?php } ?>

          <?php if (!empty($changePasswordSuccess)) { ?>
              <br/>
              <div class="o-system-alert o-system--alert-success">
                  <?php echo $changePasswordSuccess; ?>
              </div>
          <?php } ?>

           <form method="post" class="row">
                <div class="form-group col col-1">
                    <label for="user_oldpassword">Stare hasło</label>
                    <input  class="form-control" type="password" name="user_opassword" id="user_oldpassword" />
                </div>

                <div class="form-group col col-1">
                    <label for="user_password">Nowe hasło</label>
                    <input  class="form-control" type="password" name="user_password" id="user_password" />
                </div>

                <div class="form-group col col-1">
                    <label for="user_cpassword">Powtórz hasło</label>
                    <input  class="form-control" type="password" name="user_cpassword" id="user_cpassword" />
                </div>
                <?php
                    ob_start();
                    do_action('password_reset');
                    echo ob_get_clean();
                ?>
                <?php wp_nonce_field('changePassword', 'formType'); ?>

                <div class="form-group col col-1">
                    <button type="submit" class="o-systm-btn change-paw">Zmień hasło</button>
                </div>
          </form>
          </div>
          </div>
          <?php
      }
      $change_pwd_form = ob_get_clean();
      return $change_pwd_form;
  }

  add_action('wp', 'wc_user_change_pwd_callback');

  function wc_user_change_pwd_callback() {

      if (isset($_POST['formType']) && wp_verify_nonce($_POST['formType'], 'changePassword')) {
          
         global $changePasswordError, $changePasswordSuccess;

          $user = wp_get_current_user();

          $changePasswordError = '';
          $changePasswordSuccess = '';
          $u_opwd = trim($_POST['user_opassword']);
          $u_pwd = trim($_POST['user_password']);
          $u_cpwd = trim($_POST['user_cpassword']);

          if ($u_opwd == '' || $u_pwd == '' || $u_cpwd == '') {
              $changePasswordError .= '<strong>ERROR: </strong> Wprowadź hasło.,';
          }

          if (!wp_check_password($u_opwd, $user->data->user_pass, $user->ID)) {
              $changePasswordError .= '<strong>ERROR: </strong> Stare hasło nie jest poprawne.,';
          }

          if ($u_pwd != $u_cpwd) {
              $changePasswordError .= '<strong>ERROR: </strong> Hasła nie pasują do siebie.,';
          }

          if (strlen($u_pwd) < 7) {
              $changePasswordError .= '<strong>ERROR: </strong> Użyj co najmniej 7 znaków.,';
          }

          $changePasswordError = trim($changePasswordError, ',');
          $changePasswordError = str_replace(",", "<br/>", $changePasswordError);

          if (empty($changePasswordError)) {
              wp_set_password($u_pwd, $user->ID);

              wp_set_current_user($user->ID, $user->user_login);
              wp_set_auth_cookie($user->ID);
              do_action('wp_login', $user->user_login);
              $changePasswordSuccess = 'Password is successfully updated.';
          }
          
      }
  }