<?php
// $Id$

/* @file
 * featured video iframe
 */

function has_embedded_media($content) {
  $s = strtolower($content);
  return !((strpos($s, "<embed") === FALSE) || (strpos($s, "<object") === FALSE));
}

function display() {

  $themepath = "/sites/all/themes/ourmedia3";

  // 2008-09-06 - mss - added check for array_key_exists

  if (array_key_exists('video', $_GET))
    $mediaurl = urldecode($_GET['video']);
  if (array_key_exists('bigscreenshot', $_GET))
    $screenshoturl = urldecode($_GET['bigscreenshot']);
  else
    $screenshoturl = "";    

  $extension = '';
  $parts = split('\.', $mediaurl);
  if (count($parts) > 1)
    $extension = end($parts);
  if (!$extension && count($parts) > 2)
    $extension = prev($parts);
  $extension = strtolower($extension);

  if (array_key_exists('height', $_GET))
    $height = $_GET['height'];
  else
    $height = "";
  if (array_key_exists('width', $_GET))
    $width = $_GET['width'];
  else
    $width = "";
  if (array_key_exists('autostart', $_GET))
    $autostart = strtolower($_GET['autostart']);
  else
    $autostart = "false";
  if (array_key_exists('notes', $_GET))
    $notes = urldecode($_GET['notes']);
  else
    $nodes = "";

  if ((strlen($mediaurl) > 0) && (!has_embedded_media($notes))) {
    if (($extension == "jpg") || ($extension == "jpeg") || ($extension == "gif") || ($extension == "png") || ($extension == "tiff") || ($extension == "bmp") || ($extension == "svg")) {
      $output = "<p align=\"center\"><img border=\"0\" src=\"$mediaurl\" onerror=\"this.src='". $themepath ."/images/video320x240.gif';\" /></p>";
      if (strlen($notes) > 0)
        $output .= "<div id=\"medianotes\">$notes</div>";
   }
    else {
      if ((strlen($screenshoturl) > 0) && ($autostart == 'false')) {
        $mediaurl = "featured_video.php?video=". urlencode($mediaurl) ."&bigscreenshot=". urlencode($screenshoturl) ."&notes=". urlencode($notes) ."&height=$height&width=$width&autostart=true";
        $output = "<p align=\"center\"><a href=\"$mediaurl\" target=\"_self\"><img border=\"0\" src=\"$screenshoturl\" onerror=\"this.src='". $themepath ."/images/video320x240.gif';\" /></a></p>";
      }
      else
        $output = display_media($mediaurl, $extension, $height, $width, $autostart);  // no notes
    }
  }
  else {
    if ((strlen($screenshoturl) > 0) && (strpos($notes, $screenshoturl) === FALSE) && (!has_embedded_media($notes)))
      $output = "<p align=\"center\"><img border=\"0\" src=\"$screenshoturl\" onerror=\"this.src='". $themepath ."/images/video320x240.gif';\" /></p>";
    if (strlen($notes) > 0)
      $output .= "<div id=\"medianotes\">$notes</div>";
  }
  return  $output;

}


