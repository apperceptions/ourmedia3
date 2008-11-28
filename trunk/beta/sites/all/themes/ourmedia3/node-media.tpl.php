<?php
// $Id$

/* @file
 * media type
 */
//todo: move all code to preprocessing routines and define variables

  $mediaid = key($node->files);
  $node = node_build_content($node);
  $archiveidentifier = check_plain($node->field_identifier[0]['value']);
  $player = ourmedia_media_player($node->files[$mediaid]->filepath, $node->files[$mediaid]->filemime);
  $player_encoded = htmlentities($player);

  $directory = "/". $GLOBALS['theme_path'];
  $channeladdurl = $GLOBALS['channels_base_url'] ."/node/add/channelitem";
  $mediaposturl = "/ia/details/$node->ia_identifier";

  // mss, 2008-09-27, strip cc base from licence
  $license = (explode("/", str_replace("http://creativecommons.org/licenses/", "", $node->field_license[0][safe])));

  if (drupal_strlen($license[0])) {
    $licenseName = $license[0];
    $licenseVer = $license[1];
    $licensePath = 'http://creativecommons.org/licenses/'.$licenseName.'/'.$licenseVer;
  }
  else {
    $licenseName = "traditionalcopyright";
  }

  $licenseImg = '/sites/all/themes/ourmedia3/images/licenses/'.$licenseName.'/88x31.png';

  switch ($licenseName) {
  case "by":
    $licenseShare = 'Yes';
    $licenseRemix = 'Yes';
    $licenseCommercial = 'Yes';
    $licenseDisplay = 'Attribution '.$licenseVer;
    break;
  case "by-nc":
    $licenseShare = 'Yes';
    $licenseRemix = 'Yes';
    $licenseCommercial = 'No';
    $licenseDisplay = 'Attribution-Noncommercial '.$licenseVer;
    break;
  case "by-nd":
    $licenseShare = 'Yes';
    $licenseRemix = 'No';
    $licenseCommercial = 'Yes';
    $licenseDisplay = 'Attribution-No Derivative Works '.$licenseVer;
  break;
  case "by-sa":
    $licenseShare = 'Yes';
    $licenseRemix = 'Yes';
    $licenseCommercial = 'Yes';
    $licenseDisplay = 'Attribution-Share Alike '.$licenseVer;
    break;
  case "by-nc-nd":
    $licenseShare = 'Yes';
    $licenseRemix = 'No';
    $licenseCommercial = 'No';
    $licenseDisplay = 'Attribution-Noncommercial-No Derivative '.$licenseVer;
    break;
  case "by-nc-sa":
    $licenseShare = 'Yes';
    $licenseRemix = 'Yes';
    $licenseCommercial = 'No';
    $licenseDisplay = 'Attribution-Noncommercial-Share Alike '.$licenseVer;
    break;
  case "publicdomain":
    $licenseShare = 'Yes';
    $licenseRemix = 'Yes';
    $licenseCommercial = 'Yes';
    $licenseDisplay = 'Public Domain';
    break;
  case "traditionalcopyright":
    $licenseShare = 'No';
    $licenseRemix = 'No';
    $licenseCommercial = 'No';
    $licenseDisplay = 'Traditional Copyright';
  }


  // TODO: more needed, see channels area below
// $mediatypeid
// $mediaurl
// $thumbnailurl
// $artistname
// $artisthomepageurl
// $commentsurl

  //$reeladdurl = $GLOBALS['channels_base_url'] ."/node/add/reel";

  // preprocess $channels

?>

<div class='node-media<?php print($page ? "-page" : "" ) ?>' <?php print $attributes; ?> >
<?php if ($page <> 0) { ?>
  <h2><?php print check_plain($node->title); ?></h2>
<?php }
else { ?>
  <h2><a href="<?php print $node_url ?>"><?php print check_plain($node->title); ?></a></h2>
<?php } ?>

<?php if ($picture) print $picture; ?>

<?php if ($submitted): ?>
  <span class="submitted"><?php print t('Submitted by ') . theme('username', $node) . t(' on ') . date("F j, Y, g:i a", $node->files[$mediaid]->timestamp); ?></span>
<?php endif; ?>

