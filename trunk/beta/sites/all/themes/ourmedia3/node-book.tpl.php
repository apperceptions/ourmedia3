<div <?php print $attributes; ?>>
<?php if ($page == 0): ?>
  <h2 class="title"><a href="<?php print $node_url ?>"><?php print $title; ?></a></h2>
<?php endif; ?>

<?php if (count($taxonomy)): ?>
  <div class="taxonomy">
<?php print t(' in ') . $terms ?>
  </div>
<?php endif; ?>
  <div class="content">
<?php print $content; ?>
  </div>
<?php if ($links): ?>
  <div class="links">
<?php print $links; ?>

  </div>
<?php endif; ?>
</div> <!-- /#node-<?php print $node->nid; ?> -->