function display_media($mediaurl, $extension, $height, $width, $autostart) {

  $themepath = "/sites/all/themes/ourmedia3";

  if (($extension == "mov") || ($extension == "mp4") || ($extension == "m4v")) {
    if (strlen($height)==0)
      $height = "260";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output = "<embed pluginspage=\"http://www.apple.com/quicktime/download/\" src=\"". $themepath ."/players/QT.mov\" qtsrc=\"$mediaurl\" width=\"$width\" height=\"$height\" autoplay=\"$autostart\" controller=\"true\" scale=\"aspect\" enablejavascript=\"true\"></embed>";
    return $output;
  }

  if ($extension == "avi") {
    if (strlen($height)==0)
      $height = "260";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output = "<embed type=\"application/x-mplayer2\" pluginspage=\"http://microsoft.com/windows/mediaplayer/en/download/\" id=\"mediaPlayer\" name=\"mediaPlayer\" displaysize=\"4\" autosize=\"-1\" bgcolor=\"darkblue\" showcontrols=\"true\" showtracker=\"-1\" showdisplay=\"0\" showstatusbar=\"-1\" videoborder3d=\"-1\" width=\"$width\" height=\"$height\" src=\"$mediaurl\" autostart=\"$autostart\" designtimesp=\"5311\ loop=\"true\"></embed>";
    return $output;
  }

  if ($extension == "divx") {
    if (strlen($height)==0)
      $height = "212";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output = "<object classid=\"clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616\" width=\"$width\" height=\"$height\" codebase=\"http://go.divx.com/plugin/DivXBrowserPlugin.cab\"><param name=\"src\" value=\"$mediaurl\" /><embed type=\"video/divx\" src=\"$mediaurl\" autoPlay=\"$autostart\" width=\"$width\" height=\"$height\" pluginspage=\"http://go.divx.com/plugin/download/\"></embed></object>";
    return $output;
  }

  if ($extension == "wmv") {
    if (strlen($height)==0)
      $height = "260";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output = "<embed src=\"$mediaurl\" width=\"$width\" height=\"$height\" autoplay=\"$autostart\" controller=\"true\" enablejavascript=\"true\"></embed>";
    return $output;
  }

  if ($extension == "mp3") {
    //if (strlen($height)==0)
    $height = "15";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output = "<img src='". $themepath ."/images/audio320x240.gif' onerror=\"this.src='". $themepath ."/images/audio320x240.gif';\" /><br/><embed pluginspage=\"http://www.apple.com/quicktime/download/\" src=\"". $themepath ."/players/QT.mov\" qtsrc=\"$mediaurl\" width=\"$width\" height=\"$height\" autoplay=\"$autostart\" controller=\"true\" enablejavascript=\"true\" bgcolor=\"#b9b1fc\"></embed>";
    return $output;
  }

  if ($extension == "mpeg" || $extension == "mpg") {
    if (strlen($height)==0)
      $height = "260";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output = "<embed pluginspage=\"http://www.apple.com/quicktime/download/\" src=\"Sample.mov\" qtsrc=\"$mediaurl\" width=\"$width\" height=\"$height\" autoplay=\"$autostart\" controller=\"true\" enablejavascript=\"true\"></embed>";
    return $output;
  }

  if (($extension == "rm") || ($extension == "ram")) {
    if (strlen($height)==0)
      $height = "260";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output = "<embed type=\"audio/x-pn-realaudio-plugin\" src=\"$mediaurl\" width=\"$width\" height=\"$height\" controls=\"ImageWindow\" console=\"one\" autostart=\"$autostart\"></embed>";
    return $output;
  }

  if ($extension == "ra") {
    if (strlen($height)==0)
      $height = "260";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output = "add real media audio code";
    return $output;
  }

  if ($extension == "swf") {
    if (strlen($height)==0)
      $height = "260";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

    $output =  "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"$width\" height=\"$height\"> <param name=\"movie\" value=\"$mediaurl\"> <param name=\"quality\" value=\"high\"><param name=\"bgcolor\" value=\"#FFFFFF\"> <param name=\"loop\" value=\"true\"><embed src=\"$mediaurl\" quality=\"high\" bgcolor=\"#FFFFFF\" width=\"$width\" height=\"$height\" loop=\"true\" type=\"application/x-shockwave-flash\"  pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\"></embed></object>";
    return $output;
  }

  if ($extension == "flv") {
    if (strlen($height)==0)
      $height = "268";
    if (strlen($width)==0)
      $width = "320";
    if (strlen($autostart)==0)
      $autostart = "false";

      $output = <<<endofplayer
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="$width" height="$height" id="320x268_v6" align="middle" wmode="transparent">
  <param name="allowScriptAccess" value="sameDomain" />
  <param name="movie" value="$themepath/players/flvplayer.swf?file=$mediaurl&autostart=$autostart" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  <embed src="$themepath/players/flvplayer.swf?file=$mediaurl&autostart=$autostart" swliveconnect="true" quality="high" width="$width" height="$height" name="320x268_v6" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></embed>
    </object>
endofplayer;

    return $output;
  }

}
?>

<html>
  <head>
  <style>
    * {padding:0;margin:0;}
    body {}
  </style>
  </head>
  <body>
  <center><?php echo display() ?></center>
  </body>
</html>