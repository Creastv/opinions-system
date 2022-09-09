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
        <form method="post" class="o-system-form wc-login-form">
                <div class="form-group col col-1">
                    <label for="user_name">Adres email</label>
                    <input class="form-control" name="log" type="text" id="user_name" value="<?php echo $_POST['log']; ?>">
                </div>
                <div class="form-group col col-1">
                    <label for="user_password">Hasło</label>
                    <input class="form-control" name="pwd" id="user_password" type="password">
                </div>
                <div class="form-group col col-1 o-system-ex-login">
                    <div class="">
                        <input name="pwd" id="remMe" type="checkbox">
                        <small>Zapamientaj mnie</small>
                    </div>
                    <div class="">
                        <small><a   href="<?php echo home_url('/odzyskiwanie-hasla/'); ?>"> Nie pamiętasz hasła? </a></small>
                    </div>
                </div>

                <div class="form-group col col-1">
                    <!-- <div class="g-recaptcha brochure__form__captcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div> -->
                    <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Le_WLwhAAAAAHilEH4trnb6OTffXBjb68BOeVtm"></div>
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
        echo '<p>Jesteś już zalogowany</p>';
        // wp_redirect(site_url('/panel-uzytkownika/'));
        $url = site_url('/panel-uzytkownika/');
        echo("<script>location.href = '".$url."'</script>");
    }
    echo '</div>';
    echo '</div>';
      $login_form = ob_get_clean();
      return $login_form;
  }

function reCaptcha($recaptcha){
    // $secret = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
    $secret = "6Le_WLwhAAAAAI-wLBRU7yYMb-CF45lVlihUb9Ra";
    $ip = $_SERVER['REMOTE_ADDR'];
    $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
    $data = curl_exec($ch);
    curl_close($ch);
    return json_decode($data, true);
}

add_action('wp', 'wc_user_login_callback');

  function wc_user_login_callback() {

      if (isset($_POST['formType']) && wp_verify_nonce($_POST['formType'], 'userLogin')) {

          global $errors_login;
          $uName = $_POST['log'];
          $uPassword = $_POST['pwd'];
          $remMe = $_POST['remMe'];
          $redirect = $_POST['redirect'];
          
         


          $recaptcha = $_POST['g-recaptcha-response'];
          $res = reCaptcha($recaptcha);
  
          if ($uName == '' ) {
              $errors_login .= '<strong>Error! </strong> Nazwa urzytkownika jest wymagana.,';
          } 
          if ( !username_exists( $uName ) ) {
              $errors_login .= '<strong>Error! </strong> Użykownik o podanym mailu nie istnieje,';
          }
		  if ($uPassword == '') {
              $errors_login .= '<strong>Error! </strong> Hasło jest wymagane,';
          } 

		  if ($res['success'] == false) {
              $errors_login .= '<strong>Error! </strong> reCaptcha.,';
		  } 
		  
		  $errors_login = trim($errors_login, ',');
          $errors_login = str_replace(",", "<br/>", $errors_login);

          if (empty($errors_login)) {
			  
			  if ($uName != '' && $uPassword != '') {
				  $creds = array();
				  $creds['user_login'] = $uName;
				  $creds['user_password'] = $uPassword;
				  $creds['remember'] = $remMe;
				  $user = wp_signon($creds, true);
				  if (is_wp_error($user)) {
					//   $errors_login = $user->get_error_message();
                     $errors_login = '<strong>ERROR</strong>: Wprowadzone hasło dla użytkownika <strong>' . $uName . ' </strong>  jest niepoprawne<a href=" ' . site_url('/odzyskiwanie-hasla/') . '" title="nie pamietasz hasła"> nie pamietasz hasła</a>?';
				  } else {
						wp_redirect(site_url('/panel-uzytkownika/'));
					  exit;
				  }
			  }
		  }
      }
  }