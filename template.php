<?php

/**
* Implementation of hook_theme.
*
* Register custom theme functions.
* 
* Found at http://www.lullabot.com/articles/modifying-forms-5-and-6
*/
function Ourmedia3_theme() {
  return array(
    // The form ID.
    'user_login_block' => array(
      // Forms always take the form argument.
      'arguments' => array('form' => NULL),
    ),
    'aggregator_block_item' => array(
      'arguments' => array('item' => NULL, 'feed' => 0),
      'template' => 'aggregator-block-item',
    ),
  );
}

/**
* Theme override for user edit form.
*
* The function is named themename_formid.
* 
* function Ourmedia3_user_profile_form($form) {
*/

function Ourmedia3_user_login_block($form) {
  $output = '';
  // Print out the $form array to see all the elements we are working with.
  //$output .= dsm($form);
  // Once I know which part of the array I'm after we can change it.

  // Make sure you call a drupal_render() on the entire $form to make sure you
  // still output all of the elements (particularly hidden ones needed
  // for the form to function properly.)
  //  print_r($form);
  $output .= drupal_render($form);
	$posFormIdStart = strpos($output,"name=\"form_build_id\" id=\"form-") + 25;
	$posFormIdEnd = strpos($output,"\"", $posFormIdStart);
	$posFormId = substr($output,$posFormIdStart, $posFormIdEnd - $posFormIdStart);

	$output = "<div id=\"signInDivider\">";

	$output .=  "<input type=\"text\" maxlength=\"60\" name=\"name\" id=\"edit-name\" size=\"15\" value=\"\" tabindex=\"1\" class=\"form-text required signIn\" />\n";
	$output .= "<input type=\"password\" name=\"pass\" id=\"edit-pass\"  maxlength=\"60\"  size=\"15\"  tabindex=\"2\" class=\"form-text required signIn\" />\n";
	$output .= "<input type=\"submit\" name=\"op\" id=\"edit-submit\" value=\"Log in\"  tabindex=\"3\" class=\"form-submit button signIn\" />";

	$output .= "</div>";
	$output .= "<div id=\"register\"><a href=\"/user/register\"><input type=\"button\" name=\"\" value=\"Register\" class=\"button\"></a></div>";

	$output .= "<input type=\"hidden\" name=\"form_build_id\" id=\"$posFormId\" value=\"$posFormId\"  />";
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
// 	$output = "woo hoo";
// 	return $output;
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
 
function Ourmedia3_player($mediaURL, $extension, $height = "360", $width = "480", $autostart = "false") {

  // handle mimetypes as well as extensions
  if (strpos($extension, "/") > 0) 
    list($media, $extension) = split("/", $extension);

  $themepath = "http://dev.ourmedia.org/" . path_to_theme();

  if (strpos($mediaURL, "/sites/default/files") === false)
    $mediaURL = "http://dev.ourmedia.org/sites/default/files/" . $mediaURL;

  if (($extension == "mov") || ($extension == "mp4") || ($extension == "m4v") || ($extension == "x-m4v") || ($extension == "mpg") || ($extension == "mpv") || ($extension == "quicktime") || ($extension == "3gpp") || ($extension == "dv") || (($media == "video") && ($extension =="mpeg"))) {	
    $output = "<embed PLUGINSPAGE=\"http://www.apple.com/quicktime/download/\" src=\"$mediaURL\" width=\"$width\" height=\"$height\" autoplay=\"$autostart\" controller=\"true\" enablejavascript=\"true\" scale=\"aspect\"></embed>";
    return $output;
  }
	
  if ($extension == "divx") {
    $height = "212";
    $output = "<object classid=\"clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616\" width=\"$width\" height=\"$height\" codebase=\"http://go.divx.com/plugin/DivXBrowserPlugin.cab\"><param name=\"src\" value=\"$mediaURL\" /><embed type=\"video/divx\" src=\"$mediaURL\" autoPlay=\"$autostart\" width=\"$width\" height=\"$height\" pluginspage=\"http://go.divx.com/plugin/download/\"></embed></object>";
    return $output;
  }

  if (($extension == "avi") || ($extension == "wmv") || ($extension == "x-msvideo") || ($extension == "x-msvideo") || ($extension == "x-ms-wvx") || ($extension == "x-ms-wmv") || ($extension == "x-ms-asf"))  {
    $output = "<embed type=\"application/x-mplayer2\" pluginspage=\"http://microsoft.com/windows/mediaplayer/en/download/\" id=\"mediaPlayer\" name=\"mediaPlayer\" displaysize=\"4\" autosize=\"-1\" bgcolor=\"darkblue\" showcontrols=\"true\" showtracker=\"-1\" showdisplay=\"0\" showstatusbar=\"-1\" videoborder3d=\"-1\" width=\"$width\" height=\"$height\" src=\"$mediaURL\" autostart=\"$autostart\" designtimesp=\"5311\ loop=\"true\"></embed>";
  // $output = "<embed src=\"$mediaURL\" width=\"$width\" height=\"$height\" autoplay=\"$autostart\" controller=\"true\" enablejavascript=\"true\"></embed>";
    return $output;
  }

  if (($extension == "mp3") || (($media == "audio") && ($extension =="mpeg"))) {
    $height = "15";
    $output = "<embed pluginspage=\"http://www.apple.com/quicktime/download/\" src=\"$mediaURL\" width=\"$width\" height=\"$height\" autoplay=\"$autostart\" controller=\"true\" enablejavascript=\"true\"></embed>";
    return $output;
  }

  if (($extension == "rm") || ($extension == "ram")) {
    $output = "<embed type=\"audio/x-pn-realaudio-plugin\" src=\"$mediaURL\" width=\"$width\" height=\"$height\" controls=\"ImageWindow\" console=\"one\" autostart=\"$autostart\"></embed>";
    return $output;
  }

  if (($extension == "swf") || ($extension == "x-shockwave-flash")) {
    $output =  "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"$width\" height=\"$height\"> <param name=\"movie\" value=\"$mediaURL\"> <param name=\"quality\" value=\"high\"><param name=\"bgcolor\" value=\"#FFFFFF\"> <param name=\"loop\" value=\"true\"><embed src=\"$mediaURL\" quality=\"high\" bgcolor=\"#FFFFFF\" width=\"$width\" height=\"$height\" loop=\"true\" type=\"application/x-shockwave-flash\"  pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\"></embed></object>";
    return $output;
  }

  if (($extension == "flv") || ($extension == "x-flv")) {
    $mediaURL = urlencode($mediaURL);
    $output = "<embed src=\"$themepath/players/flowplayer/FlowPlayerLight.swf?config=%7Bembedded%3Atrue%2CshowFullScreenButton%3Atrue%2CshowMuteVolumeButton%3Atrue%2CshowMenu%3Atrue%2CautoBuffering%3Atrue%2CautoPlay%3A$autostart%2CinitialScale%3A%27fit%27%2CmenuItems%3A%5Bfalse%2Cfalse%2Cfalse%2Cfalse%2Ctrue%2Ctrue%2Cfalse%5D%2CusePlayOverlay%3Afalse%2CshowPlayListButtons%3Atrue%2CplayList%3A%5B%7Burl%3A%27$mediaURL%27%7D%5D%2CcontrolBarGloss%3A%27high%27%2CshowVolumeSlider%3Atrue%2CbaseURL%3A%27http%3A%2F%2Fwww%2Earchive%2Eorg%2Fdownload%2F%27%2Cloop%3Afalse%2CcontrolBarBackgroundColor%3A%270x000000%27%7D\" width=\"$width\" height=\"$height\" scale=\"noscale\" bgcolor=\"111111\" type=\"application/x-shockwave-flash\" allowFullScreen=\"true\" allowScriptAccess=\"always\" allowNetworking=\"all\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"></embed>";
    return $output;
  }

}


/**
* Override or insert PHPTemplate variables into the search_block_form template.
*
* @param $vars
*   A sequential array of variables to pass to the theme template.
* @param $hook
*   The name of the theme function being called (not used in this case.)
*/
function phptemplate_preprocess_search_block_form(&$vars, $hook) {

  // Modify elements of the search form

  $vars['form']['search_block_form']['#title'] = t('Search');


  // 
  // $vars['form']['search_block_form']['select_source'] = array(
  //   '#type' => 'select',
  //   '#default_value' => 0, 
  //   '#options' => array(t("Media"), t("Channels"), t("Producers"), t("Learning Center")),
  // );

// add the option before the submit
  $newitem = array();
  $newitem['select_source'] = array(
    '#type' => 'select',
    '#default_value' => 0, 
    '#id' => 'select-source', 
    '#name' => 'select_source', 
    '#options' => array(t("Media"), t("Channels"), t("Producers"), t("Learning Center")),
  );
  $pos = array_search('submit', array_keys($vars['form']));
  $vars['form'] = array_merge(array_slice($vars['form'], 0, $pos), $newitem, array_slice($vars['form'], $pos));

 //var_dump($vars['form']);

  // Rebuild the rendered version (search form only, rest remains unchanged)

  unset($vars['form']['search_block_form']['#printed']);
  $vars['search']['search_block_form'] = drupal_render($vars['form']['search_block_form']) . drupal_render($vars['form']['select_source']);

  // Collect all form elements to make it easier to print the whole form.

  $vars['search_form'] = implode($vars['search']);

}

?>
