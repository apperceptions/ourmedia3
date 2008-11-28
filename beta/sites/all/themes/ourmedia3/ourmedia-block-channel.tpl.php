<?php

// $Id$

/* @file
 * channel block
 */

$feed = $variables['channel_feed'];
$feednum = $variables['channel_feed_num'];

//var_dump($feed);

?>
<div id="channelslider<?php print $block->delta ?>" class='channelslider block'>
  <h2><?php print $block->title ?></h2>
  <div id="channelslider<?php print $block->delta ?>outer" class='channelsliderouter'>
    <div id="channelslider<?php print $block->delta ?>inner" class='channelsliderinner'>
      <h3>Get the latest version of Flash Player</h3>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
    </div>
  </div>
  <script defer>
      var flashvars = {feed:"<?php print $feed ?>"};
      swfobject.embedSWF('/sites/all/themes/ourmedia3/players/om_channelrdr.swf', "channelslider<?php print $block->delta ?>inner", "620", "135", "8", "swfobject/expressInstall.swf", flashvars);
  </script>
</div>