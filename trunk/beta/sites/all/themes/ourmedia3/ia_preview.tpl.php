<?php
// $Id$

/* @file
 * Internet Archive preview from thumbs
 */

if (!$message)
  $message = "Click to play";

$icon = "/". $directory ."/images/video.gif";

?>

<style>
.showcase_preview {
  margin: 10px 0;
  padding: 5px 0;
  width: 335px;
  height: 225px;
  border-top: 1px black solid;
  border-left: 1px black solid;
  border-right: 3px black solid;
  border-bottom: 3px black solid;
  overflow: hidden;
}

.showcase_preview div .thumb {
  height: 110px;
  width: 160px;
}
.showcase_preview div .thumbLeft {
  /*float:left;*/
}
.showcase_preview div .thumbRight {
  /*float: left;
  clear: right;*/
}
.showcase_preview .playButton {
  position: relative;
  top: -145px;  /* 160-30 = thumb - playbutton*/
}

.showcase_preview div img {
  border: none;
}
.showcase_preview h1 {
  color: white;
  font-family: Verdana,Arial,SunSans-Regular,Sans-Serif;
  text-shadow: purple 0px 0px 5px;
  padding: 0;
  margin: 0;
}

a {
  text-decoration: none;
}
</style>

<?php if (drupal_strlen($href)) print "<a href='$href'>"; ?>

<center>

<div class='showcase_preview'>
  <div>
    <img class='thumb' src='<?php print $icon ?>' onload="this.src='<?php print $GLOBALS['ourmedia_base_url'] ?>/ia/thumbnail/<?php print $identifier ?>/2';" />
    <img class='thumb' src='<?php print $icon ?>' onload="this.src='<?php print $GLOBALS['ourmedia_base_url'] ?>/ia/thumbnail/<?php print $identifier ?>/3';" />
  </div>
  <div>
    <img class='thumb' src='<?php print $icon ?>' onload="this.src='<?php print $GLOBALS['ourmedia_base_url'] ?>/ia/thumbnail/<?php print $identifier ?>/4';" />
    <img class='thumb' src='<?php print $icon ?>' onload="this.src='<?php print $GLOBALS['ourmedia_base_url'] ?>/<?php print $identifier ?>/5';" />
  </div>
  <div class='playButton'>
    <img src="<?php print $directory ?>/images/playButton.png"/>
    <h1><?php print $message ?></h1>
  </div>
</div>

</center>

<?php

if (drupal_strlen($href))
  print "</a>";
