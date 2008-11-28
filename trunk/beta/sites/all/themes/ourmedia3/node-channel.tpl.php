<?php

// $Id$

/* @file
 * channel
 */

  global $theme_path, $channels_base_url, $ourmedia_base_url;

  if ($page) {
    $mediaitems = mediarss_channel2array($node->nid);
    if (count($mediaitems) > 0)
      $mediaitem = $mediaitems[0];
    else
      $mediaitem = getDefaultMediaitem();

?>

<div id="homepage">

  <div id="featured-videos" style="text-align: center">

    <div id='thumbnail_left'>
      <a href="#"  ondblclck='if (window.event && window.event.srcElement) window.event.returnValue=false; else return false;' onclick='return(slide_thumbnails(-50))' onmousedown='rew_thumbnails()'  onmouseup='stop_thumbnails()' ><img src="/<?php print $theme_path ?>/images/stock_media-rew.png"/></a>
    </div>

    <div id="thumbnail_area">
      <div id='thumbnail_slider'>

        <?php print display_channel_slider($node, $mediaitems) ?>

      </div> <!-- slider -->
    </div>  <!-- thumbnail_area -->

    <div id='thumbnail_right'>
      <a href="#"  ondblclck='if (window.event && window.event.srcElement) window.event.returnValue=false; else return false;' onclick='return(slide_thumbnails(50))' onmousedown='fwd_thumbnails()'  onmouseup='stop_thumbnails()' ><img src="/<?php print $theme_path ?>/images/stock_media-fwd.png"/></a>
    </div>

    <div style='clear:both'></div>

    <div id="media_area">

      <div id='movie_media'>
        <?php print display_channel_viewer($node, $mediaitem) ?>
      </div>

      <div id="media_description">
        <?php print display_channel_media_description($node, $mediaitem) ?>
       </div>  <!-- media_description -->

    </div> <!-- media_area -->

        <div class="explain">&nbsp; &nbsp;&nbsp;<a title="Members of this channel selected these videos and audio files from around the Web to spotlight here for a few days." href="features#media_showcase">(About '<?php print $node->title ?>')</a></div>

    <div class="channelrss"><a href="<?php print $channels_base_url?>/mediarss/channel/<?php print $node->nid?>" title="Subscribe to this channel"><img border="0" src="/<?php print $theme_path?>/images/rssIcon.gif"/></a></div>

    <div class='playerlaunch'><a href="#" title="Popup channel viewer"  onclick="window.open('<?php print $channels_base_url ?>/mediarss/popup/<?php print $node->nid ?>', 'channels', 'width=720, height=650, top=20, left=20, scrollbars=no, resizable=yes, toolbar=no, directories=no, location=no, menubar=no, status=yes, left=0, top=0');return false" >Launch channel viewer</a></div>

    <div class="spacing"></div>

  </div> <!-- featured_videos -->


  <div style='clear:both'></div>


  <div id="channel-stream" class="fp-headline">
    <h2><?php print t("Channel talk") ?></h2>
    <?php print $content ?>
    
    
<?php
$view_name = 'og_ghp_ron'; //name of view
// $view_args = array();
// $view = views_get_view($view_name);
// //print views_build_view('embed', $view, $view_args, $view->use_pager, $view->nodes_per_page);
// print theme_views_view_unformatted($view, $view_args, $view->use_pager, $view->title);

print views_embed_view($view_name, 'default', $node->nid);
?>
    
    <div class="explain">&nbsp; <a title="This section draws from public conversations from this channel." href="node/308595#channel_talk">(About Channel talk)</a></div>
  </div>

</div>

<?php

}
else {

?>
<div class='node node-<?php print $node->type ?><?php if ($sticky) print " sticky" ?><?php if (!$status) print " node-unpublished" ?>'>

  <div class='nodebody'>
    <div class='date'>
      <?php print format_date($node->created, "custom", "M d, Y"); ?>
    </div>

    <div class='title'>
      <a title='Permanent link to this post' alt='permalink' href='<?php print drupal_get_path_alias('node/'. $node->nid) ?>'><?php print $title ?></a>
    </div>

    <div class='body'>
      <?php print $content ?>
    </div>

    <div class='links taxonomy'>
      <?php if ($terms) print t("Tags:") . $terms; ?>
    </div>

  </div>

</div>


<?php
}  // if ($page)


