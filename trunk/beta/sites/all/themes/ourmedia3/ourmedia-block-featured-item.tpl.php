<?php
// $Id$
/* @file
 * featured producer block items
 */
 
 if (!drupal_strlen($artistpicurl))
  $artistpicurl = $directory ."/images/omprofilegreengrassshadow.jpg";
?>

<div class='artist'>
  <a href="<?php echo $link ?>" title='Click to view artist homepage or profile'><img src='<?php echo $artistpicurl ?>' onerror='this.src="/<?php print $directory .'/images/producerImg.jpg' ?>";'/></a>
  <div>
    <label><a href="<?php print $variables['link'] ?>" title='Click to read post'><?php print $variables['title'] ?></a></label><br/>
<?php if (drupal_strlen($variables['author'])) { ?>
    by <a href="<?php print $variables['artisturl'] ?>" title='Click to view artist homepage or profile'><?php print $variables['author'] ?></a><br/>
<?php } ?>
    <p>
      <?php print $variables['description'] ?>
    </p>
  </div>
  <br/>
</div>
