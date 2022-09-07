 <?php

 require_once plugin_dir_path( __FILE__ ) . '/inc/custom-fields.php';
 require_once plugin_dir_path( __FILE__ ) . '/inc/change-password.php';
 require_once plugin_dir_path( __FILE__ ) . '/inc/edit-user.php';
 require_once plugin_dir_path( __FILE__ ) . '/inc/shop-inf.php';
 require_once plugin_dir_path( __FILE__ ) . '/inc/shop-api.php'; 
//   require_once plugin_dir_path( __FILE__ ) . '/inc/shop-control.php'; 
  require_once plugin_dir_path( __FILE__ ) . '/inc/controls-shop/shop-api-delete.php';
 
 

 add_shortcode('o-system-account-info', 'lr_seller_account_callback');
  function lr_seller_account_callback() {
    ob_start();
    global $current_user;
    if ( is_user_logged_in() ) { ?>
    
    <div class="user-panel">
      <div class="wraper">
         <div class="left">
            <ul class="tab">
               <li>
                  <a href="#dashboard" class="tablinks" onclick="openTab(event, 'dashboard')" > Dashboard</a>
               </li>
               <li>
                  <a href="#user-inf" class="tablinks" onclick="openTab(event, 'user-inf')" > Użytkownika</a>
                  <ul>
                     <li><a href="#user-settings" class="tablinks" onclick="openTab(event, 'user-settings')" > Ustawienia użytkownika</a></li>
                    
                  </ul>
               </li>
               <li>
                  <a href="#shop-info" class="tablinks" onclick="openTab(event, 'shop-info')" > Sklep</a>
                   <ul>
                     <li><a href="#shop-settings" class="tablinks" onclick="openTab(event, 'shop-settings')" > Ustawienia sklepu</a></li>
                     <li><a href="#shop-settings-api" class="tablinks" onclick="openTab(event, 'shop-settings-api')" > Integracja sklepu</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#opinions"  class="tablinks" onclick="openTab(event, 'opinions')" > Opinie</a>
                  <ul>
                     <li><a href="#shop-opinions" id="s-opinions" class="tablinks" onclick="openTab(event, 'shop-opinions')" > Opinie ze sklepu</a></li>
                     <li><a href="#system-opinions" class="tablinks" onclick="openTab(event, 'system-opinions')" > Opinie ze systemu</a></li>
                  </ul>
               </li>
            </ul>
             <a href="#" class="o-systm-btn">Sciągnij plugin</a>
         </div>
         <div class="right">
            <div id="dashboard" class="tabcontent">
               <h3>Dashboard</h3>
               <?php  require_once plugin_dir_path( __FILE__ ) . '/views/dashboard.php'; ?>
            </div>
            <div id="user-inf" class="tabcontent">
              <h3>Użytkownik</h3>
              <?php  require_once plugin_dir_path( __FILE__ ) . '/views/user-info.php'; ?>
            </div>
            <div id="user-settings" class="tabcontent">
              <h3>Ustawienia użytkownika</h3>
              <?php  require_once plugin_dir_path( __FILE__ ) . '/views/user-settings.php'; ?>
            </div>

            <div id="shop-info" class="tabcontent">
               <h3>Sklep</h3>
               <?php  require_once plugin_dir_path( __FILE__ ) . '/views/shop-info.php'; ?>
            </div> 
            <div id="shop-settings" class="tabcontent">
               <h3>Ustawienia Sklepu</h3>
               <?php  require_once plugin_dir_path( __FILE__ ) . '/views/shop-settings.php'; ?>
            </div>
            <div id="shop-settings-api" class="tabcontent">
               <h3>Integracja Sklepu</h3>
               <?php  require_once plugin_dir_path( __FILE__ ) . '/views/shop-settings-api.php'; ?>
            </div>
            
             <div id="opinions" class="tabcontent">
               <h3>Opinie</h3>
               <?php  require_once plugin_dir_path( __FILE__ ) . '/views/opinions.php'; ?>
            </div>
            <div id="shop-opinions" class="tabcontent">
               <h3>Opinie ze sklepu</h3>
               <?php  require_once plugin_dir_path( __FILE__ ) . '/views/shop-opinions.php'; ?>
            </div>
            <div id="system-opinions" class="tabcontent">
               <h3>Opinie ze systemu</h3>
                 <?php  require_once plugin_dir_path( __FILE__ ) . '/views/system-opinions.php'; ?>
            </div>
         </div>
      </div>
    </div>
   <script>

   let activeTab = localStorage.getItem('activeTab');
   if(activeTab){
      let tabLink = document.querySelector(`[href="${activeTab}"`);
     let tabContent = document.querySelector(`[id="${activeTab.replace('#', '')}"`);
     tabLink.classList.add('active');
     tabContent.classList.add('active');
   } else {
      document.querySelector('[href="#dashboard"]').classList.add('active');
      document.querySelector('[id="dashboard"]').classList.add('active');
   }
   function openTab(evt, tabContent) {
      evt.preventDefault();
      localStorage.setItem('activeTab', event.target.hash);

      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
         tabcontent[i].classList.remove('active');
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
         tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(tabContent).classList.add('active')
      evt.currentTarget.className += " active";
   }
   </script>
   
    <?php } else { ?>
         <!-- wp_loginout(); -->
      <p> <a href="<?php echo site_url('/logowanie'); ?>"> Zaloguj</a> się lub <a href="<?php echo site_url('/rejestracja'); ?>"> zarejestruj</a></p>

   <?php  }
     return ob_get_clean();

}
