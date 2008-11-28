<?php

// $Id$

/* @file
 * user block
 */

?>
<div id="signIn">
<?php
  global $user;
  $output = '';

  if (!$user->uid) {
    $output .= drupal_get_form('user_login_block');
  }
  else {
    $output .= t('<p class="user-info">Hi !user, welcome back.</p>', array('!user' => theme('username', $user)));

    $output .= theme('item_list', array(
      l(t('Your account'), 'user/'. $user->uid, array('title' => t('Edit your account'))),
      l(t('Sign out'), 'logout')));
  }

  $output = '<div id="user-bar">'. $output .'</div>';
  print $output;
?>
</div>
