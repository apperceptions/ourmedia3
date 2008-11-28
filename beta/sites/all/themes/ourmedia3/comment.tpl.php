<div <?php print $attributes; ?>>
<?php if ($new != ''): ?>
  <span class="new"><?php print $new; ?></span>
<?php endif; ?>
  <h3 class="title"><?php print $title; ?></h3>
<?php if ($picture) print $picture; ?>
  <div id="comment-info">
  <span class="submitted"><?php print theme('username', $comment) .' '. t('wrote'); ?></span><span class="submitted2"><?php print format_date($comment->timestamp, 'custom', 'F jS, Y');
?>
</div>
  <div class="content">
<?php print $content; ?>
  </div>
<?php if ($signature): ?>
  <div class="signature">
    <?php print $signature; ?>

  </div>
<?php endif; ?>
  <div class="links">
<?php print $links; ?>

  </div>
</div>

