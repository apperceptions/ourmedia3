<script>
// todo: onclick handler for items that displays video

function selectfeed(ndx) {
  t1 = document.getElementById("showcasefeedtab1");
  t2 = document.getElementById("showcasefeedtab2");
  o1 = document.getElementById("showcasefeed1");
  o2 = document.getElementById("showcasefeed2");
  if (ndx == 2) {
  o1.style.display = "none";
  o2.style.display = "block";
  t1.className = "";
  t2.className = "selected";
  } else {
  o2.style.display = "none";
  o1.style.display = "block";
  t2.className = "";
  t1.className = "selected";
  }
}

function swapmedia(url, enc, com) {
  var flashvars = {};
  var params = {};
  var attributes = {};

  // todo: check for url in description (embed or object or iframe)

  // cheap trick for now - hope for transcoding
  enc2 = enc.replace(/\.wmv/, ".flv");

  if (!com.length)
    com = "javascript: alert('No comment url available for this media item.');";

  ac = document.getElementById("addcomment");
  ac.href = com;

  if ( enc2.length && ((enc2.indexOf(".mp4") > 0) || (enc2.indexOf(".mov") > 0)  || (enc2.indexOf(".mpg") > 0)   || (enc2.indexOf(".m4v") > 0)   || (enc2.indexOf(".3gpp") > 0)   || (enc2.indexOf(".mpeg") > 0)) ) {
      var myQTObject = new QTObject(enc2, "spotvideocontentqt", "310", "258");
      myQTObject.addParam("controller", "true");
      myQTObject.addParam("autostart", "true");
      myQTObject.addParam("scale", "aspect");
      myQTObject.write("spotvideocontent");
      return;
  }

  if (enc2.length && (enc2.indexOf(".flv") > 0)) {
    // todo: use local player
    url = "<?php print $GLOBALS['ourmedia_base_url'] ."/". $GLOBALS['theme_path'] ?>/players/flvplayer.swf?file=" + enc2 + "&autostart=true";
    swfobject.embedSWF(url, "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
    return;
  }

  if (enc2.length && (enc2.indexOf(".mp3") > 0)) {
    // todo: use local player
    enc = encodeURIComponent(enc);
    swfurl = "<?php print $GLOBALS['ourmedia_base_url'] ."/". $GLOBALS['theme_path'] ?>/players/flvplayer.swf?file=" + enc2 + "&autostart=true";
    swfobject.embedSWF(swfurl, "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
    return;
  }

  if (url.indexOf("youtube") != -1) {
    url = url.replace(/watch\?v=/, "v/");
    swfobject.embedSWF(url, "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
    return;
  }

  location.href = url;
}

</script>

<div id="spotlight">
  <ul class="spotTabs">
    <li><a id='showcasefeedtab2' href='#' onclick='selectfeed(2); return false;' class=''>Most Discussed</a></li>
    <li><a id='showcasefeedtab1' href='#' onclick='selectfeed(1); return false;' class='selected'>In the spotlight</a></li>
  </ul>

  <br class="clearAll"/>

  <div id="spotlightBox">

    <div id="spotLeftSide">
      <h2>Spotlight</h2>
      <p id='addcomment'>&raquo; <a href="<?php print $showcase_video_comments ?>">Add your comment</a></p>

      <br class="clearAll"/>

      <div id="spotvideocontent">
        <a href="<?php print $showcase_video ?>"  title='Click to play media' onclick="swapmedia('', '<?php print $showcase_video ?>', '<?php print $showcase_video_comments ?>'); return false;"><img src="<?php print $showcase_video_posterimg ?>" class='posterimg' /></a>
      </div>
    </div>

    <div id="spotRightSide">

<?php
$cnt = 0;
foreach($variables['showcase_feeds'] as $feeditems) {
  $cnt++;
?>
  <ul id="showcasefeed<?php print $cnt ?>" <?php if ($cnt > 1) print 'style="display:none;"' ?> >
<?php
  foreach ($feeditems as $item) {
    $link = $item->link;
    $mediaposturl = $link; // $item->mediaposturl;
    $mediaurl = $item->mediaurl;
    $mediatitle = drupal_substr(strip_tags($item->mediatitle), 0, 22);
    $mediadescription = drupal_substr(strip_tags($item->mediadescription), 0, 40) ." ... ";
    $artistname = drupal_substr(strip_tags($item->artistname), 0, 20);
    $artisturl = $item->artisturl;
    $mediathumbnailurl = $item->mediathumbnailurl;
    if (drupal_strlen($mediathumbnailurl)==0)
      $mediathumbnailurl = $GLOBALS['ourmedia_base_url'] ."/". $GLOBALS['theme_path'] ."/images/ourmedia-thumbnail.png";
    $mediatype = $item->mediatype;
    $commenturl = $item->commenturl;
?>
    <li>
      <a href="<?php print $mediaposturl ?>"  title='Click to play media' onclick="swapmedia('<?php print $mediaposturl ?>', '<?php print $mediaurl ?>', '<?php print $commenturl ?>'); return false;"><img alt="thumb" src="<?php print $mediathumbnailurl ?>" onerror="this.src='/<?php print $directory ?>/images/video.gif';" /></a>
      <div class="spotlightText">
        <label><a href="<?php print $mediaposturl ?>" title='Click to read post'><?php print $mediatitle ?></a></label><br/>
        by <a href="<?php print $artisturl ?>" title='Click to view producer or artist homepage'><?php print $artistname ?></a><br/>
        <p class="bioText">
          <label>Why is it spotlighted?</label><br/>
          <?php print $mediadescription ?>
        </p>
      </div>
    </li>
<?php
  }
?>
  </ul>
<?php
}
?>
    </div>
    <!-- end spotRightSide -->

  </div>
  <!-- end spotlightBox -->

</div>
<!-- end spotlight -->
