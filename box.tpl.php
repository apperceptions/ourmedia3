<?php
// $Id: box.tpl.php,v 1.2.2.1 2008/02/22 08:41:50 zarabadoo Exp $
?>

<div class="box">
<?php if ($title): ?>
  <h2><?php print $title; ?></h2>
<?php endif; ?>
  <div class="content">
<?php print $content; ?>
  </div>
</div>

