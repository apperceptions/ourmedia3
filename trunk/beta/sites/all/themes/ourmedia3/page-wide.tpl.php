<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">
<head>
  <title><?php print $head_title?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
  <script type="text/javascript" src="<?php print $GLOBALS['theme_path'] ?>/players/swfobject/swfobject.js"></script>
  <script type="text/javascript" src="<?php print $GLOBALS['theme_path'] ?>/players/qtobject/qtobject.js"></script>
</head>
<body class="<?php print $body_classes ?>" >
<div align="center">
  <div id="header">
  <?php print $header ?>
  <a href="<?php print $GLOBALS['ourmedia_base_url'] ?>"><img src="<?php print $logo ?>" alt="home page" class="logo"/></a><br />
    <div id="topNav">
    <?php if (isset($primary_links)) print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
    <?php print $navbar ?>
    </div>
  </div>
  <div id="wideFront">
    <div id="wideFrontCol">
    <?php print $help ?>
    <?php if ($show_messages) print $messages ?>
    <?php print $search ?>
    <?php print $content_top ?>
    <?php print $content ?>
    <?php print $content_bottom ?>
    <br />
    </div>
    <br clear="all" />
  </div>
  <div id="footer">
    <?php if (isset($secondary_links)) print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
  </div>
</div>
<?php print $footer ?>
<?php if ($show_messages) print $footer_message ?>
<?php print $closure; ?>
</body>
</html>