<?php if ($page <> 0): ?>
  <div class='media-player'><?php print $player ?></div>
<?php endif; ?>



<?php if ($page <> 0): ?>

  <div class='media-details'>
    <h3>Details</h3>
    <div>

      <div>
        <div class="content"><?php print $node->body; ?></div>

        <label>Format:</label> <?php print $node->files[$mediaid]->filemime; ?>
      </div>

      <div class='section'>
        <h4>Download or watch</h4>
        <label>Archive.org:</label> <a href="http://archive.org/details/<?php print $archiveidentifier ?>">Download original file</a>
        <div class="links"><?php print $links; ?></div>
      </div>

     <div class='section'>
        <h4>How you may use this work</h4>
  <div class='license'>
  License:
  <br>
          <img src='<?php print $licenseImg; ?>'>
          <br/>
      <?php if (isset($licensePath)) print '<a href="'.$licensePath.'">';  ?>
    <?php print $licenseDisplay;?>
      <?php if (isset($licensePath)) print '</a>'; ?>

  </div>
        <label class='ccpermission'>Share it?</label> <?php print $licenseShare; ?>
        <br/>
        <label class='ccpermission'>Remix it?</label> <?php print $licenseRemix; ?>
        <br/>
        <label class='ccpermission'>Use commercially?</label> <?php print $licenseCommercial; ?>
        <br/>
        <label>Copyright statement</label> the original copyright holders retain their copyrights
      </div>

      <div class='section'>
        <h4>TAGS</h4>
        <div class="taxonomy"><?php print $terms ?></div>
      </div>

    </div>


    <div class='share-media'>

      <h3>YOU LIKE?</h3>

      <div id='media-revlog'>
        <h4>Add this item to a channel</h4>
          <form method='get' action='<?php print $channeladdurl ?>' >
            <input type='hidden' name='edit[title]' value='<?php print $node->title ?>'/>
            <input type='hidden' name='edit[body_filter][body]' value="<?php print htmlentities($node->body) ?>" />
            <input type='hidden' name='edit[taxonomy][1]' value='<?php print $mediatypeid ?>'/>
            <input type='hidden' name='edit[group_media][field_media][0][value]' value='<?php print $mediaurl ?>'/>
            <input type='hidden' name='edit[group_media][field_mediapost][0][value]' value='<?php print $mediaposturl ?>'/>
            <input type='hidden' name='edit[group_images][field_thumbnail][0][value]' value='<?php print $thumbnailurl ?>'/>
            <input type='hidden' name='edit[group_images][field_screenshot][0][value]' value='<?php print $thumbnailurl ?>'/>
            <input type='hidden' name='edit[group_artistproducer][field_artist][0][value]' value='<?php print $artistname ?>'/>
            <input type='hidden' name='edit[group_artistproducer][field_artisturl][0][value]' value='<?php print $artisthomepageurl ?>'/>
            <input type='hidden' name='edit[group_artistproducer][field_comments][0][value]' value='<?php print $commentsurl ?>'/>
            <select id='channel' name='gids[]'>
              <option value='5'>** Community talk **</option>
<?php
  $previousdb = db_set_active('channels');
// this should be the logged in user
  $guser = $GLOBALS['user'];
  $result = db_query("SELECT n.title, n.nid FROM {node} n, {og_uid} ogu WHERE n.nid = ogu.nid AND ogu.uid=%d AND n.status = 1 ORDER BY n.title", $guser->uid);
  $cnt = 0;
  while ($gnode = db_fetch_object($result)) {
  $cnt++;
  if ($gnode->nid != 5)
    print "<option value='$gnode->nid'>$gnode->title</option>";
  }
  db_set_active($previousdb);
?>
          </select>
          <input type='submit' value='Add...'  class="button" />
        </form>
      </div>

      <div id='media-embed'>
        <h4>Copy to your site</h4>
        <span>Copy the code below and paste it into your favorite pages.</span>
        <form>
          <input name="embedcode" type="text" value="<?php print $player_encoded ?>" />
        </form>
      </div>

    </div>

    <div class="media-comments">
      <h3>Comments</h3>
    </div>


  </div>

<?php endif; /* $page<>0 */ ?>



</div> <!-- /#node-<?php print $node->nid; ?> -->


