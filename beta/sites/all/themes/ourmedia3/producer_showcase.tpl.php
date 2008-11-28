<?php
// $Id$

/* @file
 * shocase template
 */

// move code to preprocess


function get_node_default_file($identifier = "") {
   $result = db_fetch_object(db_query("SELECT field_default_file_value AS file FROM {content_type_media} WHERE field_identifier_value = '%s'", $identifier));
   if ($result) {
     if (drupal_strlen($result->file))
       return $result->file;
   }
   return "default media url goes here";
}

function media_node_load($identifier = "") {
  $result = db_fetch_object(db_query("SELECT nid FROM {content_type_media} WHERE field_identifier_value = '%s'", $identifier));
  if ($result) 
    return node_load($result->nid);
}

function most_recent_media_noad_load($uid) {
  $result = db_fetch_object(db_query("SELECT nid FROM {node} WHERE type = 'media' AND uid = %d ORDER BY created DESC", $uid));
  if ($result) 
    return node_load($result->nid);
}


function set_media_vars($node, $identifier = "") {
  $title = $node->title;
  if (drupal_strlen($identifier))
    $link = "/ia/details/". $identifier;
  else
    $link = "/node/". $node->nid;
  $mediaurl = $node->field_default_file[0]['value'];
  if (!drupal_strlen($mediaurl)) {  // get it from attachments
   $cnt = 0;
   foreach ($node->files as $file) {
     $cnt++;
     if (count($node->files) == 1) 
       $mediaurl = $file->filepath; // if only one file, use it
     elseif (strpos($file->description, "/original/") !== FALSE) {
       $mediaurl = $file->filepath; // found original tag
       break;
     } 
     elseif (strpos($filename, "_files.xml") || strpos($filename, "_meta.xml") )
       $mediaurl = $file->filepath; // avoid _meta.xml and _files.xml files
     elseif ($cnt == 1)
       $mediaurl = $file->filepath; // always use the first file if no other hint
   }
  }
  if ((strpos($mediaurl, "internetarchive/") !== FALSE) && (strpos($mediaurl, "http://") !== 0))
    $mediaurl = str_replace("internetarchive/", "http://www.archive.org/download/", $mediaurl);    
  return array('mediaurl' => $mediaurl, 'title' => $title, 'link' => $link);
}


// main
$identifier = $account->profile_showcase_reel;
$title = "No media found for $identifier";
$mediaurl = "missing mediaurl";
$link = "missing link";

if (strpos($identifier, "http://") === 0) {
  $mediaurl = $identifier;
  $title = $identifier;
  $link = $identifier;
}
elseif ($node = media_node_load($identifier)) {
  extract(set_media_vars($node, $identifier));
}
elseif ($node = most_recent_media_noad_load($account->uid)) {
  extract(set_media_vars($node));
}

// test urls
// $mediaurl = "http://www.archive.org/download/Echo_Chamber_Project_Vlog_Episode_2_Remix/echochamber02_remix.mov";
// $mediaurl = "http://www.archive.org/download/Apperceptions-AHummerWagonForADog556/Apperceptions-AHummerWagonForADog556.flv";
// $mediaurl = "http://www.youtube.com/watch?v=PkVos2bHKYQ";


// code is duplicated from ourmedia_player 
// replace calls here with newer ourmedia_player
  if (strpos($mediaurl, "http:") === FALSE) {
    if (strpos($mediaurl, "/") !== 0) {
      if (strpos($mediaurl, "sites/default/files") === FALSE)
        $mediaurl = $base_url ."/sites/default/files/" . $mediaurl;
      else
        $mediaurl = $base_url .'/'. $mediaurl;
    }
    else {
      $mediaurl = $base_url . $mediaurl;
    }
  }


if (strpos($mediaurl, ".mp4") || strpos($mediaurl, ".mov") || strpos($mediaurl, ".m4v") || strpos($mediaurl, ".mpg") || strpos($mediaurl, ".mpeg") || strpos($mediaurl, ".mpv") || strpos($mediaurl, ".3gpp") || strpos($mediaurl, ".dv") ) {
  $output = theme("media_player_qt", $mediaurl);
}
elseif (strpos($mediaurl, ".mp3")) {
  $output = theme("media_player_mp3", $mediaurl);
}
elseif (strpos($mediaurl, ".swf")) {
  $output = theme("media_player_swf", $mediaurl);
}
elseif (strpos($mediaurl, ".divx")) {
  $output = theme("media_player_divx", $mediaurl);
}
elseif (strpos($mediaurl, ".avi")) {
  $output = theme("media_player_avi", $mediaurl);
}
elseif (strpos($mediaurl, ".wmv")) {
  $output = theme("media_player_wmv", $mediaurl);
}
elseif (strpos($mediaurl, ".flv")) {
  $output = theme("media_player_flv", $mediaurl);
}
elseif (strpos($mediaurl, ".jpg") || strpos($mediaurl, ".jpeg") || strpos($mediaurl, ".gif") || strpos($mediaurl, ".png") || strpos($mediaurl, ".svg") || strpos($mediaurl, ".tiff") || strpos($mediaurl, ".bmp")) {
  $output = theme("media_player_image", $mediaurl);
}
elseif (strpos($mediaurl, "youtube.com")) {
  list($other, $identifier) = split("\?v=", $mediaurl, 2);
  if (!drupal_strlen($identifier))
    list($other, $identifier) = split("/v/", $mediaurl, 2);
  $output = theme("media_player_youtube", $identifier);
  $link = $mediaurl;
}
else {
  $output = $mediaurl;
}
?>

<div id="producer-showcase">
  <div class='producer-showcase-media'>
    <?php print $output ?>
  </div>
  <div class='producer-showcase-info'>
    <a href="<?php print $link ?>" title="Click here to play in browser ..."><?php print $title ?></a>
  </div>
</div>



