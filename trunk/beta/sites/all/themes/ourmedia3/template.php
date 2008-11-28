<?php

// $Id$

/* @file
 * ourmedia3 theme template file
 */

/**
 * Implementation of hook_theme().
 *
 * Register custom theme functions.
 *
 * Found at http://www.lullabot.com/articles/modifying-forms-5-and-6
 */
function ourmedia3_theme() {
  return array(
    // The form ID.
    'user_login_block' => array(
      // Forms always take the form argument.
      'arguments' => array('form' => NULL),
    ),
    // 'aggregator_block_item' => array(
    //   'arguments' => array('item' => NULL, 'feed' => 0),
    //   'template' => 'aggregator-block-item',
    // ),
  );
}

/**
 * Theme override for user edit form.
 *
 * The function is named themename_formid.
 *
 * function Ourmedia3_user_profile_form($form) {
 */

function ourmedia3_user_login_block($form) {
  $output = '';
  // Print out the $form array to see all the elements we are working with.
  //$output .= dsm($form);
  // Once I know which part of the array I'm after we can change it.

  // Make sure you call a drupal_render() on the entire $form to make sure you
  // still output all of the elements (particularly hidden ones needed
  // for the form to function properly.)
  //  print_r($form);
  $output .= drupal_render($form);
  $pos_form_id_start = strpos($output, "name=\"form_build_id\" id=\"form-") + 25;
  $pos_form_id_end = strpos($output, "\"", $pos_form_id_start);
  $pos_form_id = drupal_substr($output, $pos_form_id_start, $pos_form_id_end - $pos_form_id_start);

  $output = "<div id=\"signInDivider\">";

  $output .=  "<input type=\"text\" maxlength=\"60\" name=\"name\" id=\"edit-name\" size=\"15\" value=\"\" tabindex=\"1\" class=\"form-text required signIn\" />\n";
  $output .= "<input type=\"password\" name=\"pass\" id=\"edit-pass\"  maxlength=\"60\"  size=\"15\"  tabindex=\"2\" class=\"form-text required signIn\" />\n";
  $output .= "<input type=\"submit\" name=\"op\" id=\"edit-submit\" value=\"Log in\"  tabindex=\"3\" class=\"form-submit button signIn\" />";

  $output .= "</div>";
  $output .= "<div id=\"register\"><a href=\"/user/register\"><input type=\"button\" name=\"\" value=\"Register\" class=\"button\"></a></div>";

  $output .= "<input type=\"hidden\" name=\"form_build_id\" id=\"$pos_form_id\" value=\"$pos_form_id\"  />";
  $output .= "<input type=\"hidden\" name=\"form_id\" id=\"edit-user-login-block\" value=\"user_login_block\"  />";

  return $output;
}

//<!-- <div id="signIn">
//        <form action="/user" method="post" class="nopadding">
//                <div id="signInDivider">
//                        <input name="name" type="text" value=""> &nbsp;
//                        <input name="pass" type="text" value=""> &nbsp;
//                        <input type="submit" name="" value="Sign In" class="button">
//                </div>
//                <div id="register">
//                        <a href="/user/register"><input type="button" name="" value="Register" class="button"></a>
//                </div>
//        </form>
//</div> -->


// function Ourmedia3_lt_loggedinblock() {
//   $output = "woo hoo";
//   return $output;
// }
//
//function Ourmedia3_user_bar() {
//   global $user;
//   $output = '';
//
//   if (!$user->uid) {
//     $output .= drupal_get_form('user_login_block');
//   }
//   else {
//     $output .= t('<p class="user-info">Hi !user, welcome back.</p>', array('!user' => theme('username', $user)));
//
//     $output .= theme('item_list', array(
//       l(t('Your account'), 'user/'.$user->uid, array('title' => t('Edit your account'))),
//       l(t('Sign out'), 'logout', array(), drupal_get_destination())));
//   }
//
//   $output = '<div id="user-bar">'.$output.'</div>';
//
//   return $output;
// }



function phptemplate_preprocess_page($vars) {
  if (isset($vars['node'])) {
    $vars['comments'] = comment_render($vars['node']);
  }
}

function phptemplate_preprocess_node($vars) {
  unset($vars['node']->comment);
}

