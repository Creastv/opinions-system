<?php
 add_shortcode('o-system-forgot-pwd-form', 'o_system_forgot_pwd_form');

  function o_system_forgot_pwd_form() {
      ob_start();
      if (!is_user_logged_in()) {
          global $getPasswordError, $getPasswordSuccess; ?>
        
    <div class="o-system-container">
        <div class="o-system-form">
        <?php if (!empty($getPasswordError)) { ?>
            <div class="o-system-alert o-system--alert-danger">
                <?php echo $getPasswordError; ?>
            </div>
        <?php } ?>
        <?php if (!empty($getPasswordSuccess)) { ?>
         <div class="o-system-alert o-system--alert-success">
            <?php echo $getPasswordSuccess; ?>
        </div>
        <?php } ?>
            <form method="post" class="wc-forgot-pwd-form row">
                <div class="form-group col col-1">
                    <label for="user_login">Adres e-mail:</label>
                    <?php $user_login = isset($_POST['user_login']) ? $_POST['user_login'] : ''; ?>
                    <input class="form-control" type="text" name="user_login" id="user_login" value="<?php echo $user_login; ?>" />
                </div>
                <div class="form-group col col-1">
                    <!-- <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div> -->
                    <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Le_WLwhAAAAAHilEH4trnb6OTffXBjb68BOeVtm"></div>
                </div>
                <?php
                    ob_start();
                    do_action('lostpassword_form');
                    echo ob_get_clean();
                ?>
                <?php wp_nonce_field('userGetPassword', 'formType'); ?>
                <div class="form-group col col-1">
                    <button type="submit" class="o-systm-btn ">Wyślij</button>
                </div>
            </form>
        </div>
    </div>
<?php } else {
          $url = site_url('/panel-uzytkownika/');
          echo("<script>location.href = '".$url."'</script>");
        }
      $forgot_pwd_form = ob_get_clean();
      return $forgot_pwd_form;
  }

  add_action('wp', 'o_system_forgot_pwd_callback');

  function o_system_forgot_pwd_callback() {
      if (isset($_POST['formType']) && wp_verify_nonce($_POST['formType'], 'userGetPassword')) {
          global $getPasswordError, $getPasswordSuccess;



          $email = trim($_POST['user_login']);
          $recaptcha = $_POST['g-recaptcha-response'];
          $res = reCaptcha($recaptcha);

          if (empty($email)) {
              $getPasswordError .= '<strong>Error! </strong>Wprowadź adres email.,';
          } else if (!is_email($email)) {
              $getPasswordError .= '<strong>Error! </strong>Nie poprawny adres email.,';
          } else if (!email_exists($email)) {
              $getPasswordError .= '<strong>Error! </strong>Użytkownik o tym adresie email nie istnieje.,';
          }
           if ($res['success'] == false) {
               $getPasswordError .= '<strong>Error! </strong> reCaptcha.';
           }
            $getPasswordError = trim($getPasswordError, ',');
            $getPasswordError = str_replace(",", "<br/>", $getPasswordError); 

          if (empty($getPasswordError)) {

              // lets generate our new password
              $random_password = wp_generate_password(12, false);

              // Get user data by field and data, other field are ID, slug, slug and login
              $user = get_user_by('email', $email);

              $update_user = wp_update_user(array(
                  'ID' => $user->ID,
                  'user_pass' => $random_password
                      )
              );
              // if  update user return true then lets send user an email containing the new password
              if ($update_user) {
                  $to = $email;
                  $subject = 'Twoje nowe hasło';
                  $sender = get_bloginfo('name');
                  $message = 'Twoje nowe hasło: ' . $random_password;
                  $headers[] = 'MIME-Version: 1.0' . "\r\n";
                  $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                  $headers[] = "X-Mailer: PHP \r\n";
                  $headers[] = 'From: ' . $sender . ' < ' . $email . '>' . "\r\n";
                  $headers = array('Content-Type: text/html; charset=UTF-8');

                  $mail = wp_mail($to, $subject, $message, $headers);
                  if ($mail) {
                      $getPasswordSuccess = '<strong>Success! </strong>Sprawdź swój adres e-mail.';
                  }
              } else {
                  $getPasswordError = '<strong>Error! </strong>Oops coś poszło nie tak, spróbuj za chwilę.,';
              }
          }
         
      }
  }
