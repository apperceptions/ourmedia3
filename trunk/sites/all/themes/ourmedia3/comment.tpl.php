<?php
// $Id: comment.tpl.php,v 1.3.2.3 2008/02/29 20:16:03 zarabadoo Exp $
?>
<div <?php print $attributes; ?>>
<?php if ($new != ''): ?>
  <span class="new"><?php print $new; ?></span>
<?php endif; ?>
  <h3 class="title"><?php print $title; ?></h3>
<?php if ($picture) print $picture; ?>
  <span class="submitted"><?php print t('Submitted on ') . format_date($comment->timestamp, 'custom', 'F jS, Y') . t(' by '); ?> <?php print theme('username', $comment); ?></span>
  <div class="content">
<?php print $content; ?>
  </div>
<?php if($signature): ?>
  <div class="signature">
    <?php print $signature; ?>
    
  </div>
<?php endif; ?>
  <div class="links">
<?php print $links; ?>

  </div>
</div>

