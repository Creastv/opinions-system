<?php
/**
 * Plugin Name:       Opinions system
 * Description:       Custome login form, reagistration form, lost password
 * Version:           1.0.1
 * Author:            Piotr Stefaniak
 * License:           GPL-2.0+
 * Text Domain:       o-system
 **/

require_once plugin_dir_path( __FILE__ ) . '/re-log/registration.php';
require_once plugin_dir_path( __FILE__ ) . '/re-log/login.php';
require_once plugin_dir_path( __FILE__ ) . '/re-log/lost-password.php';
require_once plugin_dir_path( __FILE__ ) . '/user-panel/panel.php';
require_once plugin_dir_path( __FILE__ ) . '/shops/cpt.php';

function o_system_reg_frond(){
        wp_enqueue_style('o-system', plugins_url('/inc/css/o-system.css', __FILE__));
        wp_enqueue_script('o-system', plugins_url( '/inc/js/o-system.js' , __FILE__ ));
        wp_enqueue_script('o-recaptcha', 'https://www.google.com/recaptcha/api.js');
       // wp_enqueue_script('o-vue-js', 'https://unpkg.com/vue@next');
        //wp_enqueue_script('o-vue-script', plugins_url( '/opinions/inc/js/o-system-vue.js' , __FILE__ ));
    }
add_action('wp_enqueue_scripts','o_system_reg_frond');

// function o_system_reg_back(){
//         wp_enqueue_style('o-system', plugins_url('/inc/css/o-system.css', __FILE__));
        //wp_enqueue_script('o-system', plugins_url( '/inc/js/o-system.js' , __FILE__ ));
//     }
// add_action('wp_enqueue_scripts','o_system_reg_back');



 class Active {
    /**
     * Plugin activation hook.
     *
     * Creates all WordPress pages needed by the plugin.
     */
    public static function plugin_activated() {
        // Information needed for creating the plugin's pages
        $page_definitions = array(
            'member-account-login' => array(
                'title' => __( 'Logowanie', 'o-system' ),
                'content' => '[o-system-login-form]'
            ),
            'member-account' => array(
                'title' => __( 'Panel użytkownika', 'o-system' ),
                'content' => '[o-system-info]'
            ),
            'member-account-lostpassword' => array(
                'title' => __( 'Odzyskiwanie hasła', 'o-system' ),
                'content' => '[o-system-forgot-pwd-form]'
            ),
            'member-account-changepassword' => array(
                'title' => __( 'Sklepy', 'o-system' ),
            ),
            'member-account-registration' => array(
                'title' => __( 'Rejestracja', 'o-system' ),
                'content' => '[o-system-acount-form]'
            ),
        );
    
        foreach ( $page_definitions as $slug => $page ) {
            // Check that the page doesn't exist already
            $query = new WP_Query( 'pagename=' . $slug );
            if ( ! $query->have_posts() ) {
                // Add the page using the data from the array above
                wp_insert_post(
                    array(
                        'post_content'   => $page['content'],
                        'post_name'      => $slug,
                        'post_title'     => $page['title'],
                        'post_status'    => 'publish',
                        'post_type'      => 'page',
                        'ping_status'    => 'closed',
                        'comment_status' => 'closed',
                    )
                );
            }
        }
    }
}

// Initialize the plugin
$personalize_login_pages_plugin = new Active();

// Create the custom pages at plugin activation
register_activation_hook( __FILE__, array( 'Active', 'plugin_activated' ) );

