<ul>
<?php

// $Id$

/* @file
 * producer reels
 */

// todo: move to preprocessing

$lastcat = "_producer_reels_last_category_this_must_be_over_twenty_characters_long";
$flag = FALSE;

foreach ($reels as $reel) {
  $title = $reel->title;
  if (drupal_strlen($title) > 20)
    $title = drupal_substr($title, 0, 18) ." ...";

  $category = $reel->category;
  if (drupal_strlen($category) > 50)
    $category = drupal_substr($category, 0, 50) ." ...";

  if (drupal_strtolower($lastcat) != drupal_strtolower($category)) {
    $lastcat = $category;
    if ($flag) {
      print "</ul></li>";
      $flag = FALSE;
    }
    print "<li><h1>$category</h1><ul>";
    $flag = TRUE;
  }

  $thumbnail = $reel->thumbnail;
  if (drupal_strlen($thumbnail)==0) {
    $thumbnail = $GLOBALS['ourmedia_base_url'] ."/". $directory ."/images/video.gif";
    if (drupal_strlen($reel->identifier))
      $thumbnail = $GLOBALS['ourmedia_base_url'] ."/ia/thumbnail/". $reel->identifier;
    else {
      $node = node_load($reel->nid);
      if (count($node->files)) {
        // todo: look for an img attchement
      }
    }
  }
  // if (drupal_strlen($thumbnail)==0)
  //   $thumbnail = "/". $directory ."/images/video.gif";

  $webpage = $reel->webpage;
  if (drupal_strlen($webpage)==0)
    $webpage = "/node/". $reel->nid;

  $icon = "/". $directory ."/images/video.gif";
  // if ()
  //   $icon = "";
  // else if ()
  //   $icon = "";

?>

<li>
<a href="<?php print $webpage ?>" title="<?php print $reel->title ?>..." >
  <img src="<?php print $icon ?>" onload="this.src='<?php print $thumbnail ?>';" />
  <div><?php print $title ?></div>
</a>
</li>

<?php
}  // foreach

if ($flag)
  print "</ul></li>";
?>
</ul>

