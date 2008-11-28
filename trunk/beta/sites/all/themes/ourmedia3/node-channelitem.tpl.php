<?php
$uid = $node->uid;
$previousdb = db_set_active('ourmedia');
$result = db_query("SELECT picture, name FROM {users} where uid = %d", $uid);
$omuser = db_fetch_object($result);
if ($omuser)
  $author_picture = $GLOBALS['ourmedia_base_url'] ."/$omuser->picture";
db_set_active($previousdb);
$author = user_load( array("uid" => $uid) );
?>
<div class='node node-<?php print $node->type ?><?php print($sticky ? " sticky" : "") ?><?php print($status ? "" : " node-unpublished") ?>'>
  <?php if (!$tabs) print "<div id='missingtabs'>&nbsp;</div>\n"; ?>
  <div class='nodebody'>
    <div class='date'>
      <?php print format_date($node->created, "custom", "M d, Y"); ?>
    </div>
    <div class='title'>
<?php if ($page) { ?>
      <?php print $title ?>
<?php }
else { ?>
      <a title='Permanent link to this post' alt='permalink' href='/<?php print drupal_get_path_alias('node/'. $node->nid) ?>'><?php print $title ?></a>
<?php } ?>
    </div>
    <div style='clear:both'></div>
<?php
if ($page) {
  if (!hasEmbeddedMedia($content)) {
    $viewer = display_channel_item_viewer($node);
?>
    <div id="media_area" style="text-align: center; margin-bottom: 20px;">
      <div id='movie_media'>
        <?php print $viewer ?>
      </div>
      <div id="media_description">
        <?php print display_channel_item_media_description($node) ?>
       </div>  <!-- media_description -->
    </div> <!-- media_area -->
<?php } ?>
    <div class='body'>
      <?php print $content ?>
    </div>
    
  <div class='user'>
    <img width='100px' src="<?php print $author_picture ?>"  onerror="this.src='/<?php print $GLOBALS['theme_path'] ?>/images/omprofilegreengrassshadow.jpg';" />
    <div class='name'>Posted to this channel by <?php print $name ?></div>
  </div>
    
<?php
}
else
    print stripTeaser($content);
?>
    <div class='links taxonomy'>
      <?php if ($terms) print t("Tags:") . $terms; ?>
    </div>
    <?php
    if ($page) {
      if ($node->og_groups) {
        for ($ind=0; $ind < count($node->og_groups); $ind++) {
          $og_links['og_'. $node->og_groups[$ind]]
            = array('title' => $node->og_groups_names[$ind], 'href' => 'node/'. $node->og_groups[$ind]);
        }
        
        // TODO: this is causing an error in underlying call's to l()
        
        // if ($og_links) {
        //   $og_links = theme('links', $og_links);
        //   print '<div class="links groups">'. t('Channels: ') .  $og_links .'</div>';
        // }
      }
    ?>
    <div class="links">Links:<?php print $links ." ". l('Report abuse', $GLOBALS['theme_path'] ."/images/help/report-abuse"); ?></div>
  <?php } ?>
  </div>
  <div style='clear:both'></div>
</div>

