<?php

/**
 *  
 * Plugin Name: User Social Media 
 * Description: Social Media is plugin for add users infos about links Social Media
 * Version: 1.0.0
 * Author: Younes Fer
 * Plugin URI: https://socialmedia.com/
 * Author URI: http://devfer.epizy.com/
 * Text Domain: user-social-media 
 * 
 */
if (!defined('ABSPATH')) exit();

class SocialMedia
{

  function __construct()
  {
    // input to user interface
    add_action('show_user_profile', [$this, 'extra_user_profile_fields']);
    add_action('edit_user_profile', [$this, 'extra_user_profile_fields']);
    // save data

    add_action('personal_options_update', [$this, 'save_extra_user_profile_fields']);
    add_action('edit_user_profile_update', [$this, 'save_extra_user_profile_fields']);

    add_action('admin_enqueue_scripts',[$this, 'enqueue_styles_scripts']);
  }

  // interface User fields
  function extra_user_profile_fields($user)
  { ?>
    <h2 class="social-media-title"><?php _e("مواقع التواصل الاجتماعي", "blank"); ?></h2>

    <table class="form-table">
      <tbody>
        <tr>
          <th><label for="">Facebook :</label></th>
          <td>
            <input type="text" class="regular-text" name="facebook" value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>" placeholder="link">
          </td>
        </tr>
        <tr>
          <th><label for="">Twitter :</label></th>
          <td>
            <input type="text" class="regular-text" name="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" placeholder="link">
          </td>
        </tr>
        <tr>
          <th><label for="">Instagram :</label></th>
          <td>
            <input type="text" class="regular-text" name="instagram" value="<?php echo esc_attr(get_the_author_meta('instagram', $user->ID)); ?>" placeholder="link">
          </td>
        </tr>
        <tr>
          <th><label for="">Linkedin :</label></th>
          <td>
            <input type="text" class="regular-text" name="linkedin" value="<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>" placeholder="link">
          </td>
        </tr>
      </tbody>
    </table>
  <?php }

  /** validate */
  function checkInput($data)
  {

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // save user data
  function save_extra_user_profile_fields($user_id)
  {

    if (!current_user_can('edit_user', $user_id)) {
      return false;
    }
    update_user_meta($user_id, 'facebook', $this->checkInput($_POST['facebook']));
    update_user_meta($user_id, 'twitter', $this->checkInput($_POST['twitter']));
    update_user_meta($user_id, 'instagram', $this->checkInput($_POST['instagram']));
    update_user_meta($user_id, 'linkedin', $this->checkInput($_POST['linkedin']));
  }

  // when activate plugin
  function activate()
  {
    //Self::create_media();
    flush_rewrite_rules();
  }

  // when deactivate plugin
  function deactivate()
  {
    flush_rewrite_rules();
  }

  // add styles css and scripts js

  function enqueue_styles_scripts(){
    wp_enqueue_style('social-media-css',plugin_dir_url(__FILE__).'/css/style.css',[],false,'all');
    wp_enqueue_script('social-media-js',plugin_dir_url(__FILE__).'/js/main.js',[],false,true);
  }

}


if (class_exists('SocialMedia')) {
  $l = new SocialMedia();

  register_activation_hook(__FILE__, ['SocialMedia', 'activate']);
  register_deactivation_hook(__FILE__, ['SocialMedia', 'deactivate']);
}


//echo plugin_dir_url(__FILE__).'<br>';

